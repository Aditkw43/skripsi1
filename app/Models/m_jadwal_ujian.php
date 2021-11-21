<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;
use PhpParser\Node\Stmt\Break_;

class m_jadwal_ujian extends Model
{

    protected $table = 'jadwal_ujian';
    protected $primaryKey = 'id_jadwal_ujian';
    protected $useTimestamps = true;
    protected $allowedFields = ['id_profile_mhs', 'mata_kuliah', 'tanggal_ujian', 'waktu_mulai_ujian', 'waktu_selesai_ujian', 'ruangan', 'keterangan', 'jenis_ujian', 'approval'];

    public function getAllJadwalUjian()
    {
        // Jadwal Madif
        $data['jadwal_madif'] = $this->builder()->select('jadwal_ujian.*')->join('profile_mhs', 'profile_mhs.id_profile_mhs=jadwal_ujian.id_profile_mhs')->orderBy('tanggal_ujian', 'asc')->orderBy('waktu_mulai_ujian', 'asc')->getWhere(['madif' => 1])->getResultArray();

        // Jadwal Pendamping
        $data['jadwal_pendamping'] = $this->builder()->select('jadwal_ujian.*')->join('profile_mhs', 'profile_mhs.id_profile_mhs=jadwal_ujian.id_profile_mhs')->orderBy('tanggal_ujian', 'asc')->orderBy('waktu_mulai_ujian', 'asc')->getWhere(['pendamping' => 1])->getResultArray();
        return $data;
    }

    public function getJadwalUjian($id_profile_mhs = 0)
    {
        return $this->where(['id_profile_mhs' => $id_profile_mhs])->orderBy('tanggal_ujian', 'asc')->findAll();
    }

    public function getJadwalUjianUTS($id_profile_mhs = 0)
    {
        return $this->where(['id_profile_mhs' => $id_profile_mhs, 'jenis_ujian' => 'UTS'])->orderBy('tanggal_ujian', 'asc')->findAll();
    }

    public function getJadwalUjianUAS($id_profile_mhs = 0)
    {
        return $this->where(['id_profile_mhs' => $id_profile_mhs, 'jenis_ujian' => 'UAS'])->orderBy('tanggal_ujian', 'asc')->findAll();
    }

    public function getDetailUjian($id_jadwal = 0)
    {
        return $this->where(['id_jadwal_ujian' => $id_jadwal])->first();
    }

    public function updateJadwalUjian($data)
    {
        /**
         * Urutan Validasi Jadwal Ujian
         * 1.Melakukan validasi inputan tanggal dan waktu mulai ujian dengan tanggal dan waktu sekarang
         * -Jika masukkan tanggal ujian kurang dari tanggal sekarang, maka validasi gagal
         * -Jika masukkan tanggal ujian tepat dengan tanggal sekarang , namun waktu mulai ujian kurang dari waktu sekarang, maka validasi gagal   
         * 
         * 2.Melakukan validasi inputan matkul dengan jadwal lain di tanggal yang sama
         * -Jika pada tanggal yang sama terdapat matkul yang sama, maka validasi gagal
         * 
         * 3.Melakukan validasi tanggal dengan jam ujian yang beririsan
         * -Jika pada tanggal yang sama terdapat waktu ujian yang beririsan, maka validasi gagal
         * a.waktu ujian lain beririsan di dalam waktu inputan
         * b.waktu inputan beririsan di dalam waktu ujian lain
         * c.waktu selesai ujian lain beririsan diantara waktu inputan
         * d.waktu mulai ujian lain beririsan diantara waktu inputan
         * 
         * 4.Melakukan validasi urutan waktu yang sesuai
         * -Jika urutan waktu mulai ujian dengan selesai ujian tidak sesuai, maka validasi gagal
         * 
         * Return dikembalikan berupa boolean
         * jika true, maka jadwal ujian tersimpan
         * jika false, maka jadwal ujian tidak disimpan dan memberikan pesan kesalahan
         */


        // Melakukan deklarasi variabel        
        $now = Time::now('Asia/Jakarta', 'id_ID');
        $date_now = $now->toDateString();
        $time_now = $now->toTimeString();
        $date = '';

        // Query untuk mencari jadwal ujian pada tanggal sama dengan user yang sedang digunakan
        $query = $this->where('tanggal_ujian', $data['tanggal_ujian'])->where('id_profile_mhs', $data['id_profile_mhs']);
        if (in_array('id_jadwal_ujian', $data)) {
            $query = $query->where('id_jadwal_ujian !=', $data['id_jadwal_ujian'])->findAll();
        } else {
            $query = $query->findAll();
        };
        $cek_tanggal_now = $data['tanggal_ujian'] >= $date_now;
        $cek_waktu_now = $data['waktu_mulai_ujian'] > $time_now;
        $cek_urutan_waktu = $data['waktu_mulai_ujian'] < $data['waktu_selesai_ujian'];

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
            'cek_mata_kuliah' => true,
            'cek_tanggal_ujian' => true,
            'cek_waktu_mulai_ujian' => true,
            'cek_waktu_selesai_ujian' => true,
        ];

        if (!empty($data['id_jadwal_ujian'])) {
            foreach ($validasi_edit_jadwal as $key => $value) {
                if ($validasi_edit_jadwal[$key] == $data[$key]) {
                    $validasi_edit_jadwal[$key] = false;
                }
            }
        }
        // End Edit jadwal Ujian        

        // Validasi inputan matkul dengan jadwal lain di tanggal yang sama
        if ($validasi_edit_jadwal['cek_mata_kuliah'] || $validasi_edit_jadwal['cek_tanggal_ujian']) {
            foreach ($query as $key => $value) {
                if ($value['mata_kuliah'] == $data['mata_kuliah']) {
                    $date = date("j F Y", strtotime($value['tanggal_ujian']));
                    $validasi['validasi'] = false;
                    $validasi['pesan'] = "Jadwal ujian " . $value['mata_kuliah'] . " sudah pernah tersimpan untuk tanggal " . $value['tanggal_ujian'];
                    $validasi['error'] = 'matkul_tanggal';
                    $validasi['saran'] = 'Mengganti mata kuliah selain ' . $value['mata_kuliah'] . ' atau mengganti tanggal ujian selain tanggal ' . $date;
                    return $validasi;
                }
            }
        }

        // Validasi inputan tanggal dan waktu mulai ujian dengan tanggal dan waktu sekarang
        if (!$cek_tanggal_now || !$cek_waktu_now) {
            $date = date("j F Y", strtotime($data['tanggal_ujian']));
            $validasi['validasi'] = false;
            $validasi['error'] = 'kalender';
            if (!$cek_tanggal_now) {
                $validasi['fail'] = 'tanggal';

                // Tanggal ujian sudah terlewat
                $validasi['pesan'] = "Tanggal " . $date . " sudah terlewat";
                $validasi['saran'] = 'Mengganti tanggal ujian';
                return $validasi;
            } elseif (!$cek_waktu_now && ($date_now == $data['tanggal_ujian'])) {
                $validasi['fail'] = 'waktu';

                // Waktu mulai ujian sudah terlewat
                $validasi['pesan'] = "Waktu mulai ujian jam " . $data['waktu_mulai_ujian'] . " sudah terlewat";
                $validasi['saran'] = 'Mengganti jam mulai ujian';
                return $validasi;
            } else {
                $validasi['validasi'] = true;
                unset($validasi['error']);
            }
        }

        // Validasi tanggal ujian sama dengan jam ujian yang beririsan
        if ($validasi_edit_jadwal['cek_waktu_mulai_ujian'] || $validasi_edit_jadwal['cek_waktu_selesai_ujian']) {
            foreach ($query as $key => $value) {
                // Variabel rule waktu
                $rules = [
                    // start_inputan <= start_waktu, end_waktu <= end_inputan, waktu ujian lain beririsan di dalam waktu inputan
                    'rule1' => $value['waktu_mulai_ujian'] >= $data['waktu_mulai_ujian'] && $value['waktu_selesai_ujian'] <= $data['waktu_selesai_ujian'],
                    // start_inputan >= start_waktu, end_waktu >= end_inputan, waktu inputan beririsan di dalam waktu ujian lain
                    'rule2' => $value['waktu_mulai_ujian'] <= $data['waktu_mulai_ujian'] && $value['waktu_selesai_ujian'] >= $data['waktu_selesai_ujian'],
                    // start_inputan <= end_waktu <= end_inputan, waktu selesai ujian lain beririsan diantara waktu inputan
                    'rule3' => $value['waktu_selesai_ujian'] >= $data['waktu_mulai_ujian'] && $value['waktu_selesai_ujian'] <= $data['waktu_selesai_ujian'],
                    // start_inputan <= start_waktu <= end_inputan, waktu mulai ujian lain beririsan diantara waktu inputan
                    'rule4' => $value['waktu_mulai_ujian'] >= $data['waktu_mulai_ujian'] && $value['waktu_mulai_ujian'] <= $data['waktu_selesai_ujian'],
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

    public function getApproval()
    {
    }

    public function approval()
    {
    }

    public function reject()
    {
    }

    public function getJadwalPendamping()
    {
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

        // Validasi inputan matkul dengan jadwal lain di tanggal yang sama
        if ($validasi_edit_jadwal['mata_kuliah'] || $validasi_edit_jadwal['tanggal_ujian']) {
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
