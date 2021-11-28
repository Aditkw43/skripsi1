<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;
use PhpParser\Node\Stmt\Break_;

class m_notif_madif extends Model
{

    protected $table = 'notif_madif';
    protected $primaryKey = 'id_notif';
    protected $useTimestamps = true;
    protected $allowedFields = ['id_profile_madif', 'id_jenis_notif', 'jenis_notif', 'pesan', 'is_read'];
    /**   
     * id_jenis_notif       
     * notif_jadwal = id_jadwal
     * notif_jenis_difabel = id_jenis_difabel
     * notif_damping = id_damping
     * notif_laporan = id_laporan_damping
     * notif_cuti = id_cuti
     * verif_presensi = id_damping_ujian
     */

    // Notifikasi madif bisa dilihat oleh semua madif, namun apabila sudah dibaca maka akan ketahuan oleh siapa telah dibaca
    public function getNotifVerifikasi($id_profile_madif = 0)
    {
        // Jadwal ujian, laporan, cuti, izin, jenis madif, skills
        $get_notif_verif = $this->where('id_profile_madif', $id_profile_madif)->where('jenis_notif', 'verif_presensi')->findAll();
        $column_1 = array_column($get_notif_verif, 'created_at');
        array_multisort($column_1, SORT_DESC, $get_notif_verif);

        return $get_notif_verif;
    }

    public function getNotif($id_profile_madif = 0)
    {
        $get_notif_user = $this->where('id_profile_madif', $id_profile_madif)->where('jenis_notif!=', 'verif_presensi')->findAll();
        $column_1 = array_column($get_notif_user, 'created_at');
        array_multisort($column_1, SORT_DESC, $get_notif_user);

        return $get_notif_user;
    }

    public function getNotificationTopBar($id_profile_madif = 0)
    {
        $get_notif_top_bar = $this->where('id_profile_madif', $id_profile_madif)->where('is_read', 0)->orderBy('created_at', 'DESC')->findAll(4);
        return $get_notif_top_bar;
    }
}
