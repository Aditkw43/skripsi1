<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<!--     
    Isi Status:
    1)Tidak ada pendamping
    2)Menunggu konfirmasi pendampingan
    3)Melakukan konfirmasi oleh pendamping
    4)Menunggu presensi kehadiran pendamping
    5)Melakukan presensi oleh pendamping
    6)Menunggu konfirmasi presensi
    7)Melakukan konfirmasi presensi oleh madif
    8)Menunggu konfirmasi pendampingan selesai oleh madif maupun pendamping
    9)Melakukan konfirmasi pendampingan selesai
    10)Melakukan pengisian review/evaluasi pendampingan
    11)Menunggu pengisian review dari madif/pendamping
    12)Jika review pendampingan sudah terkirim dari madif dan pendamping, maka status menjadi pendampingan selesai

    Status:
    a. empty, tidak ada pendamping (List Tidak Didampingi)
    b. null, konfirmasi_pendampingan (Konfirmasi Pendampingan)
    c. presensi_hadir, Presensi pendamping (Presensi)
    d. konfirmasi_presensi_hadir, Konfirmasi presensi (Presensi)
    e. damping_selesai (Presensi)
    f. laporan (Evaluasi)
    g. madif_review/pendamping_review (Evaluasi)
    h. pendamping_review/madif_review (Evaluasi)
    i. selesai, Pendampingan Selesai (Laporan)

    Indikator warna:
    a. Kuning: Menunggu Konfirmasi Pendampingan
    b. Merah: Harus Melakukan sesuatu
    c. Hijau: Menunggu Konfirmasi dari pendamping/madif
    d. Biru: Konfirmasi jika pendampingan telah selesai
-->

<div class="container-fluid px-6 py-4">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="row mb-6">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="mb-2 mt-2" style="display: flex; justify-content: space-between; align-items:center">
                        <h2><?= $title; ?></h2>
                    </div>

                    <!-- Tab content -->
                    <div class=" tab-content p-4" id="pills-tabContent-table">

                        <!-- Konfirmasi Damping Table -->
                        <div class="tab-pane tab-example-design fade show active" id="pills-table-konfirmasi-damping" role="tabpanel" aria-labelledby="pills-table-konfirmasi-damping-tab">
                            <div class="table-responsive">
                                <table class="table table-hover table-dark" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                                    <thead>

                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Tanggal Ujian</th>
                                            <?php if ($profile_mhs['madif'] == 1) : ?>
                                                <th scope="col">Pendamping</th>
                                            <?php else : ?>
                                                <th scope="col">Mahasiswa Difabel</th>
                                            <?php endif; ?>
                                            <th scope="col">Mata Kuliah</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Detail</th>
                                        </tr>

                                    </thead>
                                    <tbody class="table-light">

                                        <?php if (!empty($hasil_laporan)) : ?>
                                            <?php $i = 1 ?>
                                            <?php foreach ($hasil_laporan as $hl) : ?>
                                                <tr class="align-middle">

                                                    <!-- Id Laporan Damping -->
                                                    <input type="hidden" name="id_damping" value="<?= $hl['laporan']['id_laporan_damping']; ?>">

                                                    <!-- Nomor -->
                                                    <th scope="row"><?= $i; ?></th>

                                                    <!-- Tanggal Ujian -->
                                                    <td><?= date('d, M Y', strtotime($hl['jadwal_ujian']['tanggal_ujian'])); ?></td>

                                                    <!-- Nama Madif/Pendamping -->
                                                    <?php if (isset($profile_mhs['madif'])) : ?>
                                                        <td><?= $hl['biodata']['biodata_pendamping']['nickname']; ?></td>
                                                    <?php else : ?>
                                                        <td><?= $hl['biodata']['biodata_madif']['nickname']; ?></td>
                                                    <?php endif; ?>

                                                    <!-- Mata Kuliah -->
                                                    <td><?= $hl['jadwal_ujian']['mata_kuliah']; ?></td>

                                                    <!-- Status -->
                                                    <?php if (!isset($hl['laporan']['approval'])) : ?>
                                                        <td style="color:rgba(237, 136, 0, 1)">
                                                            Menunggu konfirmasi admin
                                                        </td>
                                                    <?php else : ?>
                                                        <td style="color: green;">
                                                            Terkonfirmasi
                                                        </td>
                                                    <?php endif; ?>

                                                    <!-- Aksi -->
                                                    <td>
                                                        <button type="button" class="btn btn-warning btn-sm my-1" data-bs-toggle="modal" data-bs-target="#detail<?= $hl['laporan']['id_laporan_damping']; ?>" ?>
                                                            Detail
                                                        </button>

                                                        <?php if (isset($profile_mhs['madif'])) : ?>
                                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#profilePendamping<?= $hl['biodata']['biodata_pendamping']['id_profile_mhs']; ?>" ?>
                                                                Profile
                                                            </button>
                                                        <?php else : ?>
                                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#profileMadif<?= $hl['biodata']['biodata_madif']['id_profile_mhs']; ?>" ?>
                                                                Profile
                                                            </button>
                                                        <?php endif; ?>


                                                    </td>

                                                </tr>
                                                <?php $i++; ?>
                                            <?php endforeach; ?>
                                        <?php else: ?>
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

<?php if (!empty($hasil_laporan)) : ?>

    <?php foreach ($hasil_laporan as $modalhl) : ?>

        <!-- Modal Profile -->
        <?php if ($profile_mhs['madif'] == 1) : ?>
            <!-- Modal Profile Pendamping-->
            <div class="modal fade" id="profilePendamping<?= $modalhl['biodata']['biodata_pendamping']['id_profile_mhs']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: blueviolet">
                            <h5 class="modal-title text-white" id="exampleModalLabel">Profile Pendamping <?= $modalhl['biodata']['biodata_pendamping']['nickname']; ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <!-- Form -->
                        <form action="<?= base_url('c_damping_ujian/generate'); ?>" method="POST">
                            <div class="modal-body text-center" style="background-color: white;">
                                <?= csrf_field(); ?>

                                <!--NIM-->
                                <div class="row mb-2" style="background-color: inherit;">
                                    <div class="col-sm-12 text-center">
                                        <label for="nim" class="form-label mb-0 fw-bold">NIM</label>
                                        <input type="text" readonly class="my-0 form-control-plaintext text-center" id="nim" value="<?= $modalhl['biodata']['biodata_pendamping']['nim']; ?>" style="color:darkslategray">
                                    </div>
                                </div>

                                <div class="shadow p-3 mb-5 rounded-2 my-0" style="background-color: rgba(241, 241, 230, 0.8);">
                                    <!--NIM-->
                                    <div class="row mb-2">
                                        <div class="col-sm-6">
                                            <label for="nama" class="form-label mb-0 ">Nama</label>
                                            <input type="text" readonly class="form-control-plaintext text-center" id="nama" value="<?= $modalhl['biodata']['biodata_pendamping']['fullname']; ?>">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="nama" class="form-label mb-0 ">Jenis Kelamin</label>
                                            <input type="text" readonly class="form-control-plaintext text-center" id="nama" value="<?= ($modalhl['biodata']['biodata_pendamping']['jenis_kelamin'] == 1) ? 'Laki-laki' : 'Perempuan'; ?>">
                                        </div>
                                    </div>
                                    <!--Jenis Kelamin-->
                                    <div class="row mb-2">
                                        <div class="col-sm-6">
                                            <label for="fakultas" class="form-label mb-0 ">Fakultas</label>
                                            <input type="text" readonly class="form-control-plaintext text-center" id="fakultas" value="<?= $modalhl['biodata']['biodata_pendamping']['fakultas']; ?>">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="semester" class="form-label mb-0 ">Semester</label>
                                            <input type="text" readonly class="form-control-plaintext text-center" id="semester" value="<?= $modalhl['biodata']['biodata_pendamping']['semester']; ?>">
                                        </div>
                                    </div>
                                </div>

                                <!--Semester-->
                                <div class="row mb-2" style="background-color: inherit;">
                                    <div class="col-sm-12 text-center">
                                        <label for="contact" class="form-label mb-0 fw-bold">Contact</label>
                                        <input type="text" readonly class="my-0 form-control-plaintext text-center" id="contact" value="<?= $modalhl['biodata']['biodata_pendamping']['nomor_hp']; ?>" style="color:darkslategray">
                                    </div>
                                </div>

                            </div>
                            <!-- Submit button -->
                            <div class="modal-footer d-flex justify-content-between">
                                <!--Contact-->
                                <a href="#" class="btn btn-primary">Lihat Profile</a>
                                <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <!-- Modal Profile Madif-->
            <div class="modal fade" id="profileMadif<?= $modalhl['biodata']['biodata_madif']['id_profile_mhs']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: blueviolet">
                            <h5 class="modal-title text-white" id="exampleModalLabel">Profile Madif <?= $modalhl['biodata']['biodata_madif']['nickname']; ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <!-- Form -->
                        <form action="<?= base_url('c_damping_ujian/generate'); ?>" method="POST">
                            <div class="modal-body text-center" style="background-color: white;">
                                <?= csrf_field(); ?>

                                <!--NIM-->
                                <div class="row mb-2" style="background-color: inherit;">
                                    <div class="col-6 text-center">
                                        <label for="nim" class="form-label mb-0 fw-bold">NIM</label>
                                        <input type="text" readonly class="my-0 form-control-plaintext text-center" id="nim" value="<?= $modalhl['biodata']['biodata_madif']['nim']; ?>" style="color:darkslategray">
                                    </div>
                                    <div class="col-6 text-center">
                                        <label for="nim" class="form-label mb-0 fw-bold">Jenis Difabel</label>
                                        <input type="text" readonly class="my-0 form-control-plaintext text-center" id="nim" value="<?= $modalhl['biodata']['biodata_madif']['jenis_madif']; ?>" style="color:darkslategray">
                                    </div>
                                </div>

                                <div class="shadow p-3 mb-5 rounded-2 my-0" style="background-color: rgba(241, 241, 230, 0.8);">
                                    <!--NIM-->
                                    <div class="row mb-2">
                                        <div class="col-sm-6">
                                            <label for="nama" class="form-label mb-0 ">Nama</label>
                                            <input type="text" readonly class="form-control-plaintext text-center" id="nama" value="<?= $modalhl['biodata']['biodata_madif']['fullname']; ?>">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="nama" class="form-label mb-0 ">Jenis Kelamin</label>
                                            <input type="text" readonly class="form-control-plaintext text-center" id="nama" value="<?= ($modalhl['biodata']['biodata_madif']['jenis_kelamin'] == 1) ? 'Laki-laki' : 'Perempuan'; ?>">
                                        </div>
                                    </div>
                                    <!--Jenis Kelamin-->
                                    <div class="row mb-2">
                                        <div class="col-sm-6">
                                            <label for="fakultas" class="form-label mb-0 ">Fakultas</label>
                                            <input type="text" readonly class="form-control-plaintext text-center" id="fakultas" value="<?= $modalhl['biodata']['biodata_madif']['fakultas']; ?>">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="semester" class="form-label mb-0 ">Semester</label>
                                            <input type="text" readonly class="form-control-plaintext text-center" id="semester" value="<?= $modalhl['biodata']['biodata_madif']['semester']; ?>">
                                        </div>
                                    </div>
                                </div>

                                <!--Semester-->
                                <div class="row mb-2" style="background-color: inherit;">
                                    <div class="col-sm-12 text-center">
                                        <label for="contact" class="form-label mb-0 fw-bold">Contact</label>
                                        <input type="text" readonly class="my-0 form-control-plaintext text-center" id="contact" value="<?= $modalhl['biodata']['biodata_madif']['nomor_hp']; ?>" style="color:darkslategray">
                                    </div>
                                </div>

                            </div>
                            <!-- Submit button -->
                            <div class="modal-footer d-flex justify-content-between">
                                <!--Contact-->
                                <a href="#" class="btn btn-primary">Lihat Profile</a>
                                <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Modal Detail Laporan Pendampingan -->
        <div class="modal fade" id="detail<?= $modalhl['laporan']['id_laporan_damping']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: orange">
                        <h5 class="modal-title fw-bold" id="exampleModalLabel">Laporan Pendampingan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">

                        <div class="card shadow p-3 mb-5 bg-body rounded">
                            <div class="card-header text-center fw-bold">
                                <?= $modalhl['jadwal_ujian']['mata_kuliah']; ?>
                            </div>
                            <div class="card-body">
                                <!--  start hidden jadwal id -->
                                <input type="hidden" name="id_jadwal_ujian" value="<?= $modalhl['laporan']['id_laporan_damping']; ?>">
                                <!-- end hidden jadwal id -->

                                <!-- Tanggal Ujian -->
                                <div class="row">
                                    <label for="tanggal_ujian" class="col-sm-4 col-form-label">Tanggal Ujian</label>
                                    <div class="col-sm-8">
                                        <input type="text" readonly class="form-control-plaintext" id="tanggal_ujian" value="<?= date('d, M Y', strtotime($modalhl['jadwal_ujian']['tanggal_ujian'])); ?>">
                                    </div>
                                </div>

                                <!-- Jam Ujian -->
                                <div class="row">
                                    <label for="staticEmail" class="col-sm-4 col-form-label">Jam Ujian</label>
                                    <div class="col-sm-8">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= date('H:i', strtotime($modalhl['jadwal_ujian']['waktu_mulai_ujian'])); ?> - <?= date('H:i', strtotime($modalhl['jadwal_ujian']['waktu_selesai_ujian'])); ?>">
                                    </div>
                                </div>

                                <!-- Ruangan -->
                                <div class="row">
                                    <label for="staticEmail" class="col-sm-4 col-form-label">Ruangan</label>
                                    <div class="col-sm-8">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $modalhl['jadwal_ujian']['ruangan']; ?>">
                                    </div>
                                </div>

                                <!-- Keterangan -->
                                <div class="row">
                                    <label for="staticEmail" class="col-sm-4 col-form-label">Keterangan</label>
                                    <div class="col-sm-8">
                                        <button class="btn btn-primary btn-sm mt-1" data-bs-target="#keterangan<?= $modalhl['laporan']['id_laporan_damping']; ?>" data-bs-toggle="modal" data-bs-dismiss="modal">Keterangan</button>
                                    </div>
                                </div>

                                <!-- Laporan -->
                                <div class="row">
                                    <label for="staticEmail" class="col-sm-4 col-form-label">Laporan</label>
                                    <div class="col-sm-8 mt-1">
                                        <button class="btn btn-success btn-sm" data-bs-target="#laporan<?= $modalhl['laporan']['id_laporan_damping']; ?>" data-bs-toggle="modal" data-bs-dismiss="modal">Detail</button>
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
        <div class="modal fade" id="keterangan<?= $modalhl['laporan']['id_laporan_damping']; ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: rgba(34, 84, 145, 1);">
                        <h5 class="modal-title text-white" id="exampleModalToggleLabel2">Keterangan Pendampingan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="color: black">
                        <?= $modalhl['jadwal_ujian']['keterangan']; ?>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" data-bs-target="#detail<?= $modalhl['laporan']['id_laporan_damping']; ?>" data-bs-toggle="modal" data-bs-dismiss="modal">Kembali</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Laporan -->
        <div class="modal fade" id="laporan<?= $modalhl['laporan']['id_laporan_damping']; ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: rgba(12, 124, 79, 1);">
                        <h5 class="modal-title text-white fw-bold" id="exampleModalToggleLabel2">Laporan Pendampingan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body" style="color: black">

                        <!-- Waktu Presensi -->
                        <div class="row mt-0 mb-2 g-3 align-items-center justify-content-center text-center">
                            <label for="" class="form-label mt-0 mb-2 fw-bold">Waktu Presensi <span style="color: red;" class="fs-6"><?= ($modalhl['laporan']['presensi']['tepat_waktu'] == 0) ? '*Terlambat' : ''; ?></span></label>
                            <div class="col-3 mt-0">
                                <input type="text" class="form-control" placeholder="kehadiran" value="<?= date('H:i', strtotime($modalhl['laporan']['presensi']['waktu_hadir'])); ?>" aria-label="First name" disabled>
                            </div>
                            -
                            <div class="col-3 mt-0">
                                <input type="text" class="form-control" placeholder="selesai" value="<?= date('H:i', strtotime($modalhl['laporan']['presensi']['waktu_selesai'])); ?>" aria-label="Last name" disabled>
                            </div>
                        </div>

                        <hr>

                        <!-- Rating Madif -->
                        <label for="disabledRange" class="form-label">Rating Mahasiswa Difabel</label>
                        <input type="range" class="form-range" id="disabledRange" min="0" max="5" value="<?= $modalhl['laporan']['madif_rating']; ?>" disabled>

                        <!-- Rating Pendamping-->
                        <label for="disabledRange" class="form-label">Rating Pendamping</label>
                        <input type="range" class="form-range" id="disabledRange" min="0" max="5" value="<?= $modalhl['laporan']['pendamping_rating']; ?>" disabled>

                        <!-- Evaluasi Madif -->
                        <div class="form-floating mb-2">
                            <textarea class="form-control" placeholder="Leave a comment here" id="evaluasi_pendampingan" style="height: 100px" name="review_pendampingan" disabled><?= $modalhl['laporan']['madif_review']; ?></textarea>
                            <label for="evaluasi_pendampingan" class="text-muted">Evaluasi Madif</label>
                        </div>

                        <!-- Evaluasi Pendamping -->
                        <div class="form-floating mb-2">
                            <textarea class="form-control" placeholder="Leave a comment here" id="evaluasi_pendampingan" style="height: 100px" name="review_pendampingan" disabled><?= $modalhl['laporan']['pendamping_review']; ?></textarea>
                            <label for="evaluasi_pendampingan" class="text-muted">Evaluasi Pendamping</label>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-sm" data-bs-target="#detail<?= $modalhl['laporan']['id_laporan_damping']; ?>" data-bs-toggle="modal" data-bs-dismiss="modal">Kembali</button>
                    </div>
                </div>
            </div>
        </div>

    <?php endforeach; ?>

<?php endif; ?>

<?= $this->endSection(); ?>