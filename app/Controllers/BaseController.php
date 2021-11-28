<?php

namespace App\Controllers;

use CodeIgniter\I18n\Time;
use DateTime;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */

class BaseController extends Controller
{
	/**
	 * Instance of the main Request object.
	 *
	 * @var IncomingRequest|CLIRequest
	 */
	protected $request;

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = ['auth'];

	/**
	 * Constructor.
	 *
	 * @param RequestInterface  $request
	 * @param ResponseInterface $response
	 * @param LoggerInterface   $logger
	 */
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.: $this->session = \Config\Services::session();
		// Object Jadwal Model
		$this->jadwalModel = new \App\Models\jadwalModel();
		$this->jenisDifabelModel = new \App\Models\jenisDifabelModel();
		date_default_timezone_set('Asia/Jakarta');
		$this->get_now = new DateTime();
		$this->date_now = $this->get_now->format('Y-m-d');
		$this->time_now = $this->get_now->format('h:i:s');

		// Notifikasi
		$this->db      = \Config\Database::connect();
		$this->builder2 = $this->db->table('users');
		$this->builder2->select('users.id as userid, username, email,  name, user_image');
		$this->builder2->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
		$this->builder2->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
		$this->builder2->where('users.id', user_id());
		$query = $this->builder2->get();
		$this->dataUser = $query->getRow();

		$this->profile_mhs = model(m_profile_mhs::class);
		$this->profile_admin = model(m_profile_admin::class);
		$this->biodata = model(m_biodata::class);
		$this->user_m = model(UserModel::class);
		$this->jadwal_ujian = model(m_jadwal_ujian::class);
		$this->damping_ujian = model(m_damping_ujian::class);
		$this->cuti = model(m_cuti::class);
		$this->izin = model(m_izin_tidak_damping::class);
		$this->laporan = model(m_laporan_damping::class);		
		$this->notif_admin = model(m_notif_admin::class);
		$this->notif_madif = model(m_notif_madif::class);
		$this->notif_pendamping = model(m_notif_pendamping::class);

		$this->notifikasi = [];
		if (in_groups('admin')) {
			$get_notifikasi = $this->notif_admin->getNotificationTopBar();

			$jenis_notif = [
				'notif_user' => 'User Baru',
				'notif_damping' => 'Generate',
				'verif_skills' => 'Skills',
				'verif_jenis_madif' => 'Jenis madif',
				'verif_izin' => 'Izin',
				'verif_cuti' => 'Cuti',
				'verif_laporan' => 'Laporan',
				'verif_jadwal' => 'Jadwal Ujian',
			];

			$get_notif = [];
			foreach ($get_notifikasi as $key_no => $value_no) {
				if ($value_no['jenis_notif'] == 'verif_jadwal') {
					$builder = $this->jadwal_ujian->find($value_no['id_jenis_notif']);
					$builder1 = $this->profile_mhs->find($builder['id_profile_mhs']);
					$get_jenis_ujian = $builder['jenis_ujian'];
					$get_nim = $builder1['nim'];
				} elseif ($value_no['jenis_notif'] == 'verif_laporan') {
					$get_laporan = $this->laporan->find($value_no['id_jenis_notif']);
					$get_damping = $this->damping_ujian->find($get_laporan['id_damping']);
				} elseif ($value_no['jenis_notif'] == 'notif_user') {
					$get_role = $this->db->table('users')->select('name as role')->join('auth_groups_users', 'users.id = auth_groups_users.user_id')->join('auth_groups', 'auth_groups.id=auth_groups_users.group_id')->getwhere(['users.id' => $value_no['id_jenis_notif']])->getRowArray();
				}

				$link_verif = [
					'verif_skills' => 'viewAllSkill',
					'verif_jenis_madif' => 'viewAllJenisMadif',
					'verif_izin' => 'viewAllIzin',
					'verif_cuti' => 'viewAllCuti',
					'verif_laporan' => 'viewAllLaporan' . ($value_no['jenis_notif'] == 'verif_laporan' ? $get_damping['jenis_ujian'] : ''),
					'verif_jadwal' => 'viewJadwal' . ($value_no['jenis_notif'] == 'verif_jadwal' ? $get_jenis_ujian . '/' . $get_nim : ''),
					'notif_user' => ($value_no['jenis_notif'] == 'notif_user' ? 'viewUser' . ucfirst($get_role['role']) : ''),
					'notif_damping' => 'c_damping_ujian',
				];

				$get_notif[$key_no]['detail'] = [
					'jenis_notif' => $jenis_notif[$value_no['jenis_notif']],
					'link_jenis_notif' => base_url('is_read/admin/' . $value_no['id_notif'] . '/' . $link_verif[$value_no['jenis_notif']]),
					'link_is_read' => base_url('is_read/admin/' . $value_no['id_notif']),
					'link_del_notif' => base_url('c_notif/delNotif/admin/' . $value_no['id_notif']),
				];

				$get_notif[$key_no]['pesan'] = $value_no['pesan'];
			}

			$jumlah_notif_user = count($this->notif_admin->getNotifUser());
			$jumlah_generate = count($this->notif_admin->getNotifGenerate());
			$jumlah_verif = count($this->notif_admin->getNotifVerifikasi());
			$jumlah_notif = $jumlah_notif_user + $jumlah_generate;

			$total_notif_admin = $jumlah_verif + $jumlah_notif;
			$this->notifikasi['notif'] = $get_notif;
			$this->notifikasi['total'] = $total_notif_admin;
		} elseif (in_groups('madif')) {
			$get_nim = $this->dataUser->username;
			$id_profile_mhs = $this->profile_mhs->getID($get_nim);
			$get_notifikasi = $this->notif_madif->getNotificationTopBar($id_profile_mhs);
			$jenis_notif = [
				'notif_jadwal' => 'Jadwal',
				'notif_jenis_difabel' => 'Difabel',
				'notif_damping' => 'Damping',
				'notif_laporan' => 'Laporan',
				'notif_cuti' => 'Cuti',
				'verif_presensi' => 'Presensi',
			];

			$get_notif = [];
			foreach ($get_notifikasi as $key_no => $value_no) {
				if ($value_no['jenis_notif'] == 'notif_jadwal') {
					$get_jadwal = $this->jadwal_ujian->getDetailUjian($value_no['id_jenis_notif']);
					$get_jenis_ujian = $get_jadwal['jenis_ujian'];
				} elseif ($value_no['jenis_notif'] == 'notif_damping') {
					if (isset($value_no['id_jenis_notif'])) {
						$get_damping = $this->damping_ujian->find($value_no['id_jenis_notif']);
						$get_jenis_ujian = $get_damping['jenis_ujian'];
					} else {
						$get_id_profile_mhs = $this->profile_mhs->getID($get_nim);
						$get_jenis_ujian = $this->db->table('damping_ujian')->select('jenis_ujian')->where('id_profile_madif', $get_id_profile_mhs)->getwhere(['created_at' => $value_no['created_at']])->getRowArray();
						$get_jenis_ujian = $get_jenis_ujian['jenis_ujian'];
					}
				} elseif ($value_no['jenis_notif'] == 'notif_laporan') {
					$get_laporan = $this->laporan->find($value_no['id_jenis_notif']);
					$get_damping = $this->damping_ujian->find($get_laporan['id_damping']);
					$get_jenis_ujian = $get_damping['jenis_ujian'];
				} elseif ($value_no['jenis_notif'] == 'verif_presensi') {
					$get_damping = $this->damping_ujian->getDetailDamping($value_no['id_jenis_notif']);
				}

				$link_verif = [
					'notif_jadwal' => 'viewJadwal' . ($value_no['jenis_notif'] == 'notif_jadwal' ? $get_jadwal['jenis_ujian'] . '/' . $get_nim : ''),
					'notif_jenis_difabel' => 'viewProfile/' . $get_nim,
					'notif_damping' => 'viewDamping' . ($value_no['jenis_notif'] == 'notif_damping' ? $get_jenis_ujian . '/' . $get_nim : ''),
					'notif_laporan' => 'viewLaporan' . ($value_no['jenis_notif'] == 'notif_laporan' ? $get_jenis_ujian . '/' . $get_nim : ''),
					'notif_cuti' => 'viewCuti/' . $get_nim,
					'verif_presensi' => 'viewDamping' . $get_damping['jenis_ujian'] . '/' . $get_nim,
				];

				$get_notif[$key_no]['detail'] = [
					'jenis_notif' => $jenis_notif[$value_no['jenis_notif']],
					'link_jenis_notif' => base_url('is_read/madif/' . $value_no['id_notif'] . '/' . $link_verif[$value_no['jenis_notif']]),
					'link_is_read' => base_url('is_read/madif/' . $value_no['id_notif']),
					'link_del_notif' => base_url('c_notif/delNotif/madif/' . $value_no['id_notif']),
				];

				$get_notif[$key_no]['pesan'] = $value_no['pesan'];
			}

			$jumlah_verif = $this->notif_madif->getNotifVerifikasi($id_profile_mhs);
			$jumlah_verif = array_filter($jumlah_verif, function ($var) {
				return ($var['is_read'] == 0);
			});

			$jumlah_notif = $this->notif_madif->getNotif($id_profile_mhs);
			$jumlah_notif = array_filter($jumlah_notif, function ($var) {
				return ($var['is_read'] == 0);
			});

			$jumlah_verif = count($jumlah_verif);
			$jumlah_notif = count($jumlah_notif);

			$total_notif_mhs = $jumlah_verif + $jumlah_notif;
			$this->notifikasi['notif'] = $get_notif;
			$this->notifikasi['total'] = $total_notif_mhs;
		} else {
			$get_nim = $this->dataUser->username;
			$id_profile_mhs = $this->profile_mhs->getID($get_nim);
			$get_notifikasi = $this->notif_pendamping->getNotificationTopBar($id_profile_mhs);
			$jenis_notif = [
				'notif_jadwal' => 'Jadwal',
				'notif_skill' => 'Skill',
				'notif_damping' => 'Damping',
				'notif_laporan' => 'Laporan',
				'notif_cuti' => 'Cuti',
				'notif_izin' => 'Izin',
				'verif_pengganti' => 'Pengganti',
			];

			$get_notif = [];
			foreach ($get_notifikasi as $key_no => $value_no) {
				if ($value_no['jenis_notif'] == 'notif_jadwal') {
					$get_jadwal = $this->jadwal_ujian->getDetailUjian($value_no['id_jenis_notif']);
					$get_jenis_ujian = $get_jadwal['jenis_ujian'];
				} elseif ($value_no['jenis_notif'] == 'notif_damping') {
					if (isset($value_no['id_jenis_notif'])) {
						$get_damping = $this->damping_ujian->find($value_no['id_jenis_notif']);
						$get_jenis_ujian = $get_damping['jenis_ujian'];
					} else {
						$get_id_profile_mhs = $this->profile_mhs->getID($get_nim);
						$get_jenis_ujian = $this->db->table('damping_ujian')->select('jenis_ujian')->where('id_profile_pendamping', $get_id_profile_mhs)->getwhere(['created_at' => $value_no['created_at']])->getRowArray();
						$get_jenis_ujian = $get_jenis_ujian['jenis_ujian'];
					}
				} elseif ($value_no['jenis_notif'] == 'notif_laporan') {
					$get_laporan = $this->laporan->find($value_no['id_jenis_notif']);
					$get_damping = $this->damping_ujian->find($get_laporan['id_damping']);
					$get_jenis_ujian = $get_damping['jenis_ujian'];
				}

				$link_verif = [
					'notif_jadwal' => 'viewJadwal' . ($value_no['jenis_notif'] == 'notif_jadwal' ? $get_jadwal['jenis_ujian'] . '/' . $get_nim : ''),
					'notif_skill' => 'viewProfile/' . $get_nim,
					'notif_damping' => 'viewDamping' . ($value_no['jenis_notif'] == 'notif_damping' ? $get_jenis_ujian . '/' . $get_nim : ''),
					'notif_laporan' => 'viewLaporan' . ($value_no['jenis_notif'] == 'notif_laporan' ? $get_jenis_ujian . '/' . $get_nim : ''),
					'notif_cuti' => 'viewCuti/' . $get_nim,
					'notif_izin' => 'viewIzin/' . $get_nim,
					'verif_presensi' =>  'konfirmasi_pengganti/' . $get_nim,
				];

				$get_notif[$key_no]['detail'] = [
					'jenis_notif' => $jenis_notif[$value_no['jenis_notif']],
					'link_jenis_notif' => base_url('is_read/pengganti/' . $value_no['id_notif'] . '/' . $link_verif[$value_no['jenis_notif']]),
					'link_is_read' => base_url('is_read/pengganti/' . $value_no['id_notif']),
					'link_del_notif' => base_url('c_notif/delNotif/pengganti/' . $value_no['id_notif']),
				];

				$get_notif[$key_no]['pesan'] = $value_no['pesan'];
			}

			$jumlah_verif = $this->notif_pendamping->getNotifVerifikasi($id_profile_mhs);
			$jumlah_verif = array_filter($jumlah_verif, function ($var) {
				return ($var['is_read'] == 0);
			});

			$jumlah_notif = $this->notif_pendamping->getNotif($id_profile_mhs);
			$jumlah_notif = array_filter($jumlah_notif, function ($var) {
				return ($var['is_read'] == 0);
			});

			$jumlah_verif = count($jumlah_verif);
			$jumlah_notif = count($jumlah_notif);

			$total_notif_mhs = $jumlah_verif + $jumlah_notif;
			$this->notifikasi['notif'] = $get_notif;
			$this->notifikasi['total'] = $total_notif_mhs;
		}
	}
}
