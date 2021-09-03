<?php

namespace App\Controllers;

use App\Models\jenisDifabelModel;
use PHPUnit\Util\PHP\DefaultPhpProcess;

class jenisMadif extends BaseController
{
    /**
     * 1)add
     * 2)delete
     * 3)edit
     */
    protected $db, $builder, $builder2, $dataUser;
    public function __construct()
    {
        $this->db      = \Config\Database::connect();
        // Query untuk spesifikasi Auth       
        $this->builder = $this->db->table('users');
        $this->builder->select('users.id as userid, username, email,  name, user_image');
        $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');

        // Query untuk User yang sedang berjalan
        $this->builder2 = $this->db->table('users');
        $this->builder2->select('users.id as userid, username, email,  name, user_image');
        $this->builder2->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->builder2->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $this->builder2->where('users.id', user_id());
        $query = $this->builder2->get();
        $this->dataUser = $query->getRow();
    }

    // Untuk menentukan apakah user admin atau bukan, dan diarahkan ke method yang sesuai
    public function index($id)
    {
        dd($id);
        $data = [
            'title' => 'Daftar Jadwal Ujian',
            'jadwal' => $this->jadwalModel->getJadwalUjian()
        ];

        // $admin = $this->builder2->get();
        $data['user'] = $this->dataUser;

        return view('jadwal_ujian/index', $data);
    }

    // Khusus admin
    public function allSkills()
    {
        $jadwalUjian = $this->jadwalModel->findAll();

        $data = [
            'title' => 'Daftar Jadwal Ujian',
            'jadwal' => $jadwalUjian
        ];

        // $admin = $this->builder2->get();
        $data['user'] = $this->dataUser;
        return view('jadwal_ujian/detail', $data);
    }

    // User Pendamping akan langsung diarahkan
    public function jenisUserMadif($nim = 0)
    {
        $data = [
            'title' => 'Jenis User Madif',
            'madif' => $this->jenisDifabelModel->getJenis($nim),
            'jenis_difabel' => $this->jenisDifabelModel->getSkills(),
        ];

        if ($nim == 0) {
            $data['user'] = $this->dataUser;
        } else {
            $this->builder->where('username', $nim);
            $query = $this->builder->get();
            $data['user'] = $query->getRow();
        }

        return view('mahasiswa/madif/jenisMadif', $data);
    }

    public function editJenisMadif($get_old_jenis = 0)
    {
        $nim = $this->request->getVar('id_pendamping');
        $jenis_difabel = $this->request->getVar('jenis_difabel');

        // Edit Jenis Difabel
        $this->jenisDifabelModel->editJenisMadif($nim, $jenis_difabel, $get_old_jenis);

        $nama_jenis = $this->jenisDifabelModel->getJenis($nim);

        session()->setFlashdata('berhasil_diedit', 'Jenis difabel berhasil diedit menjadi difabel ' . $nama_jenis);
        return redirect()->back();
    }

    public function delSkill($id_p_ref)
    {
        $id_p_ref = explode('a', $id_p_ref);
        $key = ['id_pendamping', 'ref_pendampingan', 'prioritas'];
        $i = 0;
        foreach ($key as $j) {
            $id_p_ref[$j] = $id_p_ref[$i];
            unset($id_p_ref[$i]);
            $i++;
        }

        // Delete skill
        $this->jenisDifabelModel->delSkill($id_p_ref);

        $nama_skill = $this->jenisDifabelModel->getSkills($id_p_ref['ref_pendampingan']);

        session()->setFlashdata('berhasil_dihapus', 'Skill referensi pendampingan ' . $nama_skill['jenis'] . ' berhasil dihapus');
        return redirect()->back();
    }
    public function delAllJadwal()
    {
    }
}
