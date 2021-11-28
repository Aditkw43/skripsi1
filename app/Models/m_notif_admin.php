<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;
use PhpParser\Node\Stmt\Break_;

class m_notif_admin extends Model
{

    protected $table = 'notif_admin';
    protected $primaryKey = 'id_notif';
    protected $useTimestamps = true;
    protected $allowedFields = ['id_profile_admin', 'id_jenis_notif', 'jenis_notif', 'pesan', 'is_read'];
    /**
     * id_jenis_notif
     * verif_jadwal = id_jadwal_ujian
     * verif_laporan = id_laporan
     * verif_cuti = id_cuti
     * verif_izin = id_izin
     * verif_jenis_madif = id_profile_madif
     * verif_skills = id_profile_pendamping
     * notif_user = id_users
     * notif_generate = created_at sama dengan jadwal damping
     */

    // Notifikasi admin bisa dilihat oleh semua admin, namun apabila sudah dibaca maka akan ketahuan oleh siapa telah dibaca
    public function getNotifVerifikasi()
    {
        // Jadwal ujian, laporan, cuti, izin, jenis madif, skills
        $get_notif_verif = $this->where('jenis_notif!=', 'notif_user')->where('jenis_notif!=', 'notif_damping')->findAll();
        $column_1 = array_column($get_notif_verif, 'created_at');
        array_multisort($column_1, SORT_DESC, $get_notif_verif);

        return $get_notif_verif;
    }

    public function getNotifUser()
    {
        $get_notif_user = $this->where('jenis_notif', 'notif_user')->findAll();
        $column_1 = array_column($get_notif_user, 'created_at');
        array_multisort($column_1, SORT_DESC, $get_notif_user);

        return $get_notif_user;
    }

    public function getNotifGenerate()
    {
        $get_notif_generate = $this->where('jenis_notif', 'notif_damping')->findAll();
        $column_1 = array_column($get_notif_generate, 'created_at');
        array_multisort($column_1, SORT_DESC, $get_notif_generate);

        return $get_notif_generate;
    }

    public function getNotificationTopBar()
    {
        $get_notif_top_bar = $this->where('is_read', 0)->orderBy('created_at', 'DESC')->findAll(4);
        return $get_notif_top_bar;
    }
}
