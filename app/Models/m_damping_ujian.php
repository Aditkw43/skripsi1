<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;
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
            (isset($key['ref_pendampingan'])) ? ($insert['ref_pendampingan'] = $nama_skill->jenis) : $insert['ref_pendampingan'] = '-';
            (isset($key['ref_pendampingan'])) ? ($insert['prioritas'] = $prioritas_skill) : $insert['prioritas'] = '-';

            // Get jadwal ujian
            foreach ($kunci as $k) {
                $insert[$k] = $detail_jadwal[$k];
            }
            $hasil_generate[] = $insert;
        }
        return $hasil_generate;
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
        // id_jadwal_ujian_madif as semua detail jadwal ujian, 
        // id_profile_madif dan id_profile_pendamping as biodata mahasiswa
        // jenis ujian
        // status damping
        // model jadwal ujian, model biodata, model profile
        $data_damping = $this->find($id_damping);
        $jadwal_ujian = $this->builder()->select('*')->join('jadwal_ujian', 'jadwal_ujian.id_jadwal_ujian = damping_ujian.id_jadwal_ujian_madif')->where('');

        $madif = $this->builder()->select('jadwal_ujian.*,profile')->where(['id_profile_madif' => $id_profile_mhs])->getResultArray();
        $pendamping = $this->builder()->select('jadwal_ujian.*,profile')->where(['id_profile_madif' => $id_profile_mhs])->getResultArray();
    }
    public function updateDamping()
    {
    }
}
