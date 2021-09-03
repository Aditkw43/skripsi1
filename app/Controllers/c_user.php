<?php

namespace App\Controllers;

use App\Models\m_biodata;
use App\Models\m_profile_mhs;

class c_user extends BaseController
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

	// Melihat dashboard
	public function index()
	{
		return view('user/dashboard');
	}

	public function viewAllMadif()
	{
	}

	public function viewAllPendamping()
	{
	}

	public function viewAllAdmin()
	{
	}

	public function viewProfile()
	{
		$id_profile = $this->biodata->getProfileID($this->request->getUri()->getSegment(2));
		$biodata = $this->biodata->getBiodata($id_profile);

		$profile = $this->biodata->getProfile($id_profile);
		$data = [
			'user'	  => $this->dataUser,
			'profile' => $profile,
			'biodata' => $biodata,
			'kategori_difabel' => $this->profile->getKategoriDifabel(),
		];

		if ($this->dataUser->name == 'pendamping') {
			$data['skills'] = $this->profile->getSkills($id_profile);
		} elseif ($this->dataUser->name == 'madif') {
			$data['jenis_madif'] = $this->profile->getJenisMadif($id_profile);
		}

		return view('user/v_profile', $data);
	}

	public function updateProfile()
	{
		$data = $this->request->getVar();

		if (!$this->biodata->updateBiodata($data)) {
			session()->setFlashdata('profile_gagal_diedit', 'Tidak ada perubahan pada profile');
			return redirect()->back();
		}
		session()->setFlashdata('profile_berhasil_diedit', 'Profile berhasil diedit');

		return redirect()->back();
	}

	public function updateUser()
	{
	}

	public function delUser()
	{
	}














	public function register()
	{
		$data_jenis_difabel = $this->jenisDifabelModel->getSkills();
		dd($data_jenis_difabel);
		return view('Auth/register', $data_jenis_difabel);
	}

	public function dashboard()
	{
		return view('User/dashboard');
	}

	public function save()
	{
		dd($this->request->getVar());
	}
}
