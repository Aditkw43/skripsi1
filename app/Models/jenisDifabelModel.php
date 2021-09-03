<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;
use PhpParser\Node\Stmt\Break_;

class jenisDifabelModel extends Model
{
    protected $table = 'kategori_difabel';
    protected $useTimestamps = true;
    protected $allowedFields = ['jenis', 'description'];

    public function addPendampingToSkills(int $nim, int $id_skill, int $prioritas)
    {
        $profile_skills = $this->db->table('profile_skills');
        $query = $profile_skills->where('id_pendamping', $nim);


        $data = [
            'user_id'  => (int) $nim,
            'group_id' => (int) $id_skill
        ];

        return (bool) $this->db->table('profile_skills')->insert($data);
    }

    public function getSkills($id_skill = 0)
    {
        if ($id_skill == 0) {
            return $this->findAll();
        }

        return $this->where(['id' => $id_skill])->first();
    }

    public function getJenis($id_user = 0)
    {
        $profile_madif = model(profileModel::class);
        $profile_madif = $profile_madif->getProfile($id_user);
        $profile_jenis_difabel = $this->db->query('SELECT * FROM profile_jenis_difabel WHERE id_madif =' . $profile_madif['id_profile_mhs'])->getRow();
        $jenis = $this->where(['id' => $profile_jenis_difabel->id_jenis_difabel])->first();
        return $jenis['jenis'];
    }

    public function getPrioritas($id_pendamping = 0)
    {
        $prioritas = $this->db->query('SELECT * FROM profile_skills WHERE id_pendamping = ' . $id_pendamping)->getResultArray();
        return $prioritas;
    }

    public function getDetailUjian($idJadwal = 0)
    {
        return $this->where(['id_jadwal_ujian' => $idJadwal])->first();
    }

    public function addJenisMadif($id_madif = null, $jenis_difabel = null)
    {
        $data = [
            'id_madif' => $id_madif,
            'id_jenis_difabel' => $jenis_difabel,
        ];

        $this->db->table('profile_jenis_difabel')->insert($data);
    }

    public function editJenisMadif($nim = null, $jenis_difabel = null)
    {
        $profile_madif = model(profileModel::class);
        $profile_madif = $profile_madif->getProfile($nim);

        $data = [
            'id_madif' => $profile_madif['id_profile_mhs'],
            'id_jenis_difabel' => $jenis_difabel,
        ];

        $this->db->table('profile_jenis_difabel')->where('id_madif', $nim)->replace($data);
    }


    public function addSkills($id_pendamping = 0, $ref_pendampingan = 0, $prioritas = 0)
    {
        // Simpan data inputan
        $data = [
            'id_pendamping'  => (int) $id_pendamping,
            'ref_pendampingan' => (int) $ref_pendampingan,
            'prioritas' => (int) $prioritas,
        ];

        // Ambil daftar skill lama
        $skills_lama = $this->db->query('SELECT * FROM profile_skills WHERE id_pendamping = ' . $id_pendamping)->getResultArray();
        $jumlah_skills = count($skills_lama) + 1;
        if ($prioritas == $jumlah_skills) {
            $data = [
                'id_pendamping'  => (int) $id_pendamping,
                'ref_pendampingan' => (int) $ref_pendampingan,
                'prioritas' => (int) $prioritas,
            ];
            $this->db->table('profile_skills')->insert($data);
            return;
        } else {
            foreach ($skills_lama as $row) {
                if ($row['prioritas'] == $prioritas) {
                    for ($i = count($skills_lama) + 1; $i != (int) $prioritas; $i--) {
                        $ganti = $this->db->query('SELECT * FROM profile_skills WHERE id_pendamping = ' . $id_pendamping . ' AND prioritas = ' . $i - 1)->getRowObject();
                        $data['id_pendamping'] = $ganti->id_pendamping;
                        $data['ref_pendampingan'] = $ganti->ref_pendampingan;
                        if ($i == count($skills_lama) + 1) {
                            $data['prioritas'] = $i;
                            $this->db->table('profile_skills')->where('id_pendamping', $data['id_pendamping'])->where('ref_pendampingan', $data['ref_pendampingan'])->update($data);
                            continue;
                        }
                        $data['prioritas'] = $i;
                        $this->db->table('profile_skills')->where('id_pendamping', $data['id_pendamping'])->where('ref_pendampingan', $data['ref_pendampingan'])->update($data);
                    }
                }
            }
        }

        // Masukkan data baru
        $data = [
            'id_pendamping'  => (int) $id_pendamping,
            'ref_pendampingan' => (int) $ref_pendampingan,
            'prioritas' => (int) $prioritas,
        ];
        $this->db->table('profile_skills')->insert($data);
    }

    public function editSkill($id_pendamping = null, $ref_pendampingan = null, $prioritas = null, $get_old_prioritas = null)
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

        // Ambil data lama    
        $cek = $this->db->query('SELECT * FROM profile_skills WHERE id_pendamping = ' . $id_pendamping . ' AND ref_pendampingan = ' . $ref_pendampingan . ' AND prioritas = ' . $prioritas)->getResultArray();

        //  Simpan data inputan
        $data = [
            'id_pendamping'  => (int) $id_pendamping,
            'ref_pendampingan' => (int) $ref_pendampingan,
            'prioritas' => (int) $prioritas,
        ];

        // cek(untuk melihat apakah data inputan sama persis dengan di daftar skill pendamping)
        if ($cek) {
            return (bool) false;
        } else {
            // Jika tidak maka mengambil daftar skill pendamping
            $skills_lama = $this->db->query('SELECT * FROM profile_skills WHERE id_pendamping = ' . $id_pendamping)->getResultArray();
        }

        // Memasukkan data dari daftar skill pendamping ke var data_lama 
        foreach ($skills_lama as $key) {
            if ($key['prioritas'] == $get_old_prioritas) {
                $data_lama['ref_pendampingan'] = $key['ref_pendampingan'];
                $data_lama['prioritas'] = $key['prioritas'];
            }
        }

        // Mengecek apakah data skill lama sama dengan data inputan
        if ($data_lama['ref_pendampingan'] != $ref_pendampingan) {
            $cek_ref = false;
        }
        if ($data_lama['prioritas'] != $prioritas) {
            $cek_prioritas = false;
            // Mengecek apakah data inputan lebih besar dari data lama
            if ($data_lama['prioritas'] > $prioritas) {
                $data_lama['sorting'] = 'data_atas_turun';
            } else {
                $data_lama['sorting'] = 'data_bawah_naik';
            }
        }

        // Jika data inputan mengubah referensi pendamping 
        if (!$cek_ref) {
            // Jika data inputan mengubah prioritas skill
            if (!$cek_prioritas) {
                if ($data_lama['sorting'] == 'data_atas_turun') {

                    // Turunkan prioritas skill lainnya
                    for ($i = (int) $data_lama['prioritas']; $i > $prioritas; $i--) {
                        $ganti = $this->db->query('SELECT * FROM profile_skills WHERE id_pendamping = ' . $id_pendamping . ' AND prioritas = ' . ($i - 1))->getRowObject();

                        $data['id_pendamping'] = $ganti->id_pendamping;
                        $data['ref_pendampingan'] = $ganti->ref_pendampingan;
                        $data['prioritas'] = $ganti->prioritas + 1;

                        $this->db->table('profile_skills')->where('id_pendamping', $data['id_pendamping'])->where('prioritas', $i)->replace($data);
                    }
                } elseif ($data_lama['sorting'] == 'data_bawah_naik') {

                    // Naikkan prioritas skill lainnya
                    for ($i = (int) $data_lama['prioritas']; $i < $prioritas; $i++) {
                        $ganti = $this->db->query('SELECT * FROM profile_skills WHERE id_pendamping = ' . $id_pendamping . ' AND prioritas = ' . ($i + 1))->getRowObject();

                        $data['id_pendamping'] = $ganti->id_pendamping;
                        $data['ref_pendampingan'] = $ganti->ref_pendampingan;
                        $data['prioritas'] = $ganti->prioritas - 1;

                        $this->db->table('profile_skills')->where('id_pendamping', $data['id_pendamping'])->where('prioritas', $i)->replace($data);
                    }
                }
                // Memasukkan data baru
                $data = [
                    'id_pendamping'  => (int) $id_pendamping,
                    'ref_pendampingan' => (int) $ref_pendampingan,
                    'prioritas' => (int) $prioritas,
                ];
                $this->db->table('profile_skills')->insert($data);
            } else {
                $data['id_pendamping'] = $id_pendamping;
                $data['ref_pendampingan'] = $ref_pendampingan;
                $data['prioritas'] = $prioritas;
                $this->db->table('profile_skills')->where('id_pendamping', $data['id_pendamping'])->where('prioritas', $prioritas)->replace($data);
            }
            // Jika referensi pendamping tidak berubah, namun prioritas skill berubah
        } else {
            if ($data_lama['sorting'] == 'data_atas_turun') {
                // Turunkan prioritas skill lainnya
                for ($i = (int) $data_lama['prioritas']; $i > $prioritas; $i--) {
                    $ganti = $this->db->query('SELECT * FROM profile_skills WHERE id_pendamping = ' . $id_pendamping . ' AND prioritas = ' . ($i - 1))->getRowObject();

                    $data['id_pendamping'] = $ganti->id_pendamping;
                    $data['ref_pendampingan'] = $ganti->ref_pendampingan;
                    $data['prioritas'] = $ganti->prioritas + 1;

                    $this->db->table('profile_skills')->where('id_pendamping', $data['id_pendamping'])->where('prioritas', $i)->replace($data);
                }
            } elseif ($data_lama['sorting'] == 'data_bawah_naik') {

                // Naikkan prioritas skill lainnya
                for ($i = (int) $data_lama['prioritas']; $i < $prioritas; $i++) {
                    $ganti = $this->db->query('SELECT * FROM profile_skills WHERE id_pendamping = ' . $id_pendamping . ' AND prioritas = ' . ($i + 1))->getRowObject();

                    $data['id_pendamping'] = $ganti->id_pendamping;
                    $data['ref_pendampingan'] = $ganti->ref_pendampingan;
                    $data['prioritas'] = $ganti->prioritas - 1;

                    $this->db->table('profile_skills')->where('id_pendamping', $data['id_pendamping'])->where('prioritas', $i)->replace($data);
                }
            }
            // Memasukkan data baru
            $data = [
                'id_pendamping'  => (int) $id_pendamping,
                'ref_pendampingan' => (int) $ref_pendampingan,
                'prioritas' => (int) $prioritas,
            ];
            $this->db->table('profile_skills')->insert($data);
        }
        return true;
    }


    public function delSkill($id_p_ref)
    {
        $data = [];
        foreach ($id_p_ref as $key => $value) {
            $data[$key] = $value;
        };
        $skills_lama = $this->db->query('SELECT * FROM profile_skills WHERE id_pendamping = ' . $data['id_pendamping'])->getResultArray();
        d($id_p_ref);
        d($skills_lama);

        foreach ($skills_lama as $row) {
            if ($row['prioritas'] == $id_p_ref['prioritas']) {
                for ($i = $row['prioritas']; $i < (int) count($skills_lama) + 1; $i++) {
                    $ganti = $this->db->query('SELECT * FROM profile_skills WHERE id_pendamping = ' . $data['id_pendamping'] . ' AND prioritas = ' . $i)->getRowObject();
                    $data['id_pendamping'] = $ganti->id_pendamping;
                    $data['ref_pendampingan'] = $ganti->ref_pendampingan;
                    if ($i == $row['prioritas']) {
                        $data['prioritas'] = $i;
                        $this->db->table('profile_skills')->where('id_pendamping', $data['id_pendamping'])->where('ref_pendampingan', $data['ref_pendampingan'])->delete();
                        continue;
                    }
                    $data['prioritas'] = $i - 1;
                    $this->db->table('profile_skills')->where('id_pendamping', $data['id_pendamping'])->where('ref_pendampingan', $data['ref_pendampingan'])->update($data);
                }
            }
        }
    }

    public function cekJadwal($nim, $matkul, $tgl, $waktu_awal, $waktu_selesai, $data_input = [])
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
        $query = $this->where('tanggal_ujian', $tgl)->where('nim_jadwal', $nim);
        if (in_array('id_jadwal_ujian', $data_input)) {
            $query = $query->where('id_jadwal_ujian !=', $data_input['id_jadwal_ujian'])->findAll();
        } else {
            $query = $query->findAll();
        };
        $cek_tanggal_now = $tgl >= $date_now;
        $cek_waktu_now = $waktu_awal > $time_now;
        $cek_urutan_waktu = $waktu_awal < $waktu_selesai;

        $time = [
            'waktu_mulai_ujian' => '',
            'waktu_selesai_ujian' => '',
        ];

        $validasi = [
            'validasi' => true,
            'pesan' => "Jadwal Ujian Berhasil Dimasukkan",
        ];

        // Kebutuhan Validasi edit jadwal ujian
        $validasi_edit_jadwal = [
            'mata_kuliah' => true,
            'tanggal_ujian' => true,
            'waktu_mulai_ujian' => true,
            'waktu_selesai_ujian' => true,
        ];
        if (!empty($data_input)) {
            foreach ($validasi_edit_jadwal as $key => $value) {
                if ($validasi_edit_jadwal[$key] == $data_input[$key]) {
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
        if ($validasi_edit_jadwal['waktu_mulai_ujian'] || $validasi_edit_jadwal['waktu_selesai_ujian']) {
            foreach ($query as $key => $value) {
                // Variabel rule waktu
                $rules = [
                    // start_inputan <= start_waktu, end_waktu <= end_inputan, waktu ujian lain beririsan di dalam waktu inputan
                    'rule1' => $value['waktu_mulai_ujian'] >= $waktu_awal && $value['waktu_selesai_ujian'] <= $waktu_selesai,
                    // start_inputan >= start_waktu, end_waktu >= end_inputan, waktu inputan beririsan di dalam waktu ujian lain
                    'rule2' => $value['waktu_mulai_ujian'] <= $waktu_awal && $value['waktu_selesai_ujian'] >= $waktu_selesai,
                    // start_inputan <= end_waktu <= end_inputan, waktu selesai ujian lain beririsan diantara waktu inputan
                    'rule3' => $value['waktu_selesai_ujian'] >= $waktu_awal && $value['waktu_selesai_ujian'] <= $waktu_selesai,
                    // start_inputan <= start_waktu <= end_inputan, waktu mulai ujian lain beririsan diantara waktu inputan
                    'rule4' => $value['waktu_mulai_ujian'] >= $waktu_awal && $value['waktu_mulai_ujian'] <= $waktu_selesai,
                ];
                if ($rules['rule1'] || $rules['rule2'] || $rules['rule3'] || $rules['rule4']) {
                    $date = date("j F Y", strtotime($value['tanggal_ujian']));
                    foreach ($time as $kunci => $nilai) {
                        $time[$kunci] = date('H:i', strtotime($value[$kunci]));
                    }
                    $validasi['validasi'] = false;
                    $validasi['pesan1'] = "Waktu ujian bertubrukan dengan jadwal ujian " . $value['mata_kuliah'] . " di tanggal yang sama";
                    $validasi['pesan2'] = "Jadwal ujian " . $value['mata_kuliah'] . " dimulai jam " . $time['waktu_mulai_ujian'] . " - " . $time['waktu_selesai_ujian'];
                    $validasi['error'] = 'tanggal_waktu';
                    $validasi['saran'] = 'Mengganti tanggal ujian selain tanggal ' . $date . ' atau mengganti waktu ujian diluar jam ' . $time['waktu_mulai_ujian'] . " - " . $time['waktu_selesai_ujian'];
                    return $validasi;
                }
            }
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
