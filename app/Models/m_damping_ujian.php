<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;
use Config\ForeignCharacters;
use PhpParser\Node\Stmt\Break_;

class m_damping_ujian extends Model
{
    protected $table = 'damping_ujian';
    protected $primaryKey = 'id_damping';
    protected $useTimestamps = true;
    protected $allowedFields = ['id_jadwal_ujian_madif', 'id_profile_madif', 'id_profile_pendamping', 'jenis_ujian', 'status_damping'];

    public function hasilGenerate($data_damping_sementara)
    {
        $jadwal_ujian = model(m_jadwal_ujian::class);
        $biodata_mhs = model(m_biodata::class);
        $profile_pendamping = model(m_profile_mhs::class);
        $kunci = ['tanggal_ujian', 'mata_kuliah', 'waktu_mulai_ujian', 'waktu_selesai_ujian', 'ruangan', 'keterangan'];

        $hasil_generate = [];
        $insert = [];
        foreach ($data_damping_sementara as $key) {
            $detail_jadwal = $jadwal_ujian->getDetailUjian($key['id_jadwal_ujian_madif']);
            $detail_bio_madif = $biodata_mhs->getBiodata($key['id_profile_madif']);
            $detail_bio_pendamping = $biodata_mhs->getBiodata($key['id_profile_pendamping']);
            $nama_skill = $profile_pendamping->getKategoriDifabel($key['ref_pendampingan']);
            $prioritas_skill = $key['prioritas'];
            $insert['id_profile_madif'] = $detail_bio_madif['id_profile_mhs'];
            $insert['nama_madif'] = $detail_bio_madif['nickname'];

            // Get nama pendamping
            if (isset($key['id_profile_pendamping'])) {
                $insert['nama_pendamping'] = $detail_bio_pendamping['nickname'];
            } else {
                $insert['nama_pendamping'] = null;
            }

            // Memasukkan ref_pendampingan dan prioritas
            (isset($key['ref_pendampingan'])) ? ($insert['ref_pendampingan'] = $nama_skill['jenis']) : $insert['ref_pendampingan'] = '-';
            (isset($key['ref_pendampingan'])) ? ($insert['prioritas'] = $prioritas_skill) : $insert['prioritas'] = '-';

            // Get jadwal ujian
            foreach ($kunci as $k) {
                $insert[$k] = $detail_jadwal[$k];
            }
            $hasil_generate[] = $insert;
        }
        return $hasil_generate;
    }

    public function getDampingUTS($data = null)
    {
        if (empty($data)) {
            return $this->builder()->getWhere(['jenis_ujian' => 'UTS'])->getResultArray();
        }

        if ($data['pendamping'] == 1) {
            return $this->builder()->getWhere(['id_profile_pendamping' => $data['id_profile_mhs'], 'jenis_ujian' => 'UTS'])->getResultArray();
        }
        return $this->builder()->getWhere(['id_profile_madif' => $data['id_profile_mhs'], 'jenis_ujian' => 'UTS'])->getResultArray();
    }

    public function getDampingUAS($data = null)
    {
        if (empty($data)) {
            return $this->builder()->getWhere(['jenis_ujian' => 'UAS'])->getResultArray();
        }

        if ($data['pendamping'] == 1) {
            return $this->builder()->getWhere(['id_profile_pendamping' => $data['id_profile_mhs'], 'jenis_ujian' => 'UAS'])->getResultArray();
        }
        return $this->builder()->getWhere(['id_profile_madif' => $data['id_profile_mhs'], 'jenis_ujian' => 'UAS'])->getResultArray();
    }

    public function getAllDamping($data = null)
    {
        // Semua damping
        if (empty($data)) {
            return $this->findAll();
        }

        if ($data['pendamping'] == 1) {
            // Semua pendampingan sesuai dengan id profile mahasiswa
            return $this->builder()->select('*')->getWhere(['id_profile_pendamping' => $data['id_profile_mhs']])->getResultArray();
        } else {
            // Semua pendampingan sesuai dengan id profile mahasiswa
            return $this->builder()->select('*')->getWhere(['id_profile_madif' => $data['id_profile_mhs']])->getResultArray();
        }
    }

    public function getDetailDamping($id_damping = null)
    {
        return $this->find($id_damping);
    }

    public function updateDamping()
    {
    }

    public function presensi($data = null)
    {
        // Status kehadiran untuk menentukan apakah presensi telat atau tidak        
        $insert = [
            'id_damping_ujian' => $data['id_damping'],
            'tepat_waktu' => null,
            'waktu_hadir' => null,
            'waktu_selesai' => null,
            'approval_madif' => null,
        ];

        // Jika jadwal baru digenerate
        if (empty($data['status'])) {
            dd($insert);
        }

        // Waktu Melakukan Presensi
        $now = Time::now('Asia/Jakarta', 'id_ID');
        $waktu_presensi = $now->toTimeString();

        // Mengambil waktu ujian
        $m_jadwal = model(m_jadwal_ujian::class);
        $get_detail_damping = $this->getDetailDamping($data['id_damping']);
        $get_jadwal = $m_jadwal->getDetailUjian($get_detail_damping['id_jadwal_ujian_madif']);
        $get_waktu_mulai_ujian = $get_jadwal['waktu_mulai_ujian'];

        if ($data['status'] == 'konfirmasi_presensi_hadir') {
            // Tepat waktu untuk menentukan apakah presensi telat atau tidak
            $insert['tepat_waktu'] = $get_waktu_mulai_ujian > $waktu_presensi;
            $insert['waktu_hadir'] = $waktu_presensi;
            return $this->db->table('presensi')->insert($insert);
        } elseif ($data['status'] == 'pendampingan') {
            $insert = $this->getPresensi($insert['id_damping_ujian']);
            $insert['approval_madif'] = true;
        } elseif ($data['status'] == 'laporan') {
            $insert = $this->getPresensi($insert['id_damping_ujian']);
            $insert['waktu_selesai'] = $waktu_presensi;
        } else {
            return $this->db->table('presensi')->delete(['id_damping_ujian' => $insert['id_damping_ujian']]);
        }

        return $this->db->table('presensi')->update($insert, ['id_damping_ujian' => $insert['id_damping_ujian']]);
    }

    public function getPresensi($id_damping_ujian = 0)
    {
        return $this->db->table('presensi')->getWhere(['id_damping_ujian' => $id_damping_ujian])->getRowArray();
    }

    public function getLaporan($id_damping_ujian = 0)
    {
        return $this->db->table('laporan_damping')->getWhere(['id_damping' => $id_damping_ujian])->getRowArray();
    }

    public function plottingSkill($data)
    {
        // Variabel data adalah variabel yang menyimpan data pendamping yang telah dihimpun dan jenis difabel        
        $jenis_difabel = $data['jenis_difabel'];
        unset($data['jenis_difabel']);
        $insert = [];
        $result = [];
        $profile_mhs = model(m_profile_mhs::class);

        $max_jumlah_skill = 0;
        foreach ($data as $key) {
            $skills_pendamping = $profile_mhs->getSkills($key['id_profile_mhs']);
            if ($max_jumlah_skill < count($skills_pendamping)) {
                $max_jumlah_skill = count($skills_pendamping);
            }
        }

        // Dicek dulu setiap user temp apakah pada prioritas 1 sesuai dengan kebutuhan jenis madif
        // kalau tidak, maka dilanjutkan ke user temp berikutnya dengan prioritas 1                
        for ($i = 0; $i < $max_jumlah_skill; $i++) {
            foreach ($data as $key1) {
                $skills_pendamping = $profile_mhs->getSkills($key1['id_profile_mhs']);
                if (isset($skills_pendamping[$i])) {
                    if ($skills_pendamping[$i]['ref_pendampingan'] == $jenis_difabel['id']) {
                        $insert['id_profile_pendamping'] = $skills_pendamping[$i]['id_profile_pendamping'];
                        $insert['ref_pendampingan'] = $skills_pendamping[$i]['ref_pendampingan'];
                        $insert['prioritas'] = $skills_pendamping[$i]['prioritas'];
                        $result[] = $insert;
                        break;
                    }
                }
            }
        }
        return $result;
    }

    public function plottingJadwal($data)
    {
        // 1 Jadwal Madif yang Ingin Diplottingkan
        $jadwal_madif = $data['jadwal_madif'];
        // Semua Pendamping, type array
        $count_pendamping = $data['count_pendamping'];
        // Menyimpan pendmaping yang sesuai dengan jadwal
        $temp_jadwal_sesuai = [];
        // Cek Dapat Jadwal
        $cek_dapat_jadwal = false;
        // model jadwal ujian
        $jadwal_ujian = model(m_jadwal_ujian::class);

        // Cek jadwal pendamping yang sesuai, sudah diurutkan berdasarkan banyaknya jumlah pendampingan dari tersedikit hingga terbanyak
        foreach ($count_pendamping as $key) {
            // Mengambil jadwal pendamping sesuai dengan id pendamping
            $urutan_jadwal_pendamping = $jadwal_ujian->getJadwalUjian($key);

            // Mencari jadwal kosong pada pendamping dengan jumlah mendampingi sedikit
            foreach ($urutan_jadwal_pendamping as $key1) {
                // Peraturan tanggal sama, di waktu ujian berbeda
                if ($jadwal_madif['tanggal_ujian'] == $key1['tanggal_ujian']) {
                    // Aturan waktu beririsan                        
                    $rules = [
                        // start_waktu_pendamping <= start_madif, end_madif <= end_pendamping, waktu ujian madif beririsan di dalam waktu ujian pendamping
                        'rule1' => $jadwal_madif['waktu_mulai_ujian'] >= $key1['waktu_mulai_ujian'] && $jadwal_madif['waktu_selesai_ujian'] <= $key1['waktu_selesai_ujian'],
                        // start_pendamping >= start_madif, end_madif >= end_pendamping, waktu ujian pendamping beririsan di dalam waktu ujian madif
                        'rule2' => $jadwal_madif['waktu_mulai_ujian'] <= $key1['waktu_mulai_ujian'] && $jadwal_madif['waktu_selesai_ujian'] >= $key1['waktu_selesai_ujian'],
                        // start_pendamping <= end_madif <= end_pendamping, waktu selesai ujian madif beririsan diantara waktu ujian pendamping
                        'rule3' => $jadwal_madif['waktu_selesai_ujian'] >= $key1['waktu_mulai_ujian'] && $jadwal_madif['waktu_selesai_ujian'] <= $key1['waktu_selesai_ujian'],
                        // start_pendamping <= start_madif <= end_pendamping, waktu mulai ujian madif beririsan diantara waktu ujian pendamping
                        'rule4' => $jadwal_madif['waktu_mulai_ujian'] >= $key1['waktu_mulai_ujian'] && $jadwal_madif['waktu_mulai_ujian'] <= $key1['waktu_selesai_ujian'],
                    ];

                    // Jika beririsan maka pendamping sudah pasti tidak bisa mendampingi
                    if ($rules['rule1'] || $rules['rule2'] || $rules['rule3'] || $rules['rule4']) {
                        // mencari pendamping lain
                        $cek_dapat_jadwal = false;
                        break;
                    }

                    // Jika tidak beririsan maka masukan pendamping
                    else {
                        $cek_dapat_jadwal = true;
                    }
                }

                // Peraturan tanggal ujian berbeda                    
                elseif ($jadwal_madif['tanggal_ujian'] != $key1['tanggal_ujian']) {
                    // Jika sampai eachloop akhir tidak ada jadwal tanggal ujian yang sama, maka masukkan dibawah ini                        
                    if (end($urutan_jadwal_pendamping) == $key1) {
                        $cek_dapat_jadwal = true;
                    }
                }
            }

            // Jika jadwal madif sudah terisi pendamping, maka true. Menghentikan pencarian pendamping
            if ($cek_dapat_jadwal) {
                $temp_jadwal_sesuai[] = $key;
            }
        }

        // d($temp_jadwal_sesuai);
        return $temp_jadwal_sesuai;
    }

    public function findPendampingAlt($data)
    {
        $pendamping_alt = null;
        $biodata = model(m_biodata::class);
        foreach ($data['hasil_find_skill'] as $fi) {
            $fi['kecocokan'] = true;
            $biodata_pendamping_alt = $biodata->getBiodata($fi['id_profile_pendamping']);
            $fi['biodata_pendamping_alt'] = $biodata_pendamping_alt;
            $pendamping_alt[] = $fi;
        }

        foreach ($data['get_all_pendamping'] as $key) {
            $cek_pendamping_sama = false;
            foreach ($data['hasil_find_skill'] as $f) {
                if ($key['id_profile_mhs'] == $f['id_profile_pendamping']) {
                    $cek_pendamping_sama = true;
                    break;
                }
            }

            if (!$cek_pendamping_sama) {
                $biodata_pendamping_alt2 = $biodata->getBiodata($key['id_profile_mhs']);
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

        return $pendamping_alt;
    }

    // METHOD DIPAKE SAAT ADA PERIZINAN TANPA PENDAMPING
    public function plottingJadwal1($data)
    {
        // 1 Jadwal Madif yang Ingin Diplottingkan
        $jadwal_madif = $data['jadwal_madif'];
        // Semua Pendamping, type array
        $all_id_pendamping = $data['all_id_pendamping'];
        // Menyimpan pendmaping yang sesuai dengan jadwal
        $temp_jadwal_sesuai = [];
        // Cek Dapat Jadwal
        $cek_dapat_jadwal = false;
        // model jadwal ujian
        $jadwal_ujian = model(m_jadwal_ujian::class);

        // Cek jadwal pendamping yang sesuai, sudah diurutkan berdasarkan banyaknya jumlah pendampingan dari tersedikit hingga terbanyak
        $count = 0;
        foreach ($all_id_pendamping as $key) {
            $jadwal_cocok = false;
            // Mengambil jadwal pendamping sesuai dengan id pendamping
            $urutan_jadwal_pendamping = $jadwal_ujian->getJadwalUjian($key);

            // Mencari jadwal kosong pada pendamping dengan jumlah mendampingi sedikit
            foreach ($urutan_jadwal_pendamping as $key1) {
                // Peraturan tanggal sama, di waktu ujian berbeda
                if ($jadwal_madif['tanggal_ujian'] == $key1['tanggal_ujian']) {
                    // Aturan waktu beririsan                        
                    $rules = [
                        // start_waktu_pendamping <= start_madif, end_madif <= end_pendamping, waktu ujian madif beririsan di dalam waktu ujian pendamping
                        'rule1' => $jadwal_madif['waktu_mulai_ujian'] >= $key1['waktu_mulai_ujian'] && $jadwal_madif['waktu_selesai_ujian'] <= $key1['waktu_selesai_ujian'],
                        // start_pendamping >= start_madif, end_madif >= end_pendamping, waktu ujian pendamping beririsan di dalam waktu ujian madif
                        'rule2' => $jadwal_madif['waktu_mulai_ujian'] <= $key1['waktu_mulai_ujian'] && $jadwal_madif['waktu_selesai_ujian'] >= $key1['waktu_selesai_ujian'],
                        // start_pendamping <= end_madif <= end_pendamping, waktu selesai ujian madif beririsan diantara waktu ujian pendamping
                        'rule3' => $jadwal_madif['waktu_selesai_ujian'] >= $key1['waktu_mulai_ujian'] && $jadwal_madif['waktu_selesai_ujian'] <= $key1['waktu_selesai_ujian'],
                        // start_pendamping <= start_madif <= end_pendamping, waktu mulai ujian madif beririsan diantara waktu ujian pendamping
                        'rule4' => $jadwal_madif['waktu_mulai_ujian'] >= $key1['waktu_mulai_ujian'] && $jadwal_madif['waktu_mulai_ujian'] <= $key1['waktu_selesai_ujian'],
                    ];

                    // Jika beririsan maka pendamping sudah pasti tidak bisa mendampingi
                    if ($rules['rule1'] || $rules['rule2'] || $rules['rule3'] || $rules['rule4']) {
                        // mencari pendamping lain
                        $cek_dapat_jadwal = false;
                        break;
                    }

                    // Jika tidak beririsan maka masukan pendamping
                    else {
                        $cek_dapat_jadwal = true;
                    }
                }

                // Peraturan tanggal ujian berbeda                    
                elseif ($jadwal_madif['tanggal_ujian'] != $key1['tanggal_ujian']) {
                    // Jika sampai eachloop akhir tidak ada jadwal tanggal ujian yang sama, maka masukkan dibawah ini                        
                    if (end($urutan_jadwal_pendamping) == $key1) {
                        $cek_dapat_jadwal = true;
                    }
                }
            }

            $temp_jadwal_sesuai[$count]['id_profile_pendamping'] = $key;
            // Jika jadwal madif sudah terisi pendamping, maka true. Menghentikan pencarian pendamping
            if ($cek_dapat_jadwal) {
                $jadwal_cocok = true;
                $temp_jadwal_sesuai[$count]['jadwal_cocok'] = $jadwal_cocok;
            } else {
                $temp_jadwal_sesuai[$count]['jadwal_cocok'] = $jadwal_cocok;
            }
            $count++;
        }

        return $temp_jadwal_sesuai;
    }

    public function plottingSkill1($data)
    {
        // Variabel data adalah variabel yang menyimpan data pendamping yang telah dihimpun dan jenis difabel        
        $jenis_difabel = $data['jenis_difabel'];
        $all_id_pendamping = $data['all_id_pendamping'];
        $insert = [];
        $result = [];
        $profile_mhs = model(m_profile_mhs::class);

        $max_jumlah_skill = 0;
        foreach ($all_id_pendamping as $key) {
            $skills_pendamping = $profile_mhs->getSkills($key);
            if ($max_jumlah_skill < count($skills_pendamping)) {
                $max_jumlah_skill = count($skills_pendamping);
            }
        }

        // Dicek dulu setiap user temp apakah pada prioritas 1 sesuai dengan kebutuhan jenis madif
        // kalau tidak, maka dilanjutkan ke user temp berikutnya dengan prioritas 1                        
        foreach ($all_id_pendamping as $key1) {
            $insert = [
                'id_profile_pendamping' => $key1,
                'ref_pendampingan' => null,
                'prioritas' => null,
                'skill_cocok' => false,
            ];
            for ($i = 0; $i < $max_jumlah_skill; $i++) {
                $skills_pendamping = $profile_mhs->getSkills($key1);
                if (isset($skills_pendamping[$i])) {
                    if ($skills_pendamping[$i]['ref_pendampingan'] == $jenis_difabel['id']) {
                        $insert['ref_pendampingan'] = $skills_pendamping[$i]['ref_pendampingan'];
                        $insert['prioritas'] = $skills_pendamping[$i]['prioritas'];
                        $insert['skill_cocok'] = true;
                    }
                }
            }
            $result[] = $insert;
        }

        // Tambah izin tidak damping
        $columns1 = array_column($result, 'skill_cocok');
        $columns2 = array_column($result, 'prioritas');
        $columns3 = array_column($result, 'id_profile_pendamping');
        array_multisort($columns1, SORT_DESC, $columns2, SORT_ASC, $columns3, SORT_ASC, $result);

        return $result;
    }

    public function findPendampingAlt1($data)
    {
        /**
         * Prioritas 1 = jadwal dan skill cocok
         * Prioritas 2 = jadwal cocok
         * Prioritas 3 = skill cocok
         * Prioritas 4 = tidak ada yang cocok
         */
        $find_match_jadwal = $this->plottingJadwal1($data);
        $find_match_skill = $this->plottingSkill1($data);
        $result = [];
        foreach ($find_match_skill as $key1) {
            foreach ($find_match_jadwal as $key2) {
                if ($key1['id_profile_pendamping'] == $key2['id_profile_pendamping']) {
                    $mBiodata = model(m_biodata::class);
                    $get_biodata_p = $mBiodata->getBiodata($key1['id_profile_pendamping']) + $mBiodata->getProfile($key1['id_profile_pendamping']);
                    $result[$key1['id_profile_pendamping']] = $key1 + $key2;
                    $result[$key1['id_profile_pendamping']]['biodata_pendamping'] = $get_biodata_p;
                }
            }
        }

        foreach ($result as $key3 => $value3) {
            if ($value3['jadwal_cocok'] == true && $value3['skill_cocok'] == true) {
                $result[$key3]['urutan'] = 1;
            } elseif ($value3['jadwal_cocok'] == true) {
                $result[$key3]['urutan'] = 2;
            } elseif ($value3['skill_cocok'] == true) {
                $result[$key3]['urutan'] = 3;
            } else {
                $result[$key3]['urutan'] = 4;
            }
        }

        // Sorting
        $columns1 = array_column($result, 'urutan');
        $columns2 = array_column($result, 'prioritas');
        $columns3 = array_column($result, 'id_profile_pendamping');
        array_multisort($columns1, SORT_ASC, $columns2, SORT_ASC, $columns3, SORT_ASC, $result);

        return $result;
    }
}
