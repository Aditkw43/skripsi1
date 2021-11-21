<?php

namespace App\Controllers;

use App\Models\m_biodata;
use App\Models\m_cuti;
use App\Models\m_izin_tidak_damping;
use App\Models\m_jadwal_ujian;
use App\Models\m_laporan_damping;
use App\Models\m_profile_mhs;
use Myth\Auth\Models\UserModel;
use phpDocumentor\Reflection\Types\Null_;
use SebastianBergmann\Type\NullType;

use function PHPUnit\Framework\isNull;

class c_user extends BaseController
{
	protected $db, $builder, $builder2, $dataUser, $profile, $biodata, $user_m, $jadwal_ujian, $damping_ujian, $laporan, $izin, $cuti;

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
		$this->user_m = model(UserModel::class);
		$this->jadwal_ujian = model(m_jadwal_ujian::class);
		$this->damping_ujian = model(m_damping_ujian::class);
		$this->cuti = model(m_cuti::class);
		$this->laporan = model(m_laporan_damping::class);
		$this->izin = model(m_izin_tidak_damping::class);
	}

	// Melihat dashboard
	public function dashboardAdmin()
	{
		$where_nonaktif = "(status is null OR status = 0)";

		// Dashboard Data User
		$jumlah_user = $this->db->table('users')->countAll();
		$jumlah_user_aktif = $this->db->table('users')->where('status', 1)->countAllResults();
		$jumlah_user_nonaktif = $this->db->table('users')->where('status', null)->orWhere('status', 0)->countAllResults();
		$jumlah_user_admin = $this->db->table('users')->join('auth_groups_users', 'users.id = auth_groups_users.user_id')->where('auth_groups_users.group_id', 1)->countAllResults();
		$jumlah_user_madif = $this->db->table('users')->join('auth_groups_users', 'users.id = auth_groups_users.user_id')->where('auth_groups_users.group_id', 2)->countAllResults();
		$jumlah_user_pendamping = $this->db->table('users')->join('auth_groups_users', 'users.id = auth_groups_users.user_id')->where('auth_groups_users.group_id', 3)->countAllResults();

		$jumlah_madif_aktif = $this->db->table('users')->join('auth_groups_users', 'users.id = auth_groups_users.user_id')->where('auth_groups_users.group_id', 2)->where('users.status', 1)->countAllResults();
		$jumlah_madif_nonaktif = $this->db->table('users')->join('auth_groups_users', 'users.id = auth_groups_users.user_id')->where('auth_groups_users.group_id', 2)->where($where_nonaktif)->countAllResults();

		$jumlah_pendamping_aktif = $this->db->table('users')->join('auth_groups_users', 'users.id = auth_groups_users.user_id', 'left')->where('auth_groups_users.group_id', 3)->where('users.status', 1)->countAllResults();
		$jumlah_pendamping_nonaktif = $this->db->table('users')->join('auth_groups_users', 'users.id = auth_groups_users.user_id')->where('auth_groups_users.group_id', 3)->where($where_nonaktif)->countAllResults();

		$data_user = [
			'jumlah_user' => $jumlah_user,
			'jumlah_user_aktif' => $jumlah_user_aktif,
			'jumlah_user_nonaktif' => $jumlah_user_nonaktif,
			'jumlah_user_admin' => $jumlah_user_admin,
			'jumlah_user_madif' => $jumlah_user_madif,
			'jumlah_user_pendamping' => $jumlah_user_pendamping,
			'jumlah_madif_aktif' => $jumlah_madif_aktif,
			'jumlah_madif_nonaktif' => $jumlah_madif_nonaktif,
			'jumlah_pendamping_aktif' => $jumlah_pendamping_aktif,
			'jumlah_pendamping_nonaktif' => $jumlah_pendamping_nonaktif,
		];
		// END		

		// Dashboard Jadwal Ujian
		$jumlah_jadwal_ujian = $this->db->table('jadwal_ujian')->countAll();
		$jumlah_jadwal_uts = $this->db->table('jadwal_ujian')->where('jenis_ujian', 'UTS')->countAllResults();
		$jumlah_jadwal_uas = $this->db->table('jadwal_ujian')->where('jenis_ujian', 'UAS')->countAllResults();

		$jadwal_uas_verifikasi = $this->db->table('jadwal_ujian')->where('jenis_ujian', 'UAS')->where('approval', null)->countAllResults();
		$jadwal_uas_disetujui = $this->db->table('jadwal_ujian')->where('jenis_ujian', 'UAS')->where('approval', 1)->countAllResults();
		$jadwal_uas_ditolak = $this->db->table('jadwal_ujian')->where('jenis_ujian', 'UAS')->where('approval', 0)->countAllResults();

		$jadwal_uts_verifikasi = $this->db->table('jadwal_ujian')->where('jenis_ujian', 'UTS')->where('approval', null)->countAllResults();
		$jadwal_uts_disetujui = $this->db->table('jadwal_ujian')->where('jenis_ujian', 'UTS')->where('approval', 1)->countAllResults();
		$jadwal_uts_ditolak = $this->db->table('jadwal_ujian')->where('jenis_ujian', 'UTS')->where('approval', 0)->countAllResults();

		$data_jadwal = [
			'jumlah_jadwal_ujian' => $jumlah_jadwal_ujian,
			'jumlah_jadwal_uts' => $jumlah_jadwal_uts,
			'jumlah_jadwal_uas' => $jumlah_jadwal_uas,
			'jadwal_uas_verifikasi' => $jadwal_uas_verifikasi,
			'jadwal_uas_disetujui' => $jadwal_uas_disetujui,
			'jadwal_uas_ditolak' => $jadwal_uas_ditolak,
			'jadwal_uts_verifikasi' => $jadwal_uts_verifikasi,
			'jadwal_uts_disetujui' => $jadwal_uts_disetujui,
			'jadwal_uts_ditolak' => $jadwal_uts_ditolak,
		];
		// END

		// Dashboard Pendampingan
		$jumlah_pendampingan = $this->db->table('damping_ujian')->countAll();
		$jumlah_ada_pendamping = $this->db->table('damping_ujian')->where('id_profile_pendamping', null)->countAllResults();
		$jumlah_tanpa_pendamping = $this->db->table('damping_ujian')->where('id_profile_pendamping!=', null)->countAllResults();

		$damping_uas_ada_pendamping = $this->db->table('damping_ujian')->where('jenis_ujian', 'UAS')->where('id_profile_pendamping!=', null)->countAllResults();
		$damping_uas_tanpa_pendamping = $this->db->table('damping_ujian')->where('jenis_ujian', 'UAS')->where('id_profile_pendamping', null)->countAllResults();

		$damping_uts_ada_pendamping = $this->db->table('damping_ujian')->where('jenis_ujian', 'UTS')->where('id_profile_pendamping!=', null)->countAllResults();
		$damping_uts_tanpa_pendamping = $this->db->table('damping_ujian')->where('jenis_ujian', 'UTS')->where('id_profile_pendamping', null)->countAllResults();

		$laporan = $this->db->table('laporan_damping')->countAll();

		$data_damping = [
			'jumlah_pendampingan' => $jumlah_pendampingan,
			'jumlah_ada_pendamping' => $jumlah_ada_pendamping,
			'jumlah_tanpa_pendamping' => $jumlah_tanpa_pendamping,
			'damping_uts_ada_pendamping' => $damping_uts_ada_pendamping,
			'damping_uts_tanpa_pendamping' => $damping_uts_tanpa_pendamping,
			'damping_uas_ada_pendamping' => $damping_uas_ada_pendamping,
			'damping_uas_tanpa_pendamping' => $damping_uas_tanpa_pendamping,
			'laporan' => $laporan,
		];
		// END

		// Dashboard Perizinan		
		$jumlah_cuti = $this->db->table('cuti')->countAllResults();
		$jumlah_izin = $this->db->table('izin_tidak_damping')->countAllResults();
		$jumlah_perizinan = $jumlah_cuti + $jumlah_izin;
		$jumlah_cuti_semester = $this->db->table('cuti')->where('jenis_cuti', 'cuti_semester')->countAllResults();
		$jumlah_cuti_sementara = $this->db->table('cuti')->where('jenis_cuti', 'cuti_sementara')->countAllResults();

		$cuti_verifikasi = $this->db->table('cuti')->where('approval', null)->where('approval', null)->countAllResults();
		$cuti_disetujui = $this->db->table('cuti')->where('approval', 1)->where('approval', 1)->countAllResults();
		$cuti_ditolak = $this->db->table('cuti')->where('approval', 0)->where('approval', 0)->countAllResults();

		$izin_verifikasi = $this->db->table('izin_tidak_damping')->where('approval_admin', null)->countAllResults();
		$izin_disetujui = $this->db->table('izin_tidak_damping')->where('approval_admin', 1)->countAllResults();
		$izin_ditolak = $this->db->table('izin_tidak_damping')->where('approval_admin', 0)->countAllResults();

		$data_perizinan = [
			'jumlah_perizinan' => $jumlah_perizinan,
			'jumlah_cuti' => $jumlah_cuti,
			'jumlah_izin' => $jumlah_izin,
			'jumlah_cuti_sementara' => $jumlah_cuti_sementara,
			'jumlah_cuti_semester' => $jumlah_cuti_semester,
			'cuti_verifikasi' => $cuti_verifikasi,
			'cuti_disetujui' => $cuti_disetujui,
			'cuti_ditolak' => $cuti_ditolak,
			'izin_disetujui' => $izin_disetujui,
			'izin_verifikasi' => $izin_verifikasi,
			'izin_ditolak' => $izin_ditolak,
		];
		// END				

		// Dashboard Verifikasi
		// Name, Verifikasi, Update at, Detail, Aksi
		// Jadwal _ujian, Laporan, cuti, tidak damping, Skills, Jenis Madif
		// Jadwal Ujian
		$data_verifikasi = null;
		$jadwal_ujian = $this->db->table('jadwal_ujian')->select('jadwal_ujian.*,  profile_mhs.*,biodata.*,auth_groups.name as role, jadwal_ujian.updated_at as jadwal_ujian_updated_at')->join('profile_mhs', 'profile_mhs.id_profile_mhs = jadwal_ujian.id_profile_mhs')->join('biodata', 'biodata.id_profile_mhs = profile_mhs.id_profile_mhs')->join('users', 'users.username = profile_mhs.nim')->join('auth_groups_users', 'users.id = auth_groups_users.user_id')->join('auth_groups', 'auth_groups_users.group_id = auth_groups.id')->where('approval', null)->orderBy('updated_at', 'DESC')->get()->getRowArray();

		if (isset($jadwal_ujian)) {
			$data_verifikasi['v_jadwal_ujian']['jenis_verifikasi'] = 'Jadwal Ujian';
			$data_verifikasi['v_jadwal_ujian']['nickname'] = $jadwal_ujian['nickname'];
			$data_verifikasi['v_jadwal_ujian']['role'] = $jadwal_ujian['role'];
			$data_verifikasi['v_jadwal_ujian']['updated_at'] = date('Y-m-d H:i:s', strtotime($jadwal_ujian['updated_at']));
			if ($jadwal_ujian['role'] == 'madif') {
				$get_jenis_difabel = $this->profile->getJenisMadif($jadwal_ujian['id_profile_mhs']);
				$get_kategori_madif = $this->profile->getKategoriDifabel($get_jenis_difabel['id_jenis_difabel']);
				$get_kategori_madif = $get_kategori_madif['jenis'];
				$data_verifikasi['v_jadwal_ujian']['kategori_difabel'] = $get_kategori_madif;
			}
			$jadwal_ujian = $this->jadwal_ujian->getDetailUjian($jadwal_ujian['id_jadwal_ujian']);
			$get_profile = $this->profile->getProfile($jadwal_ujian['id_profile_mhs']);
			$jadwal_ujian['nim'] = $get_profile['nim'];

			$data_verifikasi['v_jadwal_ujian']['data'] = $jadwal_ujian;
		}

		// END

		// Laporan
		$laporan = $this->db->table('laporan_damping')->select('laporan_damping.*, damping_ujian.*,jadwal_ujian.*, laporan_damping.approval as approval_laporan')->join('damping_ujian', 'laporan_damping.id_damping = damping_ujian.id_damping')->where('laporan_damping.approval', null)->join('jadwal_ujian', 'jadwal_ujian.id_jadwal_ujian = damping_ujian.id_jadwal_ujian_madif')->where('laporan_damping.approval', null)->orderBy('laporan_damping.updated_at', 'DESC')->get()->getRowArray();

		if (isset($laporan)) {
			$profile_madif = $this->biodata->getProfile($laporan['id_profile_madif']);
			$id_jenis_madif = $this->profile->getJenisMadif($laporan['id_profile_madif']);
			$jenis_madif = $this->profile->getKategoriDifabel($id_jenis_madif['id_jenis_difabel']);
			$profile_madif['jenis_madif'] = $jenis_madif['jenis'];
			$biodata_pendamping = $this->biodata->getBiodata($laporan['id_profile_pendamping']);
			// d($profile_madif);
			// d($biodata_madif);
			// d($id_jenis_madif);
			// d($jenis_madif);
			// d($profile_madif);
			// d($profile_pendamping);
			// d($biodata_pendamping);
			$insert_laporan_damping = [
				'id_laporan_damping' => $laporan['id_laporan_damping'],
				'madif_rating' => $laporan['madif_rating'],
				'pendamping_rating' => $laporan['pendamping_rating'],
				'madif_review' => $laporan['madif_review'],
				'pendamping_review' => $laporan['pendamping_review'],
				'approval' => $laporan['approval'],
				'presensi' => $this->damping_ujian->getPresensi($laporan['id_damping']),
			];

			$data_verifikasi['v_laporan']['jenis_verifikasi'] = 'Laporan';
			$data_verifikasi['v_laporan']['nickname'] = $biodata_pendamping['nickname'];
			$data_verifikasi['v_laporan']['role'] = 'pendamping';
			$data_verifikasi['v_laporan']['updated_at'] = date('Y-m-d H:i:s', strtotime($laporan['updated_at']));
			$data_verifikasi['v_laporan']['data'] = $insert_laporan_damping;
		}
		// END

		// Cuti
		$cuti = $this->db->table('cuti')->select('cuti.*,profile_mhs.*,biodata.*, cuti.updated_at as cuti_updated_at, auth_groups.name as role ')->join('profile_mhs', 'profile_mhs.id_profile_mhs = cuti.id_profile_mhs')->join('biodata', 'biodata.id_profile_mhs = profile_mhs.id_profile_mhs')->join('users', 'users.username = profile_mhs.nim')->join('auth_groups_users', 'users.id = auth_groups_users.user_id')->join('auth_groups', 'auth_groups_users.group_id = auth_groups.id')->where('cuti.approval', null)->orderBy('cuti.updated_at', 'DESC')->get()->getRowArray();

		if (isset($cuti)) {
			$get_nim = $cuti['nim'];
			$data_verifikasi['v_cuti']['jenis_verifikasi'] = 'Cuti';
			$data_verifikasi['v_cuti']['nickname'] = $cuti['nickname'];
			$data_verifikasi['v_cuti']['role'] = $cuti['role'];
			$data_verifikasi['v_cuti']['updated_at'] = date('Y-m-d H:i:s', strtotime($cuti['cuti_updated_at']));
			if ($cuti['role'] == 'madif') {
				$get_jenis_difabel = $this->profile->getJenisMadif($cuti['id_profile_mhs']);
				$get_kategori_madif = $this->profile->getKategoriDifabel($get_jenis_difabel['id_jenis_difabel']);
				$get_kategori_madif = $get_kategori_madif['jenis'];
				$data_verifikasi['v_cuti']['kategori_difabel'] = $get_kategori_madif;
			}
			$get_cuti = $this->cuti->getDetailCuti($cuti['id_cuti']);
			$get_profile_cuti = $this->profile->getProfile($get_cuti['id_profile_mhs']);
			$get_biodata_cuti = $this->biodata->getBiodata($get_cuti['id_profile_mhs']);
			$data_verifikasi['v_cuti']['data'] = $get_cuti;
			$data_verifikasi['v_cuti']['data']['fullname'] = $get_biodata_cuti['fullname'];
			$data_verifikasi['v_cuti']['data']['jenis_kelamin'] = $get_biodata_cuti['jenis_kelamin'];
			$data_verifikasi['v_cuti']['data']['fakultas'] = $get_profile_cuti['fakultas'];
			$data_verifikasi['v_cuti']['data']['jurusan'] = $get_profile_cuti['jurusan'];
			$data_verifikasi['v_cuti']['data']['nomor_hp'] = $get_biodata_cuti['nomor_hp'];
			$data_verifikasi['v_cuti']['data']['nim'] = $get_nim;
		}
		// END 

		// Tidak Damping
		$izin = $this->db->table('izin_tidak_damping')->where('izin_tidak_damping.approval_admin', null)->orderBy('izin_tidak_damping.updated_at', 'DESC')->get()->getRowArray();

		if (isset($izin)) {
			$get_damping_ujian = $this->damping_ujian->find($izin['id_damping_ujian']);
			$get_jadwal_ujian = $this->jadwal_ujian->find($get_damping_ujian['id_jadwal_ujian_madif']);

			$get_profile_pendamping_lama = $this->profile->getProfile($izin['id_pendamping_lama']);
			$get_biodata_pendamping_lama = $this->biodata->getBiodata($izin['id_pendamping_lama']);
			$get_profile_pendamping_baru = $this->profile->getProfile($izin['id_pendamping_baru']);
			$get_biodata_pendamping_baru = $this->biodata->getBiodata($izin['id_pendamping_baru']);

			$insert_v_izin = [
				'izin_tidak_damping' => $izin,
				'jadwal_ujian' => $get_jadwal_ujian,
				'profile_pendamping_lama' => $get_profile_pendamping_lama + $get_biodata_pendamping_lama,
				'profile_pendamping_baru' => (isset($izin['id_pendamping_baru'])) ? $get_profile_pendamping_baru + $get_biodata_pendamping_baru : null,
				'dokumen' => $izin['dokumen'],
			];

			$data_verifikasi['v_tidak_damping']['jenis_verifikasi'] = 'Izin';
			$data_verifikasi['v_tidak_damping']['nickname'] = $get_biodata_pendamping_lama['nickname'];
			$data_verifikasi['v_tidak_damping']['role'] = 'pendamping';
			$data_verifikasi['v_tidak_damping']['updated_at'] = date('Y-m-d H:i:s', strtotime($izin['updated_at']));
			if (!isset($izin['id_pendamping_baru'])) {
				$get_all_pendamping = $this->profile->getAllProfilePendamping();
				$all_id_profile_pendamping = [];
				foreach ($get_all_pendamping as $gap) {
					if ($gap['id_profile_mhs'] == $izin['id_pendamping_lama']) {
						continue;
					}
					$all_id_profile_pendamping[] = $gap['id_profile_mhs'];
				}
				$id_jenis_madif = $this->profile->getJenisMadif($get_jadwal_ujian['id_profile_mhs']);
				$jenis_madif = $this->profile->getKategoriDifabel($id_jenis_madif['id_jenis_difabel']);
				$data_plotting = [
					'jadwal_madif' => $get_jadwal_ujian,
					'jenis_difabel' => $jenis_madif,
					'all_id_pendamping' => $all_id_profile_pendamping,
				];
				$pendamping_alt_1 = $this->damping_ujian->findPendampingAlt1($data_plotting);

				foreach ($pendamping_alt_1 as $kunci2 => $value2) {
					$pendamping_alt_1[$kunci2]['nickname'] = $value2['biodata_pendamping']['nickname'];
					unset($pendamping_alt_1[$kunci2]['biodata_pendamping']);
				}
				$data_verifikasi['v_tidak_damping']['data'] = $insert_v_izin;
				$data_verifikasi['v_tidak_damping']['data']['pendamping_alt'] = $pendamping_alt_1;
			} else {
				$data_verifikasi['v_tidak_damping']['data'] = $insert_v_izin;
			}
		}
		// END

		// Skills Pendamping
		$skills = $this->profile->getSkills();
		$columns_1 = array_column($skills, 'approval');
		$columns_2 = array_column($skills, 'updated_at');
		$columns_3 = array_column($skills, 'prioritas');
		array_multisort($columns_1, SORT_ASC, $columns_2, SORT_DESC, $columns_3, SORT_ASC, $skills);

		if ($skills[0]['approval'] == null) {
			$skills = $skills[0];
			$get_ref_pendampingan = $this->profile->getKategoriDifabel($skills['ref_pendampingan']);
			$skills['kategori_difabel'] = $get_ref_pendampingan['jenis'];
			$get_biodata_pendamping = $this->biodata->getBiodata($skills['id_profile_pendamping']);

			$data_verifikasi['v_skills']['jenis_verifikasi'] = 'Skills';
			$data_verifikasi['v_skills']['nickname'] = $get_biodata_pendamping['nickname'];
			$data_verifikasi['v_skills']['role'] = 'pendamping';
			$data_verifikasi['v_skills']['updated_at'] = date('Y-m-d H:i:s', strtotime($skills['updated_at']));

			$data_verifikasi['v_skills']['data'] = $skills;
		}
		// END

		// Jenis Madif
		$v_jenis_madif = $this->profile->getJenisMadif();
		$columns_1 = array_column($v_jenis_madif, 'approval');
		$columns_2 = array_column($v_jenis_madif, 'updated_at');
		array_multisort($columns_1, SORT_ASC, $columns_2, SORT_DESC, $v_jenis_madif);
		$v_jenis_madif = $v_jenis_madif[0];

		if ($v_jenis_madif['approval'] == null) {
			$get_biodata_madif = $this->biodata->getBiodata($v_jenis_madif['id_profile_madif']);
			$get_jenis_madif = $this->profile->getKategoriDifabel($v_jenis_madif['id_jenis_difabel']);

			$data_verifikasi['v_jenis_madif']['jenis_verifikasi'] = 'Jenis Madif';
			$data_verifikasi['v_jenis_madif']['nickname'] = $get_biodata_madif['nickname'];
			$data_verifikasi['v_jenis_madif']['role'] = 'madif';
			$data_verifikasi['v_jenis_madif']['updated_at'] = date('Y-m-d H:i:s', strtotime($v_jenis_madif['updated_at']));
			$data_verifikasi['v_jenis_madif']['kategori_difabel'] = $get_jenis_madif['jenis'];

			$data_verifikasi['v_jenis_madif']['data'] = $v_jenis_madif;
		}
		// END
		// END VERIFIKASI		

		// Dashboard Jenis Difabel
		$jenis_madif = $this->db->table('profile_jenis_madif')->select("id_profile_madif,kategori_difabel.jenis as jenis_madif,approval")->join('kategori_difabel', 'kategori_difabel.id = profile_jenis_madif.id_jenis_difabel')->where('profile_jenis_madif.approval', 1)->orderBy('approval', 'DESC')->orderBy('jenis_madif', 'ASC')->get()->getResultArray();

		foreach ($jenis_madif as $key) {
			if (isset($data_jenis_madif[$key['jenis_madif']])) {
				$data_jenis_madif[$key['jenis_madif']]++;
			} else {
				$data_jenis_madif[$key['jenis_madif']] = 1;
			}
		}
		// END

		// Dashboard Skills
		$skills_pendamping = $this->db->table('profile_skills')->select("id_profile_pendamping,kategori_difabel.jenis as skills_pendamping,approval,prioritas")->join('kategori_difabel', 'kategori_difabel.id = profile_skills.ref_pendampingan')->where('profile_skills.approval', 1)->orderBy('approval', 'DESC')->orderBy('skills_pendamping', 'ASC')->get()->getResultArray();

		$max_prioritas = max(array_column($skills_pendamping, 'prioritas'));
		$prioritas = null;
		for ($i = 0; $i < $max_prioritas; $i++) {
			if ($max_prioritas[0]) {
				$prioritas['jumlah'] = 0;
			}
			$prioritas['prioritas' . ($i + 1)] = 0;
		}

		foreach ($skills_pendamping as $value_sp) {
			foreach ($prioritas as $key_p => $value_p) {
				$data_skills_pendamping[$value_sp['skills_pendamping']][$key_p] = 0;
				if (end($skills_pendamping) == $value_sp) {
					$data_skills_pendamping['Total'][$key_p] = 0;
				}
			}
		}

		foreach ($skills_pendamping as $key1) {
			$data_skills_pendamping[$key1['skills_pendamping']]['prioritas' . $key1['prioritas']]++;
			$data_skills_pendamping[$key1['skills_pendamping']]['jumlah']++;

			$data_skills_pendamping['Total']['prioritas' . $key1['prioritas']]++;
			$data_skills_pendamping['Total']['jumlah']++;
		}
		// END

		// Dashboard verifikasi limit 5

		$data = [
			'title'	  => "Dashboard Admin",
			'd_user' => $data_user,
			'd_jadwal' => $data_jadwal,
			'd_damping' => $data_damping,
			'd_perizinan' => $data_perizinan,
			'd_verifikasi' => $data_verifikasi,
			'd_skills_pendamping' => $data_skills_pendamping,
			'd_jenis_madif' => $data_jenis_madif,
			'user'	  => $this->dataUser,
		];
		// dd($data);

		return view('user/v_dashboard_admin', $data);
	}

	// Melihat dashboard
	public function dashboardMhs()
	{
		// Jadwal Ujian: UTS, UAS, Tidak Diverifikasi, Diverifikasi, dan Nunggu Konfirmasi
		// Damping Ujian: UTS, UAS, Tidak Diverifikasi, Diverifikasi, dan Nunggu Konfirmasi
		// Laporan: UTS, UAS, Tidak Diverifikasi, diverifikasi, dan menunggu
		// Perizinan: Tidak Damping, Cuti, Tidak Diverifikasi, diverifikasi, dan menunggu		
		$get_id_profile = $this->profile->getID($this->dataUser->username);
		$get_profile = $this->profile->getProfile($get_id_profile);

		// Dashboard Jadwal Ujian
		$jadwal_uts = $this->jadwal_ujian->getJadwalUjianUTS($get_id_profile);
		$jadwal_uas = $this->jadwal_ujian->getJadwalUjianUAS($get_id_profile);

		$jadwal_uts_verifikasi = 0;
		$jadwal_uts_disetujui = 0;
		$jadwal_uts_ditolak = 0;
		foreach ($jadwal_uts as $key_uts) {
			if (empty($key_uts['approval'])) {
				$jadwal_uts_verifikasi++;
			} elseif ($key_uts['approval'] == 1) {
				$jadwal_uts_disetujui++;
			} else {
				$jadwal_uts_ditolak++;
			}
		}

		$jadwal_uas_verifikasi = 0;
		$jadwal_uas_disetujui = 0;
		$jadwal_uas_ditolak = 0;
		foreach ($jadwal_uas as $key_uas) {
			if (empty($key_uas['approval'])) {
				$jadwal_uas_verifikasi++;
			} elseif ($key_uas['approval'] == 1) {
				$jadwal_uas_disetujui++;
			} else {
				$jadwal_uas_ditolak++;
			}
		}
		$data_jadwal = [
			'jumlah_jadwal_uts' => count($jadwal_uts),
			'jumlah_jadwal_uas' => count($jadwal_uas),
			'jadwal_uts_verifikasi' => $jadwal_uts_verifikasi,
			'jadwal_uts_disetujui' => $jadwal_uts_disetujui,
			'jadwal_uts_ditolak' => $jadwal_uts_ditolak,
			'jadwal_uas_verifikasi' => $jadwal_uas_verifikasi,
			'jadwal_uas_disetujui' => $jadwal_uas_disetujui,
			'jadwal_uas_ditolak' => $jadwal_uas_ditolak,
		];
		// END

		// Dashboard Damping Ujian		
		$damping_uts = $this->damping_ujian->getDampingUTS($get_profile);
		$damping_uas = $this->damping_ujian->getDampingUAS($get_profile);

		$jumlah_damping_uts = ($damping_uts != null) ? count($damping_uts) : 0;
		$jumlah_damping_uas = ($damping_uas != null) ? count($damping_uas) : 0;

		$damping_uts_verifikasi = 0;
		$damping_uts_disetujui = 0;
		$damping_uts_ditolak = 0;
		foreach ($damping_uts as $key_d_uts) {
			if (empty($key_d_uts['approval'])) {
				$damping_uts_verifikasi++;
			} elseif ($key_d_uts['approval'] == 1) {
				$damping_uts_disetujui++;
			} else {
				$damping_uts_ditolak++;
			}
		}

		$damping_uas_verifikasi = 0;
		$damping_uas_disetujui = 0;
		$damping_uas_ditolak = 0;
		foreach ($damping_uas as $key_d_uas) {
			if (empty($key_d_uas['approval'])) {
				$damping_uas_verifikasi++;
			} elseif ($key_d_uas['approval'] == 1) {
				$damping_uas_disetujui++;
			} else {
				$damping_uas_ditolak++;
			}
		}

		$data_damping = [
			'jumlah_damping_uts' => $jumlah_damping_uts,
			'jumlah_damping_uas' => $jumlah_damping_uas,
			'damping_uts_verifikasi' => $damping_uts_verifikasi,
			'damping_uts_disetujui' => $damping_uts_disetujui,
			'damping_uts_ditolak' => $damping_uts_ditolak,
			'damping_uas_verifikasi' => $damping_uas_verifikasi,
			'damping_uas_disetujui' => $damping_uas_disetujui,
			'damping_uas_ditolak' => $damping_uas_ditolak,
		];
		// END

		// Dashboard Laporan
		$laporan_uts = $this->laporan->getLaporanUTS($get_profile);
		$laporan_uas = $this->laporan->getLaporanUAS($get_profile);

		$jumlah_laporan_uts = ($laporan_uts != null) ? count($laporan_uts) : 0;
		$jumlah_laporan_uas = ($laporan_uas != null) ? count($laporan_uas) : 0;

		$laporan_uts_verifikasi = 0;
		$laporan_uts_disetujui = 0;
		$laporan_uts_ditolak = 0;
		if (isset($laporan_uts)) {
			foreach ($laporan_uts as $key_l_uts) {
				if (empty($key_l_uts['approval'])) {
					$laporan_uts_verifikasi++;
				} elseif ($key_l_uts['approval'] == 1) {
					$laporan_uts_disetujui++;
				} else {
					$laporan_uts_ditolak++;
				}
			}
		}

		$laporan_uas_verifikasi = 0;
		$laporan_uas_disetujui = 0;
		$laporan_uas_ditolak = 0;
		if (isset($laporan_uas)) {
			foreach ($laporan_uas as $key_l_uas) {
				if (empty($key_l_uas['approval'])) {
					$laporan_uas_verifikasi++;
				} elseif ($key_l_uas['approval'] == 1) {
					$laporan_uas_disetujui++;
				} else {
					$laporan_uas_ditolak++;
				}
			}
		}

		$data_laporan = [
			'jumlah_laporan_uts' => $jumlah_laporan_uts,
			'jumlah_laporan_uas' => $jumlah_laporan_uas,
			'laporan_uts_verifikasi' => $laporan_uts_verifikasi,
			'laporan_uts_disetujui' => $laporan_uts_disetujui,
			'laporan_uts_ditolak' => $laporan_uts_ditolak,
			'laporan_uas_verifikasi' => $laporan_uas_verifikasi,
			'laporan_uas_disetujui' => $laporan_uas_disetujui,
			'laporan_uas_ditolak' => $laporan_uas_ditolak,
		];
		// END

		// Dashboard Perizinan
		$cuti = $this->cuti->getAllCuti($get_profile);
		$izin = $this->izin->getAllIzin($get_profile);

		$jumlah_cuti = ($cuti != null) ? count($cuti) : 0;
		$jumlah_izin = ($izin != null) ? count($izin) : 0;

		$cuti_verifikasi = 0;
		$cuti_disetujui = 0;
		$cuti_ditolak = 0;
		if (isset($cuti)) {
			foreach ($cuti as $key_c_uts) {
				if (empty($key_c_uts['approval'])) {
					$cuti_verifikasi++;
				} elseif ($key_c_uts['approval'] == 1) {
					$cuti_disetujui++;
				} else {
					$cuti_ditolak++;
				}
			}
		}

		$izin_verifikasi = 0;
		$izin_disetujui = 0;
		$izin_ditolak = 0;
		if (isset($izin)) {
			foreach ($izin as $key_i_uas) {
				if (empty($key_i_uas['approval'])) {
					$izin_verifikasi++;
				} elseif ($key_i_uas['approval'] == 1) {
					$izin_disetujui++;
				} else {
					$izin_ditolak++;
				}
			}
		}

		$data_perizinan = [
			'jumlah_cuti' => $jumlah_cuti,
			'jumlah_izin' => $jumlah_izin,
			'cuti_verifikasi' => $cuti_verifikasi,
			'cuti_disetujui' => $cuti_disetujui,
			'cuti_ditolak' => $cuti_ditolak,
			'izin_verifikasi' => $izin_verifikasi,
			'izin_disetujui' => $izin_disetujui,
			'izin_ditolak' => $izin_ditolak,
		];
		// END

		$data = [
			'title'	  => (in_groups('madif')) ? 'Dashboard Mahasiswa Difabel' : 'Dashboard Pendamping',
			'd_jadwal' => $data_jadwal,
			'd_damping' => $data_damping,
			'd_laporan' => $data_laporan,
			'd_perizinan' => $data_perizinan,
			'user'	  => $this->dataUser,
		];
		// dd($data);
		return view('user/v_dashboard_mhs', $data);
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
		$kategori_difabel = $this->profile->getAllKategoriDifabel();
		$data = [
			'title'	  => "User Management Madif",
			'madif'	  => $get_all_user_madif,
			'madif_aktif'	  => $madif_aktif,
			'madif_nonaktif'	  => $madif_nonaktif,
			'kategori_difabel' => $kategori_difabel,
			'user'	  => $this->dataUser,
		];
		// dd($data);

		return view('admin/user_management/v_user_madif', $data);
	}

	public function viewUserPendamping()
	{
		$get_all_user_pendamping = $this->profile->getAllProfilePendamping();
		$get_all_kategori_difabel = $this->profile->getKategoriDifabel();
		$pendamping_aktif = [];
		$pendamping_nonaktif = [];
		// Ambil skill setiap pendamping
		foreach ($get_all_user_pendamping as $key => $value) {
			$get_skills = $this->profile->getSkills($value['id_profile_mhs']);
			$insert_skills = [];
			foreach ($get_skills as $key1) {
				$get_nama_skills = $this->profile->getKategoriDifabel($key1['ref_pendampingan']);
				$insert_skills[] = [
					'id' => $get_nama_skills['id'],
					'skill' => $get_nama_skills['jenis'],
					'prioritas' => $key1['prioritas'],
					'approval' => $key1['approval']
				];
			}
			$get_all_user_pendamping[$key]['skills'] = $insert_skills;
		}

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
			'all_jenis_skill' => $get_all_kategori_difabel,
			'user'	  => $this->dataUser,
		];
		// dd($data);

		return view('admin/user_management/v_user_pendamping', $data);
	}

	public function updateUser()
	{
	}

	public function delUser()
	{
		$get_username = $this->request->getVar('username');
		$get_user_id = $this->user_m->select('id')->getWhere(['username' => $get_username])->getRowArray();
		$get_user_id = $get_user_id['id'];

		// Mencari nickname
		$role = ($this->request->getVar('role') == 'admin') ? 'admin'	: 'mhs';
		$username = ($role == 'admin') ? 'username'	: 'nim';
		$builder = $this->biodata->select('nickname')->join('profile_' . $role, 'biodata.id_profile_' . $role . ' = profile_' . $role . '.id_profile_' . $role . '')->where($username, $get_username)->first();
		$get_nickname = $builder['nickname'];
		// End

		session()->setFlashdata('user_berhasil_dihapus', 'User ' . $get_nickname . ' berhasil dihapus');
		$this->user_m->delete($get_user_id, true);
		return redirect()->back();
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
		$word = (isset($data['user_management'])) ? 'user' : 'profile';
		if (isset($data['user_management'])) {
			$word = 'user';
			$data['user_management'] = true;
		} else {
			$word = 'profile';
		}
		if (!$this->biodata->updateBiodata($data)) {
			session()->setFlashdata($word . '_gagal_diedit', 'Tidak ada perubahan pada ' . $word);

			return redirect()->back();
		}
		session()->setFlashdata($word . '_berhasil_diedit', ucfirst($word) . ' berhasil diedit');

		return redirect()->back();
	}

	public function approval_skill()
	{
		$get_id_profile = $this->request->getUri()->getSegment(3);
		$status = $this->request->getUri()->getSegment(4);
		$get_id_skill = $this->request->getUri()->getSegment(5);
		$data = [
			'id_profile_pendamping' => $get_id_profile,
			'ref_pendampingan' => $get_id_skill,
			'approval' => $status,
		];

		$this->profile->approval_skill($data);
		if ($status == 'terima') {
			session()->setFlashdata('berhasil', 'Verifikasi skill pendamping berhasil disetujui');
		} else {
			session()->setFlashdata('tolak', 'Verifikasi skill pendamping berhasil ditolak');
		}

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

		if ($status == 'terima') {
			session()->setFlashdata('berhasil', 'Verifikasi jenis madif berhasil disetujui');
		} else {
			session()->setFlashdata('tolak', 'Verifikasi jenis madif berhasil ditolak');
		}

		return redirect()->back();
	}

	public function activate_user()
	{
		$get_username = $this->request->getUri()->getSegment(3);
		$get_id_user = $this->user_m->select('id')->getWhere(['username' => $get_username])->getRowArray();
		$this->user_m->update($get_id_user, ['status' => true]);
		$get_id_profile = $this->profile->getID($get_username);
		$get_biodata = $this->biodata->getBiodata($get_id_profile);

		session()->setFlashdata('berhasil_activate', 'User ' . $get_biodata['fullname'] . ' berhasil diaktivasi');
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
