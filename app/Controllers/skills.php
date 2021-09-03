<?php

namespace App\Controllers;

use App\Models\jenisDifabelModel;
use PHPUnit\Util\PHP\DefaultPhpProcess;

class skills extends BaseController
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
    public function skillsPendamping($nim = 0)
    {
        $data = [
            'title' => 'Daftar Skills Pendamping',
            'skills' => $this->jenisDifabelModel->getSkills(),
            'prioritas' => $this->jenisDifabelModel->getPrioritas($nim),
        ];

        // for ($i = 0; $i < count($data['skills']); $i++) {
        //     d($i);
        //     if (!empty($prioritas[$i])) {
        //         d($prioritas[$i]);
        //         if ($prioritas[$i]['ref_pendampingan'] == $i + 1) {
        //             d('HALOO');
        //         }
        //     }
        // }
        // dd("Cek");

        if ($nim == 0) {
            $data['user'] = $this->dataUser;
        } else {
            $this->builder->where('username', $nim);
            $query = $this->builder->get();
            $data['user'] = $query->getRow();
        }

        return view('mahasiswa/pendamping/skillsPendamping', $data);
    }

    public function save()
    {
        $id_pendamping = $this->request->getVar('id_pendamping');
        $ref_pendampingan = $this->request->getVar('ref_pendampingan');
        $prioritas = $this->request->getVar('prioritas');
        $urutan = count($this->jenisDifabelModel->getPrioritas($id_pendamping)) + 1;
        if (!($urutan == $prioritas++)) {
            $prioritas = $urutan;
        } else {
            $prioritas--;
        }
        // Tambah Skill
        $this->jenisDifabelModel->addSkills($id_pendamping, $ref_pendampingan, $prioritas);

        $nama_skill = $this->jenisDifabelModel->getSkills($ref_pendampingan);

        session()->setFlashdata('berhasil_ditambahkan', 'Referensi pendampingan ' . $nama_skill['jenis'] . ' berhasil ditambahkan dengan prioritas ke-' . $prioritas);
        return redirect()->back();
    }

    public function editSkill($get_old_prioritas = 0)
    {
        $id_pendamping = $this->request->getVar('id_pendamping');
        $prioritas = $this->request->getVar('prioritas');
        $ref_pendampingan = $this->request->getVar('ref_pendampingan');

        // Edit skill
        $validasi = $this->jenisDifabelModel->editSkill($id_pendamping, $ref_pendampingan, $prioritas, $get_old_prioritas);

        $nama_skill = $this->jenisDifabelModel->getSkills($ref_pendampingan);

        if (!$validasi) {
            session()->setFlashdata('tidak_diedit', 'Tidak ada perubahan pada skill referensi pendampingan ' . $nama_skill['jenis']);
            return redirect()->back();
        }

        session()->setFlashdata('berhasil_diedit', 'Skill referensi pendampingan ' . $nama_skill['jenis'] . ' berhasil diedit dengan prioritas ke-' . $prioritas);
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
