<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;
use PhpParser\Node\Stmt\Break_;

class m_izin_tidak_damping extends Model
{
    protected $table = 'izin_tidak_damping';
    protected $primaryKey = 'id_izin';
    protected $useTimestamps = true;
    protected $allowedFields = ['id_damping_ujian', 'id_pendamping_lama', 'id_pendamping_baru', 'keterangan', 'dokumen', 'approval_pengganti', 'approval_admin'];


    public function findPendampingBaru($data = null)
    {
        helper('array');
        /**
         * 1)Kumpulkan semua data jadwal ujian pendamping, kecuali pendamping lama
         * 2)Kumpulkan semua skills pendamping, kecuali pendamping lama
         * 3)Seleksi kecocokan jadwal pendamping baru dengan madif
         * 4)Seleksi kecocokan skill pendamping baru dengan jenis difabel madif
         */
        $builder = $this->db->table('jadwal_ujian')->select('jadwal_ujian.*')->join('profile_mhs', 'profile_mhs.id_profile_mhs = jadwal_ujian.id_profile_mhs')->where('profile_mhs.pendamping', 1)->where('jadwal_ujian.id_profile_mhs !=', $data['id_profile_pendamping'])->where('jadwal_ujian.approval', true)->orderBy('jadwal_ujian.id_profile_mhs ASC, jadwal_ujian.tanggal_ujian ASC, jadwal_ujian.waktu_mulai_ujian ASC')->get()->getResultArray();
        $m_bio = model(m_biodata::class);

        // Menghimpun seluruh pendamping
        $jumlah_pendamping = [];
        foreach ($builder as $key1) {
            $count_data_sama = 0;
            foreach ($jumlah_pendamping as $key2 => $value) {
                if ($key2 == $key1['id_profile_mhs']) {
                    $count_data_sama++;
                }
            }

            // Jika count data sama = 0, berarti tidak ada data yang terduplikasi            
            if ($count_data_sama == 0) {
                $skill_pendamping = [];
                $m_skill = model(m_profile_mhs::class);
                $get_skill = $m_skill->getSkills($key1['id_profile_mhs']);

                // Insert Skill Pendamping
                foreach ($get_skill as $gs) {
                    $ref_pendampingan = $m_skill->getKategoriDifabel($gs['ref_pendampingan']);
                    $insert = [
                        'ref_pendampingan' => $ref_pendampingan->jenis,
                        'prioritas' => $gs['prioritas'],
                    ];

                    $skill_pendamping[] = $insert;
                }

                // Insert Jadwal Ujian Pendamping
                foreach ($builder as $key2) {
                    if ($key2['id_profile_mhs'] == $key1['id_profile_mhs']) {
                        $jumlah_pendamping[$key1['id_profile_mhs']]['jadwal_ujian'][] = $key2;
                    }
                }

                $jumlah_pendamping[$key1['id_profile_mhs']]['skill'] = $skill_pendamping;
            }
        }
        // Menyocokan Jadwal Pendamping
        $temp_pendamping = [];
        foreach ($jumlah_pendamping as $id_profile_pendamping => $value) {
            foreach ($value['jadwal_ujian'] as $v) {
                $cek_dapat_damping = false;

                // Peraturan tanggal sama, di waktu ujian berbeda                    
                if ($v['tanggal_ujian'] == $data['jadwal_ujian_madif']['tanggal_ujian']) {
                    // Aturan waktu beririsan                        
                    $rules = [
                        // start_waktu_pendamping <= start_madif, end_madif <= end_pendamping, waktu ujian madif beririsan di dalam waktu ujian pendamping
                        'rule1' => $v['waktu_mulai_ujian'] >= $data['jadwal_ujian_madif']['waktu_mulai_ujian'] && $v['waktu_selesai_ujian'] <= $data['jadwal_ujian_madif']['waktu_selesai_ujian'],
                        // start_pendamping >= start_madif, end_madif >= end_pendamping, waktu ujian pendamping beririsan di dalam waktu ujian madif
                        'rule2' => $v['waktu_mulai_ujian'] <= $data['jadwal_ujian_madif']['waktu_mulai_ujian'] && $v['waktu_selesai_ujian'] >= $data['jadwal_ujian_madif']['waktu_selesai_ujian'],
                        // start_pendamping <= end_madif <= end_pendamping, waktu selesai ujian madif beririsan diantara waktu ujian pendamping
                        'rule3' => $v['waktu_selesai_ujian'] >= $data['jadwal_ujian_madif']['waktu_mulai_ujian'] && $v['waktu_selesai_ujian'] <= $data['jadwal_ujian_madif']['waktu_selesai_ujian'],
                        // start_pendamping <= start_madif <= end_pendamping, waktu mulai ujian madif beririsan diantara waktu ujian pendamping
                        'rule4' => $v['waktu_mulai_ujian'] >= $data['jadwal_ujian_madif']['waktu_mulai_ujian'] && $v['waktu_mulai_ujian'] <= $data['jadwal_ujian_madif']['waktu_selesai_ujian'],
                    ];

                    // Jika beririsan maka pendamping sudah pasti tidak bisa mendampingi
                    if ($rules['rule1'] || $rules['rule2'] || $rules['rule3'] || $rules['rule4']) {
                        break;
                    }

                    // Jika tidak beririsan maka masukan pendamping
                    else {
                        $cek_dapat_damping = true;
                    }
                }
                // Peraturan tanggal ujian berbeda                    
                elseif ($v['tanggal_ujian'] != $data['jadwal_ujian_madif']['tanggal_ujian']) {
                    $cek_dapat_damping = true;
                }

                if (end($value['jadwal_ujian']) == $v) {
                    $temp_pendamping[$id_profile_pendamping]['skill'] = $value['skill'];
                    $temp_pendamping[$id_profile_pendamping]['cek_jadwal'] = true;
                    $temp_pendamping[$id_profile_pendamping]['cek_skill'] = false;
                }
            }

            if (!$cek_dapat_damping) {
                continue;
            }
        }

        // Menyocokan Skills Pendamping
        $rekomen_pendamping = [];
        if (!empty($temp_pendamping)) {
            $max_jumlah_skill = 0;
            foreach ($temp_pendamping as $t) {
                if ($max_jumlah_skill < count($t['skill'])) {
                    $max_jumlah_skill = count($t['skill']);
                }
            }

            // Mencari kecocokan skill dan jenis difabel
            foreach ($temp_pendamping as $kunci => $tp) {
                foreach ($tp['skill'] as $key3) {
                    if ($key3['ref_pendampingan'] == $data['jenis_difabel']) {
                        $get_biodata = $m_bio->getBiodata($kunci);
                        $rekomen_pendamping[$kunci]['profile'] = $get_biodata;
                        $rekomen_pendamping[$kunci]['prioritas'] = $key3['prioritas'];
                        $temp_pendamping[$get_biodata['id_profile_mhs']]['cek_skill'] = true;
                    }
                }
            }
            array_sort_by_multiple_keys($rekomen_pendamping, [
                'prioritas' => SORT_ASC,
            ]);
            foreach ($rekomen_pendamping as $key4 => $value1) {
                $rekomen_pendamping[$value1['profile']['id_profile_mhs']] = $value1;
                unset($rekomen_pendamping[$key4]);
            }

            // Jika tidak ada skill yang sesuai        
            foreach ($temp_pendamping as $key5 => $value2) {
                if ($value2['cek_skill'] == false) {
                    $get_biodata = $m_bio->getBiodata($key5);
                    $rekomen_pendamping[$key5]['profile'] = $get_biodata;
                    $rekomen_pendamping[$key5]['prioritas'] = null;
                }
            }
        }

        return $rekomen_pendamping;
    }

    public function getAllIzin($data = null)
    {
        // Semua damping
        if (empty($data)) {
            return $this->findAll();
        }

        return $this->builder()->select('*')->getWhere(['id_pendamping_lama' => $data['id_profile_mhs']])->getResultArray();
    }

    public function getDetailIzin($id_izin = null)
    {
        return $this->find($id_izin);
    }

    public function getAllKonfirmasi($id_profile = null)
    {
        $get_konfirmasi = $this->db->table('izin_tidak_damping')->select("*")->getwhere(['id_pendamping_baru' => $id_profile])->getResultArray();
        return $get_konfirmasi;
    }

    public function approval_pendamping()
    {
    }
    public function approval_admin()
    {
    }
    public function reject_pendamping()
    {
    }
    public function reject_admin()
    {
    }
}
