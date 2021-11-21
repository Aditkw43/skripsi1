<?php

namespace App\Controllers;

use App\Models\m_biodata;
use App\Models\m_profile_mhs;

class c_profile_pendamping extends BaseController
{
    protected $db, $builder, $builder2, $dataUser, $profile, $biodata;

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

        $this->profile = model(m_profile_mhs::class);
        $this->biodata = model(m_biodata::class);
    }

    // Melihat dashboard pendamping
    public function index()
    {
        $data = [
            'title' => 'Daftar Jadwal Ujian',
            'jadwal' => $this->jadwalModel->getJadwalUjian()
        ];

        // $admin = $this->builder2->get();
        $data['user'] = $this->dataUser;

        return view('jadwal_ujian/index', $data);
    }

    // Menampilkan Notifikasi Pendamping
    public function viewNotifikasi()
    {
        /**
         * 1) Melihat notifikasi pergantian pendamping
         * 2) Melihat notifikasi verifikasi skill
         * 3) Melihat notifikasi verifikasi jadwal ujian
         * 4) Melihat notifikasi jadwal pendampingan ujian
         * 5) Melihat notifikasi verifikasi presensi
         * 6) Melihat notifikasi hasil verifikasi cuti    
         * 7) Melihat notifikasi hasil verifikasi izin tidak damping
         */
    }

    // Menampilkan semua Skill atau skill pendamping
    public function viewSkill($nim = 0)
    {
        // get id profile
        $id_profile_pendamping = $this->profile->getID($nim);
        $data = [
            'id_profile_pendamping' => $id_profile_pendamping,
            'user' => $this->dataUser,
            'title' => 'Daftar Skills Pendamping',
            'biodata' => $this->biodata->getBiodata($id_profile_pendamping),
            'kategori_difabel' => $this->profile->getKategoriDifabel(),
            'skills_pendamping' => $this->profile->getSkills($id_profile_pendamping),
        ];

        return view('mahasiswa/pendamping/v_p_skills', $data);
    }

    // Menyimpan skill pendamping yang ditambahkan
    public function saveSkill()
    {
        $ref_pendampingan = $this->request->getVar('ref_pendampingan');
        $prioritas = $this->request->getVar('prioritas');
        $user_management = $this->request->getVar('user_management');
        $data = [
            'id_profile_pendamping' => $this->request->getVar('id_profile_pendamping'),
            'ref_pendampingan' => $ref_pendampingan,
            'prioritas' => $prioritas,
            'approval' => ($user_management) ? true : false,
        ];

        if ($ref_pendampingan == null || $prioritas == 0) {
            session()->setFlashdata('form_tidak_lengkap', 'Form tambah skill tidak lengkap');
            return redirect()->back();
        }
        // Tambah Skill
        $validasi = $this->profile->addSkillPendamping($data);

        if (!$validasi) {
            session()->setFlashdata('gagal_ditambahkan', 'Anda belum memilih referensi pendamping atau prioritas ');
            return redirect()->back();
        }
        $nama_skill = $this->profile->getKategoriDifabel($data['ref_pendampingan']);

        session()->setFlashdata('berhasil_ditambahkan', 'Referensi pendampingan ' . $nama_skill['jenis'] . ' berhasil ditambahkan dengan prioritas ke-' . $data['prioritas']);
        return redirect()->back();
    }

    // Menyimpan skill pendamping yang diedit
    public function editSkill()
    {
        $get_approval = $this->request->getVar('approval');
        $data = [
            'id_profile_pendamping' => $this->request->getVar('id_profile_pendamping'),
            'old_ref_pendampingan' => $this->request->getVar('old_ref_pendampingan'),
            'old_prioritas' => $this->request->getVar('old_prioritas'),
            'ref_pendampingan' => $this->request->getVar('ref_pendampingan'),
            'prioritas' => $this->request->getVar('prioritas'),
            'approval' => ($get_approval == '') ? null : $get_approval,
        ];

        // Edit skill
        $validasi = $this->profile->editSkillPendamping($data);
        $nama_skill = $this->profile->getKategoriDifabel($data['ref_pendampingan']);

        if (!$validasi) {
            session()->setFlashdata('tidak_diedit', 'Tidak ada perubahan pada skill referensi pendampingan ' . $nama_skill['jenis']);
            return redirect()->back();
        }

        session()->setFlashdata('berhasil_diedit', 'Skill referensi pendampingan ' . $nama_skill['jenis'] . ' berhasil diedit dengan prioritas ke-' . $data['prioritas']);
        return redirect()->back();
    }

    // Melakukan delete skill
    public function delSkill()
    {
        $data = [
            'id_profile_pendamping' => $this->request->getVar('id_profile_pendamping'),
            'ref_pendampingan' => $this->request->getVar('ref_pendampingan'),
            'prioritas' => $this->request->getVar('prioritas'),
        ];

        // Delete skill
        $this->profile->removeSkillPendamping($data);

        $nama_skill = $this->profile->getKategoriDifabel($data['ref_pendampingan']);

        session()->setFlashdata('berhasil_dihapus', 'Skill referensi pendampingan ' . $nama_skill['jenis'] . ' berhasil dihapus');
        return redirect()->back();
    }
}
