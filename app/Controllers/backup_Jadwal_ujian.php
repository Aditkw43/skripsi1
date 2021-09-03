<?php

namespace App\Controllers;

use App\Models\m_biodata;
use App\Models\m_jadwal_ujian;
use App\Models\m_profile_mhs;

class backup_jadwal_ujian extends BaseController
{
    protected $db, $builder, $builder2, $dataUser, $profile, $jadwal_ujian, $biodata;
    public function __construct()
    {
        $this->db      = \Config\Database::connect();
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
        $data = [
            'title' => 'Daftar Semua Jadwal Ujian Mahasiswa',
            'jadwal' => $this->jadwal_ujian->getJadwalUjian()
        ];

        // $admin = $this->builder2->get();
        $data['user'] = $this->dataUser;

        return view('jadwal_ujian/index', $data);
    }

    // Melihat jadwal mahasiswa
    public function viewJadwal()
    {
        // get id profile
        $id_profile_mhs = $this->profile->getID($this->request->getUri()->getSegment(2));
        $nama = $this->biodata->getBiodata($id_profile_mhs);

        $data = [
            'id_profile_mhs' => $id_profile_mhs,
            'title' => 'Daftar Jadwal Ujian ' . $nama['nickname'],
            'jadwal' => $this->jadwal_ujian->getJadwalUjian($id_profile_mhs),
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
        ]);

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
        session()->setFlashdata('berhasil_dihapus', 'Jadwal ujian ' . $matkul['mata_kuliah'] . ' berhasil dihapus');
        $this->jadwal_ujian->delete($this->request->getVar('id_jadwal_ujian'));
        return redirect()->back();
    }






    // Update jadwal mahasiswa
    public function editJadwalBackup()
    {
        $data = [
            'id_profile_mhs' => $this->request->getVar('id_profile_mhs'),
            'id_ujian' => $this->request->getVar('id_jadwal_ujian'),
            'mata_kuliah' => $this->request->getVar('mata_kuliah'),
            'tanggal_ujian' => $this->request->getVar('tanggal_ujian'),
            'waktu_mulai_ujian' => $this->request->getVar('waktu_mulai_ujian'),
            'waktu_selesai_ujian' => $this->request->getVar('waktu_selesai_ujian'),
        ];

        //Validasi jika hanya beberapa saja yang diubah, terkhusus jika matkul tidak diubah di tanggal yang sama
        $key = ['mata_kuliah', 'tanggal_ujian', 'waktu_mulai_ujian', 'waktu_selesai_ujian', 'ruangan', 'keterangan'];
        $jadwalLama = $this->jadwalModel->getDetailUjian($id_ujian);
        $data_lama = [
            'id_jadwal_ujian' => $id_ujian,
            'count' => 0
        ];

        for ($i = 0; $i < sizeof($key); $i++) {
            if ($key[$i] == 'waktu_mulai_ujian' || $key[$i] == 'waktu_selesai_ujian') {
                $waktu_input = $this->request->getVar($key[$i]);
                $waktu_data_lama = $jadwalLama[$key[$i]];
                if ($waktu_input == $waktu_data_lama) {
                    $data_lama[$key[$i]] = true;
                    $data_lama['count'] += 1;
                } else {
                    $data_lama[$key[$i]] = false;
                }
            } elseif ($key[$i] == 'ruangan' || $key[$i] == 'keterangan') {
                if ($this->request->getVar($key[$i]) == $jadwalLama[$key[$i]]) {
                    $data_lama[$key[$i]] = true;
                    $data_lama['count'] += 1;
                } else {
                    $data_lama[$key[$i]] = false;
                }
            } elseif ($this->request->getVar($key[$i]) == $jadwalLama[$key[$i]]) {
                $data_lama[$key[$i]] = true;
                $data_lama['count'] += 1;
            } else {
                $data_lama[$key[$i]] = false;
            }
        }

        if ($data_lama['count'] == 6) {
            session()->setFlashdata('tidak_diedit', 'Tidak ada perubahan pada jadwal ujian ' . $matkul);
            return redirect()->back();
        }

        // validasi jika tidak ada perubahan, return array
        $validasi = $this->jadwalModel->cekJadwal($this->dataUser->username, $matkul, $tgl_ujian, $waktu_mulai, $waktu_selesai, $data_lama);

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
            session()->setFlashdata('gagal_diedit', 'Jadwal ujian ' . $matkul . ' gagal diedit');
            return redirect()->back()->withInput()->with('idUjian', $id_ujian);
        }

        $data = [
            'mata_kuliah' => $matkul,
            'tanggal_ujian' => $tgl_ujian,
            'waktu_mulai_ujian' => $waktu_mulai,
            'waktu_selesai_ujian' => $waktu_selesai,
            'ruangan' => $this->request->getVar('ruangan'),
            'keterangan' => $this->request->getVar('keterangan'),
        ];

        $this->jadwalModel->update($id_ujian, $data);
        session()->setFlashdata('berhasil_diedit', 'Jadwal ' . $matkul . ' berhasil diedit');
        return redirect()->back();
    }


    // Khusus admin
    public function allJadwalUjian()
    {
        $data = [
            'title' => 'Daftar Jadwal Ujian',
            'biodata' => '',
            'jadwal' => $jadwalUjian,
        ];

        // $admin = $this->builder2->get();
        $data['user'] = $this->dataUser;
        return view('admin/damping_ujian/index', $data);
    }

    public function jadwalMadif()
    {
        $data = [
            'title' => 'Daftar Jadwal Ujian Mahasiswa Difabel',
            'jadwal_madif' => $this->profile->getJadwalMadif(),
        ];

        $data['user'] = $this->dataUser;

        return view('admin/damping_ujian', $data);
    }

    // User Madif dan Pendamping akan langsung diarahkan
    public function jadwalUser($nim = 0)
    {
        $data = [
            'title' => 'Daftar Jadwal Ujian',
            'jadwal' => $this->jadwalModel->getJadwalUjian($nim)
        ];

        if ($nim == 0) {
            $data['user'] = $this->dataUser;
        } else {
            $this->builder->where('username', $nim);
            $query = $this->builder->get();
            $data['user'] = $query->getRow();
        }

        return view('jadwal_ujian/jadwalUser', $data);
    }

    public function save()
    {
        $matkul = $this->request->getVar('mata_kuliah');
        $tgl_ujian = $this->request->getVar('tanggal_ujian');
        $waktu_mulai = $this->request->getVar('waktu_mulai_ujian');
        $waktu_selesai = $this->request->getVar('waktu_selesai_ujian');

        // validasi input, return array
        $validasi = $this->jadwalModel->cekJadwal($this->dataUser->username, $matkul, $tgl_ujian, $waktu_mulai, $waktu_selesai);

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
            session()->setFlashdata('gagal_ditambahkan', 'Jadwal ujian ' . $matkul . ' gagal ditambahkan');
            return redirect()->back()->withInput();
        }

        // Menyimpan dan Update Data ke Database
        $this->jadwalModel->save([
            'nim_jadwal' => $this->dataUser->username,
            'mata_kuliah' => $matkul,
            'tanggal_ujian' => $tgl_ujian,
            'waktu_mulai_ujian' => $waktu_mulai,
            'waktu_selesai_ujian' => $waktu_selesai,
            'ruangan' => $this->request->getVar('ruangan'),
            'keterangan' => $this->request->getVar('keterangan'),
        ]);

        session()->setFlashdata('berhasil_ditambahkan', 'Jadwal berhasil ditambahkan');
        return redirect()->back();
    }
}
