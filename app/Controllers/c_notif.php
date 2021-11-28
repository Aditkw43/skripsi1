<?php

namespace App\Controllers;

use App\Models\m_biodata;
use App\Models\m_cuti;
use App\Models\m_izin_tidak_damping;
use App\Models\m_jadwal_ujian;
use App\Models\m_laporan_damping;
use App\Models\m_notif_admin;
use App\Models\m_profile_admin;
use App\Models\m_profile_mhs;
use Myth\Auth\Models\UserModel;

use function PHPUnit\Framework\isNull;

class c_notif extends BaseController
{
    protected $db, $builder, $builder2, $dataUser, $profile_mhs, $profile_admin, $biodata, $user_m, $jadwal_ujian, $damping_ujian, $laporan, $izin, $cuti, $notif_admin, $notif_madif, $notif_pendamping;

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

        $this->profile_admin = model(m_profile_admin::class);
        $this->profile_mhs = model(m_profile_mhs::class);
        $this->biodata = model(m_biodata::class);
        $this->user_m = model(UserModel::class);
        $this->jadwal_ujian = model(m_jadwal_ujian::class);
        $this->damping_ujian = model(m_damping_ujian::class);
        $this->cuti = model(m_cuti::class);
        $this->laporan = model(m_laporan_damping::class);
        $this->izin = model(m_izin_tidak_damping::class);
        $this->notif_admin = model(m_notif_admin::class);
        $this->notif_pendamping = model(m_notif_pendamping::class);
        $this->notif_madif = model(m_notif_madif::class);
    }

    public function notifAdmin()
    {
        /**
         * Pesan
         * verif_jadwal = Permohonan verifikasi untuk jadwal ujian [jenis ujian] dari [nama]
         * verif_laporan = Permohonan verifikasi untuk laporan damping [jenis ujian] pada jadwal ujian [nama madif]
         * verif_cuti = Permohonan verifikasi untuk perizinan cuti [jenis cuti] dari [nama]
         * verif_izin = Permohonan verifikasi untuk perizinan tidak damping dari [nama]
         * verif_jenis_madif = Permohonan verifikasi jenis madif dari [madif]
         * verif_skills = Permohonan verifikasi skill pendamping dari [pendamping]
         * notif_user = User [nama] telah ditambahkan ke role [role] (BERADA DI MYTH AUTH CONTROLLER)
         * notif_generate = Jadwal pendampingan ujian [jenis_ujian] tahun [tahun] telah digenerate
         */

        $get_verif = $this->notif_admin->getNotifVerifikasi();
        $get_notif_user = $this->notif_admin->getNotifUser();
        $get_notif_generate = $this->notif_admin->getNotifGenerate();
        $get_notif = array_merge($get_notif_user, $get_notif_generate);
        $column_1 = array_column($get_notif, 'created_at');
        array_multisort($column_1, SORT_DESC, $get_notif);

        // Untuk verifikasi unutk link
        $jenis_verif = [
            'verif_skills' => 'Skills',
            'verif_jenis_madif' => 'Jenis madif',
            'verif_izin' => 'Izin',
            'verif_cuti' => 'Cuti',
            'verif_laporan' => 'Laporan',
            'verif_jadwal' => 'Jadwal Ujian',
        ];

        foreach ($get_verif as $key_v1 => $value_v1) {
            if ($value_v1['jenis_notif'] == 'verif_jadwal') {
                $builder = $this->jadwal_ujian->find($value_v1['id_jenis_notif']);
                $builder1 = $this->profile_mhs->find($builder['id_profile_mhs']);
                $get_jenis_ujian = $builder['jenis_ujian'];
                $get_nim = $builder1['nim'];
            } elseif ($value_v1['jenis_notif'] == 'verif_laporan') {
                $get_laporan = $this->laporan->find($value_v1['id_jenis_notif']);
                $get_damping = $this->damping_ujian->find($get_laporan['id_damping']);
            }

            $link_verif = [
                'verif_skills' => 'viewAllSkill',
                'verif_jenis_madif' => 'viewAllJenisMadif',
                'verif_izin' => 'viewAllIzin',
                'verif_cuti' => 'viewAllCuti',
                'verif_laporan' => 'viewAllLaporan' . (isset($get_damping['jenis_ujian']) ? $get_damping['jenis_ujian'] : ''),
                'verif_jadwal' => 'viewJadwal' . (isset($get_nim) ? $get_jenis_ujian . '/' . $get_nim : ''),
            ];

            $get_verif[$key_v1]['detail'] = [
                'jenis_notif' => $jenis_verif[$value_v1['jenis_notif']],
                'link_jenis_notif' => base_url('is_read/admin/' . $value_v1['id_notif'] . '/' . $link_verif[$value_v1['jenis_notif']]),
                'link_is_read' => base_url('is_read/admin/' . $value_v1['id_notif']),
                'link_del_notif' => base_url('c_notif/delNotif/admin/' . $value_v1['id_notif']),
            ];

            $get_verif[$key_v1]['nickname_admin'] = null;
            if ($value_v1['is_read'] == true) {
                $get_biodata = $this->biodata->getBiodata($value_v1['id_profile_admin']);
                $get_nama = $get_biodata['nickname'];
                $get_verif[$key_v1]['nickname_admin'] = $get_nama;
            }
        }

        // Untuk Notif User untuk link
        $jenis_notif = [
            'notif_user' => 'User Baru',
            'notif_damping' => 'Generate',
        ];

        foreach ($get_notif as $key_nu1 => $value_nu1) {
            if ($value_nu1['jenis_notif'] == 'notif_user') {
                $get_role = $this->db->table('users')->select('name as role')->join('auth_groups_users', 'users.id = auth_groups_users.user_id')->join('auth_groups', 'auth_groups.id=auth_groups_users.group_id')->getwhere(['users.id' => $value_nu1['id_jenis_notif']])->getRowArray();
            }

            $link_notif = [
                'notif_user' => (isset($get_role) ? 'viewUser' . ucfirst($get_role['role']) : ''),
                'notif_damping' => 'c_damping_ujian',
            ];

            $get_notif[$key_nu1]['detail'] = [
                'jenis_notif' => $jenis_notif[$value_nu1['jenis_notif']],
                'link_jenis_notif' => base_url('is_read/admin/' . $value_nu1['id_notif'] . '/' . $link_notif[$value_nu1['jenis_notif']]),
                'link_is_read' => base_url('is_read/admin/' . $value_nu1['id_notif']),
                'link_del_notif' => base_url('c_notif/delNotif/admin/' . $value_nu1['id_notif']),
            ];

            $get_notif[$key_nu1]['nickname_admin'] = null;
            if ($value_nu1['is_read'] == true) {
                $get_biodata = $this->biodata->getBiodata($value_nu1['id_profile_admin']);
                $get_nama = $get_biodata['nickname'];
                $get_notif[$key_nu1]['nickname_admin'] = $get_nama;
            }
        }

        $data = [
            'title' => 'Notifikasi Admin',
            'verifikasi' => $get_verif,
            'notifikasi' => $get_notif,
            'user' => $this->dataUser,
            'notifikasi'      => $this->notifikasi,
        ];
        // dd($data);

        return view('user/v_notif', $data);
    }

    public function notifMadif()
    {
        /**
         * Pesan
         * notif_jadwal = Jadwal ujian [jenis ujian] [mata kuliah] telah disetujui/ditolak oleh Admin
         * notif_jenis_difabel = Jenis difabel Anda telah disetujui/ditolak oleh Admin
         * notif_damping = Jadwal pendampingan ujian [jenis ujian] sudah tersedia
         * notif_damping = Pendamping pada jadwal ujian [jenis ujian] [mata kuliah] telah berganti 
         * notif_damping = Pendamping [nama] telah mengkonfirmasi pendampingan
         * notif_damping = Segera lakukan review pendampingan pada pendampingan ujian [jenis ujian][mata kuliah]
         * notif_laporan = Laporan pendampingan ujian [jenis ujian][mata kuliah] telah dikirimkan
         * notif_cuti = Permohonan cuti [jenis cuti] telah dikirimkan
         * notif_cuti = Permohonan cuti [jenis cuti] telah disetujui/ditolak oleh admin
         * verif_presensi = Segera lakukan konfirmasi presensi pendampingan ujian [jenis ujian] [mata kuliah]
         */

        /**
         * Pesan
         * notif_jadwal = c_jadwal_ujian/approval
         * notif_jenis_difabel = c_user/approval_jenis_madif
         * notif_damping = c_damping_ujian/saveGenerate
         * notif_damping = c_perizinan/approval_izin
         * notif_damping = c_damping_ujian/changeStatus
         * notif_damping = c_damping_ujian/changeStatus
         * notif_laporan = c_damping_ujian/saveLaporan
         * notif_cuti = c_perizinan/saveCuti
         * notif_cuti = c_perizinan/approval_cuti
         * verif_presensi = c_damping_ujian/changeStatus
         */

        $get_verif = $this->notif_madif->getNotifVerifikasi();
        $get_notif = $this->notif_madif->getNotif();
        // Untuk verifikasi unutk link
        foreach ($get_verif as $key_v1 => $value_v1) {
            $get_damping = $this->damping_ujian->getDetailDamping($value_v1['id_jenis_notif']);
            $get_nim = $this->dataUser->username;

            $get_verif[$key_v1]['detail'] = [
                'jenis_notif' => 'Presensi',
                'link_jenis_notif' => base_url('is_read/madif/' . $value_v1['id_notif'] . '/' . 'viewDamping' . $get_damping['jenis_ujian'] . '/' . $get_nim),
                'link_is_read' => base_url('is_read/madif/' . $value_v1['id_notif']),
                'link_del_notif' => base_url('c_notif/delNotif/madif/' . $value_v1['id_notif']),
            ];
        }

        // Untuk Notif User untuk link
        $jenis_notif = [
            'notif_jadwal' => 'Jadwal',
            'notif_jenis_difabel' => 'Difabel',
            'notif_damping' => 'Damping',
            'notif_laporan' => 'Laporan',
            'notif_cuti' => 'Cuti',
        ];

        foreach ($get_notif as $key_nu1 => $value_nu1) {
            $get_nim = $this->dataUser->username;
            if ($value_nu1['jenis_notif'] == 'notif_jadwal') {
                $get_jadwal = $this->jadwal_ujian->getDetailUjian($value_nu1['id_jenis_notif']);
                $get_jenis_ujian = $get_jadwal['jenis_ujian'];
            } elseif ($value_nu1['jenis_notif'] == 'notif_damping') {
                if (isset($value_nu1['id_jenis_notif'])) {
                    $get_damping = $this->damping_ujian->find($value_nu1['id_jenis_notif']);
                    $get_jenis_ujian = $get_damping['jenis_ujian'];
                } else {
                    $get_id_profile_mhs = $this->profile_mhs->getID($get_nim);
                    $get_jenis_ujian = $this->db->table('damping_ujian')->select('jenis_ujian')->where('id_profile_madif', $get_id_profile_mhs)->getwhere(['created_at' => $value_nu1['created_at']])->getRowArray();
                    $get_jenis_ujian = $get_jenis_ujian['jenis_ujian'];
                }
            } elseif ($value_nu1['jenis_notif'] == 'notif_laporan') {
                $get_laporan = $this->laporan->find($value_nu1['id_jenis_notif']);
                $get_damping = $this->damping_ujian->find($get_laporan['id_damping']);
                $get_jenis_ujian = $get_damping['jenis_ujian'];
            }

            $link_notif = [
                'notif_jadwal' => 'viewJadwal' . ($value_nu1['jenis_notif'] == 'notif_jadwal' ? $get_jadwal['jenis_ujian'] . '/' . $get_nim : ''),
                'notif_jenis_difabel' => 'viewProfile/' . $get_nim,
                'notif_damping' => 'viewDamping' . ($value_nu1['jenis_notif'] == 'notif_damping' ? $get_jenis_ujian . '/' . $get_nim : ''),
                'notif_laporan' => 'viewLaporan' . ($value_nu1['jenis_notif'] == 'notif_laporan' ? $get_jenis_ujian . '/' . $get_nim : ''),
                'notif_cuti' => 'viewCuti/' . $get_nim,
            ];

            $get_notif[$key_nu1]['detail'] = [
                'jenis_notif' => $jenis_notif[$value_nu1['jenis_notif']],
                'link_jenis_notif' => base_url('is_read/madif/' . $value_nu1['id_notif'] . '/' . $link_notif[$value_nu1['jenis_notif']]),
                'link_is_read' => base_url('is_read/madif/' . $value_nu1['id_notif']),
                'link_del_notif' => base_url('c_notif/delNotif/madif/' . $value_nu1['id_notif']),
            ];
        }

        $data = [
            'title' => 'Notifikasi Madif',
            'verifikasi' => $get_verif,
            'notifikasi' => $get_notif,
            'user' => $this->dataUser,
            'notifikasi'      => $this->notifikasi,
        ];
        // dd($data);

        return view('user/v_notif', $data);
    }

    public function notifPendamping()
    {
        /**
         * Pesan
         * notif_jadwal = Jadwal ujian [jenis ujian] [mata kuliah] telah disetujui/ditolak oleh Admin
         * notif_skill = Referensi pendampingan [nama skill] Anda telah disetujui/ditolak oleh Admin
         * notif_damping = Jadwal pendampingan ujian [jenis ujian] sudah tersedia
         * notif_damping = Presensi telah dikonfirmasi oleh [nickname madif] pada pendampingan [jenis ujian] [mata kuliah]
         * notif_damping = Segera lakukan review pendampingan pada pendampingan ujian [jenis ujian] [mata kuliah]
         * notif_laporan = Laporan pendampingan ujian [jenis ujian] [mata kuliah] telah dikirimkan
         * notif_cuti = Permohonan cuti [jenis cuti] telah dikirimkan
         * notif_cuti = Permohonan cuti [jenis cuti] telah disetujui/ditolak oleh admin
         * notif_izin = Permohonan izin tidak damping telah dikirimkan
         * notif_izin = Permohonan izin tidak damping telah disetujui/ditolak oleh admin
         * notif_izin = Permohonan izin tidak damping telah disetujui/ditolak oleh pendamping pengganti
         * verif_damping = Segera lakukan konfirmasi kesediaan pendampingan ujian [jenis ujian] [mata kuliah](Tidak Jadi)
         * verif_pengganti = Anda dipilih sebagai pendamping pengganti. Segera lakukan konfirmasi pergantian pendamping
         */

        /**
         * Pesan
         * notif_jadwal = c_jadwal_ujian/approval
         * notif_skill = c_user/approval_skill
         * notif_damping = c_damping_ujian/saveGenerate
         * notif_damping = c_damping_ujian/changeStatus
         * notif_damping = c_damping_ujian/changeStatus
         * notif_laporan = c_damping_ujian/saveLaporan
         * notif_cuti = c_perizinan/saveCuti
         * notif_cuti = c_perizinan/approval_cuti
         * notif_izin = c_perizinan/saveizin
         * notif_izin = c_perizinan/approval_izin
         * notif_izin = c_perizinan/approval_izin
         * verif_damping = c_damping_ujian/changeStatus (Tidak Jadi)
         * verif_pengganti = c_damping_ujian/changeStatus
         */

        $get_verif = $this->notif_pendamping->getNotifVerifikasi();
        $get_notif = $this->notif_pendamping->getNotif();

        // Untuk verifikasi unutk link
        foreach ($get_verif as $key_v1 => $value_v1) {
            $get_nim = $this->dataUser->username;

            $get_verif[$key_v1]['detail'] = [
                'jenis_notif' => 'Pengganti',
                'link_jenis_notif' => base_url('is_read/pendamping/' . $value_v1['id_notif'] . '/' . 'konfirmasi_pengganti/' . $get_nim),
                'link_is_read' => base_url('is_read/pendamping/' . $value_v1['id_notif']),
                'link_del_notif' => base_url('c_notif/delNotif/pendamping/' . $value_v1['id_notif']),
            ];
        }

        // Untuk Notif User untuk link
        $jenis_notif = [
            'notif_jadwal' => 'Jadwal',
            'notif_skill' => 'Skill',
            'notif_damping' => 'Damping',
            'notif_laporan' => 'Laporan',
            'notif_cuti' => 'Cuti',
            'notif_izin' => 'Izin',
        ];

        foreach ($get_notif as $key_nu1 => $value_nu1) {
            $get_nim = $this->dataUser->username;

            if ($value_nu1['jenis_notif'] == 'notif_jadwal') {
                $get_jadwal = $this->jadwal_ujian->getDetailUjian($value_nu1['id_jenis_notif']);
                $get_jenis_ujian = $get_jadwal['jenis_ujian'];
            } elseif ($value_nu1['jenis_notif'] == 'notif_damping') {
                if (isset($value_nu1['id_jenis_notif'])) {
                    $get_damping = $this->damping_ujian->find($value_nu1['id_jenis_notif']);
                    $get_jenis_ujian = $get_damping['jenis_ujian'];
                } else {
                    $get_id_profile_mhs = $this->profile_mhs->getID($get_nim);
                    $get_jenis_ujian = $this->db->table('damping_ujian')->select('jenis_ujian')->where('id_profile_pendamping', $get_id_profile_mhs)->getwhere(['created_at' => $value_nu1['created_at']])->getRowArray();
                    $get_jenis_ujian = $get_jenis_ujian['jenis_ujian'];
                }
            } elseif ($value_nu1['jenis_notif'] == 'notif_laporan') {
                $get_laporan = $this->laporan->find($value_nu1['id_jenis_notif']);
                $get_damping = $this->damping_ujian->find($get_laporan['id_damping']);
                $get_jenis_ujian = $get_damping['jenis_ujian'];
            }

            $link_notif = [
                'notif_jadwal' => 'viewJadwal' . ($value_nu1['jenis_notif'] == 'notif_jadwal' ? $get_jadwal['jenis_ujian'] . '/' . $get_nim : ''),
                'notif_skill' => 'viewProfile/' . $get_nim,
                'notif_damping' => 'viewDamping' . ($value_nu1['jenis_notif'] == 'notif_damping' ? $get_jenis_ujian . '/' . $get_nim : ''),
                'notif_laporan' => 'viewLaporan' . ($value_nu1['jenis_notif'] == 'notif_laporan' ? $get_jenis_ujian . '/' . $get_nim : ''),
                'notif_cuti' => 'viewCuti/' . $get_nim,
                'notif_izin' => 'viewIzin/' . $get_nim,
            ];

            $get_notif[$key_nu1]['detail'] = [
                'jenis_notif' => $jenis_notif[$value_nu1['jenis_notif']],
                'link_jenis_notif' => base_url('is_read/pendamping/' . $value_nu1['id_notif'] . '/' . $link_notif[$value_nu1['jenis_notif']]),
                'link_is_read' => base_url('is_read/pendamping/' . $value_nu1['id_notif']),
                'link_del_notif' => base_url('c_notif/delNotif/pendamping/' . $value_nu1['id_notif']),
            ];
        }

        $data = [
            'title' => 'Notifikasi Pendamping',
            'verifikasi' => $get_verif,
            'notifikasi' => $get_notif,
            'user' => $this->dataUser,
            'notifikasi'      => $this->notifikasi,
        ];
        // dd($data);

        return view('user/v_notif', $data);
    }

    public function isRead()
    {
        $get_role = $this->request->getUri()->getSegment(2);
        $get_id_notif = $this->request->getUri()->getSegment(3);
        $total_segments = $this->request->getUri()->getTotalSegments();
        if ($total_segments == 3) {
            if ($get_role == 'admin') {
                $get_id_profile_admin = $this->profile_admin->getID($this->dataUser->username);
                $this->notif_admin->update($get_id_notif, ['id_profile_admin' => $get_id_profile_admin, 'is_read' => 1]);
            } elseif ($get_role == 'madif') {
                $this->notif_madif->update($get_id_notif, ['is_read' => 1]);
            } else {
                $this->notif_pendamping->update($get_id_notif, ['is_read' => 1]);
            }
        } else {
            $get_view = $this->request->getUri()->getSegment(4);
            $get_username = $this->request->getUri()->getSegment(5);
            if ($get_role == 'admin') {
                $get_id_profile_admin = $this->profile_admin->getID($this->dataUser->username);
                $this->notif_admin->update($get_id_notif, ['id_profile_admin' => $get_id_profile_admin, 'is_read' => 1]);
            } elseif ($get_role == 'madif') {
                $this->notif_madif->update($get_id_notif, ['is_read' => 1]);
            } else {
                $this->notif_pendamping->update($get_id_notif, ['is_read' => 1]);
            }
            return redirect()->to(base_url($get_view . '/' . $get_username));
        }
        return redirect()->back();
    }

    public function delNotif()
    {
        $get_role = $this->request->getUri()->getSegment(3);
        $get_id_notif = $this->request->getUri()->getSegment(4);
        if ($get_role == 'admin') {
            $this->notif_admin->delete($get_id_notif);
        } elseif ($get_role == 'madif') {
            $this->notif_madif->delete($get_id_notif);
        } else {
            $this->notif_pendamping->delete($get_id_notif);
        }
        return redirect()->back();
    }
}
