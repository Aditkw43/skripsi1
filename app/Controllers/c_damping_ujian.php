<?php

namespace App\Controllers;

use App\Models\m_biodata;
use App\Models\m_damping_ujian;
use App\Models\m_jadwal_ujian;
use App\Models\m_laporan_damping;
use App\Models\m_profile_mhs;

class c_damping_ujian extends BaseController
{

    protected $db, $builder, $builder2, $dataUser, $damping_ujian, $jadwal_ujian, $profile_mhs, $biodata, $laporan;
    public function __construct()
    {
        $this->db      = \Config\Database::connect();
        // Query untuk spesifikasi Auth       
        $this->builder = $this->db->table('users');
        $this->builder->select('users.id as userid, username, email, user_image');
        $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');

        // Query untuk User yang sedang berjalan
        $this->builder2 = $this->db->table('users');
        $this->builder2->select('users.id as userid, username, email, user_image');
        $this->builder2->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->builder2->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $this->builder2->where('users.id', user_id());
        $query = $this->builder2->get();
        $this->dataUser = $query->getRow();

        // Instansiasi Model
        $this->damping_ujian = model(m_damping_ujian::class);
        $this->jadwal_ujian = model(m_jadwal_ujian::class);
        $this->profile_mhs = model(m_profile_mhs::class);
        $this->biodata = model(m_biodata::class);
        $this->laporan = model(m_laporan_damping::class);
    }

    // Menampilkan view generate, khusus admin
    public function index()
    {

        $get_all_damping = $this->damping_ujian->getAllDamping();
        $himpun_madif = null;
        $transform_jadwal_damping = null;

        if (!empty($get_all_damping)) {

            // Menghimpun seluruh madif dalam generate pendampingan
            $count_madif = [];
            foreach ($get_all_damping as $key) {
                $jumlah_didampingi = 0;
                $jumlah_tidak_didampingi = 0;
                $count_data_sama = 0;
                foreach ($count_madif as $cm) {
                    if ($cm == $key['id_profile_madif']) {
                        $count_data_sama++;
                    }
                }

                // Jumlah didampingi dan tidak didampingi
                foreach ($get_all_damping as $dps) {
                    if ($key['id_profile_madif'] == $dps['id_profile_madif']) {
                        if (isset($dps['id_profile_pendamping'])) {
                            $jumlah_didampingi++;
                        } else {
                            $jumlah_tidak_didampingi++;
                        }
                    }
                }

                // Jika count data sama = 0, berarti tidak ada data yang terduplikasi
                if ($count_data_sama == 0) {
                    $id_madif = $key['id_profile_madif'];
                    $get_profile = $this->profile_mhs->getProfile($id_madif);
                    $get_nama = $this->biodata->getBiodata($id_madif);
                    $insert = [
                        'id_profile_madif' => $get_profile['id_profile_mhs'],
                        'nim' => $get_profile['nim'],
                        'nama' => $get_nama['nickname'],
                        'fakultas' => $get_profile['fakultas'],
                        'jumlah_didampingi' => $jumlah_didampingi,
                        'jumlah_tidak_didampingi' => $jumlah_tidak_didampingi,
                    ];
                    $himpun_madif[] = $insert;

                    $count_madif[] = $key['id_profile_madif'];
                }
            }

            // Mendapatkan semua detail jadwal damping setiap madif
            $raw_data_damping = [];
            foreach ($himpun_madif as $dtj) {
                $get_jadwal = [
                    'pendamping' => 0,
                    'madif' => 1,
                    'id_profile_mhs' => $dtj['id_profile_madif'],
                ];
                $jadwal_ujian = $this->damping_ujian->getAllDamping($get_jadwal);
                $raw_data_damping[$dtj['id_profile_madif']] = $jadwal_ujian;
            }

            // Transform dari data mentah ke informasi yang diperlukan
            foreach ($raw_data_damping as $acuan => $ajd) {
                $insert = [];
                $insert2 = [];
                foreach ($ajd as $isi) {
                    $jadwal_ujian = $this->jadwal_ujian->getDetailUjian($isi['id_jadwal_ujian_madif']);
                    $biodata_madif = $this->biodata->getProfile($isi['id_profile_madif']);
                    $biodata_pendamping = $this->biodata->getProfile($isi['id_profile_pendamping']);
                    $insert = [
                        'jadwal_ujian' => $jadwal_ujian,
                        'biodata_madif' => $biodata_madif,
                        'biodata_pendamping' => $biodata_pendamping,
                        'jenis_ujian' => $isi['jenis_ujian'],
                        'status_damping' => $isi['status_damping'],
                    ];
                    $insert2[$isi['id_damping']] = $insert;
                }
                $transform_jadwal_damping[$acuan] = $insert2;
            }
        } else {
            $get_all_damping = null;
        }

        $data = [
            'title' => 'Daftar Pendampingan Ujian',
            'data' => $get_all_damping,
            'himpunan_damping_madif' => $himpun_madif,
            'hasil_jadwal_damping' => $transform_jadwal_damping,
            'user' => $this->dataUser,
        ];
        // dd($data);

        return view('admin/damping_ujian/index', $data);
    }

    // Menampilkan view jadwal damping, view untuk mahasiswa/detail jadwal mahasiswa
    public function viewDamping()
    {
        $nim = $this->request->getUri()->getSegment(2);
        $get_id_profile = $this->biodata->getProfileID($nim);
        $get_profile = $this->biodata->getProfile($get_id_profile);
        $get_jadwal_damping = $this->damping_ujian->getAllDamping($get_profile);

        // Transform dari data mentah ke informasi yang diperlukan
        $transform_jadwal_damping = [];
        $urutan = [];
        foreach ($get_jadwal_damping as $acuan => $ajd) {
            $insert = [];
            $jadwal_ujian = $this->jadwal_ujian->getDetailUjian($ajd['id_jadwal_ujian_madif']);

            $profile_madif = $this->biodata->getProfile($ajd['id_profile_madif']);
            $biodata_madif = $this->biodata->getBiodata($ajd['id_profile_madif']);
            $id_jenis_madif = $this->profile_mhs->getJenisMadif($ajd['id_profile_madif']);
            $jenis_madif = $this->profile_mhs->getKategoriDifabel($id_jenis_madif['id_jenis_difabel']);
            $profile_madif['jenis_madif'] = $jenis_madif['jenis'];

            $profile_pendamping = $this->biodata->getProfile($ajd['id_profile_pendamping']);
            $biodata_pendamping = $this->biodata->getBiodata($ajd['id_profile_pendamping']);

            $presensi = $this->damping_ujian->getPresensi($ajd['id_damping']);
            $laporan = $this->damping_ujian->getLaporan($ajd['id_damping']);
            $insert = [
                'id_damping' => $ajd['id_damping'],
                'jadwal_ujian' => $jadwal_ujian,
                'biodata_madif' => $profile_madif + $biodata_madif,
                'biodata_pendamping' => (empty($profile_pendamping)) ? null : ($profile_pendamping + $biodata_pendamping),
                'jenis_ujian' => $ajd['jenis_ujian'],
                'status_damping' => $ajd['status_damping'],
                'presensi' => $presensi,
                'laporan' => $laporan,
            ];
            $transform_jadwal_damping[$acuan] = $insert;
        }

        $data = [
            'title' => 'Daftar Pendampingan Ujian ',
            'data' => $get_jadwal_damping,
            'hasil_jadwal_damping' => $transform_jadwal_damping,
            'profile_mhs' => $get_profile,
            'user' => $this->dataUser,
        ];

        return view('mahasiswa/damping/v_damping_ujian', $data);
    }

    public function viewAllDamping()
    {
        $get_jadwal_damping = $this->damping_ujian->getAllDamping();
        $get_all_pendamping = $this->profile_mhs->getAllProfilePendamping();

        // Transform dari data mentah ke informasi yang diperlukan
        $jadwal_damping = [];
        $jadwal_tidak_damping = [];
        $pendamping_alt = [];

        foreach ($get_jadwal_damping as $ajd) {
            if (!($ajd['status_damping'] == 'selesai')) {
                $insert = [];
                $jadwal_ujian = $this->jadwal_ujian->getDetailUjian($ajd['id_jadwal_ujian_madif']);

                $profile_madif = $this->biodata->getProfile($ajd['id_profile_madif']);
                $biodata_madif = $this->biodata->getBiodata($ajd['id_profile_madif']);
                $id_jenis_madif = $this->profile_mhs->getJenisMadif($ajd['id_profile_madif']);
                $jenis_madif = $this->profile_mhs->getKategoriDifabel($id_jenis_madif['id_jenis_difabel']);
                $profile_madif['jenis_madif'] = $jenis_madif['jenis'];

                $profile_pendamping = $this->biodata->getProfile($ajd['id_profile_pendamping']);
                $biodata_pendamping = $this->biodata->getBiodata($ajd['id_profile_pendamping']);

                $presensi = $this->damping_ujian->getPresensi($ajd['id_damping']);
                $laporan = $this->damping_ujian->getLaporan($ajd['id_damping']);
                $insert = [
                    'id_damping' => $ajd['id_damping'],
                    'jadwal_ujian' => $jadwal_ujian,
                    'biodata_madif' => $profile_madif + $biodata_madif,
                    'biodata_pendamping' => (empty($profile_pendamping)) ? null : ($profile_pendamping + $biodata_pendamping),
                    'jenis_ujian' => $ajd['jenis_ujian'],
                    'status_damping' => $ajd['status_damping'],
                    'presensi' => $presensi,
                    'laporan' => $laporan,
                ];

                if (isset($ajd['id_profile_pendamping'])) {
                    $jadwal_damping[] = $insert;
                } else {
                    $get_all_pendamping['jenis_difabel'] = $jenis_madif;
                    $find = $this->plottingSkill($get_all_pendamping);
                    unset($find['cek_get_pendamping_skill']);
                    unset($get_all_pendamping['jenis_difabel']);
                    $pendamping_alt = null;

                    foreach ($find as $fi) {
                        $fi['kecocokan'] = true;
                        $biodata_pendamping_alt = $this->biodata->getBiodata($fi['id_profile_pendamping']);
                        $fi['biodata_pendamping_alt'] = $biodata_pendamping_alt;
                        $pendamping_alt[] = $fi;
                    }

                    foreach ($get_all_pendamping as $key) {
                        $cek_pendamping_sama = true;
                        foreach ($find as $f) {
                            if ($key['id_profile_mhs'] == $f['id_profile_pendamping']) {
                                $cek_pendamping_sama = false;
                                break;
                            }
                        }

                        if ($cek_pendamping_sama) {
                            $biodata_pendamping_alt2 = $this->biodata->getBiodata($key['id_profile_mhs']);
                            $pendamping_alt2 = [
                                'id_profile_pendamping' => $key['id_profile_mhs'],
                                'ref_pendampingan' => null,
                                'prioritas' => null,
                                'kecocokan' => false,
                                'biodata_pendamping_alt' => $biodata_pendamping_alt2,
                            ];
                            $pendamping_alt[] = $pendamping_alt2;
                        }
                    }
                    $insert['pendamping_alt'] = $pendamping_alt;
                    $jadwal_tidak_damping[] = $insert;
                }
            }
        }

        foreach ($get_jadwal_damping as $key1 => $value1) {
            if ($value1['status_damping'] == 'selesai') {
                unset($get_jadwal_damping[$key1]);
                continue;
            }
        }

        $get_jadwal_damping = array_merge($jadwal_damping, $jadwal_tidak_damping);

        $data = [
            'title' => 'Daftar Seluruh Pendampingan Ujian ',
            'all_jadwal_damping' => $get_jadwal_damping,
            'jadwal_damping' => $jadwal_damping,
            'jadwal_tidak_damping' => $jadwal_tidak_damping,
            'user' => $this->dataUser,
        ];

        // dd($data);
        return view('admin/damping_ujian/v_all_damping', $data);
    }

    // Menampilkan view jadwal damping, view untuk mahasiswa/detail jadwal mahasiswa
    public function viewAllLaporan()
    {
        $get_all_laporan = $this->laporan->getAllLaporan();
        $laporan_not_approval = [];
        $laporan_diterima = [];
        $laporan_ditolak = [];
        $hasil_laporan = [];

        foreach ($get_all_laporan as $key => $value) {
            $get_jadwal_damping = $this->damping_ujian->getDetailDamping($value['id_damping']);
            $get_jadwal_ujian = $this->jadwal_ujian->getDetailUjian($get_jadwal_damping['id_jadwal_ujian_madif']);

            // Madif
            $profile_madif = $this->biodata->getProfile($get_jadwal_damping['id_profile_madif']);
            $biodata_madif = $this->biodata->getBiodata($get_jadwal_damping['id_profile_madif']);
            $id_jenis_madif = $this->profile_mhs->getJenisMadif($get_jadwal_damping['id_profile_madif']);
            $jenis_madif = $this->profile_mhs->getKategoriDifabel($id_jenis_madif['id_jenis_difabel']);
            $profile_madif['jenis_madif'] = $jenis_madif['jenis'];

            // Pendamping
            $profile_pendamping = $this->biodata->getProfile($get_jadwal_damping['id_profile_pendamping']);
            $biodata_pendamping = $this->biodata->getBiodata($get_jadwal_damping['id_profile_pendamping']);

            // Presensi
            $presensi = $this->damping_ujian->getPresensi($value['id_damping']);

            $insert_jadwal_ujian = [
                'mata_kuliah' => $get_jadwal_ujian['mata_kuliah'],
                'tanggal_ujian' => $get_jadwal_ujian['tanggal_ujian'],
                'waktu_mulai_ujian' => $get_jadwal_ujian['waktu_mulai_ujian'],
                'waktu_selesai_ujian' => $get_jadwal_ujian['waktu_selesai_ujian'],
                'ruangan' => $get_jadwal_ujian['ruangan'],
                'keterangan' => $get_jadwal_ujian['keterangan'],
            ];

            $insert_biodata = [
                'biodata_madif' => $biodata_madif + $profile_madif,
                'biodata_pendamping' => $biodata_pendamping + $profile_pendamping,
            ];

            $insert_laporan_damping = [
                'id_laporan_damping' => $value['id_laporan_damping'],
                'madif_rating' => $value['madif_rating'],
                'pendamping_rating' => $value['pendamping_rating'],
                'madif_review' => $value['madif_review'],
                'pendamping_review' => $value['pendamping_review'],
                'approval' => $value['approval'],
                'presensi' => $presensi,
            ];

            $hasil_laporan[$key] = [
                'jadwal_ujian' => $insert_jadwal_ujian,
                'biodata' => $insert_biodata,
                'laporan' => $insert_laporan_damping,
            ];
        }

        foreach ($hasil_laporan as $key1) {
            if ($key1['laporan']['approval'] === '1') {
                $laporan_diterima[] = $key1;
            } elseif ($key1['laporan']['approval'] === '0') {
                $laporan_ditolak[] = $key1;
            } else {
                $laporan_not_approval[] = $key1;
            }
        }

        $data = [
            'title' => 'Seluruh Laporan Pendampingan Ujian',
            'hasil_laporan' => $hasil_laporan,
            'laporan_diterima' => $laporan_diterima,
            'laporan_ditolak' => $laporan_ditolak,
            'laporan_diverifikasi' => $laporan_not_approval,
            'user' => $this->dataUser,
        ];
        // dd($data);

        return view('admin/laporan_damping/v_all_laporan_damping', $data);
    }

    // Menampilkan view jadwal damping, view untuk mahasiswa/detail jadwal mahasiswa
    public function viewTidakDamping()
    {
        $nim = $this->request->getUri()->getSegment(2);
        $get_id_profile = $this->biodata->getProfileID($nim);
        $get_profile = $this->biodata->getProfile($get_id_profile);
        $get_jadwal_damping = $this->damping_ujian->getAllDamping($get_profile);

        // Transform dari data mentah ke informasi yang diperlukan
        $transform_jadwal_damping = [];
        foreach ($get_jadwal_damping as $acuan => $ajd) {
            $insert = [];
            $jadwal_ujian = $this->jadwal_ujian->getDetailUjian($ajd['id_jadwal_ujian_madif']);

            $profile_madif = $this->biodata->getProfile($ajd['id_profile_madif']);
            $biodata_madif = $this->biodata->getBiodata($ajd['id_profile_madif']);
            $id_jenis_madif = $this->profile_mhs->getJenisMadif($ajd['id_profile_madif']);
            $jenis_madif = $this->profile_mhs->getKategoriDifabel($id_jenis_madif['id_jenis_difabel']);
            $profile_madif['jenis_madif'] = $jenis_madif['jenis'];

            $profile_pendamping = $this->biodata->getProfile($ajd['id_profile_pendamping']);
            $biodata_pendamping = $this->biodata->getBiodata($ajd['id_profile_pendamping']);

            $presensi = $this->damping_ujian->getPresensi($ajd['id_damping']);
            $laporan = $this->damping_ujian->getLaporan($ajd['id_damping']);
            $insert = [
                'id_damping' => $ajd['id_damping'],
                'jadwal_ujian' => $jadwal_ujian,
                'biodata_madif' => $profile_madif + $biodata_madif,
                'biodata_pendamping' => (empty($profile_pendamping)) ? null : ($profile_pendamping + $biodata_pendamping),
                'jenis_ujian' => $ajd['jenis_ujian'],
                'status_damping' => $ajd['status_damping'],
                'presensi' => $presensi,
                'laporan' => $laporan,
            ];
            $transform_jadwal_damping[$acuan] = $insert;
        }

        $data = [
            'title' => 'Daftar Ujian Tidak Didampingi ',
            'data' => $get_jadwal_damping,
            'hasil_jadwal_damping' => $transform_jadwal_damping,
            'profile_mhs' => $get_profile,
            'user' => $this->dataUser,
        ];

        return view('mahasiswa/damping/v_tidak_damping', $data);
    }

    // Menampilkan view jadwal damping, view untuk mahasiswa/detail jadwal mahasiswa
    public function viewLaporan()
    {
        $nim = $this->request->getUri()->getSegment(2);
        $get_id_profile = $this->biodata->getProfileID($nim);
        $get_profile = $this->biodata->getProfile($get_id_profile);

        $get_laporan = $this->laporan->getAllLaporan($get_profile);
        $hasil_laporan = [];

        // Tanggal ujian(jadwal_ujian), mata kuliah(jadwal_ujian), nama madif/nama pendamping(biodata), status_approval(laporan_damping), detail_laporan(laporan_damping dan presensi)
        // Detail_laporan: rating madif/pendamping, review madif/pendamping, waktu absensi(Presensi) (Waktu hadir, pulang, tepat waktu)           
        foreach ($get_laporan as $key => $value) {
            $get_jadwal_damping = $this->damping_ujian->getDetailDamping($value['id_damping']);
            $get_jadwal_ujian = $this->jadwal_ujian->getDetailUjian($get_jadwal_damping['id_jadwal_ujian_madif']);

            $profile_madif = $this->biodata->getProfile($get_jadwal_damping['id_profile_madif']);
            $biodata_madif = $this->biodata->getBiodata($get_jadwal_damping['id_profile_madif']);
            $id_jenis_madif = $this->profile_mhs->getJenisMadif($get_jadwal_damping['id_profile_madif']);
            $jenis_madif = $this->profile_mhs->getKategoriDifabel($id_jenis_madif['id_jenis_difabel']);
            $profile_madif['jenis_madif'] = $jenis_madif['jenis'];

            $profile_pendamping = $this->biodata->getProfile($get_jadwal_damping['id_profile_pendamping']);
            $biodata_pendamping = $this->biodata->getBiodata($get_jadwal_damping['id_profile_pendamping']);

            $presensi = $this->damping_ujian->getPresensi($value['id_damping']);

            $insert_jadwal_ujian = [
                'mata_kuliah' => $get_jadwal_ujian['mata_kuliah'],
                'tanggal_ujian' => $get_jadwal_ujian['tanggal_ujian'],
                'waktu_mulai_ujian' => $get_jadwal_ujian['waktu_mulai_ujian'],
                'waktu_selesai_ujian' => $get_jadwal_ujian['waktu_selesai_ujian'],
                'ruangan' => $get_jadwal_ujian['ruangan'],
                'keterangan' => $get_jadwal_ujian['keterangan'],
            ];

            $insert_biodata = [
                'biodata_madif' => $biodata_madif + $profile_madif,
                'biodata_pendamping' => $biodata_pendamping + $profile_pendamping,
            ];

            $insert_laporan_damping = [
                'id_laporan_damping' => $value['id_laporan_damping'],
                'madif_rating' => $value['madif_rating'],
                'pendamping_rating' => $value['pendamping_rating'],
                'madif_review' => $value['madif_review'],
                'pendamping_review' => $value['pendamping_review'],
                'approval' => $value['approval'],
                'presensi' => $presensi,
            ];

            $hasil_laporan[$key] = [
                'jadwal_ujian' => $insert_jadwal_ujian,
                'biodata' => $insert_biodata,
                'laporan' => $insert_laporan_damping,
            ];
        }

        if (isset($get_jadwal_damping)) {
            $data = [
                'title' => 'Laporan Pendampingan Ujian',
                'hasil_laporan' => $hasil_laporan,
                'profile_mhs' => $get_profile,
                'user' => $this->dataUser,
            ];
        } else {
            $data = [
                'title' => 'Laporan Pendampingan Ujian',
                'data' => null,
                'hasil_laporan' => null,
                'profile_mhs' => $get_profile,
                'user' => $this->dataUser,
            ];
        }
        return view('mahasiswa/damping/v_laporan', $data);
    }

    // Menampilkan jadwal sementara hasil generate    
    public function viewGenerate($data_damping_sementara)
    {
        // START deklarasi variabel
        $v_damping = [];
        $insert = [];
        $hasil_generate = $this->damping_ujian->hasilGenerate($data_damping_sementara);
        $profile = model(m_profile_mhs::class);
        $jumlah_madif_generate[] = $data_damping_sementara[0];
        $jenis_ujian = $data_damping_sementara[0]['jenis_ujian'];
        // END 

        // Menghimpun seluruh madif dalam generate pendampingan
        foreach ($data_damping_sementara as $key) {
            $count_data_sama = 0;
            foreach ($jumlah_madif_generate as $jmg) {
                if ($jmg['id_profile_madif'] == $key['id_profile_madif']) {
                    $count_data_sama++;
                }
            }

            // Jika count data sama = 0, berarti tidak ada data yang terduplikasi
            if ($count_data_sama == 0) {
                $jumlah_madif_generate[] = $key;
            }
        }

        // Memasukkan data dan hitung jumlah madif didampingi dan tidak didampingi
        foreach ($jumlah_madif_generate as $k) {
            $jumlah_didampingi = 0;
            $jumlah_tidak_didampingi = 0;
            // id_profile, NIM dan Fakultas
            $nim_fakultas = $profile->getProfile($k['id_profile_madif']);
            $id_profile_madif = $nim_fakultas['id_profile_mhs'];
            $nim = $nim_fakultas['nim'];
            $fakultas = $nim_fakultas['fakultas'];

            // Nama
            $nama = $this->db->table('biodata')->select('fullname')->getWhere(['id_profile_mhs' => $k['id_profile_madif']])->getFirstRow();
            $nama = $nama->fullname;

            // Jumlah didampingi dan tidak didampingi
            foreach ($data_damping_sementara as $dps) {
                if ($k['id_profile_madif'] == $dps['id_profile_madif']) {
                    if (isset($dps['id_profile_pendamping'])) {
                        $jumlah_didampingi++;
                    } else {
                        $jumlah_tidak_didampingi++;
                    }
                }
            }
            $insert = [
                'id_profile_madif' => $id_profile_madif,
                'nim' => $nim,
                'nama' => $nama,
                'fakultas' => $fakultas,
                'jumlah_didampingi' => $jumlah_didampingi,
                'jumlah_tidak_didampingi' => $jumlah_tidak_didampingi,
            ];

            $v_damping[] = $insert;
        }

        // Memasukkan data yang tidak didampingi
        $v_tidak_didampingi = [];
        foreach ($hasil_generate as $key) {
            if (!isset($key['nama_pendamping'])) {
                $key['nama_pendamping'] = 'kosong';
                $v_tidak_didampingi[] = $key;
            }
        }

        $data = [
            'title' => 'Hasil Generate Jadwal Damping ' . $jenis_ujian,
            'value_generate' => $data_damping_sementara,
            'hasil_generate' => $hasil_generate,
            'madif' => $v_damping,
            'v_tidak_didampingi' => $v_tidak_didampingi,
        ];

        // $admin = $this->builder2->get();
        $data['user'] = $this->dataUser;

        return view('admin/damping_ujian/v_generate', $data);
    }

    /**
     * Diplotting berdasarkan:
     * 1)Jadwal kosong dan prioritas skill pendamping diutamakan
     * 2)Jadwal kosong, prioritas skill sama dengan pendamping lain, maka diplottingkan berdasarkan urutan keadilan pendampingan
     * 3)Jadwal kosong, tanpa skill yang cocok, maka diplottingkan berdasarkan urutan keadilan pendampingan
     * 4)Jadwal tidak ada yang kosong, maka dimasukkan null pada id pendamping
     */
    public function generate()
    {
        /**
         * 1)Ambil jadwal madif dan pendamping, diurutkan berdasarkan tanggal dan waktu
         * 2)Ambil jenis madif dan skills pendamping yang ingin diplotingkan
         * 3)Plottingkan jadwal madif dengan jadwal pendamping yang tidak satu tanggal
         * -Jika tidak dapat menemukan pendamping di tanggal yang berbeda, maka plottingkan di tanggal yang sama dengan waktu yang berbeda
         * -Jika tidak ada pendamping yang bisa di tanggal yang berbeda maupun waktu yang berbeda, maka isikan pendamping dengan null
         * 4)Plottingkan berdasarkan jenis madif dan prioritas skill pendamping
         * -Jika tidak menemukan kebutuhan skill yang sesuai, maka masukkan pendamping yang tidak memiliki skill/memiliki skill lain namun tersedia waktu
         */

        /**
         * 1)Cek apakah pendamping sudah terisi di waktu yang beririsan
         * 2)Cek apakah pendamping kosong di tanggal ujian madif
         * 3)Cek apakah pendamping kosong di tanggal sama di waktu ujian madif
         * 4)Cek apakah pendamping memiliki ref_pendampingan yang sesuai dengan kebutuhan  jenis _madif         
         */
        // Deklarasi variabel damping ujian sementara dan variabel insert data untuk dimasukkan ke var damping ujian sementara
        $damping_ujian_sementara = [];

        $insert = [
            'id_jadwal_ujian_madif' => '',
            'id_profile_madif' => '',
            'id_profile_pendamping' => '',
            'ref_pendampingan' => null,
            'prioritas' => null,
            'jenis_ujian' => $this->request->getVar('jenis_ujian'),
        ];

        // Ambil jadwal ujian madif 
        $all_jadwal_ujian = $this->jadwal_ujian->getAllJadwalUjian();
        $all_jadwal_madif = $all_jadwal_ujian['jadwal_madif'];

        // Ambil skills pendamping        
        $profile_pendamping = $this->profile_mhs->getAllProfile('pendamping');

        /**
         * Aturannya, semua pendamping dapat mendampingi secara adil dan rata, namun jadwal kosong dengan prioritas skill pendamping yang cocok diutamakan
         * Variabel dibawah untuk menunjukkan berapa banyak pendampingan  melakukan pendampingan
         * 
         * 1)Cek apakah semua pendamping adil mendampingi
         * -Jika tidak urutkan id pendamping sesuai dengan urutan dari jumlah pendampingan paling sedikit ke paling terbanyak
         * 2)Ambil jadwal pendamping sesuai dengan urutan adil pendamping  
         * 
         * Note: sorting array asort(), dari value terkecil ke terbesar
         */
        // Memasukkan seluruh id profile pendamping ke variabel count_jumlah_damping        
        $count_jumlah_damping = [];
        foreach ($profile_pendamping as $key) {
            $count_jumlah_damping[$key['id_profile_mhs']] = 0;
        }

        /**
         * 1)Pendampingan dipilih pertama berdasarkan jadwal kosong
         * -Jika terdapat jadwal kosong, maka dikumpulkan semua jadwal kosong pendamping untuk diseleski lebih lanjut pada tahap seleksi skills. Diurutkan berdasarkan urutan adil pendamping
         * -Jika tidak ada jadwal kosong, maka tidak bisa lanjut ke seleksi kebutuhan skills        
         * 
         * 2)Pendampingan dipilih kedua berdasarkan skills yang dibutuhkan madif
         * -Seleksi dilakukan pertama pada urutan prioritas pertama. Semua pendamping diseleksi terlebih dahulu prioritas pertamanya            
         * -Jika tidak menemukan prioritas pertama yang cocok, maka dilanjutkan dengan prioritas kedua (urutan tetap berdasarkan urutan adil pendamping) hingga seterusnya
         * -Jika menemukan pendamping dengan prioritas pertama (walau tidak sesuai urutan adil pendamping), maka pendamping langsung diplottingkan pada pendampingan tsb. Begitu juga jika didapatkan kecocokan kebutuhan skills pada prioritas kesekian        
         */

        // Mengisi semua jadwal madif dengan pendamping        
        foreach ($all_jadwal_madif as $key) {

            // Deklarasi variabel temp jadwal_sesuai, untuk menampung id_pendamping yang jadwalnya kosong
            $temp_jadwal_sesuai = [];

            //Jika jumlah damping sama, mengurutkan pendamping dari key terkecil hingga tebesar
            ksort($count_jumlah_damping);

            // Mengurutkan pendamping dari paling sedikit mendamping hingga paling banyak. Tidak berlaku bagi jumlah damping sama                    
            asort($count_jumlah_damping);

            // Ambil jenis difabel madif
            $jenis_difabel = $this->profile_mhs->getJenisMadif($key['id_profile_mhs']);

            // Deklarasi var jika jadwal pendamping ditemukan kosong
            $cek_dapat_jadwal = false;

            // Cek jadwal pendamping yang sesuai, sudah diurutkan berdasarkan banyaknya jumlah pendampingan dari tersedikit hingga terbanyak
            foreach ($count_jumlah_damping as $acuan => $isi) {

                // Mengambil jadwal pendamping sesuai dengan id pendamping
                $urutan_jadwal_pendamping = $this->jadwal_ujian->getJadwalUjian($acuan);

                // Mencari jadwal kosong pada pendamping dengan jumlah mendampingi sedikit
                foreach ($urutan_jadwal_pendamping as $ujp) {
                    // Peraturan tanggal sama, di waktu ujian berbeda
                    if ($key['tanggal_ujian'] == $ujp['tanggal_ujian']) {
                        // Aturan waktu beririsan                        
                        $rules = [
                            // start_waktu_pendamping <= start_madif, end_madif <= end_pendamping, waktu ujian madif beririsan di dalam waktu ujian pendamping
                            'rule1' => $key['waktu_mulai_ujian'] >= $ujp['waktu_mulai_ujian'] && $key['waktu_selesai_ujian'] <= $ujp['waktu_selesai_ujian'],
                            // start_pendamping >= start_madif, end_madif >= end_pendamping, waktu ujian pendamping beririsan di dalam waktu ujian madif
                            'rule2' => $key['waktu_mulai_ujian'] <= $ujp['waktu_mulai_ujian'] && $key['waktu_selesai_ujian'] >= $ujp['waktu_selesai_ujian'],
                            // start_pendamping <= end_madif <= end_pendamping, waktu selesai ujian madif beririsan diantara waktu ujian pendamping
                            'rule3' => $key['waktu_selesai_ujian'] >= $ujp['waktu_mulai_ujian'] && $key['waktu_selesai_ujian'] <= $ujp['waktu_selesai_ujian'],
                            // start_pendamping <= start_madif <= end_pendamping, waktu mulai ujian madif beririsan diantara waktu ujian pendamping
                            'rule4' => $key['waktu_mulai_ujian'] >= $ujp['waktu_mulai_ujian'] && $key['waktu_mulai_ujian'] <= $ujp['waktu_selesai_ujian'],
                        ];

                        // Jika beririsan maka pendamping sudah pasti tidak bisa mendampingi
                        if ($rules['rule1'] || $rules['rule2'] || $rules['rule3'] || $rules['rule4']) {
                            $insert['id_profile_pendamping'] = null;
                            // mencari pendamping lain
                            $cek_dapat_jadwal = false;
                            break;
                        }

                        // Jika tidak beririsan maka masukan pendamping
                        else {
                            $insert['id_profile_pendamping'] = $ujp['id_profile_mhs'];
                            $cek_dapat_jadwal = true;
                        }
                    }

                    // Peraturan tanggal ujian berbeda                    
                    elseif ($key['tanggal_ujian'] != $ujp['tanggal_ujian']) {
                        // Jika sampai eachloop akhir tidak ada jadwal tanggal ujian yang sama, maka masukkan dibawah ini                        
                        if (end($urutan_jadwal_pendamping) == $ujp) {
                            $insert['id_profile_pendamping'] = $ujp['id_profile_mhs'];
                            $cek_dapat_jadwal = true;
                        }
                    }
                }

                // Jika jadwal madif sudah terisi pendamping, maka true. Menghentikan pencarian pendamping
                if ($cek_dapat_jadwal) {
                    // break;
                    $temp_jadwal_sesuai[] = $acuan;
                }
            }

            $cek_dapat_pendamping_skill = false;
            // Cek skills pendamping yang sesuai, sudah diurutkan adil            
            if (!empty($temp_jadwal_sesuai)) {
                $max_jumlah_skill = 0;
                foreach ($temp_jadwal_sesuai as $t) {
                    $skills_pendamping = $this->profile_mhs->getSkills($t);
                    if ($max_jumlah_skill < count($skills_pendamping)) {
                        $max_jumlah_skill = count($skills_pendamping);
                    }
                }

                // Dicek dulu setiap user temp apakah pada prioritas 1 sesuai dengan kebutuhan jenis madif
                // kalau tidak, maka dilanjutkan ke user temp berikutnya dengan prioritas 1                
                for ($i = 0; $i < $max_jumlah_skill; $i++) {
                    foreach ($temp_jadwal_sesuai as $tjs) {
                        $skills_pendamping = $this->profile_mhs->getSkills($tjs);
                        if (isset($skills_pendamping[$i])) {
                            if ($skills_pendamping[$i]['ref_pendampingan'] == $jenis_difabel['id_jenis_difabel']) {
                                $insert['id_profile_pendamping'] = $skills_pendamping[$i]['id_profile_pendamping'];
                                $insert['ref_pendampingan'] = $skills_pendamping[$i]['ref_pendampingan'];
                                $insert['prioritas'] = $skills_pendamping[$i]['prioritas'];
                                $cek_dapat_pendamping_skill = true;
                                break;
                            }
                        }
                    }
                    if ($cek_dapat_pendamping_skill) {
                        $count_jumlah_damping[$skills_pendamping[0]['id_profile_pendamping']] += 1;
                        break;
                    }
                }

                // Jika tidak ada skill yang sesuai
                if (!$cek_dapat_pendamping_skill) {
                    $insert['id_profile_pendamping'] = $temp_jadwal_sesuai[0];
                    $count_jumlah_damping[$temp_jadwal_sesuai[0]] += 1;
                }
            }

            // Jika tidak ada skill yang sesuai
            if (!$cek_dapat_pendamping_skill) {
                $insert['ref_pendampingan'] = null;
                $insert['prioritas'] = null;
            }

            // Memasukkan madif dan pendamping ke pendampingan
            $insert['id_jadwal_ujian_madif'] = $key['id_jadwal_ujian'];
            $insert['id_profile_madif'] = $key['id_profile_mhs'];
            $damping_ujian_sementara[] = $insert;
        }

        return $this->viewGenerate($damping_ujian_sementara);
    }

    public function plottingSkill($data)
    {
        $jenis_difabel = $data['jenis_difabel'];
        unset($data['jenis_difabel']);
        $insert = [];
        $result = ['cek_get_pendamping_skill' => false,];

        $max_jumlah_skill = 0;
        foreach ($data as $ap) {
            $skills_pendamping = $this->profile_mhs->getSkills($ap['id_profile_mhs']);
            if ($max_jumlah_skill < count($skills_pendamping)) {
                $max_jumlah_skill = count($skills_pendamping);
            }
        }

        // Dicek dulu setiap user temp apakah pada prioritas 1 sesuai dengan kebutuhan jenis madif
        // kalau tidak, maka dilanjutkan ke user temp berikutnya dengan prioritas 1                
        for ($i = 0; $i < $max_jumlah_skill; $i++) {
            foreach ($data as $dt) {
                $skills_pendamping = $this->profile_mhs->getSkills($dt['id_profile_mhs']);
                if (isset($skills_pendamping[$i])) {
                    if ($skills_pendamping[$i]['ref_pendampingan'] == $jenis_difabel['id']) {
                        $insert['id_profile_pendamping'] = $skills_pendamping[$i]['id_profile_pendamping'];
                        $insert['ref_pendampingan'] = $skills_pendamping[$i]['ref_pendampingan'];
                        $insert['prioritas'] = $skills_pendamping[$i]['prioritas'];
                        $result['cek_get_pendamping_skill'] = true;
                        $result[] = $insert;
                        break;
                    }
                }
            }
        }
        return $result;
    }

    // Simpan Pendamping Alternatif untuk pendampingan tidak ada pendamping
    public function savePendampingAlt()
    {
        $id_damping = $this->request->getVar('id_damping');
        $pendamping_alt = $this->request->getVar('pendamping_alt');
        $this->damping_ujian->update($id_damping, ['id_profile_pendamping' => $pendamping_alt]);
        session()->setFlashdata('berhasil', 'Pendamping berhasil dimasukkan ke jadwal pendampingan');
        return redirect()->back();
    }

    public function saveGenerate()
    {
        $getArray = $this->request->getVar();
        $data = $getArray['v_damping'];
        $simpan_generate = [];
        dd($data);

        for ($i = 0; $i < count($data['id_jadwal_ujian_madif']); $i++) {
            foreach ($data as $key => $value) {
                if ($key == 'ref_pendampingan' || $key == 'prioritas') {
                    continue;
                }
                if (empty($value[$i])) {
                    $value[$i] = null;
                }
                $simpan_generate[$i][$key] = $value[$i];
            }
            $this->damping_ujian->save($simpan_generate[$i]);
            $this->damping_ujian->presensi($simpan_generate[$i]);
            $this->damping_ujian->save($simpan_generate[$i]);
        }

        session()->setFlashdata('berhasil_generate', 'Jadwal Pendampingan Berhasil Digenerate');
        return view('admin/damping_ujian/index', $data);
    }

    public function changeStatus()
    {
        $status = $this->request->getUri()->getSegment(2);
        $id_damping = $this->request->getUri()->getSegment(3);

        if ($status == 'tolak_presensi_hadir' || $status == 'konfirmasi_presensi_hadir' || $status == 'pendampingan' || $status == 'laporan') {
            $this->presensi();
            if ($status == 'tolak_presensi_hadir') {
                $status = 'presensi_hadir';
            }
        }

        // d($status);
        // dd($id_damping);
        $this->damping_ujian->update($id_damping, ['status_damping' => $status]);
        return redirect()->back();
    }

    public function saveLaporan()
    {
        $id_damping = $this->request->getVar('id_damping');
        $madif = $this->request->getVar('madif');
        $rating = $this->request->getVar('rating');
        $review = $this->request->getVar('review_pendampingan');
        $status = '';
        $data['id_damping'] = $id_damping;

        // Mencari laporan
        $get_laporan = $this->db->table('laporan_damping')->getWhere(['id_damping' => $id_damping])->getRowArray();

        if (isset($get_laporan)) {
            $data['id_laporan_damping'] = $get_laporan['id_laporan_damping'];
            if ($madif == 1) {
                $data['madif_rating'] = $rating;
                $data['madif_review'] = $review;
            } else {
                $data['pendamping_rating'] = $rating;
                $data['pendamping_review'] = $review;
            }
            $this->laporan->update($data['id_laporan_damping'], $data);
            $status = 'selesai';
        } else {
            if ($madif == 1) {
                $data['madif_rating'] = $rating;
                $data['madif_review'] = $review;
                $status = 'pendamping_review';
            } else {
                $data['pendamping_rating'] = $rating;
                $data['pendamping_review'] = $review;
                $status = 'madif_review';
            }
            $this->laporan->insert($data);
        }
        $this->damping_ujian->update($id_damping, ['status_damping' => $status]);
        return redirect()->back();
    }

    public function presensi()
    {
        $status = $this->request->getUri()->getSegment(2);
        $id_damping = $this->request->getUri()->getSegment(3);

        $data = [
            'status' => $status,
            'id_damping' => $id_damping,
        ];

        $this->damping_ujian->presensi($data);

        return redirect()->back();
    }

    public function approval()
    {
        $get_id_laporan_damping = $this->request->getUri()->getSegment(3);
        $status = $this->request->getUri()->getSegment(4);
        if ($status == 'terima') {
            $this->laporan->update($get_id_laporan_damping, ['approval' => 1]);
        } elseif ($status == 'tolak') {
            $this->laporan->update($get_id_laporan_damping, ['approval' => 0]);
        }
        return redirect()->back();
    }
}
