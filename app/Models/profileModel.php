<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;
use PhpParser\Node\Stmt\Break_;

class profileModel extends Model
{

    protected $table = 'profile_mhs';
    protected $primaryKey = 'id_profile_mhs';
    protected $allowedFields = ['user_nim', 'fakultas', 'jurusan', 'prodi', 'madif', 'pendamping'];

    // public function __construct($user_group_id)
    // {
    //     if ($user_group_id == 'admin') {
    //         $this->table = 'profile_admin';
    //         $this->primaryKey = 'id_profile_admin';
    //         $this->allowedFields = ['jabatan'];
    //     } else {
    //         $this->table = 'profile_mhs';
    //         $this->primaryKey = 'id_profile_mhs';
    //         $this->allowedFields = ['fakultas', 'jurusan', 'prodi', 'madif', 'pendamping'];
    //     }
    // }

    public function getProfile($username = null)
    {
        if ($username == null) {
            return $this->findAll();
        }

        return $this->where(['user_nim' => $username])->first();
    }

    public function getDetailUjian($idJadwal = 0)
    {
        return $this->where(['id_jadwal_ujian' => $idJadwal])->first();
    }

    public function getAllJadwal(){
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
