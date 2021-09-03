<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;
use PhpParser\Node\Stmt\Break_;

class m_damping_ujian extends Model
{
    protected $table = 'damping_ujian';
    protected $primaryKey = 'id_damping_ujian';
    protected $useTimestamps = true;
    protected $allowedFields = ['id_jadwal_ujian_madif', 'id_profile_madif', 'id_profile_pendamping', 'status_damping'];

    public function hasilGenerate($data_damping_sementara)
    {
        $jadwal_ujian = model(m_jadwal_ujian::class);
        $biodata_mhs = model(m_biodata::class);
        $kunci = ['tanggal_ujian', 'mata_kuliah', 'waktu_mulai_ujian', 'waktu_selesai_ujian', 'ruangan', 'keterangan'];

        $hasil_generate = [];
        $insert = [];
        foreach ($data_damping_sementara as $key) {
            $detail_jadwal = $jadwal_ujian->getDetailUjian($key['id_jadwal_ujian_madif']);
            $detail_bio_madif = $biodata_mhs->getBiodata($key['id_profile_madif']);
            $detail_bio_pendamping = $biodata_mhs->getBiodata($key['id_profile_pendamping']);
            $insert['id_profile_madif'] = $detail_bio_madif['id_profile_mhs'];
            $insert['nama_madif'] = $detail_bio_madif['nickname'];

            // Get nama pendamping
            if (isset($key['id_profile_pendamping'])) {
                $insert['nama_pendamping'] = $detail_bio_pendamping['nickname'];
            } else {
                $insert['nama_pendamping'] = null;
            }

            // Get jadwal ujian
            foreach ($kunci as $k) {
                $insert[$k] = $detail_jadwal[$k];
            }
            $hasil_generate[] = $insert;
        }
        return $hasil_generate;
    }
    public function getAllDamping()
    {
    }
    public function getDetailDamping()
    {
    }
    public function updateDamping()
    {
    }
}
