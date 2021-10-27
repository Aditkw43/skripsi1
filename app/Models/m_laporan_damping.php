<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;
use PhpParser\Node\Stmt\Break_;

class m_laporan_damping extends Model
{
    protected $table = 'laporan_damping';
    protected $primaryKey = 'id_laporan_damping';
    protected $allowedFields = ['id_damping', 'madif_rating', 'pendamping_rating', 'madif_review', 'pendamping_review', 'approval'];

    public function getLaporan($id_damping = null)
    {
        if ($id_damping) {
            return $this->find($id_damping);
        }
        return $this->findAll();
    }

    public function getAllLaporan($data = null)
    {
        // Semua Laporan
        if (empty($data)) {
            return $this->findAll();
        }

        $query = $this->db->table('damping_ujian')->select('laporan_damping.*');
        if (isset($data['madif'])) {
            $query = $query->where('id_profile_madif', $data['id_profile_mhs']);
        } else {
            $query = $query->where('id_profile_pendamping', $data['id_profile_mhs']);
        }
        return $query->join('laporan_damping', 'damping_ujian.id_damping=laporan_damping.id_damping')->get()->getResultArray();
    }

    public function getDetailLaporan($id_laporan_damping = null)
    {
        return $this->find($id_laporan_damping);
    }
}
