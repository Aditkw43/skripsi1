<?php

namespace App\Controllers;

use App\Models\m_damping_ujian;
use App\Models\m_jadwal_ujian;
use App\Models\m_profile_mhs;

class c_damping_ujian extends BaseController
{

    protected $db, $builder, $builder2, $dataUser, $damping_ujian, $jadwal_ujian, $profile_mhs;
    public function __construct()
    {
        $this->db      = \Config\Database::connect();
        // Query untuk spesifikasi Auth       
        $this->builder = $this->db->table('users');
        $this->builder->select('users.id as userid, username, email, user_image');
        $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');

        // Query untuk User yang sedang berjalan
        $this->builder2 = $this->db->table('users');
        $this->builder2->select('users.id as userid, username, email, user_image');
        $this->builder2->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->builder2->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $this->builder2->where('users.id', user_id());
        $query = $this->builder2->get();
        $this->dataUser = $query->getRow();

        // Instansiasi Model
        $this->damping_ujian = model(m_damping_ujian::class);
        $this->jadwal_ujian = model(m_jadwal_ujian::class);
        $this->profile = model(m_profile_mhs::class);
    }

    // Menampilkan view generate, khusus admin
    public function index()
    {

        $data = [
            'title' => 'Daftar Pendampingan Ujian',
        ];

        // $admin = $this->builder2->get();
        $data['user'] = $this->dataUser;

        return view('admin/damping_ujian/index', $data);
    }

    public function backupViewGenerate($data_damping_sementara)
    {

        $data = [
            'title' => 'Hasil Generate Jadwal Damping Sementara',
            'value_generate' => $data_damping_sementara,
            'hasil_generate' => $this->damping_ujian->hasilGenerate($data_damping_sementara),
        ];

        // $admin = $this->builder2->get();
        $data['user'] = $this->dataUser;

        return view('admin/damping_ujian/v_generate', $data);
    }

    public function viewGenerate($data_damping_sementara)
    {
        // START deklarasi variabel
        $v_damping = [];
        $insert = [];
        $hasil_generate = $this->damping_ujian->hasilGenerate($data_damping_sementara);
        $profile = model(m_profile_mhs::class);
        $jumlah_madif_generate[] = $data_damping_sementara[0];
        // END 

        // Menghimpun seluruh madif dalam generate pendampingan
        foreach ($data_damping_sementara as $key) {
            $count_data_sama = 0;
            foreach ($jumlah_madif_generate as $jmg) {
                if ($jmg['id_profile_madif'] == $key['id_profile_madif']) {
                    $count_data_sama++;
                }
            }

            // Jika count data sama = 0, berarti tidak ada data yang terduplikasi
            if ($count_data_sama == 0) {
                $jumlah_madif_generate[] = $key;
            }
        }

        // Memasukkan data dan hitung jumlah madif didampingi dan tidak didampingi
        foreach ($jumlah_madif_generate as $k) {
            $jumlah_didampingi = 0;
            $jumlah_tidak_didampingi = 0;
            // id_profile, NIM dan Fakultas
            $nim_fakultas = $profile->getProfile($k['id_profile_madif']);
            $id_profile_madif = $nim_fakultas['id_profile_mhs'];
            $nim = $nim_fakultas['nim'];
            $fakultas = $nim_fakultas['fakultas'];

            // Nama
            $nama = $this->db->table('biodata')->select('fullname')->getWhere(['id_profile_mhs' => $k['id_profile_madif']])->getFirstRow();
            $nama = $nama->fullname;

            // Jumlah didampingi dan tidak didampingi
            foreach ($data_damping_sementara as $dps) {
                if ($k['id_profile_madif'] == $dps['id_profile_madif']) {
                    if (isset($dps['id_profile_pendamping'])) {
                        $jumlah_didampingi++;
                    } else {
                        $jumlah_tidak_didampingi++;
                    }
                }
            }
            $insert = [
                'id_profile_madif' => $id_profile_madif,
                'nim' => $nim,
                'nama' => $nama,
                'fakultas' => $fakultas,
                'jumlah_didampingi' => $jumlah_didampingi,
                'jumlah_tidak_didampingi' => $jumlah_tidak_didampingi,
            ];

            $v_damping[] = $insert;
        }

        $data = [
            'title' => 'Hasil Generate Jadwal Damping Sementara Ujian',
            'value_generate' => $data_damping_sementara,
            'hasil_generate' => $hasil_generate,
            'v_damping' => $v_damping,
        ];

        // $admin = $this->builder2->get();
        $data['user'] = $this->dataUser;

        return view('admin/damping_ujian/v_generate', $data);
    }

    /**
     * Diplotting berdasarkan:
     * 1)Jadwal kosong dan prioritas skill pendamping diutamakan
     * 2)Jadwal kosong, prioritas skill sama dengan pendamping lain, maka diplottingkan berdasarkan urutan keadilan pendampingan
     * 3)Jadwal kosong, tanpa skill yang cocok, maka diplottingkan berdasarkan urutan keadilan pendampingan
     * 4)Jadwal tidak ada yang kosong, maka dimasukkan null pada id pendamping
     */
    public function generate()
    {
        /**
         * 1)Ambil jadwal madif dan pendamping, diurutkan berdasarkan tanggal dan waktu
         * 2)Ambil jenis madif dan skills pendamping yang ingin diplotingkan
         * 3)Plottingkan jadwal madif dengan jadwal pendamping yang tidak satu tanggal
         * -Jika tidak dapat menemukan pendamping di tanggal yang berbeda, maka plottingkan di tanggal yang sama dengan waktu yang berbeda
         * -Jika tidak ada pendamping yang bisa di tanggal yang berbeda maupun waktu yang berbeda, maka isikan pendamping dengan null
         * 4)Plottingkan berdasarkan jenis madif dan prioritas skill pendamping
         * -Jika tidak menemukan kebutuhan skill yang sesuai, maka masukkan pendamping yang tidak memiliki skill/memiliki skill lain namun tersedia waktu
         */

        /**
         * 1)Cek apakah pendamping sudah terisi di waktu yang beririsan
         * 2)Cek apakah pendamping kosong di tanggal ujian madif
         * 3)Cek apakah pendamping kosong di tanggal sama di waktu ujian madif
         * 4)Cek apakah pendamping memiliki ref_pendampingan yang sesuai dengan kebutuhan  jenis _madif         
         */
        // Deklarasi variabel damping ujian sementara dan variabel insert data untuk dimasukkan ke var damping ujian sementara
        $damping_ujian_sementara = [];
        $insert = [
            'id_jadwal_ujian_madif' => '',
            'id_profile_madif' => '',
            'id_profile_pendamping' => '',
            'jenis_ujian' => 'UTS',
        ];

        // Ambil jadwal ujian madif 
        $all_jadwal_ujian = $this->jadwal_ujian->getAllJadwalUjian();
        $all_jadwal_madif = $all_jadwal_ujian['jadwal_madif'];

        // Ambil skills pendamping        
        $profile_pendamping = $this->profile->getAllProfile('pendamping');

        /**
         * Aturannya, semua pendamping dapat mendampingi secara adil dan rata, namun jadwal kosong dengan prioritas skill pendamping yang cocok diutamakan
         * Variabel dibawah untuk menunjukkan berapa banyak pendampingan  melakukan pendampingan
         * 
         * 1)Cek apakah semua pendamping adil mendampingi
         * -Jika tidak urutkan id pendamping sesuai dengan urutan dari jumlah pendampingan paling sedikit ke paling terbanyak
         * 2)Ambil jadwal pendamping sesuai dengan urutan adil pendamping  
         * 
         * Note: sorting array asort(), dari value terkecil ke terbesar
         */
        // Memasukkan seluruh id profile pendamping ke variabel count_jumlah_damping        
        $count_jumlah_damping = [];
        foreach ($profile_pendamping as $key) {
            $count_jumlah_damping[$key['id_profile_mhs']] = 0;
        }

        /**
         * 1)Pendampingan dipilih pertama berdasarkan jadwal kosong
         * -Jika terdapat jadwal kosong, maka dikumpulkan semua jadwal kosong pendamping untuk diseleski lebih lanjut pada tahap seleksi skills. Diurutkan berdasarkan urutan adil pendamping
         * -Jika tidak ada jadwal kosong, maka tidak bisa lanjut ke seleksi kebutuhan skills        
         * 
         * 2)Pendampingan dipilih kedua berdasarkan skills yang dibutuhkan madif
         * -Seleksi dilakukan pertama pada urutan prioritas pertama. Semua pendamping diseleksi terlebih dahulu prioritas pertamanya            
         * -Jika tidak menemukan prioritas pertama yang cocok, maka dilanjutkan dengan prioritas kedua (urutan tetap berdasarkan urutan adil pendamping) hingga seterusnya
         * -Jika menemukan pendamping dengan prioritas pertama (walau tidak sesuai urutan adil pendamping), maka pendamping langsung diplottingkan pada pendampingan tsb. Begitu juga jika didapatkan kecocokan kebutuhan skills pada prioritas kesekian        
         */

        // Mengisi semua jadwal madif dengan pendamping        
        foreach ($all_jadwal_madif as $key) {

            // Deklarasi variabel temp jadwal_sesuai, untuk menampung id_pendamping yang jadwalnya kosong
            $temp_jadwal_sesuai = [];

            //Jika jumlah damping sama, mengurutkan pendamping dari key terkecil hingga tebesar
            ksort($count_jumlah_damping);

            // Mengurutkan pendamping dari paling sedikit mendamping hingga paling banyak. Tidak berlaku bagi jumlah damping sama                    
            asort($count_jumlah_damping);

            // Ambil jenis difabel madif
            $jenis_difabel = $this->profile->getJenisMadif($key['id_profile_mhs']);

            // Deklarasi var jika jadwal pendamping ditemukan kosong
            $cek_dapat_jadwal = false;

            // Cek jadwal pendamping yang sesuai, sudah diurutkan berdasarkan banyaknya jumlah pendampingan dari tersedikit hingga terbanyak
            foreach ($count_jumlah_damping as $acuan => $isi) {

                // Mengambil jadwal pendamping sesuai dengan id pendamping
                $urutan_jadwal_pendamping = $this->jadwal_ujian->getJadwalUjian($acuan);

                // Mencari jadwal kosong pada pendamping dengan jumlah mendampingi sedikit
                foreach ($urutan_jadwal_pendamping as $ujp) {
                    // Peraturan tanggal sama, di waktu ujian berbeda
                    if ($key['tanggal_ujian'] == $ujp['tanggal_ujian']) {
                        // Aturan waktu beririsan                        
                        $rules = [
                            // start_waktu_pendamping <= start_madif, end_madif <= end_pendamping, waktu ujian madif beririsan di dalam waktu ujian pendamping
                            'rule1' => $key['waktu_mulai_ujian'] >= $ujp['waktu_mulai_ujian'] && $key['waktu_selesai_ujian'] <= $ujp['waktu_selesai_ujian'],
                            // start_pendamping >= start_madif, end_madif >= end_pendamping, waktu ujian pendamping beririsan di dalam waktu ujian madif
                            'rule2' => $key['waktu_mulai_ujian'] <= $ujp['waktu_mulai_ujian'] && $key['waktu_selesai_ujian'] >= $ujp['waktu_selesai_ujian'],
                            // start_pendamping <= end_madif <= end_pendamping, waktu selesai ujian madif beririsan diantara waktu ujian pendamping
                            'rule3' => $key['waktu_selesai_ujian'] >= $ujp['waktu_mulai_ujian'] && $key['waktu_selesai_ujian'] <= $ujp['waktu_selesai_ujian'],
                            // start_pendamping <= start_madif <= end_pendamping, waktu mulai ujian madif beririsan diantara waktu ujian pendamping
                            'rule4' => $key['waktu_mulai_ujian'] >= $ujp['waktu_mulai_ujian'] && $key['waktu_mulai_ujian'] <= $ujp['waktu_selesai_ujian'],
                        ];

                        // Jika beririsan maka pendamping sudah pasti tidak bisa mendampingi
                        if ($rules['rule1'] || $rules['rule2'] || $rules['rule3'] || $rules['rule4']) {
                            $insert['id_profile_pendamping'] = null;
                            // mencari pendamping lain
                            $cek_dapat_jadwal = false;
                            break;
                        }

                        // Jika tidak beririsan maka masukan pendamping
                        else {
                            $insert['id_profile_pendamping'] = $ujp['id_profile_mhs'];
                            $cek_dapat_jadwal = true;
                        }
                    }

                    // Peraturan tanggal ujian berbeda                    
                    elseif ($key['tanggal_ujian'] != $ujp['tanggal_ujian']) {
                        // Jika sampai eachloop akhir tidak ada jadwal tanggal ujian yang sama, maka masukkan dibawah ini                        
                        if (end($urutan_jadwal_pendamping) == $ujp) {
                            $insert['id_profile_pendamping'] = $ujp['id_profile_mhs'];
                            $cek_dapat_jadwal = true;
                        }
                    }
                }

                // Jika jadwal madif sudah terisi pendamping, maka true. Menghentikan pencarian pendamping
                if ($cek_dapat_jadwal) {
                    // break;
                    $temp_jadwal_sesuai[] = $acuan;
                }
            }

            $cek_dapat_pendamping_skill = false;
            // Cek skills pendamping yang sesuai, sudah diurutkan adil
            if (!empty($temp_jadwal_sesuai)) {
                $max_jumlah_skill = 0;
                foreach ($temp_jadwal_sesuai as $t) {
                    $skills_pendamping = $this->profile->getSkills($t);
                    if ($max_jumlah_skill < count($skills_pendamping)) {
                        $max_jumlah_skill = count($skills_pendamping);
                    }
                }

                // Dicek dulu setiap user temp apakah pada prioritas 1 sesuai dengan kebutuhan jenis madif
                // kalau tidak, maka dilanjutkan ke user temp berikutnya dengan prioritas 1                
                for ($i = 0; $i < $max_jumlah_skill; $i++) {
                    foreach ($temp_jadwal_sesuai as $tjs) {
                        $skills_pendamping = $this->profile->getSkills($tjs);

                        if (isset($skills_pendamping[$i])) {
                            if ($skills_pendamping[$i]['ref_pendampingan'] == $jenis_difabel['id_jenis_difabel']) {
                                $insert['id_profile_pendamping'] = $skills_pendamping[$i]['id_profile_pendamping'];
                                $cek_dapat_pendamping_skill = true;
                                break;
                            }
                        }
                    }
                    if ($cek_dapat_pendamping_skill) {
                        $count_jumlah_damping[$skills_pendamping[0]['id_profile_pendamping']] += 1;
                        break;
                    }
                }

                // Jika tidak ada skill yang sesuai
                if (!$cek_dapat_pendamping_skill) {
                    $insert['id_profile_pendamping'] = $temp_jadwal_sesuai[0];
                    $count_jumlah_damping[$temp_jadwal_sesuai[0]] += 1;
                }
            }

            // Memasukkan madif dan pendamping ke pendampingan
            $insert['id_jadwal_ujian_madif'] = $key['id_jadwal_ujian'];
            $insert['id_profile_madif'] = $key['id_profile_mhs'];
            $damping_ujian_sementara[] = $insert;
        }

        return $this->viewGenerate($damping_ujian_sementara);
    }

    public function saveGenerate()
    {
        dd("HELLO");
    }

    public function editGenerate()
    {
    }

    public function delGenerate()
    {
    }

    public function editDamping()
    {
    }

    public function delDamping()
    {
    }

    public function editPendamping()
    {
    }
}
