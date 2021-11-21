<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;
use Myth\Auth\Authorization\GroupModel;
use Myth\Auth\Models\UserModel;
use PhpParser\Node\Stmt\Break_;


class m_profile_admin extends Model
{
    protected $table = 'profile_admin';
    protected $primaryKey = 'id_profile_admin';
    protected $allowedFields = ['username', 'jabatan'];    

    public function getID($nim = 0)
    {
        $id = $this;
        $id->select('id_profile_mhs');
        $id->where('nim', $nim);
        $id = $id->first();
        return $id['id_profile_mhs'];
    }

    public function getProfile($id_profile_mhs = 0)
    {
        return $this->where('id_profile_mhs', $id_profile_mhs)->first();
    }

    public function getAllProfile($jenis_mhs = null)
    {
        if ($jenis_mhs == 'madif') {
            return $this->where('madif', 1)->findAll();
        }
        return $this->where('pendamping', 1)->findAll();
    }

    public function getSkills($id_profile_pendamping = 0)
    {
        $skill_pendamping = $this->builder();
        if ($id_profile_pendamping == 0) {
            $skill_pendamping = $skill_pendamping->select('profile_skills.*')
                ->join('profile_skills', 'profile_skills.id_profile_pendamping = profile_mhs.id_profile_mhs', 'right')
                ->orderBy('id_profile_pendamping', 'asc')
                ->orderBy('prioritas', 'asc')
                ->get()->getResultArray();
            return $skill_pendamping;
        }

        $skill_pendamping = $skill_pendamping->select('profile_skills.*')
            ->join('profile_skills', 'profile_skills.id_profile_pendamping = profile_mhs.id_profile_mhs', 'right')
            ->where('id_profile_pendamping', $id_profile_pendamping)
            ->orderBy('prioritas', 'asc')
            ->get()->getResultArray();

        return $skill_pendamping;
    }

    public function getJenisMadif($id_profile_madif = 0)
    {
        $jenis_madif = $this->builder();
        if ($id_profile_madif == 0) {
            $jenis_madif = $jenis_madif->select('profile_jenis_madif.*')
                ->join('profile_jenis_madif', 'profile_jenis_madif.id_profile_madif = profile_mhs.id_profile_mhs')
                ->get()->getResultArray();
            return $jenis_madif;
        }

        $jenis_madif = $jenis_madif->select('profile_jenis_madif.*')
            ->join('profile_jenis_madif', 'profile_jenis_madif.id_profile_madif = profile_mhs.id_profile_mhs')
            ->getWhere(['id_profile_madif' => $id_profile_madif])
            ->getRowArray();

        return $jenis_madif;
    }

    public function getKategoriDifabel($ref_pendampingan = 0)
    {
        if ($ref_pendampingan == 0) {
            return $this->db->table('kategori_difabel')->get()->getResultArray();
        }

        return $this->db->table('kategori_difabel')->getwhere(['id' => $ref_pendampingan])->getRowArray();
    }

    public function addSkillPendamping($data)
    {
        // Ambil daftar skill lama
        $skills_lama = $this->getSkills($data['id_profile_pendamping']);

        if ($data['ref_pendampingan'] == 0 || $data['prioritas'] == 0) {
            return false;
        }

        if ($data['prioritas'] == ((int)count($skills_lama) + 1)) {
            $this->db->table('profile_skills')->insert($data);
            return true;
        } else {
            foreach ($skills_lama as $row) {
                if ($row['prioritas'] == $data['prioritas']) {
                    for ($i = ((int)(count($skills_lama) + 1)); $i != (int) $data['prioritas']; $i--) {
                        $ganti = $this->db->query('SELECT * FROM profile_skills WHERE id_profile_pendamping = ' . $data['id_profile_pendamping'] . ' AND prioritas = ' . $i - 1)->getRowObject();

                        $add = [
                            'id_profile_pendamping' => $ganti->id_profile_pendamping,
                            'ref_pendampingan' => $ganti->ref_pendampingan,
                        ];
                        if ($i == count($skills_lama) + 1) {
                            $add['prioritas'] = $i;
                            $this->db->table('profile_skills')->where('id_profile_pendamping', $add['id_profile_pendamping'])->where('ref_pendampingan', $add['ref_pendampingan'])->update($add);
                            continue;
                        }
                        $add['prioritas'] = $i;
                        $this->db->table('profile_skills')->where('id_profile_pendamping', $add['id_profile_pendamping'])->where('ref_pendampingan', $add['ref_pendampingan'])->update($add);
                    }
                }
            }
        }

        // Masukkan data baru
        $data = [
            'id_profile_pendamping'  => (int) $data['id_profile_pendamping'],
            'ref_pendampingan' => (int) $data['ref_pendampingan'],
            'prioritas' => (int) $data['prioritas'],
        ];

        $this->db->table('profile_skills')->insert($data);
        return true;
    }

    public function editSkillPendamping($data)
    {
        /**
         * CASE
         * 1)Jika ref ganti, prior ganti
         * 2)Jika ref ganti, prior tetap
         * 3)Jika ref tetap, prior ganti
         * 
         * catatan: ref ganti sudah pasti tidak ada di skills_lama
         */

        //  Deklarasi cek_ref, cek_prioritas, dan cek
        $cek_ref = true;
        $cek_prioritas = true;

        // cek(untuk melihat apakah data inputan sama persis dengan di daftar skill pendamping)
        if ($data['old_ref_pendampingan'] == $data['ref_pendampingan'] && $data['old_prioritas'] == $data['prioritas']) {
            return (bool) false;
        }

        // Mengecek apakah data skill lama sama dengan data inputan
        if ($data['old_ref_pendampingan'] != $data['ref_pendampingan']) {
            $cek_ref = false;
        }
        if ($data['old_prioritas'] != $data['prioritas']) {
            $cek_prioritas = false;
            // Mengecek apakah data inputan lebih besar dari data lama
            if ($data['old_prioritas'] > $data['prioritas']) {
                $data['sorting'] = 'data_atas_turun';
            } else {
                $data['sorting'] = 'data_bawah_naik';
            }
        }

        // Jika data inputan mengubah referensi pendamping 
        if (!$cek_ref) {
            // Jika data inputan mengubah prioritas skill
            if (!$cek_prioritas) {
                if ($data['sorting'] == 'data_atas_turun') {

                    // Turunkan prioritas skill lainnya
                    for ($i = (int) $data['old_prioritas']; $i > $data['prioritas']; $i--) {
                        $ganti = $this->db->query('SELECT * FROM profile_skills WHERE id_profile_pendamping = ' . $data['id_profile_pendamping'] . ' AND prioritas = ' . ($i - 1))->getRowObject();

                        $insert = [
                            'id_profile_pendamping' => $ganti->id_profile_pendamping,
                            'ref_pendampingan' => $ganti->ref_pendampingan,
                            'prioritas' => $ganti->prioritas + 1,
                            'approval' => $ganti->approval,
                        ];

                        $this->db->table('profile_skills')->where('id_profile_pendamping', $data['id_profile_pendamping'])->where('prioritas', $i)->replace($insert);
                    }
                } elseif ($data['sorting'] == 'data_bawah_naik') {

                    // Naikkan prioritas skill lainnya
                    for ($i = (int) $data['old_prioritas']; $i < $data['prioritas']; $i++) {
                        $ganti = $this->db->query('SELECT * FROM profile_skills WHERE id_profile_pendamping = ' . $data['id_profile_pendamping'] . ' AND prioritas = ' . ($i + 1))->getRowObject();

                        $insert = [
                            'id_profile_pendamping' => $ganti->id_profile_pendamping,
                            'ref_pendampingan' => $ganti->ref_pendampingan,
                            'prioritas' => $ganti->prioritas - 1,
                            'approval' => $ganti->approval,
                        ];

                        $this->db->table('profile_skills')->where('id_profile_pendamping', $insert['id_profile_pendamping'])->where('prioritas', $i)->replace($insert);
                    }
                }

                // Memasukkan data baru
                $insert = [
                    'id_profile_pendamping'  => (int) $data['id_profile_pendamping'],
                    'ref_pendampingan' => (int) $data['ref_pendampingan'],
                    'prioritas' => (int) $data['prioritas'],
                ];

                $this->db->table('profile_skills')->insert($insert);
            } else {
                $insert = [
                    'id_profile_pendamping'  => (int) $data['id_profile_pendamping'],
                    'ref_pendampingan' => (int) $data['ref_pendampingan'],
                    'prioritas' => (int) $data['prioritas'],
                    'approval' => $data['approval'],
                ];
                $this->db->table('profile_skills')->where('id_profile_pendamping', $insert['id_profile_pendamping'])->where('prioritas', $insert['prioritas'])->replace($insert);
            }

            // Jika skill ditolak, dan mau mengubah ulang skill
            if (isset($data['skill_ditolak'])) {
                $this->db->table('profile_skills')->Where('id_profile_pendamping', $data['id_profile_pendamping'])->where('ref_pendampingan', $data['ref_pendampingan'])->update(['approval' => null]);
            }
            // Jika referensi pendamping tidak berubah, namun prioritas skill berubah
        } else {
            if ($data['sorting'] == 'data_atas_turun') {
                // Turunkan prioritas skill lainnya
                for ($i = (int) $data['old_prioritas']; $i > $data['prioritas']; $i--) {
                    $ganti = $this->db->query('SELECT * FROM profile_skills WHERE id_profile_pendamping = ' . $data['id_profile_pendamping'] . ' AND prioritas = ' . ($i - 1))->getRowObject();

                    $insert = [
                        'id_profile_pendamping' => $ganti->id_profile_pendamping,
                        'ref_pendampingan' => $ganti->ref_pendampingan,
                        'prioritas' => $ganti->prioritas + 1,
                        'approval' => $ganti->approval,
                    ];

                    $this->db->table('profile_skills')->where('id_profile_pendamping', $insert['id_profile_pendamping'])->where('prioritas', $i)->replace($insert);
                }
            } elseif ($data['sorting'] == 'data_bawah_naik') {

                // Naikkan prioritas skill lainnya
                for ($i = (int) $data['old_prioritas']; $i < $data['prioritas']; $i++) {
                    $ganti = $this->db->query('SELECT * FROM profile_skills WHERE id_profile_pendamping = ' . $data['id_profile_pendamping'] . ' AND prioritas = ' . ($i + 1))->getRowObject();

                    $insert = [
                        'id_profile_pendamping' => $ganti->id_profile_pendamping,
                        'ref_pendampingan' => $ganti->ref_pendampingan,
                        'prioritas' => $ganti->prioritas - 1,
                        'approval' => $ganti->approval,
                    ];

                    d($insert);

                    $this->db->table('profile_skills')->where('id_profile_pendamping', $insert['id_profile_pendamping'])->where('prioritas', $i)->replace($insert);
                }
            }
            // Memasukkan data baru
            $insert = [
                'id_profile_pendamping'  => (int) $data['id_profile_pendamping'],
                'ref_pendampingan' => (int) $data['ref_pendampingan'],
                'prioritas' => (int) $data['prioritas'],
                'approval' => (isset($data['approval'])) ? $data['approval'] : null,
            ];

            $this->db->table('profile_skills')->insert($insert);
        }


        return true;
    }

    public function removeSkillPendamping($data)
    {
        $skills_lama = $this->getSkills($data['id_profile_pendamping']);

        foreach ($skills_lama as $row) {
            if ($row['prioritas'] == $data['prioritas']) {
                for ($i = $row['prioritas']; $i < count($skills_lama) + 1; $i++) {
                    $ganti = $this->db->query('SELECT * FROM profile_skills WHERE id_profile_pendamping = ' . $data['id_profile_pendamping'] . ' AND prioritas = ' . $i)->getRowObject();

                    $data['id_profile_pendamping'] = $ganti->id_profile_pendamping;
                    $data['ref_pendampingan'] = $ganti->ref_pendampingan;
                    if ($i == $row['prioritas']) {
                        d($data);
                        $data['prioritas'] = $i;
                        $this->db->table('profile_skills')->where('id_profile_pendamping', $data['id_profile_pendamping'])->where('ref_pendampingan', $data['ref_pendampingan'])->delete();
                        d($i);
                        continue;
                    }
                    $data['prioritas'] = $i - 1;
                    d($data);
                    $this->db->table('profile_skills')->where('id_profile_pendamping', $data['id_profile_pendamping'])->where('ref_pendampingan', $data['ref_pendampingan'])->update($data);
                    d($i);
                }
                break;
            }
        }
    }

    public function updateJenisDifabel($data)
    {
        $this->db->table('profile_jenis_madif')->replace($data);
    }

    public function approval_skill($data = null)
    {
        $approval = $this->db->table('profile_skills')->Where('id_profile_pendamping', $data['id_profile_pendamping'])->where('ref_pendampingan', $data['ref_pendampingan']);

        if ($data['approval'] == 'terima') {
            return $approval->update(['approval' => true]);
        } else {
            return $approval->update(['approval' => false]);
        }
    }

    public function approval_jenis_madif($data = null)
    {
        $approval = $this->db->table('profile_jenis_madif')->Where('id_profile_madif', $data['id_profile_madif']);

        if ($data['approval'] == 'terima') {
            return $approval->update(['approval' => true]);
        } else {
            return $approval->update(['approval' => false]);
        }
    }

    public function getAllKategoriDifabel($id_profile_pendamping = 0)
    {
        $builder = $this->db->query("SELECT * FROM kategori_difabel")->getResultArray();
        return $builder;
    }

    public function getProfileUser($nim = null)
    {
        $profile_user = $this;
        $profile_user->select('nim, fakultas, jurusan, prodi, semester, fullname');
        $profile_user->join('biodata', 'biodata.nim_mhs = profile_mhs.nim');
        $profile_user->where('nim_mhs', $nim);

        return $this->where(['nim' => $nim])->first();
    }

    public function getAllProfileMadif()
    {
        $biodata = $this;
        $biodata->select('profile_mhs.id_profile_mhs,nim,nickname,fullname,fakultas,jurusan,prodi,semester,name as role,users.status, kategori_difabel.jenis');
        $biodata->join('biodata', 'biodata.id_profile_mhs = profile_mhs.id_profile_mhs');
        $biodata->where('madif', 1);
        $biodata->join('users', 'users.username = profile_mhs.nim');
        $biodata->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $biodata->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $biodata->join('profile_jenis_madif', 'profile_jenis_madif.id_profile_madif = profile_mhs.id_profile_mhs');
        $biodata->join('kategori_difabel', 'kategori_difabel.id = profile_jenis_madif.id_jenis_difabel');

        return $biodata->findAll();
    }

    public function getAllProfilePendamping()
    {
        $biodata = $this;
        $biodata->select('profile_mhs.id_profile_mhs,nim,nickname,fullname,fakultas,jurusan,prodi,semester,name as role,users.status');
        $biodata->join('biodata', 'biodata.id_profile_mhs = profile_mhs.id_profile_mhs');
        $biodata->where('pendamping', 1);
        $biodata->join('users', 'users.username = profile_mhs.nim');
        $biodata->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $biodata->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');

        return $biodata->findAll();
    }

    public function getAllProfileAdmin()
    {
        $biodata = $this->db->table('profile_admin');
        $biodata->select('profile_admin.id_profile_admin,profile_admin.username,profile_admin.jabatan,biodata.nickname,biodata.fullname,biodata.jenis_kelamin, biodata.alamat,biodata.nomor_hp');
        $biodata->join('biodata', 'biodata.id_profile_admin = profile_admin.id_profile_admin');
        $biodata->join('users', 'users.username = profile_admin.username');
        $biodata->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $biodata->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');

        return $biodata->get()->getResultArray();
    }

    public function getAllProfileMhs()
    {
        $biodata = $this;
        $biodata->select('profile_mhs.id_profile_mhs,nim,nickname,fullname,fakultas,jurusan,prodi,semester,name as role,users.status, kategori_difabel.jenis');
        $biodata->join('biodata', 'biodata.id_profile_mhs = profile_mhs.id_profile_mhs');
        $biodata->join('users', 'users.username = profile_mhs.nim');
        $biodata->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $biodata->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $biodata->join('profile_jenis_madif', 'profile_jenis_madif.id_profile_madif = profile_mhs.id_profile_mhs', 'left');
        $biodata->join('kategori_difabel', 'kategori_difabel.id = profile_jenis_madif.id_jenis_difabel', 'left');
        $biodata->orderBy('id_profile_mhs', 'ASC');

        return $biodata->findAll();
    }

    public function getJumlahUjianMHS($nim = 0)
    {
        // ambil biodata
        $biodata = $this;
        $biodata->select('nim_jadwal');
        $biodata->join('jadwal_ujian', 'jadwal_ujian.nim_jadwal=nim');
        $biodata->where('nim_jadwal', $nim);
        return $biodata->countAllResults();
    }

    public function getUjianMhs($nim = 0)
    {
        $jadwal_ujian = $this;
        $jadwal_ujian->select('mata_kuliah,tanggal_ujian,waktu_mulai_ujian,waktu_selesai_ujian,ruangan,keterangan');
        $jadwal_ujian->join('jadwal_ujian', 'jadwal_ujian.nim_jadwal = profile_mhs.nim');
        $jadwal_ujian->where('nim_jadwal', $nim);

        return $jadwal_ujian->findAll();
    }

    public function getAllJadwal()
    {
        $builder = $this;
        $builder->select('nim, mata_kuliah, tanggal_ujian, waktu_mulai_ujian, waktu_selesai_ujian, ruangan, keterangan');
        $builder->join('jadwal_ujian', 'jadwal_ujian.nim_jadwal = profile_mhs.nim');
        $query = $builder->get();
        $dataMadif = $query->getRow();
        return $dataMadif;
    }

    public function getJadwalMadif()
    {
        // Query untuk User yang sedang berjalan
        $builder = $this;
        $builder->select('nim, mata_kuliah, tanggal_ujian, waktu_mulai_ujian, waktu_selesai_ujian, ruangan, keterangan');
        $builder->where('madif', 1);
        $builder->join('jadwal_ujian', 'jadwal_ujian.nim_jadwal = profile_mhs.nim');
        $query = $builder->get();
        $dataMadif = $query->getRow();
        return $dataMadif;
    }

    public function cekJadwal($userid, $matkul, $tgl, $waktu_awal, $waktu_selesai, $data_lama = [])
    {
        /*
        Urutan Validasi Jadwal Ujian
        1.Melakukan validasi inputan tanggal dan waktu mulai ujian dengan tanggal dan waktu sekarang
        -Jika masukkan tanggal ujian kurang dari tanggal sekarang, maka validasi gagal
        -Jika masukkan tanggal ujian tepat dengan tanggal sekarang , namun waktu mulai ujian kurang dari waktu sekarang, maka validasi gagal

        2.Melakukan validasi inputan matkul dengan jadwal lain di tanggal yang sama
        -Jika pada tanggal yang sama terdapat matkul yang sama, maka validasi gagal
        
        3.Melakukan validasi tanggal dengan jam ujian yang beririsan
        -Jika pada tanggal yang sama terdapat waktu ujian yang beririsan, maka validasi gagal
            a.waktu ujian lain beririsan di dalam waktu inputan
            a.waktu inputan beririsan di dalam waktu ujian lain
            a.waktu selesai ujian lain beririsan diantara waktu inputan
            a.waktu mulai ujian lain beririsan diantara waktu inputan

        4.Melakukan validasi urutan waktu yang sesuai
        -Jika urutan waktu mulai ujian dengan selesai ujian tidak sesuai, maka validasi gagal
        
        Return dikembalikan berupa boolean
        jika true, maka jadwal ujian tersimpan
        jika false, maka jadwal ujian tidak disimpan dan memberikan pesan kesalahan
        */

        // Melakukan deklarasi variabel        
        $now = Time::now('Asia/Jakarta', 'id_ID');
        $date_now = $now->toDateString();
        $time_now = $now->toTimeString();
        $date = '';

        // Query untuk mencari jadwal ujian pada tanggal sama dengan user yang sedang digunakan
        $query = $this->where('tanggal_ujian', $tgl)->where('user_id_jadwal', $userid)->findAll();

        $cek_tanggal_now = $tgl >= $date_now;
        $cek_waktu_now = $waktu_awal > $time_now;
        $cek_urutan_waktu = $waktu_awal < $waktu_selesai;

        $time = [
            'mulai_waktu_ujian' => '',
            'selesai_waktu_ujian' => '',
        ];

        $validasi = [
            'validasi' => true,
            'pesan' => "Jadwal Ujian Berhasil Dimasukkan",
        ];

        // Kebutuhan Validasi edit jadwal ujian
        $validasi_edit_jadwal = [
            'mata_kuliah' => true,
            'tanggal_ujian' => true,
            'mulai_waktu_ujian' => true,
            'selesai_waktu_ujian' => true,
        ];
        if (!empty($data_lama)) {
            foreach ($validasi_edit_jadwal as $key => $value) {
                if ($validasi_edit_jadwal[$key] == $data_lama[$key]) {
                    $validasi_edit_jadwal[$key] = false;
                }
            }
        }

        // End Edit jadwal Ujian

        // Validasi inputan tanggal dan waktu mulai ujian dengan tanggal dan waktu sekarang
        if (!$cek_tanggal_now || !$cek_waktu_now) {
            $date = date("j F Y", strtotime($tgl));
            $validasi['validasi'] = false;
            $validasi['error'] = 'kalender';
            if (!$cek_tanggal_now) {
                $validasi['fail'] = 'tanggal';

                // Tanggal ujian sudah terlewat
                $validasi['pesan'] = "Tanggal " . $date . " sudah terlewat";
                $validasi['saran'] = 'Mengganti tanggal ujian';
                return $validasi;
            } elseif (!$cek_waktu_now && ($date_now == $tgl)) {
                $validasi['fail'] = 'waktu';

                // Waktu mulai ujian sudah terlewat
                $validasi['pesan'] = "Waktu mulai ujian jam " . $waktu_awal . " sudah terlewat";
                $validasi['saran'] = 'Mengganti jam mulai ujian';
                return $validasi;
            } else {
                $validasi['validasi'] = true;
                unset($validasi['error']);
            }
        }

        // Validasi inputan matkul dengan jadwal lain di tanggal yang sama
        if ($validasi_edit_jadwal['mata_kuliah']) {
            foreach ($query as $key => $value) {
                if ($value['mata_kuliah'] == $matkul) {
                    $date = date("j F Y", strtotime($value['tanggal_ujian']));
                    $validasi['validasi'] = false;
                    $validasi['pesan'] = "Jadwal ujian " . $value['mata_kuliah'] . " sudah pernah tersimpan untuk tanggal " . $value['tanggal_ujian'];
                    $validasi['error'] = 'matkul_tanggal';
                    $validasi['saran'] = 'Mengganti mata kuliah selain ' . $value['mata_kuliah'] . ' atau mengganti tanggal ujian selain tanggal ' . $date;
                    return $validasi;
                }
            }
        }

        // Validasi tanggal ujian sama dengan jam ujian yang beririsan
        if ($validasi_edit_jadwal['mulai_waktu_ujian'] || $validasi_edit_jadwal['selesai_waktu_ujian']) {
            foreach ($query as $key => $value) {
                // Variabel rule waktu
                $rules = [
                    // start_inputan <= start_waktu, end_waktu <= end_inputan, waktu ujian lain beririsan di dalam waktu inputan
                    'rule1' => $value['mulai_waktu_ujian'] >= $waktu_awal && $value['selesai_waktu_ujian'] <= $waktu_selesai,
                    // start_inputan >= start_waktu, end_waktu >= end_inputan, waktu inputan beririsan di dalam waktu ujian lain
                    'rule2' => $value['mulai_waktu_ujian'] >= $waktu_awal && $value['selesai_waktu_ujian'] <= $waktu_selesai,
                    // start_inputan <= end_waktu <= end_inputan, waktu selesai ujian lain beririsan diantara waktu inputan
                    'rule3' => $value['selesai_waktu_ujian'] >= $waktu_awal && $value['selesai_waktu_ujian'] <= $waktu_selesai,
                    // start_inputan <= start_waktu <= end_inputan, waktu mulai ujian lain beririsan diantara waktu inputan
                    'rule4' => $value['mulai_waktu_ujian'] >= $waktu_awal && $value['mulai_waktu_ujian'] <= $waktu_selesai,
                ];
                if ($rules['rule1'] || $rules['rule2'] || $rules['rule3'] || $rules['rule4']) {
                    $date = date("j F Y", strtotime($value['tanggal_ujian']));
                    foreach ($time as $kunci => $nilai) {
                        $time[$kunci] = date('H:i', strtotime($value[$kunci]));
                    }
                    $validasi['validasi'] = false;
                    $validasi['pesan1'] = "Waktu ujian bertubrukan dengan jadwal ujian " . $value['mata_kuliah'] . " di tanggal yang sama";
                    $validasi['pesan2'] = "Jadwal ujian " . $value['mata_kuliah'] . " dimulai jam " . $time['mulai_waktu_ujian'] . " - " . $time['selesai_waktu_ujian'];
                    $validasi['error'] = 'tanggal_waktu';
                    $validasi['saran'] = 'Mengganti tanggal ujian selain tanggal ' . $date . ' atau mengganti waktu ujian diluar jam ' . $time['mulai_waktu_ujian'] . " - " . $time['selesai_waktu_ujian'];
                    return $validasi;
                }
            }
            d($validasi);
        }
        // Validasi urutan waktu yang sesuai        
        if (!$cek_urutan_waktu) {
            $validasi['validasi'] = false;
            $validasi['error'] = 'waktu';

            // Urutan waktu tidak sesuai
            $validasi['pesan'] = "Urutan jam selesai ujian harus setelah jam mulai ujian";
            $validasi['saran'] = 'memasukkan ulang jam ujian sesuai dengan urutan waktu yang benar';

            return $validasi;
        };

        return $validasi;
    }
}
