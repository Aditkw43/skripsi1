<?php

namespace App\Controllers;

use CodeIgniter\I18n\Time;
use CodeIgniter\HTTP\Request;

use App\Models\m_biodata;
use App\Models\m_cuti;
use App\Models\m_damping_ujian;
use App\Models\m_izin_tidak_damping;
use App\Models\m_jadwal_ujian;
use App\Models\m_laporan_damping;
use App\Models\m_profile_mhs;

class c_perizinan extends BaseController
{

    protected $db, $builder, $builder2, $dataUser, $damping_ujian, $jadwal_ujian, $profile_mhs, $biodata, $laporan, $cuti, $izin;
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
        $this->cuti = model(m_cuti::class);
        $this->izin = model(m_izin_tidak_damping::class);
    }

    // Menampilkan view semua perizinan, khusus admin
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

        return view('admin/damping_ujian/index', $data);
    }

    public function viewAllCuti()
    {
        $get_all_cuti = $this->cuti->getAllCuti();
        $get_all_mhs = $this->profile_mhs->getAllProfileMhs();
        $cuti_semester_approval = [];
        $cuti_sementara_approval = [];
        $cuti_diterima = [];
        $cuti_ditolak = [];
        $hasil_cuti = [];

        foreach ($get_all_cuti as $key) {
            $get_profile = $this->biodata->getProfile($key['id_profile_mhs']);
            $get_biodata = $this->biodata->getBiodata($key['id_profile_mhs']);

            $tanggal = date_create($key['tanggal_selesai']);
            $tanggal_now = date_create(date('Y-m-d'));
            $diff = date_diff($tanggal, $tanggal_now);
            $insert = [
                'id_cuti' => $key['id_cuti'],
                'id_profile_mhs' => $key['id_profile_mhs'],
                'profile' => $get_profile,
                'biodata' => $get_biodata,
                'role' => ($get_profile['madif']) ? 'Madif' : 'Pendamping',
                'jenis_cuti' => $key['jenis_cuti'],
                'tanggal_mulai' => $key['tanggal_mulai'],
                'tanggal_selesai' => $key['tanggal_selesai'],
                'keterangan' => $key['keterangan'],
                'dokumen' => $key['dokumen'],
                'approval' => $key['approval'],
                'sisa_waktu' => $diff->days,
            ];
            $hasil_cuti[] = $insert;
        }

        foreach ($hasil_cuti as $key1) {
            if ($key1['approval'] === '1') {
                $cuti_diterima[] = $key1;
            } elseif ($key1['approval'] === '0') {
                $cuti_ditolak[] = $key1;
            } elseif ($key1['jenis_cuti'] == 'cuti_semester') {
                $cuti_semester_approval[] = $key1;
            } elseif ($key1['jenis_cuti'] == 'cuti_sementara') {
                $cuti_sementara_approval[] = $key1;
            }
        }

        $tambah_cuti = [];
        foreach ($get_all_mhs as $key2 => $value2) {
            $cek_belum_cuti = true;
            if (empty($value2['status']) || $value2['status'] === 0) {
                unset($get_all_mhs[$key2]);
                continue;
            }
            foreach ($cuti_diterima as $key3) {
                if ($value2['id_profile_mhs'] == $key3['id_profile_mhs']) {
                    $cek_belum_cuti = false;
                    break;
                }
            }
            if ($cek_belum_cuti) {
                $tambah_cuti[] = $value2;
            }
        }

        $data = [
            'title' => 'Seluruh Perizinan Cuti',
            'tambah_cuti' => $tambah_cuti,
            'hasil_cuti' => $hasil_cuti,
            'cuti_diterima' => $cuti_diterima,
            'cuti_ditolak' => $cuti_ditolak,
            'cuti_semester_approval' => $cuti_semester_approval,
            'cuti_sementara_approval' => $cuti_sementara_approval,
            'user' => $this->dataUser,
        ];
        // dd($data);

        return view('admin/verifikasi/perizinan/v_all_izin_cuti', $data);
    }

    public function viewAllIzin()
    {
        $get_all_izin = $this->izin->getAllIzin();
        $get_all_damping = $this->damping_ujian->getAllDamping();
        $tambah_izin = [];
        $izin_tanpa_pengganti_approval = [];
        $izin_ada_pengganti_approval = [];
        $izin_diterima = [];
        $izin_ditolak = [];
        $hasil_izin = [];

        foreach ($get_all_izin as $key) {
            $get_damping = $this->damping_ujian->getDetailDamping($key['id_damping_ujian']);
            $get_jadwal_ujian = $this->jadwal_ujian->getDetailUjian($get_damping['id_jadwal_ujian_madif']);

            $get_madif = $this->biodata->getBiodata($get_damping['id_profile_madif']);
            $get_pendamping_lama = $this->biodata->getBiodata($key['id_pendamping_lama']);
            $get_pendamping_baru = $this->biodata->getBiodata($key['id_pendamping_baru']);
            $get_profile_lama = $this->biodata->getProfile($key['id_pendamping_lama']);
            $get_profile_baru = $this->biodata->getProfile($key['id_pendamping_baru']);

            if (empty($key['id_pendamping_baru'])) {
                $pendamping_baru = null;
            } else {
                $pendamping_baru = $get_pendamping_baru + $get_profile_baru;
            }

            $insert = [
                'id_izin' => $key['id_izin'],
                'id_damping' => $get_damping['id_damping'],
                'jadwal_ujian' => $get_jadwal_ujian,
                'madif' => $get_madif['nickname'],
                'pendamping_lama' => $get_pendamping_lama + $get_profile_lama,
                'pendamping_baru' => $pendamping_baru,
                'keterangan' => $key['keterangan'],
                'approval_pengganti' => $key['approval_pengganti'],
                'approval_admin' => $key['approval_admin'],
                'dokumen' => $key['dokumen'],
            ];

            $hasil_izin[] = $insert;
        }

        foreach ($hasil_izin as $key1) {
            if ($key1['approval_admin'] === '1') {
                $izin_diterima[] = $key1;
            } elseif ($key1['approval_admin'] === '0') {
                $izin_ditolak[] = $key1;
            } elseif (empty($key1['approval_admin']) && empty($key1['pendamping_baru'])) {
                $izin_tanpa_pengganti_approval[] = $key1;
            } elseif (empty($key1['approval_admin']) && $key1['approval_pengganti'] === '1') {
                $izin_ada_pengganti_approval[] = $key1;
            }
        }

        // Tambah izin tidak damping
        $columns1 = array_column($get_all_damping, 'id_profile_pendamping');
        $columns2 = array_column($get_all_damping, 'id_damping');
        array_multisort($columns1, SORT_ASC, $columns2, SORT_ASC, $get_all_damping);

        foreach ($get_all_damping as $key2) {
            if (isset($key2['id_profile_pendamping']) && (($key2['status_damping'] == null) || ($key2['status_damping'] == 'presensi_hadir'))) {
                $cek_jadwal_belum_izin = true;
                // Cek jika jadwal sudah diajukan perizinan dan telah diverifikasi admin
                foreach ($izin_diterima as $key3) {
                    if ($key2['id_damping'] == $key3['id_damping']) {
                        $cek_jadwal_belum_izin = false;
                        break;
                    }
                }

                if ($cek_jadwal_belum_izin) {
                    // Id_damping, profile madif, profile pendamping, detail jadwal ujian
                    $profile_madif = $this->biodata->getProfile($key2['id_profile_madif']);
                    $profile_pendamping = $this->biodata->getProfile($key2['id_profile_pendamping']);

                    $biodata_madif = $this->biodata->getBiodata($key2['id_profile_madif']);
                    $biodata_pendamping = $this->biodata->getBiodata($key2['id_profile_pendamping']);

                    $jadwal_ujian = $this->jadwal_ujian->getDetailUjian($key2['id_jadwal_ujian_madif']);

                    $get_all_pendamping = $this->profile_mhs->getAllProfilePendamping();
                    $id_jenis_madif = $this->profile_mhs->getJenisMadif($profile_madif['id_profile_mhs']);
                    $jenis_madif = $this->profile_mhs->getKategoriDifabel($id_jenis_madif['id_jenis_difabel']);

                    $get_all_pendamping['jenis_difabel'] = $jenis_madif;

                    $find = $this->damping_ujian->plottingSkill($get_all_pendamping);
                    unset($get_all_pendamping['jenis_difabel']);

                    $data_pendamping_alt = [
                        'hasil_find_skill' => $find,
                        'get_all_pendamping' => $get_all_pendamping,
                    ];
                    $pendamping_alt = $this->damping_ujian->findPendampingAlt($data_pendamping_alt);

                    foreach ($pendamping_alt as $key4 => $value4) {
                        if ($value4['id_profile_pendamping'] == $profile_pendamping['id_profile_mhs']) {
                            unset($pendamping_alt[$key4]);
                            continue;
                        }
                        $pendamping_alt[$key4]['nickname'] = $value4['biodata_pendamping_alt']['nickname'];
                        unset($pendamping_alt[$key4]['biodata_pendamping_alt']);
                    }

                    $insert = [
                        'id_damping' => $key2['id_damping'],
                        'profile_madif' => $profile_madif + $biodata_madif,
                        'profile_pendamping' => $profile_pendamping + $biodata_pendamping,
                        'jadwal_ujian' => $jadwal_ujian,
                        'pendamping_alt' => $pendamping_alt,
                    ];

                    $tambah_izin[$insert['profile_pendamping']['id_profile_mhs']][] = $insert;
                    $tambah_izin[$insert['profile_pendamping']['id_profile_mhs']]['nickname_pendamping'] = $insert['profile_pendamping']['nickname'] . ' (' . $insert['profile_pendamping']['fakultas'] . ')';
                }
            }
        }
        // END Tambah Izin Tidak Dmaping

        // Approval perizinan tanpa pengganti
        $get_all_pendamping = $this->profile_mhs->getAllProfilePendamping();

        foreach ($get_all_pendamping as $gap) {
            $all_id_profile_pendamping[] = $gap['id_profile_mhs'];
        }

        if (!empty($izin_tanpa_pengganti_approval)) {
            foreach ($izin_tanpa_pengganti_approval as $key5 => $value5) {
                $get_all_pendamping = $this->profile_mhs->getAllProfilePendamping();

                $id_jenis_madif = $this->profile_mhs->getJenisMadif($value5['jadwal_ujian']['id_profile_mhs']);
                $jenis_madif = $this->profile_mhs->getKategoriDifabel($id_jenis_madif['id_jenis_difabel']);
                $get_all_pendamping['jenis_difabel'] = $jenis_madif;
                // Plotting skill
                $skill_sesuai = $this->damping_ujian->plottingSkill($get_all_pendamping);

                // START Plotting jadwal 
                foreach ($skill_sesuai as $kunci1 => $ss1) {
                    if ($value5['pendamping_lama']['id_profile_mhs'] == $ss1['id_profile_pendamping']) {
                        unset($skill_sesuai[$kunci1]);
                        continue;
                    }
                    $skill_sesuai[$kunci1] = $ss1['id_profile_pendamping'];
                }

                $data_plotting_jadwal = [
                    'jadwal_madif' => $value5['jadwal_ujian'],
                    'count_pendamping' => $skill_sesuai,
                ];
                $temp_jadwal_sesuai = $this->damping_ujian->plottingJadwal($data_plotting_jadwal);

                if ($temp_jadwal_sesuai) {
                    foreach ($temp_jadwal_sesuai as $kunci => $tjs) {
                        $get_profile = $this->biodata->getProfile($tjs);
                        $temp_jadwal_sesuai[$kunci] = $get_profile;
                    }
                } else {
                    $temp_jadwal_sesuai = $this->profile_mhs->getAllProfilePendamping();
                }
                // END Plotting Jadwal

                $data_pendamping_alt = [
                    'hasil_find_skill' => $temp_jadwal_sesuai,
                    'get_all_pendamping' => $get_all_pendamping,
                ];
                // find pendamping Alt
                d($temp_jadwal_sesuai);
                dd($data_pendamping_alt);
                $pendamping_alt = $this->damping_ujian->findPendampingAlt($data_pendamping_alt);

                unset($get_all_pendamping['jenis_difabel']);
                foreach ($pendamping_alt as $key7 => $value7) {
                    $prioritas = false;
                    $pendamping_alt[$key7]['nickname'] = $value7['biodata_pendamping_alt']['nickname'];
                    unset($pendamping_alt[$key7]['biodata_pendamping_alt']);
                    foreach ($temp_jadwal_sesuai as $key8) {
                        if ($value7['id_profile_pendamping'] == $key8['id_profile_mhs']) {
                            $pendamping_alt[$key7]['kecocokan_jadwal'] = true;
                            $prioritas = true;
                            break;
                        }
                    }

                    if (!$prioritas) {
                        $pendamping_alt[$key7]['kecocokan_jadwal'] = false;
                    }
                }
                d($pendamping_alt);
                d($temp_jadwal_sesuai);

                $izin_tanpa_pengganti_approval[$key5]['pendamping_alt'] = $pendamping_alt;
            }
        }
        // END Approval Perizinan tanpa pengganti

        $data = [
            'title' => 'Seluruh Perizinan Tidak Damping',
            'tambah_izin' => $tambah_izin,
            'hasil_izin' => $hasil_izin,
            'izin_diterima' => $izin_diterima,
            'izin_ditolak' => $izin_ditolak,
            'izin_tanpa_pengganti_approval' => $izin_tanpa_pengganti_approval,
            'izin_ada_pengganti_approval' => $izin_ada_pengganti_approval,
            'user' => $this->dataUser,
        ];
        dd($data);

        return view('admin/verifikasi/perizinan/v_all_izin_tidak_damping', $data);
    }

    public function viewCuti()
    {
        $nim = $this->request->getUri()->getSegment(2);
        $get_id_profile = $this->biodata->getProfileID($nim);
        $get_profile = $this->biodata->getProfile($get_id_profile);
        $get_cuti = $this->cuti->getAllCuti($get_profile);
        $insert_data_cuti = [];

        foreach ($get_cuti as $key) {
            $tanggal = date_create($key['tanggal_selesai']);
            $tanggal_now = date_create(date('Y-m-d'));
            $diff = date_diff($tanggal, $tanggal_now);
            $insert = [
                'id_cuti' => $key['id_cuti'],
                'id_profile_mhs' => $key['id_profile_mhs'],
                'jenis_cuti' => $key['jenis_cuti'],
                'tanggal_mulai' => $key['tanggal_mulai'],
                'tanggal_selesai' => $key['tanggal_selesai'],
                'keterangan' => $key['keterangan'],
                'dokumen' => $key['dokumen'],
                'approval' => $key['approval'],
                'sisa_waktu' => $diff->days,
            ];
            $insert_data_cuti[] = $insert;
        }

        $data = [
            'title' => 'Daftar Perizinan Cuti ',
            'user' => $this->dataUser,
            'get_cuti' => $insert_data_cuti,
            'id_mhs' => $get_id_profile,
        ];
        // dd($data);

        return view('mahasiswa/perizinan/v_cuti', $data);
    }

    public function viewIzin()
    {
        $nim = $this->request->getUri()->getSegment(2);
        $get_id_profile = $this->biodata->getProfileID($nim);
        $get_profile = $this->biodata->getProfile($get_id_profile);
        $get_izin = $this->izin->getAllIzin($get_profile);
        $insert_data_izin = [];
        $insert_data_damping = [];

        if (isset($get_izin)) {
            foreach ($get_izin as $key) {
                $get_damping = $this->damping_ujian->getDetailDamping($key['id_damping_ujian']);
                $get_jadwal_ujian = $this->jadwal_ujian->getDetailUjian($get_damping['id_jadwal_ujian_madif']);
                $get_madif = $this->biodata->getBiodata($get_damping['id_profile_madif']);
                $get_pendamping_baru = $this->biodata->getBiodata($key['id_pendamping_baru']);
                if (!isset($get_pendamping_baru['nickname'])) {
                    $get_pendamping_baru = null;
                } else {
                    $get_pendamping_baru = $get_pendamping_baru['nickname'];
                }

                $insert = [
                    'jadwal_ujian' => $get_jadwal_ujian,
                    'madif' => $get_madif['nickname'],
                    'pendamping_baru' => $get_pendamping_baru,
                    'keterangan' => $key['keterangan'],
                    'approval_pengganti' => $key['approval_pengganti'],
                    'approval_admin' => $key['approval_admin'],
                    'dokumen' => $key['dokumen'],
                ];
                $insert_data_izin[] = $insert;
            }
        }

        // Get pendampingan
        $get_pendampingan = $this->damping_ujian->getAllDamping($get_profile);
        $now = Time::now('Asia/Jakarta', 'id_ID');
        $now = $now->toDateString();

        if (isset($get_pendampingan)) {
            foreach ($get_pendampingan as $gp) {
                if (empty($gp['status_damping']) || $gp['status_damping'] == 'presensi_hadir') {

                    $get_detail_izin = $this->db->table('izin_tidak_damping')->select('*')->getWhere(['id_damping_ujian' => $gp['id_damping']])->getResultArray();
                    // Cek apakah perizinan sudah diverifikasi
                    $cek_izin = true;
                    if (isset($get_detail_izin)) {
                        foreach ($get_detail_izin as $gdi) {
                            if ($gdi['id_damping_ujian'] == $gp['id_damping']) {
                                if ($gdi['approval_pengganti'] === '0' || $gdi['approval_admin'] === '0') {
                                    continue;
                                } else {
                                    $cek_izin = false;
                                    break;
                                }
                            }
                        }
                    }

                    if ($cek_izin == false) {
                        continue;
                    }

                    $insert = [];
                    $jadwal_ujian = $this->jadwal_ujian->getDetailUjian($gp['id_jadwal_ujian_madif']);
                    if ($now > $jadwal_ujian['tanggal_ujian']) {
                        continue;
                    }

                    $profile_madif = $this->biodata->getProfile($gp['id_profile_madif']);
                    $biodata_madif = $this->biodata->getBiodata($gp['id_profile_madif']);
                    $id_jenis_madif = $this->profile_mhs->getJenisMadif($gp['id_profile_madif']);
                    $jenis_madif = $this->profile_mhs->getKategoriDifabel($id_jenis_madif['id_jenis_difabel']);
                    $profile_madif['jenis_madif'] = $jenis_madif['jenis'];

                    $profile_pendamping = $this->biodata->getProfile($gp['id_profile_pendamping']);
                    $biodata_pendamping = $this->biodata->getBiodata($gp['id_profile_pendamping']);

                    $data = [
                        'id_profile_pendamping' => $get_id_profile,
                        'id_damping' => $gp['id_damping'],
                        'jadwal_ujian_madif' => $jadwal_ujian,
                        'jenis_difabel' => $profile_madif['jenis_madif'],
                    ];

                    $pendamping_pengganti = $this->izin->findPendampingBaru($data);

                    $insert = [
                        'id_damping' => $gp['id_damping'],
                        'jadwal_ujian' => $jadwal_ujian,
                        'biodata_madif' => $profile_madif + $biodata_madif,
                        'biodata_pendamping' => (empty($profile_pendamping)) ? null : ($profile_pendamping + $biodata_pendamping),
                        'jenis_ujian' => $gp['jenis_ujian'],
                        'status_damping' => $gp['status_damping'],
                        'pendamping_pengganti' => $pendamping_pengganti,
                    ];

                    $insert_data_damping[] = $insert;
                }
            }
        }

        $data = [
            'title' => 'Daftar Perizinan Tidak Damping ',
            'user' => $this->dataUser,
            'get_damping' => $insert_data_damping,
            'get_izin' => $insert_data_izin,
            'id_mhs' => $get_id_profile,
        ];

        // dd($data);
        return view('mahasiswa/perizinan/v_izin', $data);
    }

    public function konfirmasi_pengganti()
    {
        $nim = $this->request->getUri()->getSegment(2);
        $get_id_profile = $this->biodata->getProfileID($nim);
        $get_profile = $this->biodata->getProfile($get_id_profile);
        $get_all_konfirmasi = $this->izin->getAllKonfirmasi($get_profile['id_profile_mhs']);
        $all_konfirmasi = [];
        $konfirmasi_diterima = [];
        $konfirmasi_ditolak = [];
        $get_konfirmasi = [];

        if (isset($get_all_konfirmasi)) {

            foreach ($get_all_konfirmasi as $key) {
                $get_damping = $this->damping_ujian->getDetailDamping($key['id_damping_ujian']);
                $get_jadwal_ujian = $this->jadwal_ujian->getDetailUjian($get_damping['id_jadwal_ujian_madif']);
                $get_biodata_madif = $this->biodata->getBiodata($get_damping['id_profile_madif']);
                $get_biodata_pendamping_lama = $this->biodata->getBiodata($key['id_pendamping_lama']);

                $get_id_jenis_difabel = $this->profile_mhs->getJenisMadif($get_biodata_madif['id_profile_mhs']);
                $jenis_difabel = $this->profile_mhs->getKategoriDifabel($get_id_jenis_difabel['id_jenis_difabel']);
                $get_profile_madif = $this->profile_mhs->getProfile($get_biodata_madif['id_profile_mhs']);
                $get_profile_madif['jenis_difabel'] = $jenis_difabel['jenis'];

                $get_profile_pendamping_lama = $this->profile_mhs->getProfile($get_biodata_pendamping_lama['id_profile_mhs']);

                $insert = [
                    'id_izin' => $key['id_izin'],
                    'id_damping' => $key['id_damping_ujian'],
                    'jadwal_ujian' => $get_jadwal_ujian,
                    'madif' => $get_biodata_madif + $get_profile_madif,
                    'pendamping_lama' => $get_biodata_pendamping_lama + $get_profile_pendamping_lama,
                    'keterangan' => $key['keterangan'],
                    'dokumen' => $key['dokumen'],
                    'approval_admin' => $key['approval_admin'],
                    'approval_pengganti' => $key['approval_pengganti'],
                ];

                $all_konfirmasi[] = $insert;
            }

            foreach ($all_konfirmasi as $key1) {
                if ($key1['approval_pengganti'] === '1') {
                    $konfirmasi_diterima[] = $key1;
                } elseif ($key1['approval_pengganti'] === '0') {
                    $konfirmasi_ditolak[] = $key1;
                } else {
                    $get_konfirmasi[] = $key1;
                }
            }
        } else {
            $get_konfirmasi = null;
            $konfirmasi_diterima = null;
            $konfirmasi_ditolak = null;
        }

        $data = [
            'title' => 'Konfirmasi Peralihan Pendamping',
            'user' => $this->dataUser,
            'get_all_konfirmasi' => $all_konfirmasi,
            'get_konfirmasi' => $get_konfirmasi,
            'get_diterima' => $konfirmasi_diterima,
            'get_ditolak' => $konfirmasi_ditolak,
            'id_mhs' => $get_id_profile,
        ];

        // dd($data);
        return view('mahasiswa/pendamping/v_konfirmasi_pengganti', $data);
    }

    public function saveCuti()
    {
        $get_admin = $this->request->getVar('admin');
        $get_id_profile_mhs = $this->request->getVar('id_profile_mhs');
        $get_jenis_cuti = $this->request->getVar('jenis_cuti');
        $get_alasan = $this->request->getVar('alasan');
        $get_dokumen = $this->request->getFile('dokumen');

        $get_semester = $this->request->getVar('semester');
        $get_year = Time::today();
        $get_year = $get_year->getYear();

        if ($get_jenis_cuti == 'cuti_semester' && $get_semester == 'ganjil') {
            $get_tanggal_mulai_cuti = $get_year . "-08-01";
            $get_tanggal_selesai_cuti = $get_year . "-12-30";
        } elseif ($get_jenis_cuti == 'cuti_semester') {
            $get_tanggal_mulai_cuti = $get_year . "-02-01";
            $get_tanggal_selesai_cuti = $get_year . "-06-30";
        } else {
            $get_tanggal_mulai_cuti = $this->request->getVar('tanggal_mulai_cuti');
            $get_tanggal_selesai_cuti = $this->request->getVar('tanggal_selesai_cuti');
        }
        $namaDokumen = null;

        if (file_exists($get_dokumen)) {
            // generate nama sampul random
            $namaDokumen = $get_dokumen->getRandomName();

            //pindahkan file ke folder img
            $get_dokumen->move('img/dokumen_izin/cuti', $namaDokumen);
        }

        $insert = [
            'id_profile_mhs' => $get_id_profile_mhs,
            'jenis_cuti' => $get_jenis_cuti,
            'tanggal_mulai' => $get_tanggal_mulai_cuti,
            'tanggal_selesai' => $get_tanggal_selesai_cuti,
            'keterangan' => $get_alasan,
            'dokumen' => $namaDokumen,
        ];

        if (isset($get_admin)) {
            $insert['approval'] = true;
            $get_nim_mhs = $this->profile_mhs->getProfile($get_id_profile_mhs);
            $this->db->table('users')->where(['username' => $get_nim_mhs['nim']])->update(['status' => false]);
            session()->setFlashdata('berhasil', 'Perizinan cuti berhasil ditambahkan');
        } else {
            session()->setFlashdata('berhasil', 'Perizinan cuti berhasil diajukan');
        }

        $this->cuti->save($insert);

        return redirect()->back();
    }

    public function saveIzin()
    {
        $get_admin = $this->request->getVar('admin');
        $get_id_profile_mhs = $this->request->getVar('id_profile_mhs');
        $get_id_damping = $this->request->getVar('id_damping');
        $get_pendamping_baru = $this->request->getVar('rekomen_pengganti');
        $get_alasan = $this->request->getVar('alasan');
        $get_dokumen = $this->request->getFile('dokumen');

        $namaDokumen = null;

        if (file_exists($get_dokumen)) {
            // generate nama sampul random
            $namaDokumen = $get_dokumen->getRandomName();
            //pindahkan file ke folder img
            $get_dokumen->move('img/dokumen_izin/izin', $namaDokumen);
        }

        $insert = [
            'id_damping_ujian' => $get_id_damping,
            'id_pendamping_lama' => $get_id_profile_mhs,
            'id_pendamping_baru' => $get_pendamping_baru,
            'keterangan' => $get_alasan,
            'dokumen' => $namaDokumen,
            'approval_pengganti' => null,
            'approval_admin' => null,
        ];

        if (isset($get_admin)) {
            $insert['approval_pengganti'] = true;
            $insert['approval_admin'] = true;
            session()->setFlashdata('berhasil', 'Perizinan tidak damping berhasil ditambahkan');
        } else {
            session()->setFlashdata('berhasil', 'Perizinan tidak damping berhasil diajukan');
        }

        $this->izin->save($insert);
        $this->damping_ujian->update($get_id_damping, ['id_profile_pendamping' => $get_pendamping_baru]);
        return redirect()->back();
    }

    public function approval_cuti()
    {
        $get_id_cuti = $this->request->getUri()->getSegment(3);
        $status = $this->request->getUri()->getSegment(4);
        if ($status == 'terima') {
            $this->cuti->update($get_id_cuti, ['approval' => 1]);
            $get_nim_mhs = $this->request->getUri()->getSegment(5);
            $this->db->table('users')->where(['username' => $get_nim_mhs])->update(['status' => false]);
        } elseif ($status == 'tolak') {
            $this->cuti->update($get_id_cuti, ['approval' => 0]);
        }
        return redirect()->back();
    }

    public function approval_izin()
    {
        $role = $this->request->getUri()->getSegment(3);
        $get_id_izin = $this->request->getUri()->getSegment(4);
        $status = $this->request->getUri()->getSegment(5);
        $approval = ($role == 'admin') ? 'approval_admin' : 'approval_pengganti';

        if ($status == 'terima') {
            if ($role == 'admin') {
                $get_id_damping = $this->request->getUri()->getSegment(6);
                $get_id_pengganti = $this->request->getUri()->getSegment(7);
                $this->damping_ujian->update($get_id_damping, ['id_profile_pendamping' => $get_id_pengganti, 'status_damping' => 'presensi_hadir']);
            }

            $this->izin->update($get_id_izin, [$approval => '1']);
        } elseif ($status == 'tolak') {
            $this->izin->update($get_id_izin, [$approval => '0']);
        }

        return redirect()->back();
    }
}
