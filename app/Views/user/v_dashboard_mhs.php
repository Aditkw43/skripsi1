<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div class="bg-primary pt-10 pb-21"></div>
<div class="container-fluid mt-n22 px-6">
    <div class="row">
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
        <!-- Jadwal Ujian -->
        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
            <!-- card -->
            <div class="card rounded-3">
                <!-- card body -->
                <div class="card-body">
                    <!-- heading -->
                    <div class="d-flex justify-content-between align-items-center
                    mb-3">
                        <div>
                            <h4 class="mb-0">Jadwal Ujian</h4>
                        </div>
                        <div class="icon-shape icon-md bg-light-primary text-primary rounded-1">
                            <i class="fas fa-clipboard-list fs-4"></i>
                        </div>
                    </div>
                    <!-- project number -->
                    <div class="d-flex align-items-center justify-content-center">
                        <h1 class="fw-bold"><?= $d_jadwal['jumlah_jadwal_uts']; ?></h1>
                        <p class="mb-0 mx-2">UTS</p>
                    </div>
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
                    <div class="d-flex align-items-center justify-content-center mt-3">
                        <h1 class="fw-bold"><?= $d_jadwal['jumlah_jadwal_uas']; ?></h1>
                        <p class="mb-0 mx-2">UAS</p>
                    </div>
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
        <!-- Pendampingan Ujian -->
        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
            <!-- card -->
            <div class="card rounded-3">
                <!-- card body -->
                <div class="card-body">
                    <!-- heading -->
                    <div class="d-flex justify-content-between align-items-center
                    mb-3">
                        <div>
                            <h4 class="mb-0">Pendampingan Ujian</h4>
                        </div>
                        <div class="icon-shape icon-md bg-light-primary text-primary rounded-1">
                            <i class="fas fa-calendar-week fs-4"></i>
                        </div>
                    </div>
                    <!-- project number -->
                    <div class="d-flex align-items-center justify-content-center">
                        <h1 class="fw-bold"><?= $d_damping['jumlah_damping_uts']; ?></h1>
                        <p class="mb-0 mx-2">UTS</p>
                    </div>
                    <div>
                        <ul class="list-group">
                            <li class="list-group-item bg-primary text-white fw-normal">
                                <p class="mb-0"><span class="text-white me-2 fw-bold"><?= $d_damping['damping_uts_verifikasi']; ?></span>Verifikasi</p>
                            </li>
                            <li class="list-group-item bg-success text-white fw-normal">
                                <p class="mb-0"><span class="text-white me-2 fw-bold"><?= $d_damping['damping_uts_disetujui']; ?></span>Disetujui</p>
                            </li>
                            <li class="list-group-item bg-danger text-white fw-normal">
                                <p class="mb-0"><span class="text-white me-2 fw-bold"><?= $d_damping['damping_uts_ditolak']; ?></span>Ditolak</p>
                            </li>
                        </ul>
                    </div>
                    <div class="d-flex align-items-center justify-content-center mt-3">
                        <h1 class="fw-bold"><?= $d_damping['jumlah_damping_uts']; ?></h1>
                        <p class="mb-0 mx-2">UAS</p>
                    </div>
                    <div>
                        <ul class="list-group">
                            <li class="list-group-item bg-primary text-white fw-normal">
                                <p class="mb-0"><span class="text-white me-2 fw-bold"><?= $d_damping['damping_uts_verifikasi']; ?></span>Verifikasi</p>
                            </li>
                            <li class="list-group-item bg-success text-white fw-normal">
                                <p class="mb-0"><span class="text-white me-2 fw-bold"><?= $d_damping['damping_uts_disetujui']; ?></span>Disetujui</p>
                            </li>
                            <li class="list-group-item bg-danger text-white fw-normal">
                                <p class="mb-0"><span class="text-white me-2 fw-bold"><?= $d_damping['damping_uts_ditolak']; ?></span>Ditolak</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Laporan Ujian -->
        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
            <!-- card -->
            <div class="card rounded-3">
                <!-- card body -->
                <div class="card-body">
                    <!-- heading -->
                    <div class="d-flex justify-content-between align-items-center
                    mb-3">
                        <div>
                            <h4 class="mb-0">Laporan Ujian</h4>
                        </div>
                        <div class="icon-shape icon-md bg-light-primary text-primary rounded-1">
                            <i class="fas fa-clipboard-check fs-4"></i>
                        </div>
                    </div>
                    <!-- project number -->
                    <div class="d-flex align-items-center justify-content-center">
                        <h1 class="fw-bold"><?= $d_laporan['jumlah_laporan_uts']; ?></h1>
                        <p class="mb-0 mx-2">UTS</p>
                    </div>
                    <div>
                        <ul class="list-group">
                            <li class="list-group-item bg-primary text-white fw-normal">
                                <p class="mb-0"><span class="text-white me-2 fw-bold"><?= $d_laporan['laporan_uts_verifikasi']; ?></span>Verifikasi</p>
                            </li>
                            <li class="list-group-item bg-success text-white fw-normal">
                                <p class="mb-0"><span class="text-white me-2 fw-bold"><?= $d_laporan['laporan_uts_disetujui']; ?></span>Disetujui</p>
                            </li>
                            <li class="list-group-item bg-danger text-white fw-normal">
                                <p class="mb-0"><span class="text-white me-2 fw-bold"><?= $d_laporan['laporan_uts_ditolak']; ?></span>Ditolak</p>
                            </li>
                        </ul>
                    </div>
                    <div class="d-flex align-items-center justify-content-center mt-3">
                        <h1 class="fw-bold"><?= $d_laporan['jumlah_laporan_uts']; ?></h1>
                        <p class="mb-0 mx-2">UAS</p>
                    </div>
                    <div>
                        <ul class="list-group">
                            <li class="list-group-item bg-primary text-white fw-normal">
                                <p class="mb-0"><span class="text-white me-2 fw-bold"><?= $d_laporan['laporan_uts_verifikasi']; ?></span>Verifikasi</p>
                            </li>
                            <li class="list-group-item bg-success text-white fw-normal">
                                <p class="mb-0"><span class="text-white me-2 fw-bold"><?= $d_laporan['laporan_uts_disetujui']; ?></span>Disetujui</p>
                            </li>
                            <li class="list-group-item bg-danger text-white fw-normal">
                                <p class="mb-0"><span class="text-white me-2 fw-bold"><?= $d_laporan['laporan_uts_ditolak']; ?></span>Ditolak</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Perizinan Ujian -->
        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
            <!-- card -->
            <div class="card rounded-3">
                <!-- card body -->
                <div class="card-body">
                    <!-- heading -->
                    <div class="d-flex justify-content-between align-items-center
                    mb-3">
                        <div>
                            <h4 class="mb-0">Perizinan</h4>
                        </div>
                        <div class="icon-shape icon-md bg-light-primary text-primary rounded-1">
                            <i class="fas fa-file-medical fs-4"></i>
                        </div>
                    </div>
                    <!-- project number -->
                    <div class="d-flex align-items-center justify-content-center">
                        <h1 class="fw-bold"><?= $d_perizinan['jumlah_cuti']; ?></h1>
                        <p class="mb-0 mx-2">Cuti</p>
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
                    <div class="d-flex align-items-center justify-content-center mt-3">
                        <h1 class="fw-bold"><?= $d_perizinan['jumlah_izin']; ?></h1>
                        <p class="mb-0 mx-2">Tidak Damping</p>
                    </div>
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
</div>

<?= $this->endSection('page-content'); ?>