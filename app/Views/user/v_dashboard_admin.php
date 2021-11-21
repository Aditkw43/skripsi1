<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div class="bg-primary pt-10 pb-21"></div>
<div class="container-fluid mt-n22 px-6">
    <!-- Data -->
    <div class="row">
        <!-- Title -->
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="mb-2 mb-lg-0">
                        <h3 class="mb-0 fw-bold text-white"><?= $title; ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- User -->
        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
            <!-- Title card -->
            <div class="card rounded-3 mb-3">
                <h3 class="text-center my-3">User</h3>
            </div>

            <!-- Jumlah user card -->
            <div class="card rounded-3">

                <!-- Jumlah User card body -->
                <div class="card-body py-3">
                    <!-- project number -->
                    <div class="text-center mb-3">
                        <h3>Total <span class="fw-bold"><?= $d_user['jumlah_user']; ?></span></h3>
                    </div>

                    <div class="row text-center d-flex justify-content-center">
                        <div class="col-auto">
                            <p class="my-auto"><span class="text-dark me-2"><?= $d_user['jumlah_user_aktif']; ?></span>Aktif</p>
                        </div>
                        <div class="col-auto">
                            <p class="my-auto"><span class="text-dark me-2"><?= $d_user['jumlah_user_nonaktif']; ?></span>Non-aktif</p>
                        </div>
                    </div>
                </div>

                <!-- Jumlah masing2 user card body -->
                <div class="card-body py-0">
                    <!-- heading -->
                    <div class="row py-3 border border-2 border-primary rounded-2">
                        <div class="col-4">
                            <div class="row justify-content-center">
                                <h4 class="fw-bold text-center"><?= $d_user['jumlah_user_admin']; ?></h4>
                            </div>
                            <div class="row justify-content-center">
                                Admin
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="row justify-content-center">
                                <h4 class="fw-bold text-center"><?= $d_user['jumlah_user_pendamping']; ?></h4>
                            </div>
                            <div class="row justify-content-center">
                                Pendamping
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="row justify-content-center">
                                <h4 class="fw-bold text-center"><?= $d_user['jumlah_user_madif']; ?></h4>
                            </div>
                            <div class="row justify-content-center">
                                Madif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mahasiswa Difabel card body -->
                <div class="card-body py-3">
                    <!-- heading -->
                    <div class="d-flex justify-content-between align-items-center
                    mb-3">
                        <div>
                            <h4 class="mb-0"><a href="#" class="text-inherit">Mahasiswa Difabel</a></h4>
                        </div>
                        <div class="icon-shape icon-sm bg-light-primary text-primary rounded-1">
                            <a href="#"><i class="fas fa-wheelchair fs-5"></i></a>
                        </div>
                    </div>
                    <!-- project number -->
                    <div class="row d-flex justify-content-center align-items-center">
                        <div class="col-auto">
                            <h4 class="fw-bold d-inline px-1"><?= $d_user['jumlah_madif_aktif']; ?></h4>Aktif
                        </div>
                        <div class="col-auto">
                            <h4 class="fw-bold d-inline px-1"><?= $d_user['jumlah_madif_nonaktif']; ?></h4>Non-aktif
                        </div>
                    </div>
                </div>

                <!-- Pendamping card body -->
                <div class="card-body py-3">
                    <!-- heading -->
                    <div class="d-flex justify-content-between align-items-center
                    mb-3">
                        <div>
                            <h4 class="mb-0"><a href="#" class="text-inherit">Pendamping</a></h4>
                        </div>
                        <div class="icon-shape icon-sm bg-light-primary text-primary rounded-1">
                            <a href="#"><i class="fas fa-user-friends fs-5"></i></a>
                        </div>
                    </div>
                    <!-- project number -->
                    <div class="row d-flex justify-content-center align-items-center">
                        <div class="col-auto">
                            <h4 class="fw-bold d-inline px-1"><?= $d_user['jumlah_pendamping_aktif']; ?></h4>Aktif
                        </div>
                        <div class="col-auto">
                            <h4 class="fw-bold d-inline px-1"><?= $d_user['jumlah_pendamping_nonaktif']; ?></h4>Non-aktif
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Jadwal Ujian  -->
        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
            <!-- card -->
            <div class="card rounded-3 mb-3">
                <h3 class="text-center my-3">Jadwal Ujian</h3>
            </div>
            <!-- card -->
            <div class="card rounded-3">
                <!-- Jumlah jadwal ujian card body -->
                <div class="card-body py-3">
                    <!-- project number -->
                    <div class="text-center mb-3">
                        <h3>Total <span class="fw-bold"><?= $d_jadwal['jumlah_jadwal_ujian']; ?></span></h3>
                    </div>

                    <div class="row text-center d-flex justify-content-center">
                        <div class="col-auto">
                            <p class="my-auto"><span class="text-dark me-2"><?= $d_jadwal['jumlah_jadwal_uts']; ?></span>UTS</p>
                        </div>
                        <div class="col-auto">
                            <p class="my-auto"><span class="text-dark me-2"><?= $d_jadwal['jumlah_jadwal_uas']; ?></span>UAS</p>
                        </div>
                    </div>
                </div>

                <!-- Jadwal ujian UTS card body -->
                <div class="card-body py-1">
                    <!-- heading -->
                    <div class="d-flex justify-content-between align-items-center
                    mb-3">
                        <div>
                            <h4 class="mb-0">Jadwal Ujian UTS</h4>
                        </div>
                        <div class="dropdown dropstart">
                            <a class="text-muted text-primary-hover" href="#" role="button" id="dropdownTeamOne" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="icon-shape icon-md bg-light-primary text-primary rounded-1">
                                    <i class="bi bi-list-task fs-4"></i>
                                </div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownTeamOne">
                                <a class="dropdown-item" href="#">Mahasiswa Difabel</a>
                                <a class="dropdown-item" href="#">Pendamping</a>
                            </div>
                        </div>
                    </div>
                    <!-- project number -->
                    <div>
                        <ul class="list-group">
                            <li class="list-group-item bg-primary text-white fw-normal">
                                <p class="mb-0"><span class="text-white me-2 fw-bold"><?= $d_jadwal['jadwal_uts_verifikasi']; ?></span>Verifikasi</p>
                            </li>
                            <li class="list-group-item bg-success text-white fw-normal">
                                <p class="mb-0"><span class="text-white me-2 fw-bold"><?= $d_jadwal['jadwal_uts_disetujui']; ?></span>Disetujui</p>
                            </li>
                            <li class="list-group-item bg-danger text-white fw-normal">
                                <p class="mb-0"><span class="text-white me-2 fw-bold"><?= $d_jadwal['jadwal_uts_ditolak']; ?></span>Ditolak</p>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Jadwal ujian UAS card body -->
                <div class="card-body py-3">
                    <!-- heading -->
                    <div class="d-flex justify-content-between align-items-center
                    mb-3">
                        <div>
                            <h4 class="mb-0">Jadwal Ujian UAS</h4>
                        </div>
                        <div class="dropdown dropstart">
                            <a class="text-muted text-primary-hover" href="#" role="button" id="dropdownTeamOne" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="icon-shape icon-md bg-light-primary text-primary rounded-1">
                                    <i class="bi bi-list-task fs-4"></i>
                                </div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownTeamOne">
                                <a class="dropdown-item" href="#">Mahasiswa Difabel</a>
                                <a class="dropdown-item" href="#">Pendamping</a>
                            </div>
                        </div>
                    </div>
                    <!-- project number -->
                    <div>
                        <ul class="list-group">
                            <li class="list-group-item bg-primary text-white fw-normal">
                                <p class="mb-0"><span class="text-white me-2 fw-bold"><?= $d_jadwal['jadwal_uas_verifikasi']; ?></span>Verifikasi</p>
                            </li>
                            <li class="list-group-item bg-success text-white fw-normal">
                                <p class="mb-0"><span class="text-white me-2 fw-bold"><?= $d_jadwal['jadwal_uas_disetujui']; ?></span>Disetujui</p>
                            </li>
                            <li class="list-group-item bg-danger text-white fw-normal">
                                <p class="mb-0"><span class="text-white me-2 fw-bold"><?= $d_jadwal['jadwal_uas_ditolak']; ?></span>Ditolak</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pendampingan Ujian  -->
        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
            <!-- card -->
            <div class="card rounded-3 mb-3">
                <h3 class="text-center my-3">Pendampingan Ujian</h3>
            </div>

            <!-- pendampingan body card -->
            <div class="card rounded-3">
                <!-- Jumlah Pendampingan card body -->
                <div class="card-body py-3">
                    <!-- project number -->
                    <div class="text-center mb-3">
                        <h3>Total <span class="fw-bold"><?= $d_damping['jumlah_pendampingan']; ?></span></h3>
                    </div>

                    <div class="row text-center d-flex justify-content-center">
                        <div class="col-auto my-1">
                            <p class="my-auto"><span class="text-dark me-2"><?= $d_damping['jumlah_ada_pendamping']; ?></span>Ada Pendamping</p>
                        </div>
                        <div class="col-auto my-1">
                            <p class="my-auto"><span class="text-dark me-2"><?= $d_damping['jumlah_tanpa_pendamping']; ?></span>Tanpa Pendamping</p>
                        </div>
                    </div>
                </div>

                <!-- Pendampingan UTS card body -->
                <div class="card-body py-1">
                    <!-- heading -->
                    <div class="d-flex justify-content-between align-items-center
                    mb-3">
                        <div>
                            <h4 class="mb-0">Pendampingan UTS</h4>
                        </div>
                        <div class="icon-shape icon-md bg-light-primary text-primary rounded-1">
                            <i class="bi bi-list-task fs-4"></i>
                        </div>
                    </div>
                    <!-- project number -->
                    <div>
                        <ul class="list-group">
                            <li class="list-group-item bg-success text-white fw-normal">
                                <p class="mb-0"><span class="text-white me-2 fw-bold"><?= $d_damping['damping_uts_ada_pendamping']; ?></span>Ada Pendamping</p>
                            </li>
                            <li class="list-group-item bg-danger text-white fw-normal">
                                <p class="mb-0"><span class="text-white me-2 fw-bold"><?= $d_damping['damping_uts_tanpa_pendamping']; ?></span>Tanpa Pendamping</p>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Pendampingan UAS card body -->
                <div class="card-body py-1">
                    <!-- heading -->
                    <div class="d-flex justify-content-between align-items-center
                    mb-3">
                        <div>
                            <h4 class="mb-0">Pendampingan UAS</h4>
                        </div>
                        <div class="icon-shape icon-md bg-light-primary text-primary rounded-1">
                            <i class="bi bi-list-task fs-4"></i>
                        </div>
                    </div>
                    <!-- project number -->
                    <div>
                        <ul class="list-group">
                            <li class="list-group-item bg-success text-white fw-normal">
                                <p class="mb-0"><span class="text-white me-2 fw-bold"><?= $d_damping['damping_uas_tanpa_pendamping']; ?></span>Ada Pendamping</p>
                            </li>
                            <li class="list-group-item bg-danger text-white fw-normal">
                                <p class="mb-0"><span class="text-white me-2 fw-bold"><?= $d_damping['damping_uas_tanpa_pendamping']; ?></span>Tanpa Pendamping</p>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Laporan Pendampingan card body -->
                <div class="card-body py-3">
                    <!-- heading -->
                    <div class="d-flex justify-content-between align-items-center
                    mb-3">
                        <div>
                            <h4 class="mb-0">Laporan</h4>
                        </div>
                        <div class="icon-shape icon-md bg-light-primary text-primary rounded-1">
                            <i class="bi bi-list-task fs-4"></i>
                        </div>
                    </div>
                    <!-- project number -->
                    <div class="d-flex align-items-center">
                        <h1 class="fw-bold"><?= $d_damping['laporan']; ?></h1>
                        <p class="mb-0 mx-2">Completed</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Perizinan -->
        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
            <!-- card -->
            <div class="card rounded-3 mb-3">
                <h3 class="text-center my-3">Perizinan</h3>
            </div>
            <!-- card -->
            <div class="card rounded-3">
                <!-- Jumlah Perizinan card body -->
                <div class="card-body py-3">
                    <!-- project number -->
                    <div class="text-center mb-3">
                        <h3>Total <span class="fw-bold"><?= $d_perizinan['jumlah_perizinan']; ?></span></h3>
                    </div>

                    <div class="row text-center d-flex justify-content-center">
                        <div class="col-sm-6 col-md-6 col-auto my-1">
                            <p class="my-auto"><span class="text-dark me-2"><?= $d_perizinan['jumlah_cuti']; ?></span>Cuti</p>
                        </div>
                        <div class="col-sm-6 col-md-6 col-auto my-1">
                            <p class="my-auto"><span class="text-dark me-2"><?= $d_perizinan['jumlah_izin']; ?></span>Izin</p>
                        </div>
                    </div>
                </div>

                <!-- Perizinan cuti card body -->
                <div class="card-body py-1">
                    <!-- heading -->
                    <div class="d-flex justify-content-between align-items-center
                    mb-3">
                        <div>
                            <h4 class="mb-0">Cuti</h4>
                        </div>
                        <div class="icon-shape icon-md bg-light-primary text-primary rounded-1">
                            <i class="bi bi-list-task fs-4"></i>
                        </div>
                    </div>
                    <!-- project number -->
                    <div class="d-flex align-items-center">
                        <h1 class="fw-bold"><?= $d_perizinan['jumlah_cuti_sementara']; ?></h1>
                        <p class="mb-0 mx-2">Cuti Sementara</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <h1 class="fw-bold"><?= $d_perizinan['jumlah_cuti_semester']; ?></h1>
                        <p class="mb-0 mx-2">Cuti Semester</p>
                    </div>

                    <div>
                        <ul class="list-group">
                            <li class="list-group-item bg-primary text-white fw-normal">
                                <p class="mb-0"><span class="text-white me-2 fw-bold"><?= $d_perizinan['cuti_verifikasi']; ?></span>Verifikasi</p>
                            </li>
                            <li class="list-group-item bg-success text-white fw-normal">
                                <p class="mb-0"><span class="text-white me-2 fw-bold"><?= $d_perizinan['cuti_disetujui']; ?></span>Disetujui</p>
                            </li>
                            <li class="list-group-item bg-danger text-white fw-normal">
                                <p class="mb-0"><span class="text-white me-2 fw-bold"><?= $d_perizinan['cuti_ditolak']; ?></span>Ditolak</p>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Perizinan Izin card body -->
                <div class="card-body py-3">
                    <!-- heading -->
                    <div class="d-flex justify-content-between align-items-center
                    mb-3">
                        <div>
                            <h4 class="mb-0">Izin Tidak Damping</h4>
                        </div>
                        <div class="icon-shape icon-md bg-light-primary text-primary rounded-1">
                            <i class="bi bi-list-task fs-4"></i>
                        </div>
                    </div>
                    <!-- project number -->
                    <div>
                        <ul class="list-group">
                            <li class="list-group-item bg-primary text-white fw-normal">
                                <p class="mb-0"><span class="text-white me-2 fw-bold"><?= $d_perizinan['izin_verifikasi']; ?></span>Verifikasi</p>
                            </li>
                            <li class="list-group-item bg-success text-white fw-normal">
                                <p class="mb-0"><span class="text-white me-2 fw-bold"><?= $d_perizinan['izin_disetujui']; ?></span>Disetujui</p>
                            </li>
                            <li class="list-group-item bg-danger text-white fw-normal">
                                <p class="mb-0"><span class="text-white me-2 fw-bold"><?= $d_perizinan['izin_ditolak']; ?></span>Ditolak</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Verifikasi oleh Admin row  -->
    <div class="row my-6">
        <!-- Verifikasi card  -->
        <div class="col">
            <div class="card h-100">
                <!-- card header  -->
                <div class="card-header bg-white border-bottom-0 py-4">
                    <h4 class="mb-0">Verifikasi oleh Admin</h4>
                </div>

                <!-- table  -->
                <div class="table-responsive">
                    <table class="table text-nowrap">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Verifikasi</th>
                                <th>Update At</th>
                                <th>Detail</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($d_verifikasi)) : ?>
                                <?php
                                $modal = [
                                    'Jadwal Ujian' => 'jadwal_ujian',
                                    'Laporan' => 'laporan',
                                    'Cuti' => 'cuti',
                                    'Izin' => 'izin',
                                    'Skills' => 'skills',
                                    'Jenis Madif' => 'jenis_madif',
                                ];

                                $link = [
                                    'Jadwal Ujian' => 'viewJadwal',
                                    'Laporan' => 'viewAllLaporan',
                                    'Cuti' => 'viewAllCuti',
                                    'Izin' => 'viewAllIzin',
                                    'Skills' => 'viewAllSkill',
                                    'Jenis Madif' => 'viewAllJenisMadif',
                                ];
                                ?>
                                <?php foreach ($d_verifikasi as $dv) : ?>
                                    <?php
                                    foreach ($modal as $key_m => $value_m) {
                                        if ($key_m == $dv['jenis_verifikasi']) {
                                            $jenis_verif = $key_m;
                                            $key_modal = $value_m;
                                            break;
                                        }
                                    }

                                    foreach ($link as $key_l => $value_l) {
                                        if ($key_l == $dv['jenis_verifikasi']) {
                                            $key_link = $value_l;
                                            if (isset($dv['data']['jenis_ujian'])) {
                                                $key_link = $key_link . $dv['data']['jenis_ujian'] . '/' . $dv['data']['nim'];
                                            }
                                        }
                                    }

                                    $approval = [
                                        'Jadwal Ujian' => ($jenis_verif == 'Jadwal Ujian') ? base_url('c_jadwal_ujian/approval/' . $dv['data']['id_jadwal_ujian']) : null,
                                        'Laporan' => ($jenis_verif == 'Laporan') ? base_url('c_damping_ujian/approval/' . $dv['data']['id_laporan_damping']) : null,
                                        'Cuti' => ($jenis_verif == 'Cuti') ? base_url('c_perizinan/approval_cuti/' . $dv['data']['id_cuti']) : null,
                                        'Izin' => ($jenis_verif == 'Izin') ? base_url('c_perizinan/approval_izin/admin/' . $dv['data']['izin_tidak_damping']['id_izin']) : null,
                                        'Skills' => ($jenis_verif == 'Skills') ? base_url('c_user/approval_skill/' . $dv['data']['id_profile_pendamping']) : null,
                                        'Jenis Madif' => ($jenis_verif == 'Jenis Madif') ? base_url('c_user/approval_jenis_madif/' . $dv['data']['id_profile_madif']) : null,
                                    ];

                                    $izin_tanpa_pendamping = null;
                                    if ($jenis_verif == 'Cuti') {
                                        $terima = $approval['Cuti'] . '/terima/' . $dv['data']['nim'];
                                    } elseif ($jenis_verif == 'Izin') {
                                        $terima = $approval['Izin'] . '/terima/' . $dv['data']['izin_tidak_damping']['id_damping_ujian'] . '/' . $dv['data']['izin_tidak_damping']['id_pendamping_baru'];
                                        $cek_izin_tanpa_pendamping = $dv['data']['profile_pendamping_baru'];
                                    } elseif ($jenis_verif == 'Skills') {
                                        $terima = $approval['Skills'] . '/terima/' . $dv['data']['ref_pendampingan'];
                                    } else {
                                        $terima = $approval[$jenis_verif] . '/terima';
                                    }

                                    if ($jenis_verif == 'Skills') {
                                        $tolak = $approval['Skills'] . '/tolak/' . $dv['data']['ref_pendampingan'];
                                    } else {
                                        $tolak = $approval[$jenis_verif] . '/tolak';
                                    }
                                    ?>
                                    <tr>
                                        <td class="align-middle">
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <img src="assets/images/avatar/avatar-2.jpg" alt="" class="avatar-md avatar rounded-circle">
                                                </div>
                                                <div class="ms-3 lh-1">
                                                    <h5 class="fw-bold mb-1"><?= $dv['nickname']; ?></h5>
                                                    <p class="mb-0"><?= ucfirst($dv['role']); ?> <?= ($dv['role'] == 'madif') ? ' -> ' . $dv['kategori_difabel'] : ''; ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle"><a href="<?= $key_link; ?>" class="text-inherit btn btn-primary btn-sm"><?= $dv['jenis_verifikasi']; ?></a></td>
                                        <td class="align-middle"><?= $dv['updated_at']; ?></td>
                                        <td class="align-middle">
                                            <button type="button" class="btn btn-warning btn-sm my-1" data-bs-toggle="modal" data-bs-target="#<?= $key_modal; ?>" ?>
                                                Detail
                                            </button>
                                            <?php if ($dv['jenis_verifikasi'] == 'Izin' || $dv['jenis_verifikasi'] == 'Cuti') : ?>
                                                <a href="/img/dokumen_izin/<?= strtolower($dv['jenis_verifikasi']) . '/' . $dv['data']['dokumen']; ?>" target="_blank" class="btn btn-secondary btn-sm"><i class="fa fa-download"></i> Dokumen</a>
                                            <?php endif; ?>
                                        </td>
                                        <td class="align-middle">
                                            <?php if (!isset($cek_izin_tanpa_pendamping)) : ?>
                                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#terimaIzin">Terima</button>
                                            <?php else : ?>
                                                <a href="<?= $terima; ?>" class="btn btn-success btn-sm my-1">Terima</a>
                                            <?php endif; ?>
                                            <a href="<?= $tolak; ?>" class="btn btn-danger btn-sm">Tolak</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <td colspan="5" class="text-center">Tidak ada data untuk diverifikasi</td>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php
    $icon_kategori_difabel = [
        'Tunarungu' => "text-success fas fa-deaf",
        'Tunadaksa' => "text-success fab fa-accessible-icon",
        'Tunanetra' => "text-success fas fa-eye-slash",
        'Autisme' => "text-success fas fa-puzzle-piece",
        'ADHD' => "text-success fas fa-running",
        'Celebral Palsy' => "text-success fas fa-brain",
        'Slow Learner' => "text-success fas fa-book-reader",
        'Tunagrahita' => "text-success fas fa-braille",
        'Bibir Sumbing' => "text-success fas fa-grin-alt",
        'Down Syndrome' => "text-success far fa-smile",
        'Gangguan Syaraf' => "text-success fas fa-code-branch",
        'Hydrochepalus' => "text-warning fas fa-brain",
        'IQ Borderline' => "text-danger fas fa-brain",
        'Low Vision' => "text-success fas fa-low-vision",
        'Tunawicara' => "text-success fas fa-volume-mute",
        "Writer's Cramp Dystonia" => "text-success fas fa-pencil-alt",
    ];
    ?>

    <!-- Jenis difabel row -->
    <div class="row my-6">
        <!-- Jenis Difabel -->
        <div class="col-md-12 col-12">
            <!-- card  -->
            <div class="card h-auto">
                <!-- card body  -->
                <div class="card-body">
                    <div class="d-flex align-items-center
                    justify-content-between mb-8">
                        <div>
                            <h4 class="mb-0">Jenis Difabel</h4>
                        </div>
                    </div>
                    <!-- icon with content  -->
                    <div class="row d-flex align-items-center justify-content-center">
                        <?php foreach ($d_jenis_madif as $key_jm => $value_jm) : ?>
                            <?php
                            foreach ($icon_kategori_difabel as $key_icon => $value_icon) {
                                if ($key_jm == $key_icon) {
                                    $icon_jenis_madif = $value_icon;
                                }
                            }
                            ?>
                            <div class="text-center col-3 mb-2">
                                <i class="fs-2 <?= $icon_jenis_madif; ?>"></i>
                                <h1 class="mt-3 fw-bold mb-1"><?= $value_jm; ?></h1>
                                <p><?= $key_jm; ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Skills pendamping row  -->
    <div class="row mt-6 mb-6">
        <div class="col-md-12 col-12">
            <!-- card  -->
            <div class="card">
                <!-- card header  -->
                <div class="card-header bg-white border-bottom-0 py-4">
                    <h4 class="mb-0">Skills Pendamping</h4>
                </div>
                <!-- table  -->
                <div class="table-responsive">
                    <table class="table text-nowrap mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Referensi</th>
                                <?php foreach ($d_skills_pendamping[array_key_first($d_skills_pendamping)] as $key_prior => $value_prior) : ?>
                                    <th><?= $key_prior; ?></th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($d_skills_pendamping as $key_sp => $value_sp) : ?>
                                <tr class="<?= ($key_sp == 'Total') ? 'table-success' : ''; ?>">
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <?php
                                                foreach ($icon_kategori_difabel as $key_icon_skill => $value_icon_skill) {
                                                    if ($key_sp == $key_icon_skill) {
                                                        $icon_jenis_madif = $value_icon_skill;
                                                    }
                                                }
                                                ?>
                                                <?php if ($key_sp != 'Total') : ?>
                                                    <div class="icon-shape icon-md p-4">
                                                        <i class="fs-2 <?= $icon_jenis_madif; ?>"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="ms-3 lh-1">
                                                <h5 class="fw-bold mb-1"><a href="#" class="text-inherit"><?= $key_sp; ?></a></h5>
                                            </div>
                                        </div>
                                    </td>
                                    <?php foreach ($value_sp as $prior_sp) : ?>
                                        <td class="align-middle"><?= $prior_sp; ?></td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<?php if (isset($d_verifikasi['v_jadwal_ujian'])) : ?>
    <!-- Modal Jadwal Ujian -->
    <div class="modal fade" id="jadwal_ujian" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background-color: orange">
                    <h5 class="modal-title fw-bold" id="exampleModalLabel">Detail Jadwal Ujian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="card shadow p-3 mb-5 bg-body rounded">
                        <div class="card-header text-center fw-bold">
                            <?= $d_verifikasi['v_jadwal_ujian']['data']['mata_kuliah']; ?>
                        </div>
                        <div class="card-body">
                            <!-- Tanggal Ujian -->
                            <div class="row">
                                <label for="tanggal_ujian" class="col-sm-4 col-form-label">Tanggal Ujian</label>
                                <div class="col-sm-8">
                                    <input type="text" readonly class="form-control-plaintext" id="tanggal_ujian" value="<?= date('d, M Y', strtotime($d_verifikasi['v_jadwal_ujian']['data']['tanggal_ujian'])); ?>">
                                </div>
                            </div>

                            <!-- Jam Ujian -->
                            <div class="row">
                                <label for="staticEmail" class="col-sm-4 col-form-label">Jam Ujian</label>
                                <div class="col-sm-8">
                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= date('H:i', strtotime($d_verifikasi['v_jadwal_ujian']['data']['waktu_mulai_ujian'])); ?> - <?= date('H:i', strtotime($d_verifikasi['v_jadwal_ujian']['data']['waktu_selesai_ujian'])); ?>">
                                </div>
                            </div>

                            <!-- Ruangan -->
                            <div class="row">
                                <label for="staticEmail" class="col-sm-4 col-form-label">Ruangan</label>
                                <div class="col-sm-8">
                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $d_verifikasi['v_jadwal_ujian']['data']['ruangan']; ?>">
                                </div>
                            </div>

                            <!-- Keterangan -->
                            <div class="row">
                                <label for="staticEmail" class="col-sm-4 col-form-label">Keterangan</label>
                                <div class="col-sm-8">
                                    <button class="btn btn-primary btn-sm mt-1" data-bs-target="#keterangan-jadwal-ujian<?= $d_verifikasi['v_jadwal_ujian']['data']['id_jadwal_ujian']; ?>" data-bs-toggle="modal" data-bs-dismiss="modal">Keterangan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit button -->
                <div class="modal-footer">
                    <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cancel</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Keterangan Jadwal Ujian-->
    <div class="modal fade" id="keterangan-jadwal-ujian<?= $d_verifikasi['v_jadwal_ujian']['data']['id_jadwal_ujian']; ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background-color: rgba(34, 84, 145, 1);">
                    <h5 class="modal-title text-white" id="exampleModalToggleLabel2">Keterangan Jadwal Ujian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="color: black">
                    <?= $d_verifikasi['v_jadwal_ujian']['data']['keterangan']; ?>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-bs-target="#jadwal_ujian" data-bs-toggle="modal" data-bs-dismiss="modal">Kembali</button>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if (isset($d_verifikasi['v_laporan'])) : ?>
    <!-- Modal Laporan -->
    <div class="modal fade" id="laporan" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background-color: rgba(12, 124, 79, 1);">
                    <h5 class="modal-title text-white fw-bold" id="exampleModalToggleLabel2">Laporan Pendampingan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body" style="color: black">

                    <!-- Waktu Presensi -->
                    <div class="row mt-0 mb-2 g-3 align-items-center justify-content-center text-center">
                        <label for="" class="form-label mt-0 mb-2 fw-bold">Waktu Presensi <span style="color: red;" class="fs-6"><?= ($d_verifikasi['v_laporan']['data']['presensi']['tepat_waktu'] == 0) ? '*Terlambat' : ''; ?></span></label>
                        <div class="col-3 mt-0">
                            <input type="text" class="form-control" placeholder="kehadiran" value="<?= date('H:i', strtotime($d_verifikasi['v_laporan']['data']['presensi']['waktu_hadir'])); ?>" aria-label="First name" disabled>
                        </div>
                        -
                        <div class="col-3 mt-0">
                            <input type="text" class="form-control" placeholder="selesai" value="<?= date('H:i', strtotime($d_verifikasi['v_laporan']['data']['presensi']['waktu_selesai'])); ?>" aria-label="Last name" disabled>
                        </div>
                    </div>

                    <hr>

                    <!-- Rating Madif -->
                    <label for="disabledRange" class="form-label">Rating Mahasiswa Difabel</label>
                    <input type="range" class="form-range" id="disabledRange" min="0" max="5" value="<?= $d_verifikasi['v_laporan']['data']['madif_rating']; ?>" disabled>

                    <!-- Rating Pendamping-->
                    <label for="disabledRange" class="form-label">Rating Pendamping</label>
                    <input type="range" class="form-range" id="disabledRange" min="0" max="5" value="<?= $d_verifikasi['v_laporan']['data']['pendamping_rating']; ?>" disabled>

                    <!-- Evaluasi Madif -->
                    <div class="form-floating mb-2">
                        <textarea class="form-control" placeholder="Leave a comment here" id="evaluasi_pendampingan" style="height: 100px" name="review_pendampingan" disabled><?= $d_verifikasi['v_laporan']['data']['madif_review']; ?></textarea>
                        <label for="evaluasi_pendampingan" class="text-muted">Evaluasi Madif</label>
                    </div>

                    <!-- Evaluasi Pendamping -->
                    <div class="form-floating mb-2">
                        <textarea class="form-control" placeholder="Leave a comment here" id="evaluasi_pendampingan" style="height: 100px" name="review_pendampingan" disabled><?= $d_verifikasi['v_laporan']['data']['pendamping_review']; ?></textarea>
                        <label for="evaluasi_pendampingan" class="text-muted">Evaluasi Pendamping</label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if (isset($d_verifikasi['v_cuti'])) : ?>
    <!-- Modal Profile Pendamping-->
    <div class="modal fade" id="cuti" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background-color: blueviolet">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Form -->
                <div class="modal-body" style="background-color: white;">

                    <div class="container">
                        <h4 class="text-center"><?= ($d_verifikasi['v_cuti']['role'] == 'madif') ? 'Mahasiswa Difabel' : 'Pendamping'; ?></h4>
                        <div class="row mt-5">
                            <div class="col-md-6 mb-2">
                                <label for="nama_pendamping_lama" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama_pendamping_lama" placeholder='<?= $d_verifikasi['v_cuti']['data']['fullname']; ?>' readonly>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="jenis_kelamin_pendamping_lama" class="form-label">Jenis Kelamin</label>
                                <input type="text" class="form-control" id="jenis_kelamin_pendamping_lama" placeholder='<?= ($d_verifikasi['v_cuti']['data']['jenis_kelamin'] == 1) ? 'Laki-laki' : 'Perempuan'; ?>' readonly>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="fakultas_pendamping_lama" class="form-label">Fakultas</label>
                                <input type="text" class="form-control" id="fakultas_pendamping_lama" placeholder='<?= $d_verifikasi['v_cuti']['data']['fakultas']; ?>' readonly>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="jurusan_pendamping_lama" class="form-label">Jurusan</label>
                                <input type="text" class="form-control" id="jurusan_pendamping_lama" placeholder='<?= $d_verifikasi['v_cuti']['data']['jurusan'] ?>' readonly>
                            </div>
                            <label for="nomor_pendamping_lama" class="col-sm-auto col-form-label">Nomor HP</label>

                            <div class="col-sm-auto">
                                <input type="text" class="form-control-plaintext" id="nomor_pendamping_lama" value='<?= $d_verifikasi['v_cuti']['data']['nomor_hp'] ?>'>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if (isset($d_verifikasi['v_jenis_madif'])) : ?>
    <!-- Modal Jenis Madif-->
    <div class="modal fade" id="jenis_madif" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background-color: blueviolet">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Jenis Mahasiswa Difabel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Form -->
                <div class="modal-body" style="background-color: white;">

                    <div class="container">
                        <div class="row">
                            <div class="col mb-2">
                                <label for="nama_pendamping_lama" class="form-label">Jenis Difabel</label>
                                <input type="text" class="form-control" id="nama_pendamping_lama" placeholder='<?= $d_verifikasi['v_jenis_madif']['kategori_difabel']; ?>' readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if (isset($d_verifikasi['v_skills'])) : ?>
    <!-- Modal Jenis Madif-->
    <div class="modal fade" id="skills" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background-color: blueviolet">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Skills Pendamping</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Form -->
                <div class="modal-body" style="background-color: white;">
                    <div class="container">
                        <div class="row">
                            <div class="mb-2">
                                <label for="nama_pendamping_lama" class="form-label">Referensi Pendamping</label>
                                <input type="text" class="form-control" id="nama_pendamping_lama" placeholder='<?= $d_verifikasi['v_skills']['data']['kategori_difabel']; ?>' readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-2">
                                <label for="nama_pendamping_lama" class="form-label">Prioritas</label>
                                <input type="text" class="form-control" id="nama_pendamping_lama" placeholder='<?= $d_verifikasi['v_skills']['data']['prioritas']; ?>' readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if (isset($d_verifikasi['v_tidak_damping'])) : ?>
    <!-- Modal Profile Pendamping-->
    <div class="modal fade" id="izin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background-color: blueviolet">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Profile Pendamping</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Form -->
                <div class="modal-body" style="background-color: white;">

                    <div class="container">
                        <h4 class="text-center">Pendamping Lama</h4>
                        <div class="row mt-5">
                            <div class="col-md-6 mb-2">
                                <label for="nama_pendamping_lama" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama_pendamping_lama" placeholder='<?= $d_verifikasi['v_tidak_damping']['data']['profile_pendamping_lama']['fullname']; ?>' readonly>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="jenis_kelamin_pendamping_lama" class="form-label">Jenis Kelamin</label>
                                <input type="text" class="form-control" id="jenis_kelamin_pendamping_lama" placeholder='<?= ($d_verifikasi['v_tidak_damping']['data']['profile_pendamping_lama']['jenis_kelamin'] == 1) ? 'Laki-laki' : 'Perempuan'; ?>' readonly>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="fakultas_pendamping_lama" class="form-label">Fakultas</label>
                                <input type="text" class="form-control" id="fakultas_pendamping_lama" placeholder='<?= $d_verifikasi['v_tidak_damping']['data']['profile_pendamping_lama']['fakultas']; ?>' readonly>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="jurusan_pendamping_lama" class="form-label">Jurusan</label>
                                <input type="text" class="form-control" id="jurusan_pendamping_lama" placeholder='<?= $d_verifikasi['v_tidak_damping']['data']['profile_pendamping_lama']['jurusan'] ?>' readonly>
                            </div>
                            <label for="nomor_pendamping_lama" class="col-sm-auto col-form-label">Nomor HP</label>

                            <div class="col-sm-auto">
                                <input type="text" class="form-control-plaintext" id="nomor_pendamping_lama" value='<?= $d_verifikasi['v_tidak_damping']['data']['profile_pendamping_lama']['nomor_hp'] ?>'>
                            </div>
                        </div>

                    </div>
                    <?php if (isset($d_verifikasi['v_tidak_damping']['data']['profile_pendamping_baru'])) : ?>
                        <hr>
                        <div class="container">
                            <h4 class="text-center">Pendamping Baru</h4>
                            <div class="row mt-5">
                                <div class="col-md-6 mb-2">
                                    <label for="nama_pendamping_baru" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama_pendamping_baru" placeholder='<?= $d_verifikasi['v_tidak_damping']['data']['profile_pendamping_baru']['fullname']; ?>' readonly>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="jenis_kelamin_pendamping_baru" class="form-label">Jenis Kelamin</label>
                                    <input type="text" class="form-control" id="jenis_kelamin_pendamping_baru" placeholder='<?= ($d_verifikasi['v_tidak_damping']['data']['profile_pendamping_baru']['jenis_kelamin'] == 1) ? 'Laki-laki' : 'Perempuan'; ?>' readonly>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="fakultas_pendamping_baru" class="form-label">Fakultas</label>
                                    <input type="text" class="form-control" id="fakultas_pendamping_baru" placeholder='<?= $d_verifikasi['v_tidak_damping']['data']['profile_pendamping_baru']['fakultas']; ?>' readonly>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="jurusan_pendamping_baru" class="form-label">Jurusan</label>
                                    <input type="text" class="form-control" id="jurusan_pendamping_baru" placeholder='<?= $d_verifikasi['v_tidak_damping']['data']['profile_pendamping_baru']['jurusan'] ?>' readonly>
                                </div>
                                <label for="nomor_pendamping_baru" class="col-sm-auto col-form-label">Nomor HP</label>

                                <div class="col-sm-auto">
                                    <input type="text" class="form-control-plaintext" id="nomor_pendamping_baru" value='<?= $d_verifikasi['v_tidak_damping']['data']['profile_pendamping_baru']['nomor_hp'] ?>'>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <?php if (!isset($d_verifikasi['v_tidak_damping']['data']['profile_pendamping_baru'])) : ?>
        <!-- Izin Tanpa Pendamping -->
        <div class="modal fade" id="terimaIzin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Header -->
                    <div class="modal-header" style="background-color: rgba(0, 136, 120, 1)">
                        <h5 class="modal-title" id="exampleModalLabel" style=" color:white">Mencari Pengganti</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="<?= base_url('c_perizinan/approval_izin/admin/' . $d_verifikasi['v_tidak_damping']['data']['izin_tidak_damping']['id_izin'] . '/terima'); ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <div class="modal-body">
                            <!-- ID Daping -->
                            <input type="hidden" name="id_damping" value="<?= $d_verifikasi['v_tidak_damping']['data']['izin_tidak_damping']['id_damping_ujian']; ?>">

                            <!-- Pilih Mahasiswa-->
                            <div class="row mb-3">
                                <label for="pendamping_pengganti" class="col-sm-4 col-form-label">Pengganti</label>
                                <div class="col-sm-8">
                                    <select class="form-select" aria-label="Default select example" name="pendamping_pengganti" id="pendamping_pengganti" autofocus required>
                                        <option value='null' selected>Pilih Pengganti</option>
                                        <?= $count = 1; ?>
                                        <?php foreach ($d_verifikasi['v_tidak_damping']['data']['pendamping_alt'] as $pendamping_alt) : ?>
                                            <?php
                                            $status = '';
                                            if ($pendamping_alt['urutan'] == 1) {
                                                $status = ' (Rekomendasi)';
                                            } elseif ($pendamping_alt['urutan'] == 2) {
                                                $status = ' (Jadwal Cocok)';
                                            } elseif ($pendamping_alt['urutan'] == 3) {
                                                $status = ' (Skill Cocok)';
                                            }
                                            ?>
                                            <option value="<?= $pendamping_alt['id_profile_pendamping']; ?>"> <?= $count . '. ' . $pendamping_alt['nickname'] . $status; ?></option>
                                            <?php $count++; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Submit button -->
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success">
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>

<?= $this->endSection('page-content'); ?>