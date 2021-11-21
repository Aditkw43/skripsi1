<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;
use PhpParser\Node\Stmt\Break_;

class m_biodata extends Model
{

    protected $table = 'biodata';
    protected $allowedFields = ['id_profile_admin', 'id_profile_mhs', 'nickname', 'fullname', 'jenis_kelamin', 'alamat', 'nomor_hp'];

    public function getProfileID($username)
    {
        $id_profile_admin = $this->db->table('profile_admin')->getWhere(['username' => $username])->getRowArray();

        $id_profile_mhs = $this->db->table('profile_mhs')->getWhere(['nim' => $username])->getRowArray();

        if (isset($id_profile_mhs)) {
            return $id_profile_mhs['id_profile_mhs'];
        }
        return $id_profile_admin['id_profile_admin'];
    }

    public function getProfile($id_profile)
    {
        $id_profile_admin = $this->db->table('profile_admin')->getWhere(['id_profile_admin' => $id_profile])->getRowArray();

        $id_profile_mhs = $this->db->table('profile_mhs')->getWhere(['id_profile_mhs' => $id_profile])->getRowArray();

        if (isset($id_profile_mhs)) {
            return $id_profile_mhs;
        }
        return $id_profile_admin;
    }

    public function getBiodata($id_profile = 0)
    {
        if ($id_profile == 0) {
            return $this->findAll();
        }
        $biodata_admin = $this->where(['id_profile_admin' => $id_profile])->first();
        $biodata_mhs = $this->where(['id_profile_mhs' => $id_profile])->first();

        if (isset($biodata_mhs)) {
            return $biodata_mhs;
        }

        return $biodata_admin;
    }

    public function updateBiodata($data)
    {
        // START Persiapan Variabel
        $old_bio = $this->getBiodata($this->getProfileID($data['username']));
        $key_bio = ['id_profile_admin', 'id_profile_mhs', 'nickname', 'fullname', 'jenis_kelamin', 'alamat', 'nomor_hp'];
        // Id_profile tidak perlu, karena id tidak perlu di update, tapi dijadikan where
        $key_profile_mhs = ['nim', 'fakultas', 'jurusan', 'prodi', 'semester'];
        $data_bio = [];
        $data_profile = [];
        // END 

        // Memasukkan Biodata ke variabel data_bio
        foreach ($key_bio as $key) {
            $data_bio[$key] = null;
            foreach ($data as $d => $k) {
                if ($d == $key) {
                    $data_bio[$key] = $data[$key];
                }
            }
        }

        // Jika mahasiswa, masukkan profile dan biodata
        if (!($data['role'] == 'admin')) {
            // START mengatur id profile
            $data_bio['id_profile_mhs'] = $this->getProfileID($data['username']);
            $data['id_profile_mhs'] = $this->getProfileID($data['username']);
            $old_profile = model(m_profile_mhs::class);
            $old_profile = $old_profile->getProfile($data['id_profile_mhs']);
            unset($old_profile['id_profile_mhs']);
            // END        

            // Data profile, tanpa id_profile_mhs            
            foreach ($key_profile_mhs as $key) {
                $data_profile[$key] = null;
                foreach ($data as $d => $k) {
                    if ($key == 'nim') {
                        $data_profile[$key] = $data['username'];
                    } elseif ($d == $key) {
                        $data_profile[$key] = $data[$key];
                    }
                }
            }

            // Memasukkan jenis madif
            $cek_jenis_madif = true;
            if ($data['role'] == 'madif') {
                $data_jenis_madif['id_profile_madif'] = $data['id_profile_mhs'];
                $data_jenis_madif['id_jenis_difabel'] = $data['jenis_madif'];
                $update_jenis_madif = model(m_profile_mhs::class);
                $old_jenis_madif = $update_jenis_madif->getJenisMadif($data['id_profile_mhs']);
                if (!($data_jenis_madif['id_jenis_difabel'] == $old_jenis_madif['id_jenis_difabel'])) {
                    if (isset($data['user_management'])) {
                        $data_jenis_madif['approval'] = true;
                    }
                    $update_jenis_madif = $update_jenis_madif->updateJenisDifabel($data_jenis_madif);
                    $cek_jenis_madif = false;
                }
                $data_profile['madif'] = 1;
                $data_profile['pendamping'] = 0;
            } else {
                $data_profile['pendamping'] = 1;
                $data_profile['madif'] = 0;
            }

            // Jika tidak ada perubahan
            if ($old_bio == $data_bio && $old_profile == $data_profile && $cek_jenis_madif) return false;

            if (!($old_profile == $data_profile)) {
                $this->db->table('profile_mhs')->where('id_profile_mhs', $data['id_profile_mhs'])->update($data_profile);
            }

            if (!($old_bio == $data_bio)) {
                $this->replace($data_bio);
            }
        } else {
            $data_bio['id_profile_admin'] = $this->getProfileID($data['username']);
            $data['id_profile_admin'] = $this->getProfileID($data['username']);
            $old_profile = $this->db->table('profile_admin')->getwhere(['id_profile_admin' => $data['id_profile_admin']])->getRowArray();
            unset($old_profile['id_profile_admin']);

            $data_profile['username'] = $data['username'];
            $data_profile['jabatan'] = $data['jabatan'];

            if ($old_bio == $data_bio && $old_profile == $data_profile) return false;

            if (!($old_profile == $data_profile)) {
                $this->db->table('profile_admin')->where('id_profile_admin', $data['id_profile_admin'])->update($data_profile);
            }

            if (!($old_bio == $data_bio)) {
                $this->replace($data_bio);
            }
        }
        return true;
    }
}
