<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;
use PhpParser\Node\Stmt\Break_;

class m_cuti extends Model
{
    protected $table = 'cuti';
    protected $primaryKey = 'id_cuti';
    protected $useTimestamps = true;
    protected $allowedFields = ['id_profile_mhs', 'jenis_cuti', 'tanggal_mulai', 'tanggal_selesai', 'keterangan', 'dokumen', 'approval'];

    public function getAllCuti($data = null)
    {
        // Semua damping
        if (empty($data)) {
            return $this->findAll();
        }

        // Semua pendampingan sesuai dengan id profile mahasiswa
        return $this->builder()->select('*')->getWhere(['id_profile_mhs' => $data['id_profile_mhs']])->getResultArray();
    }

    public function getDetailCuti($id_damping = null)
    {
        return $this->find($id_damping);
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
}
