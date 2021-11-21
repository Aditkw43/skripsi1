<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid px-6 py-4">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="row mb-6">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="mb-2 mt-2" style="display: flex; justify-content: space-between; align-items:center">
                        <h2><?= $title; ?></h2>
                    </div>
                    <?php if (session()->getFlashData('berhasil_digenerate')) : ?>
                        <div class="alert alert-success" role="alert">
                            <?= session()->getFlashData('berhasil_digenerate'); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Card -->
                    <div class="card">

                        <!-- Tab table -->
                        <ul class="nav nav-line-bottom" id="pills-tab-table" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-table-verifikasi-laporan-damping-tab" data-bs-toggle="pill" href="#pills-table-verifikasi-laporan-damping" role="tab" aria-controls="pills-table-verifikasi-laporan-damping" aria-selected="true">Verifikasi Laporan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-table-laporan-diterima-tab" data-bs-toggle="pill" href="#pills-table-laporan-diterima" role="tab" aria-controls="pills-table-laporan-diterima" aria-selected="true">Laporan Diterima</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-table-laporan-ditolak-tab" data-bs-toggle="pill" href="#pills-table-laporan-ditolak" role="tab" aria-controls="pills-table-laporan-ditolak" aria-selected="true">Laporan Ditolak</a>
                            </li>
                        </ul>

                        <!-- Tab content -->
                        <div class=" tab-content p-4" id="pills-tabContent-table">

                            <!-- Laporan Diverifikasi Table -->
                            <div class="tab-pane tab-example-design fade show active" id="pills-table-verifikasi-laporan-damping" role="tabpanel" aria-labelledby="pills-table-verifikasi-laporan-damping-tab">
                                <div class="table-responsive">
                                    <table class="table table-hover table-dark" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                                        <thead>

                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Tanggal Ujian</th>
                                                <th scope="col">Madif</th>
                                                <th scope="col">Pendamping</th>
                                                <th scope="col">Mata Kuliah</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Aksi</th>
                                            </tr>

                                        </thead>
                                        <tbody class="table-light">
                                            <?php if (!empty($laporan_diverifikasi)) : ?>
                                                <?php $i = 1 ?>
                                                <?php foreach ($laporan_diverifikasi as $lv) : ?>
                                                    <tr class="align-middle">

                                                        <!-- Id Laporan Damping -->
                                                        <input type="hidden" name="id_damping" value="<?= $lv['laporan']['id_laporan_damping']; ?>">

                                                        <!-- Nomor -->
                                                        <th scope="row"><?= $i; ?></th>

                                                        <!-- Tanggal Ujian -->
                                                        <td><?= date('d, M Y', strtotime($lv['jadwal_ujian']['tanggal_ujian'])); ?></td>

                                                        <!-- Nama Madif-->
                                                        <td><?= $lv['biodata']['biodata_madif']['nickname']; ?></td>
                                                        <!-- Nama Pendamping -->
                                                        <td><?= $lv['biodata']['biodata_pendamping']['nickname']; ?></td>

                                                        <!-- Mata Kuliah -->
                                                        <td><?= $lv['jadwal_ujian']['mata_kuliah']; ?></td>

                                                        <!-- Status -->
                                                        <td>
                                                            <a href="<?= base_url('c_damping_ujian/approval'); ?>/<?= $lv['laporan']['id_laporan_damping'], '/terima'; ?>" class="btn btn-success btn-sm my-1">Terima</a>
                                                            <a href="<?= base_url('c_damping_ujian/approval'); ?>/<?= $lv['laporan']['id_laporan_damping'], '/tolak'; ?>" class="btn btn-danger btn-sm">Tolak</a>
                                                        </td>

                                                        <!-- Aksi -->
                                                        <td>
                                                            <button type="button" class="btn btn-warning btn-sm editJadwal my-1" data-bs-toggle="modal" data-bs-target="#jadwalDamping<?= $lv['laporan']['id_laporan_damping']; ?>" ?>
                                                                Detail
                                                            </button>

                                                            <button type="button" class="btn btn-primary btn-sm editJadwal" data-bs-toggle="modal" data-bs-target="#profile<?= $lv['laporan']['id_laporan_damping']; ?>" ?>
                                                                Profile
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <?php $i++; ?>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Laporan Diterima Table -->
                            <div class="tab-pane tab-example-html fade" id="pills-table-laporan-diterima" role="tabpanel" aria-labelledby="pills-table-laporan-diterima-tab">
                                <div class="table-responsive">
                                    <table class="table table-hover table-dark" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                                        <thead>

                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Tanggal Ujian</th>
                                                <th scope="col">Madif</th>
                                                <th scope="col">Pendamping</th>
                                                <th scope="col">Mata Kuliah</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Aksi</th>
                                            </tr>

                                        </thead>
                                        <tbody class="table-light">
                                            <?php if (!empty($laporan_diterima)) : ?>
                                                <?php $i = 1 ?>
                                                <?php foreach ($laporan_diterima as $acc) : ?>
                                                    <tr class="align-middle">

                                                        <!-- Id Laporan Damping -->
                                                        <input type="hidden" name="id_damping" value="<?= $acc['laporan']['id_laporan_damping']; ?>">

                                                        <!-- Nomor -->
                                                        <th scope="row"><?= $i; ?></th>

                                                        <!-- Tanggal Ujian -->
                                                        <td><?= date('d, M Y', strtotime($acc['jadwal_ujian']['tanggal_ujian'])); ?></td>

                                                        <!-- Nama Madif-->
                                                        <td><?= $acc['biodata']['biodata_madif']['nickname']; ?></td>
                                                        <!-- Nama Pendamping -->
                                                        <td><?= $acc['biodata']['biodata_pendamping']['nickname']; ?></td>

                                                        <!-- Mata Kuliah -->
                                                        <td><?= $acc['jadwal_ujian']['mata_kuliah']; ?></td>

                                                        <!-- Status -->
                                                        <td style="color: green">
                                                            Terverifikasi
                                                        </td>

                                                        <!-- Aksi -->
                                                        <td>
                                                            <button type="button" class="btn btn-warning btn-sm editJadwal my-1" data-bs-toggle="modal" data-bs-target="#jadwalDamping<?= $acc['laporan']['id_laporan_damping']; ?>" ?>
                                                                Detail
                                                            </button>

                                                            <button type="button" class="btn btn-primary btn-sm editJadwal" data-bs-toggle="modal" data-bs-target="#profile<?= $acc['laporan']['id_laporan_damping']; ?>" ?>
                                                                Profile
                                                            </button>
                                                        </td>

                                                    </tr>
                                                    <?php $i++; ?>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Laporan Ditolak Table -->
                            <div class="tab-pane tab-example-html fade" id="pills-table-laporan-ditolak" role="tabpanel" aria-labelledby="pills-table-laporan-ditolak-tab">
                                <div class="table-responsive">
                                    <table class="table table-hover table-dark" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                                        <thead>

                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Tanggal Ujian</th>
                                                <th scope="col">Madif</th>
                                                <th scope="col">Pendamping</th>
                                                <th scope="col">Mata Kuliah</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Aksi</th>
                                            </tr>

                                        </thead>
                                        <tbody class="table-light">
                                            <?php if (!empty($laporan_ditolak)) : ?>
                                                <?php $i = 1 ?>
                                                <?php foreach ($laporan_ditolak as $reject) : ?>
                                                    <tr class="align-middle">

                                                        <!-- Id Laporan Damping -->
                                                        <input type="hidden" name="id_damping" value="<?= $reject['laporan']['id_laporan_damping']; ?>">

                                                        <!-- Nomor -->
                                                        <th scope="row"><?= $i; ?></th>

                                                        <!-- Tanggal Ujian -->
                                                        <td><?= date('d, M Y', strtotime($reject['jadwal_ujian']['tanggal_ujian'])); ?></td>

                                                        <!-- Nama Madif-->
                                                        <td><?= $reject['biodata']['biodata_madif']['nickname']; ?></td>
                                                        <!-- Nama Pendamping -->
                                                        <td><?= $reject['biodata']['biodata_pendamping']['nickname']; ?></td>

                                                        <!-- Mata Kuliah -->
                                                        <td><?= $reject['jadwal_ujian']['mata_kuliah']; ?></td>

                                                        <!-- Status -->
                                                        <td style="color: red">
                                                            Ditolak
                                                        </td>

                                                        <!-- Aksi -->
                                                        <td>
                                                            <button type="button" class="btn btn-warning btn-sm editJadwal my-1" data-bs-toggle="modal" data-bs-target="#jadwalDamping<?= $reject['laporan']['id_laporan_damping']; ?>" ?>
                                                                Detail
                                                            </button>

                                                            <button type="button" class="btn btn-primary btn-sm editJadwal" data-bs-toggle="modal" data-bs-target="#profile<?= $reject['laporan']['id_laporan_damping']; ?>" ?>
                                                                Profile
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <?php $i++; ?>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($hasil_laporan)) : ?>
    <?php foreach ($hasil_laporan as $hla) : ?>

        <!-- Modal Profile-->
        <div class="modal fade" id="profile<?= $hla['laporan']['id_laporan_damping']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: blueviolet">
                        <h5 class="modal-title text-white" id="exampleModalLabel">Detail Profile</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Form -->
                    <div class="modal-body" style="background-color: white;">

                        <div class="container">
                            <h4 class="text-center">Mahasiswa Difabel</h4>
                            <div class="row mt-5">
                                <div class="col-md-6 mb-2">
                                    <label for="nama_madif" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama_madif" placeholder='<?= $hla['biodata']['biodata_madif']['fullname']; ?>' readonly>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="jenis_kelamin_madif" class="form-label">Jenis Kelamin</label>
                                    <input type="text" class="form-control" id="jenis_kelamin_madif" placeholder='<?= ($hla['biodata']['biodata_madif']['jenis_kelamin'] == 1) ? 'Laki-laki' : 'Perempuan'; ?>' readonly>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="fakultas_madif" class="form-label">Fakultas</label>
                                    <input type="text" class="form-control" id="fakultas_madif" placeholder='<?= $hla['biodata']['biodata_madif']['fakultas']; ?>' readonly>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="jurusan_madif" class="form-label">Jurusan</label>
                                    <input type="text" class="form-control" id="jurusan_madif" placeholder='<?= $hla['biodata']['biodata_madif']['jurusan'] ?>' readonly>
                                </div>
                                <label for="nomor_madif" class="col-sm-auto col-form-label">Nomor HP</label>

                                <div class="col-sm-auto">
                                    <input type="text" class="form-control-plaintext" id="nomor_madif" value='<?= $hla['biodata']['biodata_madif']['nomor_hp'] ?>'>
                                </div>
                            </div>

                        </div>

                        <hr>
                        <div class="container">
                            <h4 class="text-center">Pendamping</h4>
                            <div class="row mt-5">
                                <div class="col-md-6 mb-2">
                                    <label for="nama_pendamping" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama_pendamping" placeholder='<?= $hla['biodata']['biodata_pendamping']['fullname']; ?>' readonly>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="jenis_kelamin_pendamping" class="form-label">Jenis Kelamin</label>
                                    <input type="text" class="form-control" id="jenis_kelamin_pendamping" placeholder='<?= ($hla['biodata']['biodata_pendamping']['jenis_kelamin'] == 1) ? 'Laki-laki' : 'Perempuan'; ?>' readonly>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="fakultas_pendamping" class="form-label">Fakultas</label>
                                    <input type="text" class="form-control" id="fakultas_pendamping" placeholder='<?= $hla['biodata']['biodata_pendamping']['fakultas']; ?>' readonly>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="jurusan_pendamping" class="form-label">Jurusan</label>
                                    <input type="text" class="form-control" id="jurusan_pendamping" placeholder='<?= $hla['biodata']['biodata_pendamping']['jurusan'] ?>' readonly>
                                </div>
                                <label for="nomor_pendamping" class="col-sm-auto col-form-label">Nomor HP</label>

                                <div class="col-sm-auto">
                                    <input type="text" class="form-control-plaintext" id="nomor_pendamping" value='<?= $hla['biodata']['biodata_pendamping']['nomor_hp'] ?>'>
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

        <!-- Modal Jadwal Ujian -->
        <div class="modal fade" id="jadwalDamping<?= $hla['laporan']['id_laporan_damping']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: orange">
                        <h5 class="modal-title fw-bold" id="exampleModalLabel">Detail Jadwal Ujian</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="card shadow p-3 mb-5 bg-body rounded">
                            <div class="card-header text-center fw-bold">
                                <?= $hla['jadwal_ujian']['mata_kuliah']; ?>
                            </div>
                            <div class="card-body">
                                <!-- Tanggal Ujian -->
                                <div class="row">
                                    <label for="tanggal_ujian" class="col-sm-4 col-form-label">Tanggal Ujian</label>
                                    <div class="col-sm-8">
                                        <input type="text" readonly class="form-control-plaintext" id="tanggal_ujian" value="<?= date('d, M Y', strtotime($hla['jadwal_ujian']['tanggal_ujian'])); ?>">
                                    </div>
                                </div>

                                <!-- Jam Ujian -->
                                <div class="row">
                                    <label for="staticEmail" class="col-sm-4 col-form-label">Jam Ujian</label>
                                    <div class="col-sm-8">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= date('H:i', strtotime($hla['jadwal_ujian']['waktu_mulai_ujian'])); ?> - <?= date('H:i', strtotime($hla['jadwal_ujian']['waktu_selesai_ujian'])); ?>">
                                    </div>
                                </div>

                                <!-- Ruangan -->
                                <div class="row">
                                    <label for="staticEmail" class="col-sm-4 col-form-label">Ruangan</label>
                                    <div class="col-sm-8">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $hla['jadwal_ujian']['ruangan']; ?>">
                                    </div>
                                </div>

                                <!-- Keterangan -->
                                <div class="row">
                                    <label for="staticEmail" class="col-sm-4 col-form-label">Keterangan</label>
                                    <div class="col-sm-8">
                                        <button class="btn btn-primary btn-sm mt-1" data-bs-target="#keterangan<?= $hla['laporan']['id_laporan_damping']; ?>" data-bs-toggle="modal" data-bs-dismiss="modal">Keterangan</button>
                                    </div>
                                </div>

                                <!-- Laporan -->
                                <div class="row">
                                    <label for="staticEmail" class="col-sm-4 col-form-label">Laporan</label>
                                    <div class="col-sm-8 mt-1">
                                        <button class="btn btn-success btn-sm" data-bs-target="#laporan<?= $hla['laporan']['id_laporan_damping']; ?>" data-bs-toggle="modal" data-bs-dismiss="modal">Detail</button>
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

        <!-- Modal Keterangan-->
        <div class="modal fade" id="keterangan<?= $hla['laporan']['id_laporan_damping']; ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: rgba(34, 84, 145, 1);">
                        <h5 class="modal-title text-white" id="exampleModalToggleLabel2">Keterangan Pendampingan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="color: black">
                        <?= $hla['jadwal_ujian']['keterangan']; ?>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" data-bs-target="#jadwalDamping<?= $hla['laporan']['id_laporan_damping']; ?>" data-bs-toggle="modal" data-bs-dismiss="modal">Kembali</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Laporan -->
        <div class="modal fade" id="laporan<?= $hla['laporan']['id_laporan_damping']; ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: rgba(12, 124, 79, 1);">
                        <h5 class="modal-title text-white fw-bold" id="exampleModalToggleLabel2">Laporan Pendampingan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body" style="color: black">

                        <!-- Waktu Presensi -->
                        <div class="row mt-0 mb-2 g-3 align-items-center justify-content-center text-center">
                            <label for="" class="form-label mt-0 mb-2 fw-bold">Waktu Presensi <span style="color: red;" class="fs-6"><?= ($hla['laporan']['presensi']['tepat_waktu'] == 0) ? '*Terlambat' : ''; ?></span></label>
                            <div class="col-3 mt-0">
                                <input type="text" class="form-control" placeholder="kehadiran" value="<?= date('H:i', strtotime($hla['laporan']['presensi']['waktu_hadir'])); ?>" aria-label="First name" disabled>
                            </div>
                            -
                            <div class="col-3 mt-0">
                                <input type="text" class="form-control" placeholder="selesai" value="<?= date('H:i', strtotime($hla['laporan']['presensi']['waktu_selesai'])); ?>" aria-label="Last name" disabled>
                            </div>
                        </div>

                        <hr>

                        <!-- Rating Madif -->
                        <label for="disabledRange" class="form-label">Rating Mahasiswa Difabel</label>
                        <input type="range" class="form-range" id="disabledRange" min="0" max="5" value="<?= $hla['laporan']['madif_rating']; ?>" disabled>

                        <!-- Rating Pendamping-->
                        <label for="disabledRange" class="form-label">Rating Pendamping</label>
                        <input type="range" class="form-range" id="disabledRange" min="0" max="5" value="<?= $hla['laporan']['pendamping_rating']; ?>" disabled>

                        <!-- Evaluasi Madif -->
                        <div class="form-floating mb-2">
                            <textarea class="form-control" placeholder="Leave a comment here" id="evaluasi_pendampingan" style="height: 100px" name="review_pendampingan" disabled><?= $hla['laporan']['madif_review']; ?></textarea>
                            <label for="evaluasi_pendampingan" class="text-muted">Evaluasi Madif</label>
                        </div>

                        <!-- Evaluasi Pendamping -->
                        <div class="form-floating mb-2">
                            <textarea class="form-control" placeholder="Leave a comment here" id="evaluasi_pendampingan" style="height: 100px" name="review_pendampingan" disabled><?= $hla['laporan']['pendamping_review']; ?></textarea>
                            <label for="evaluasi_pendampingan" class="text-muted">Evaluasi Pendamping</label>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-sm" data-bs-target="#jadwalDamping<?= $hla['laporan']['id_laporan_damping']; ?>" data-bs-toggle="modal" data-bs-dismiss="modal">Kembali</button>
                    </div>
                </div>
            </div>
        </div>

    <?php endforeach; ?>
<?php endif; ?>

<?= $this->endSection(); ?>