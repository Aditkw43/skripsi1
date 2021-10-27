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

	public function viewUserAdmin()
	{
		$get_all_user_admin = $this->profile->getAllProfileAdmin();

		$data = [
			'title'	  => "User Management Admin",
			'admin'	  => $get_all_user_admin,
			'user'	  => $this->dataUser,
		];

		// dd($data);

		return view('admin/user_management/v_user_admin', $data);
	}

	public function viewUserMadif()
	{
		$get_all_user_madif = $this->profile->getAllProfileMadif();
		$madif_aktif = [];
		$madif_nonaktif = [];
		foreach ($get_all_user_madif as $key) {
			if ($key['status'] == true) {
				$madif_aktif[] = $key;
			} else {
				$madif_nonaktif[] = $key;
			}
		}
		$data = [
			'title'	  => "User Management Madif",
			'madif'	  => $get_all_user_madif,
			'madif_aktif'	  => $madif_aktif,
			'madif_nonaktif'	  => $madif_nonaktif,
			'user'	  => $this->dataUser,
		];

		// dd($data);

		return view('admin/user_management/v_user_madif', $data);
	}

	public function viewUserPendamping()
	{
		$get_all_user_pendamping = $this->profile->getAllProfilePendamping();
		$pendamping_aktif = [];
		$pendamping_nonaktif = [];
		foreach ($get_all_user_pendamping as $key) {
			if ($key['status'] == true) {
				$pendamping_aktif[] = $key;
			} else {
				$pendamping_nonaktif[] = $key;
			}
		}
		$data = [
			'title'	  => "User Management Pendamping",
			'pendamping'	  => $get_all_user_pendamping,
			'pendamping_aktif'	  => $pendamping_aktif,
			'pendamping_nonaktif'	  => $pendamping_nonaktif,
			'user'	  => $this->dataUser,
		];

		return view('admin/user_management/v_user_pendamping', $data);
	}

	public function updateUser()
	{
	}

	public function delUser()
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

		// dd($data);

		return view('user/v_profile', $data);
	}

	public function viewAllSkill()
	{
		$get_all_skill = $this->profile->getSkills();
		$verifikasi_skill = [];
		if (isset($get_all_skill)) {
			foreach ($get_all_skill as $value) {
				if (!isset($value['approval'])) {
					$id_profile = $value['id_profile_pendamping'];
					$get_profile = $this->profile->getProfile($id_profile);
					$get_biodata = $this->biodata->getBiodata($id_profile);
					$get_nama_skill = $this->profile->getKategoriDifabel($value['ref_pendampingan']);
					$value['nama_skill'] = $get_nama_skill['jenis'];
					unset($get_profile['id_profile_mhs']);
					unset($get_biodata['id_profile_mhs']);
					unset($get_profile['madif']);
					unset($get_profile['pendamping']);
					unset($get_biodata['id_profile_admin']);
					$verifikasi_skill[] = $value + $get_profile + $get_biodata;
				}
			}
		}

		$data = [
			'title' => 'Verifikasi Skills Pendamping',
			'v_skill' => $verifikasi_skill,
			'user' => $this->dataUser,
		];

		// dd($data);
		return view('admin/verifikasi/skills/v_skills_pendamping', $data);
	}

	public function viewAllJenisMadif()
	{
		$get_all_jenis_madif = $this->profile->getJenisMadif();
		$verifikasi_jenis_madif = [];
		if (isset($get_all_jenis_madif)) {
			foreach ($get_all_jenis_madif as $value) {
				if (!isset($value['approval'])) {
					$id_profile = $value['id_profile_madif'];
					$get_profile = $this->profile->getProfile($id_profile);
					$get_biodata = $this->biodata->getBiodata($id_profile);

					$get_nama_jenis = $this->profile->getKategoriDifabel($value['id_jenis_difabel']);
					$value['nama_jenis_madif'] = $get_nama_jenis['jenis'];

					unset($get_profile['id_profile_mhs']);
					unset($get_biodata['id_profile_mhs']);
					unset($get_profile['madif']);
					unset($get_profile['pendamping']);
					unset($get_biodata['id_profile_admin']);

					$verifikasi_jenis_madif[] = $value + $get_profile + $get_biodata;
				}
			}
		}

		$data = [
			'title' => 'Verifikasi Jenis Mahasiswa Difabel',
			'v_jenis_madif' => $verifikasi_jenis_madif,
			'user' => $this->dataUser,
		];

		return view('admin/verifikasi/jenis_difabel/v_jenis_difabel_madif', $data);
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

	public function approval_skill()
	{
		$get_id_profile = $this->request->getUri()->getSegment(3);
		$get_id_skill = $this->request->getUri()->getSegment(4);
		$status = $this->request->getUri()->getSegment(5);
		$data = [
			'id_profile_pendamping' => $get_id_profile,
			'ref_pendampingan' => $get_id_skill,
			'approval' => $status,
		];
		$this->profile->approval_skill($data);

		return redirect()->back();
	}

	public function approval_jenis_madif()
	{
		$get_id_profile = $this->request->getUri()->getSegment(3);
		$status = $this->request->getUri()->getSegment(4);
		$data = [
			'id_profile_madif' => $get_id_profile,
			'approval' => $status,
		];
		$this->profile->approval_jenis_madif($data);

		return redirect()->back();
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
