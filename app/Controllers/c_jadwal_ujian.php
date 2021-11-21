<?php

namespace App\Controllers;

use App\Models\m_biodata;
use App\Models\m_jadwal_ujian;
use App\Models\m_profile_mhs;

class c_jadwal_ujian extends BaseController
{
    protected $db, $builder, $builder2, $dataUser, $profile, $jadwal_ujian, $biodata;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        // Query untuk spesifikasi Auth       
        $this->builder = $this->db->table('users');
        $this->builder->select('users.id as userid, username, email,  name, user_image');
        $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');

        // Query untuk User yang sedang berjalan
        $this->builder2 = $this->db->table('users');
        $this->builder2->select('users.id as userid, username, email,  name, user_image');
        $this->builder2->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->builder2->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $this->builder2->where('users.id', user_id());
        $query = $this->builder2->get();
        $this->dataUser = $query->getRow();

        // Instansiasi Model Profile dan Jadwal Ujian
        $this->profile = model(m_profile_mhs::class);
        $this->jadwal_ujian = model(m_jadwal_ujian::class);
        $this->biodata = model(m_biodata::class);
    }

    // Melihat semua jadwal mahasiswa
    public function index()
    {
        $jenis_mhs = $this->request->getUri()->getSegment(2);
        $title = ($this->request->getUri()->getSegment(2) == 'madif') ? 'Mahasiswa Difabel' : 'Pendamping';

        // START
        $jadwal = [];
        $temp = [];
        $all_mhs = [];
        $builder_jadwal = '';
        $profile = model(m_profile_mhs::class);

        if ($jenis_mhs == 'madif') {
            $get_all_profile_madif = $profile->getAllProfile('madif');
            foreach ($get_all_profile_madif as $key) {
                $builder_jadwal = $this->db->table('jadwal_ujian')->select('nim,fullname, fakultas, semester')->join('profile_mhs', 'profile_mhs.id_profile_mhs=jadwal_ujian.id_profile_mhs')->orderBy('tanggal_ujian', 'asc')->orderBy('waktu_mulai_ujian', 'asc')->where('madif', 1)->join('biodata', 'biodata.id_profile_mhs = jadwal_ujian.id_profile_mhs')->getWhere(['profile_mhs.id_profile_mhs' => $key['id_profile_mhs']])->getResultArray();

                $get_bio = $this->biodata->getBiodata($key['id_profile_mhs']);
                $get_profile = $this->biodata->getProfile($key['id_profile_mhs']);
                $all_mhs[] = $get_bio + $get_profile;

                if (empty($builder_jadwal)) {
                    continue;
                }

                $temp = [
                    'id_profile_mhs' => $key['id_profile_mhs'],
                    'nim' => $key['nim'],
                    'nama' => $builder_jadwal[0]['fullname'],
                    'fakultas' => $builder_jadwal[0]['fakultas'],
                    'semester' => $builder_jadwal[0]['semester'],
                    'jumlah_ujian' => count($builder_jadwal),
                ];
                $jadwal[] = $temp;
            }
        } else {
            $get_all_profile_pendamping = $profile->getAllProfile('pendamping');
            foreach ($get_all_profile_pendamping as $key) {
                $builder_jadwal = $this->db->table('jadwal_ujian')->select('nim,fullname, fakultas, semester')->join('profile_mhs', 'profile_mhs.id_profile_mhs=jadwal_ujian.id_profile_mhs')->orderBy('tanggal_ujian', 'asc')->orderBy('waktu_mulai_ujian', 'asc')->where('pendamping', 1)->join('biodata', 'biodata.id_profile_mhs = jadwal_ujian.id_profile_mhs')->getWhere(['profile_mhs.id_profile_mhs' => $key['id_profile_mhs']])->getResultArray();

                $get_bio = $this->biodata->getBiodata($key['id_profile_mhs']);
                $get_profile = $this->biodata->getProfile($key['id_profile_mhs']);
                $all_mhs[] = $get_bio + $get_profile;

                if (empty($builder_jadwal)) {
                    continue;
                }

                $temp = [
                    'id_profile_mhs' => $key['id_profile_mhs'],
                    'nim' => $key['nim'],
                    'nama' => $builder_jadwal[0]['fullname'],
                    'fakultas' => $builder_jadwal[0]['fakultas'],
                    'semester' => $builder_jadwal[0]['semester'],
                    'jumlah_ujian' => count($builder_jadwal),
                ];
                $jadwal[] = $temp;
            }
        }
        // END        

        $data = [
            'title' => 'Daftar Semua Jadwal Ujian ' . $title,
            'jadwal_ujian' => $jadwal,
            'jenis_mhs' => $this->request->getUri()->getSegment(2),
            'all_mhs' => $all_mhs,
            'user' => $this->dataUser,
        ];
        // dd($data);

        return view('admin/jadwal_ujian/v_all_jadwal_ujian', $data);
    }

    // Melihat jadwal UTS mahasiswa 
    public function viewJadwalUTS()
    {
        // get id profile
        $id_profile_mhs = $this->profile->getID($this->request->getUri()->getSegment(2));
        $nama = $this->biodata->getBiodata($id_profile_mhs);

        $data = [
            'id_profile_mhs' => $id_profile_mhs,
            'nama_mhs' => $nama['nickname'],
            'title' => 'Daftar Jadwal Ujian UTS ',
            'jadwal' => $this->jadwal_ujian->getJadwalUjianUTS($id_profile_mhs),
            'jenis_ujian' => 'UTS',
        ];

        if ($this->dataUser->name == 'admin') {
            $data['user'] = $this->dataUser;
        } else {
            $this->builder->where('username', $this->request->getUri()->getSegment(2));
            $query = $this->builder->get();
            $data['user'] = $query->getRow();
        }
        // dd($data);

        return view('mahasiswa/jadwal_ujian/v_jadwal_ujian', $data);
    }

    // Melihat jadwal UAS mahasiswa
    public function viewJadwalUAS()
    {
        // get id profile
        $id_profile_mhs = $this->profile->getID($this->request->getUri()->getSegment(2));
        $nama = $this->biodata->getBiodata($id_profile_mhs);

        $data = [
            'id_profile_mhs' => $id_profile_mhs,
            'nama_mhs' => $nama['nickname'],
            'title' => 'Daftar Jadwal Ujian UAS ',
            'jadwal' => $this->jadwal_ujian->getJadwalUjianUAS($id_profile_mhs),
            'jenis_ujian' => 'UAS',
        ];

        if ($this->dataUser->name == 'admin') {
            $data['user'] = $this->dataUser;
        } else {
            $this->builder->where('username', $this->request->getUri()->getSegment(2));
            $query = $this->builder->get();
            $data['user'] = $query->getRow();
        }

        return view('mahasiswa/jadwal_ujian/v_jadwal_ujian', $data);
    }

    // Menyimpan jadwal mahasiswa
    public function saveJadwal()
    {
        $data = [
            'id_profile_mhs' => $this->request->getVar('id_profile_mhs'),
            'mata_kuliah' => $this->request->getVar('mata_kuliah'),
            'tanggal_ujian' => $this->request->getVar('tanggal_ujian'),
            'waktu_mulai_ujian' => $this->request->getVar('waktu_mulai_ujian'),
            'waktu_selesai_ujian' => $this->request->getVar('waktu_selesai_ujian'),
        ];

        // validasi input, return array
        $validasi = $this->jadwal_ujian->updateJadwalUjian($data);

        // Validasi = false; jika ada rules yang dilanggar
        if (!$validasi['validasi']) {
            if ($validasi['error'] == 'kalender') {
                session()->setFlashdata('fail_kalender', $validasi['fail']);
                session()->setFlashdata('validasi_kalender', $validasi['pesan']);
                session()->setFlashdata('saran_kalender', $validasi['saran']);
            } elseif ($validasi['error'] == 'waktu') {
                session()->setFlashdata('validasi_waktu_tidak_sesuai', $validasi['pesan']);
                session()->setFlashdata('saran_waktu_tidak_sesuai', $validasi['saran']);
            } elseif ($validasi['error'] == 'matkul_tanggal') {
                session()->setFlashdata('validasi_matkul_tanggal', $validasi['pesan']);
                session()->setFlashdata('saran_matkul_tanggal', $validasi['saran']);
            } elseif ($validasi['error'] == 'tanggal_waktu') {
                session()->setFlashdata('validasi_tanggal', $validasi['pesan1']);
                session()->setFlashdata('validasi_waktu', $validasi['pesan2']);
                session()->setFlashdata('saran_tanggal_waktu', $validasi['saran']);
            }
            session()->setFlashdata('gagal_ditambahkan', 'Jadwal ujian ' . $data['mata_kuliah'] . ' gagal ditambahkan');
            return redirect()->back()->withInput();
        }

        // Menyimpan dan Update Data ke Database
        $this->jadwal_ujian->save([
            'id_profile_mhs' => $data['id_profile_mhs'],
            'mata_kuliah' => $data['mata_kuliah'],
            'tanggal_ujian' => $data['tanggal_ujian'],
            'waktu_mulai_ujian' => $data['waktu_mulai_ujian'],
            'waktu_selesai_ujian' => $data['waktu_selesai_ujian'],
            'ruangan' => $this->request->getVar('ruangan'),
            'keterangan' => $this->request->getVar('keterangan'),
            'jenis_ujian' => $this->request->getVar('jenis_ujian'),
        ]);

        if (!empty($this->request->getVar('admin'))) {
            $this->jadwal_ujian->update($data['id_profile_mhs'], ['approval' => true]);
        }

        session()->setFlashdata('berhasil_ditambahkan', 'Jadwal berhasil ditambahkan');
        return redirect()->back();
    }

    // Update jadwal mahasiswa
    public function editJadwal()
    {
        $data = [
            'id_profile_mhs' => $this->request->getVar('id_profile_mhs'),
            'id_jadwal_ujian' => $this->request->getVar('id_jadwal_ujian'),
            'mata_kuliah' => $this->request->getVar('mata_kuliah'),
            'tanggal_ujian' => $this->request->getVar('tanggal_ujian'),
            'waktu_mulai_ujian' => $this->request->getVar('waktu_mulai_ujian'),
            'waktu_selesai_ujian' => $this->request->getVar('waktu_selesai_ujian'),
            'ruangan' => $this->request->getVar('ruangan'),
            'keterangan' => $this->request->getVar('keterangan'),
            'count' => 0
        ];

        $old_mata_kuliah = $this->jadwal_ujian->getDetailUjian($data['id_jadwal_ujian']);

        //Validasi jika hanya beberapa saja yang diubah, terkhusus jika matkul tidak diubah di tanggal yang sama
        $key = ['mata_kuliah', 'tanggal_ujian', 'waktu_mulai_ujian', 'waktu_selesai_ujian', 'ruangan', 'keterangan'];
        $jadwalLama = $this->jadwal_ujian->getDetailUjian($data['id_jadwal_ujian']);

        for ($i = 0; $i < sizeof($key); $i++) {
            if ($key[$i] == 'waktu_mulai_ujian' || $key[$i] == 'waktu_selesai_ujian') {
                $waktu_input = $this->request->getVar($key[$i]);
                $waktu_data_lama = $jadwalLama[$key[$i]];
                if ($waktu_input == $waktu_data_lama) {
                    $data['cek_' . $key[$i]] = true;
                    $data['count'] += 1;
                } else {
                    $data['cek_' . $key[$i]] = false;
                }
            } elseif ($key[$i] == 'ruangan' || $key[$i] == 'keterangan') {
                if ($this->request->getVar($key[$i]) == $jadwalLama[$key[$i]]) {
                    $data['cek_' . $key[$i]] = true;
                    $data['count'] += 1;
                } else {
                    $data['cek_' . $key[$i]] = false;
                }
            } elseif ($this->request->getVar($key[$i]) == $jadwalLama[$key[$i]]) {
                $data['cek_' . $key[$i]] = true;
                $data['count'] += 1;
            } else {
                $data['cek_' . $key[$i]] = false;
            }
        }

        if ($data['count'] == 6) {
            session()->setFlashdata('tidak_diedit', 'Tidak ada perubahan pada jadwal ujian ' . $data['mata_kuliah']);
            return redirect()->back();
        }

        // validasi jika tidak ada perubahan, return array
        $validasi = $this->jadwal_ujian->updateJadwalUjian($data);

        // Validasi = false; jika ada rules yang dilanggar
        if (!$validasi['validasi']) {
            if ($validasi['error'] == 'kalender') {
                session()->setFlashdata('fail_kalender', $validasi['fail']);
                session()->setFlashdata('validasi_kalender', $validasi['pesan']);
                session()->setFlashdata('saran_kalender', $validasi['saran']);
            } elseif ($validasi['error'] == 'waktu') {
                session()->setFlashdata('validasi_waktu_tidak_sesuai', $validasi['pesan']);
                session()->setFlashdata('saran_waktu_tidak_sesuai', $validasi['saran']);
            } elseif ($validasi['error'] == 'matkul_tanggal') {
                session()->setFlashdata('validasi_matkul_tanggal', $validasi['pesan']);
                session()->setFlashdata('saran_matkul_tanggal', $validasi['saran']);
            } elseif ($validasi['error'] == 'tanggal_waktu') {
                session()->setFlashdata('validasi_tanggal', $validasi['pesan1']);
                session()->setFlashdata('validasi_waktu', $validasi['pesan2']);
                session()->setFlashdata('saran_tanggal_waktu', $validasi['saran']);
            }
            session()->setFlashdata('gagal_diedit', 'Jadwal ujian ' . $old_mata_kuliah['mata_kuliah'] . ' pada tanggal ' . $old_mata_kuliah['tanggal_ujian'] . ' gagal diedit');
            return redirect()->back()->withInput()->with('idUjian', $data['id_jadwal_ujian']);
        }

        $id_jadwal_ujian = $data['id_jadwal_ujian'];
        unset($data['id_jadwal_ujian']);
        unset($data['count']);

        $this->jadwal_ujian->update($id_jadwal_ujian, $data);
        session()->setFlashdata('berhasil_diedit', 'Jadwal ' . $data['mata_kuliah'] . ' berhasil diedit');
        return redirect()->back();
    }

    // Delete jadwal mahasiswa
    public function delJadwal()
    {
        $matkul = $this->jadwal_ujian->getDetailUjian($this->request->getVar('id_jadwal_ujian'));
        $this->jadwal_ujian->delete($this->request->getVar('id_jadwal_ujian'));
        session()->setFlashdata('berhasil_dihapus', 'Jadwal ujian ' . $matkul['mata_kuliah'] . ' berhasil dihapus');
        return redirect()->back();
    }

    public function approval()
    {
        $get_id_jadwal = $this->request->getUri()->getSegment(3);
        $status = $this->request->getUri()->getSegment(4);
        if ($status == 'terima') {
            $this->jadwal_ujian->update($get_id_jadwal, ['approval' => 1]);
        } elseif ($status == 'tolak') {
            $this->jadwal_ujian->update($get_id_jadwal, ['approval' => 0]);
        }
        return redirect()->back();
    }
}
