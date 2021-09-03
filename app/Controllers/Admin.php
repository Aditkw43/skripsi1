<?php

namespace App\Controllers;

use App\Models\m_profile_mhs;

class Admin extends BaseController
{
    protected $db, $builder, $builder2, $dataAdmin, $jadwal_mhs;
    public function __construct()
    {
        $this->db      = \Config\Database::connect();
        $this->builder = $this->db->table('users');
        $this->builder->select('users.id as userid, username, email,  name, user_image');
        $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');

        // Query untuk User yang sedang berjalan
        $this->builder2 = $this->db->table('users');
        $this->builder2->select('users.id as userid, username, email,  name, user_image, ');
        $this->builder2->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->builder2->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $this->builder2->where('users.id', user_id());
        $query = $this->builder2->get();
        $this->dataAdmin = $query->getResultObject();

        $this->config = config('Auth');

        // Model Profile Mahasiswa        
        $this->jadwal_mhs = model(m_profile_mhs::class);
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        // $admin = $this->builder2->get();
        $data['user'] = $this->dataAdmin;
        return view('user/dashboard', $data);
    }

    public function getAllJadwalMadif()
    {
        $data = [
            'title' => 'Daftar Jadwal Mahasiswa Difabel',
            'jadwal_madif' => $this->jadwal_mhs->getAllProfileMadif(),
            'jenis_mhs' => 'madif',
        ];
        $data['user'] = $this->dataAdmin;

        return view('jadwal_ujian/index', $data);
    }

    public function getAllJadwalPendamping()
    {
        $data = [
            'title' => 'Daftar Jadwal Pendamping',
            'jadwal_pendamping' => $this->jadwal_mhs->getAllProfilePendamping(),
            'jenis_mhs' => 'pendamping',
        ];
        $data['user'] = $this->dataAdmin;

        return view('jadwal_ujian/index', $data);
    }

    public function getJadwalMHS($nim)
    {
        $data = [
            'title' => 'Daftar Jadwal',
            'jadwal' => $this->jadwal_mhs->getUjianMhs($nim),
            'profile' => $this->jadwal_mhs->getProfileUser($nim),
        ];
        // $admin = $this->builder2->get();
        $data['user'] = $this->dataAdmin;
        dd($data);
    }

    public function confirmJadwalUjian()
    {
        $data['title'] = 'Konfirmasi Jadwal Ujian';
        return view('user/dashboard', $data);
    }

    public function daftarAdmin()
    {
        // Title
        $data['title'] = 'User List';

        // daftar users admin        
        $this->builder->where('name', 'admin');
        $query = $this->builder->get();
        $data['users'] = $query->getResult();
        // data user
        $data['user'] = $this->dataAdmin;
        $data['errors'] = \Config\Services::validation();
        return view('admin/daftarAdmin', $data);
    }

    public function daftarMahasiswa()
    {
        $data['title'] = 'User List';
        $this->builder->where('name', 'madif');
        $this->builder->orWhere('name', 'pendamping');
        $query = $this->builder->get();
        $data['users'] = $query->getResult();

        // data user
        $data['user'] = $this->dataAdmin;

        return view('admin/daftarMahasiswa', $data);
    }

    public function detail($id = 0)
    {
        $data['title'] = 'User Detail';
        $this->builder->where('users.id', $id);
        $query = $this->builder->get();

        $data['user'] = $query->getRow();

        if (empty($data['user'])) {
            return redirect()->to('/admin');
        }

        return view('admin/detail', $data);
    }
    public function createUser()
    {
        // session();
        $data = [
            'title' => 'Form Tambah User',
            'validation' => \Config\Services::validation()
        ];
        $data['user'] = $this->dataAdmin;

        return view('admin/Users/addUser', $data);
    }

    public function save()
    {
        $users = model(UserModel::class);

        // Validate basics first since some password rules rely on these fields
        $rules = [
            'username' => [
                'rules' => 'required|is_unique[users.username]',
                "erorrs" => [
                    'required' => '{field} harus diisi.',
                    'is_unique' => '{field} sudah terdaftar'
                ]
            ],
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password'     => 'required|strong_password',
            'pass_confirm' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Save the user
        $allowedPostFields = array_merge(['password'], $this->config->validFields, $this->config->personalFields);
        $user = new User($this->request->getPost($allowedPostFields));

        // Ensure default group gets assigned if set
        if (!empty($this->config->defaultUserGroup)) {
            $users = $users->withGroup($this->config->defaultUserGroup);
        }

        if (!$users->save($user)) {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }

        // Success!
        return redirect()->route('login')->with('message', lang('Auth.registerSuccess'));
    }
}
