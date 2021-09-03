<?php

namespace App\Controllers;

class Madif extends BaseController
{
    protected $db, $builder;
    public function __construct()
    {
        $this->db      = \Config\Database::connect();
        $this->builder = $this->db->table('users');
    }
    public function index()
    {
        $data['title'] = 'Konfirmasi Jadwal Ujian';
        return view('mahasiswa/madif/index', $data);
    }
}
