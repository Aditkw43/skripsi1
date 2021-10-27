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
}
