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

                    <!-- Basic table -->
                    <div class="table-responsive">
                        <table class="table table-hover table-dark" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                            <thead>

                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Tanggal Ujian</th>
                                    <th scope="col">Mata Kuliah</th>
                                    <?php if ($profile_mhs['madif'] == 1) : ?>
                                        <th scope="col">Pendamping</th>
                                    <?php else : ?>
                                        <th scope="col">Mahasiswa Difabel</th>
                                        <th scope="col">Jenis Difabel</th>
                                    <?php endif; ?>
                                    <th scope="col">Status</th>
                                    <th scope="col">Aksi</th>
                                </tr>

                            </thead>
                            <tbody class="table-light">

                                <?php if (!empty($data)) : ?>
                                    <?php $i = 1 ?>
                                    <?php foreach ($hasil_jadwal_damping as $hjd) : ?>
                                        <tr class="align-middle" style="color:<?= (empty($hjd['biodata_pendamping'])) ? 'grey' : '' ?>">

                                            <input type="hidden" name="id_damping" value="<?= $hjd['id_damping']; ?>">

                                            <th scope="row"><?= $i; ?></th>
                                            <td><?= date('d, M Y', strtotime($hjd['jadwal_ujian']['tanggal_ujian'])); ?></td>
                                            <td><?= $hjd['jadwal_ujian']['mata_kuliah']; ?></td>

                                            <?php if ($profile_mhs['madif'] == 1) : ?>

                                                <?php if (!empty($hjd['biodata_pendamping'])) : ?>
                                                    <td><?= $hjd['biodata_pendamping']['nickname']; ?></td>
                                                <?php else : ?>
                                                    <td>-</td>
                                                <?php endif; ?>

                                            <?php else : ?>
                                                <td><?= $hjd['biodata_madif']['nickname']; ?></td>
                                                <td><?= $hjd['biodata_madif']['jenis_madif']; ?></td>
                                            <?php endif; ?>

                                            <!-- Status -->
                                            <?php if ($profile_mhs['madif'] == 1) : ?>

                                                <!-- Jika Ada Pendamping -->
                                                <?php if (!empty($hjd['biodata_pendamping'])) : ?>

                                                    <?php if (empty($hjd['status_damping'])) : ?>
                                                        <td style="color: rgba(237, 136, 0, 1);">
                                                            Menunggu Konfirmasi Pendamping
                                                        </td>
                                                    <?php elseif ($hjd['status_damping'] == 'presensi_hadir') : ?>
                                                        <td style="color: green;">
                                                            Menunggu Presensi
                                                        </td>
                                                    <?php elseif ($hjd['status_damping'] == 'konfirmasi_presensi_hadir') : ?>
                                                        <td style="color:red">
                                                            Lakukan Konfirmasi Presensi
                                                        </td>
                                                    <?php elseif ($hjd['status_damping'] == 'damping_selesai') : ?>
                                                        <td style="color:blue">
                                                            Lakukan Konfirmasi Presensi Jika<br>Pendampingan Telah Selesai
                                                        </td>
                                                    <?php elseif ($hjd['status_damping'] == 'laporan') : ?>
                                                        <td style="color: red;">
                                                            Lakukan Pengisian Review Pendampingan
                                                        </td>
                                                    <?php elseif ($hjd['status_damping'] == 'madif_review') : ?>
                                                        <td style="color: red;">
                                                            Lakukan Pengisian Review Pendampingan
                                                        </td>
                                                    <?php elseif ($hjd['status_damping'] == 'pendamping_review') : ?>
                                                        <td style="color: green;">
                                                            Menunggu Laporan Review dari Pendamping
                                                        </td>
                                                    <?php elseif ($hjd['status_damping'] == 'selesai') : ?>
                                                        <td style="color: green;">
                                                            Pendampingan Selesai
                                                        </td>
                                                    <?php endif; ?>


                                                    <!-- Jika Tidak Ada Pendamping -->
                                                <?php else : ?>
                                                    <td>
                                                        Tidak Ada Pendamping
                                                    </td>
                                                <?php endif; ?>

                                            <?php else : ?>

                                                <!-- Red: Ada task, green: menunggu task atau selesai -->
                                                <?php if (empty($hjd['status_damping'])) : ?>
                                                    <td style="color: <?= (empty($hjd['status_damping'])) ? 'red' : '' ?>;">
                                                        <a href="<?= base_url('konfirmasiDamping'); ?>/<?= $hjd['id_damping']; ?>" class="btn btn-success btn-sm">Confirm</a>
                                                        <a href="<?= base_url('IzinTidakDamping'); ?>/<?= $hjd['id_damping']; ?>" class="btn btn-danger btn-sm">Izin</a>
                                                    </td>
                                                <?php elseif ($hjd['status_damping'] == 'presensi_hadir') : ?>
                                                    <td style="color:red">
                                                        Lakukan Presensi Kehadiran
                                                    </td>
                                                <?php elseif ($hjd['status_damping'] == 'konfirmasi_presensi_hadir') : ?>
                                                    <td style="color: green;">
                                                        Menunggu Konfirmasi Presensi
                                                    </td>
                                                <?php elseif ($hjd['status_damping'] == 'damping_selesai') : ?>
                                                    <td style="color: blue;">
                                                        Lakukan Konfirmasi Presensi Jika<br>Pendampingan Telah Selesai
                                                    </td>
                                                <?php elseif ($hjd['status_damping'] == 'laporan') : ?>
                                                    <td style="color: red;">
                                                        Lakukan Pengisian Review Pendampingan
                                                    </td>
                                                <?php elseif ($hjd['status_damping'] == 'pendamping_review') : ?>
                                                    <td style="color: red;">
                                                        Lakukan Pengisian Review Pendampingan
                                                    </td>
                                                <?php elseif ($hjd['status_damping'] == 'madif_review') : ?>
                                                    <td style="color: green;">
                                                        Menunggu Laporan Review dari Madif
                                                    </td>
                                                <?php elseif ($hjd['status_damping'] == 'selesai') : ?>
                                                    <td style="color: green;">
                                                        Pendampingan Selesai
                                                    </td>
                                                <?php endif; ?>

                                            <?php endif; ?>

                                            <td>
                                                <button type="button" class="btn btn-warning btn-sm editJadwal my-1" data-bs-toggle="modal" data-bs-target="#jadwalDamping<?= $hjd['id_damping']; ?>" ?>
                                                    Detail
                                                </button>

                                                <?php if (!empty($hjd['biodata_pendamping'])) : ?>
                                                    <button type="button" class="btn btn-primary btn-sm editJadwal" data-bs-toggle="modal" data-bs-target="#profilePendamping<?= $hjd['biodata_pendamping']['id_profile_mhs']; ?>" ?>
                                                        Profile
                                                    </button>
                                                <?php endif; ?>
                                            </td>

                                        </tr>
                                        <?php $i++; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($data)) : ?>
    <?php foreach ($hasil_jadwal_damping as $modalhjd) : ?>

        <!-- Modal Profile -->
        <?php if ($profile_mhs['madif'] == 1) : ?>
            <?php if ($modalhjd['biodata_pendamping']) : ?>
                <!-- Modal Profile Pendamping-->
                <div class="modal fade" id="profilePendamping<?= $modalhjd['biodata_pendamping']['id_profile_mhs']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: blueviolet">
                                <h5 class="modal-title text-white" id="exampleModalLabel">Profile Pendamping <?= $modalhjd['biodata_pendamping']['nickname']; ?></h5>
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
                                            <input type="text" readonly class="my-0 form-control-plaintext text-center" id="nim" value="<?= $modalhjd['biodata_pendamping']['nim']; ?>" style="color:darkslategray">
                                        </div>
                                    </div>

                                    <div class="shadow p-3 mb-5 rounded-2 my-0" style="background-color: rgba(241, 241, 230, 0.8);">
                                        <!--NIM-->
                                        <div class="row mb-2">
                                            <div class="col-sm-6">
                                                <label for="nama" class="form-label mb-0 ">Nama</label>
                                                <input type="text" readonly class="form-control-plaintext text-center" id="nama" value="<?= $modalhjd['biodata_pendamping']['fullname']; ?>">
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="nama" class="form-label mb-0 ">Jenis Kelamin</label>
                                                <input type="text" readonly class="form-control-plaintext text-center" id="nama" value="<?= ($modalhjd['biodata_pendamping']['jenis_kelamin'] == 1) ? 'Laki-laki' : 'Perempuan'; ?>">
                                            </div>
                                        </div>
                                        <!--Jenis Kelamin-->
                                        <div class="row mb-2">
                                            <div class="col-sm-6">
                                                <label for="fakultas" class="form-label mb-0 ">Fakultas</label>
                                                <input type="text" readonly class="form-control-plaintext text-center" id="fakultas" value="<?= $modalhjd['biodata_pendamping']['fakultas']; ?>">
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="semester" class="form-label mb-0 ">Semester</label>
                                                <input type="text" readonly class="form-control-plaintext text-center" id="semester" value="<?= $modalhjd['biodata_pendamping']['semester']; ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <!--Semester-->
                                    <div class="row mb-2" style="background-color: inherit;">
                                        <div class="col-sm-12 text-center">
                                            <label for="contact" class="form-label mb-0 fw-bold">Contact</label>
                                            <input type="text" readonly class="my-0 form-control-plaintext text-center" id="contact" value="<?= $modalhjd['biodata_pendamping']['nomor_hp']; ?>" style="color:darkslategray">
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
        <?php else : ?>
            <!-- Modal Profile Pendamping-->
            <div class="modal fade" id="profilePendamping<?= $modalhjd['biodata_pendamping']['id_profile_mhs']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: blueviolet">
                            <h5 class="modal-title text-white" id="exampleModalLabel">Generate Jadwal Pendampingan Ujian</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <!-- Form -->
                        <form action="<?= base_url('c_damping_ujian/generate'); ?>" method="POST">
                            <div class="modal-body">
                                <?= csrf_field(); ?>

                                <!--Jenis Ujian-->
                                <div class="row mb-3">
                                    <label for="jenis_ujian" class="col-sm-6 col-form-label">Jenis Ujian</label>
                                    <div class="col-sm-6">
                                        <select class="form-select" aria-label="Default select example" name="jenis_ujian" id="jenis_ujian" autofocus required>
                                            <option value='null' selected>Jenis Ujian</option>
                                            <option value='UTS'>UTS</option>
                                            <option value='UAS'>UAS</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <!-- Submit button -->
                            <div class="modal-footer">
                                <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success">
                                    Generate
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Modal Jadwal Ujian -->
        <div class="modal fade" id="jadwalDamping<?= $modalhjd['id_damping']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: orange">
                        <h5 class="modal-title fw-bold" id="exampleModalLabel">Detail Jadwal Ujian</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">

                        <div class="card shadow p-3 mb-5 bg-body rounded">
                            <div class="card-header text-center fw-bold">
                                <?= $modalhjd['jadwal_ujian']['mata_kuliah']; ?>
                            </div>
                            <div class="card-body">
                                <!--  start hidden jadwal id -->
                                <input type="hidden" name="id_jadwal_ujian" value="<?= $modalhjd['jadwal_ujian']['id_jadwal_ujian']; ?>">
                                <!-- end hidden jadwal id -->

                                <!-- Tanggal Ujian -->
                                <div class="row">
                                    <label for="tanggal_ujian" class="col-sm-4 col-form-label">Tanggal Ujian</label>
                                    <div class="col-sm-8">
                                        <input type="text" readonly class="form-control-plaintext" id="tanggal_ujian" value="<?= date('d, M Y', strtotime($modalhjd['jadwal_ujian']['tanggal_ujian'])); ?>">
                                    </div>
                                </div>

                                <!-- Jam Ujian -->
                                <div class="row">
                                    <label for="staticEmail" class="col-sm-4 col-form-label">Jam Ujian</label>
                                    <div class="col-sm-8">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= date('H:i', strtotime($modalhjd['jadwal_ujian']['waktu_mulai_ujian'])); ?> - <?= date('H:i', strtotime($modalhjd['jadwal_ujian']['waktu_selesai_ujian'])); ?>">
                                    </div>
                                </div>

                                <!-- Ruangan -->
                                <div class="row">
                                    <label for="staticEmail" class="col-sm-4 col-form-label">Ruangan</label>
                                    <div class="col-sm-8">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $modalhjd['jadwal_ujian']['ruangan']; ?>">
                                    </div>
                                </div>

                                <!-- Keterangan -->
                                <div class="row">
                                    <label for="staticEmail" class="col-sm-4 col-form-label">Keterangan</label>
                                    <div class="col-sm-8">
                                        <button class="btn btn-primary btn-sm mt-1" data-bs-target="#keterangan<?= $modalhjd['id_damping']; ?>" data-bs-toggle="modal" data-bs-dismiss="modal">Keterangan</button>
                                    </div>
                                </div>

                                <!-- Presensi -->
                                <div class="row">
                                    <label for="staticEmail" class="col-sm-4 col-form-label">Presensi</label>

                                    <?php if ($profile_mhs['madif'] == 1) : ?>
                                        <!-- Madif -->
                                        <?php if (empty($modalhjd['status_damping'])) : ?>
                                            <div class="col-sm-8 mt-2">
                                                -
                                            </div>
                                        <?php elseif ($modalhjd['status_damping'] == 'presensi_hadir') : ?>
                                            <div class="col-sm-8">
                                                <button class="btn btn-secondary btn-sm mt-1" disabled>Proses...</button>
                                            </div>
                                        <?php elseif ($modalhjd['status_damping'] == 'konfirmasi_presensi_hadir') : ?>
                                            <div class="col-sm-8 mt-1">
                                                <a href="<?= base_url('konfirmasiDamping'); ?>/<?= $modalhjd['id_damping']; ?>" class="btn btn-success btn-sm">Confirm</a>
                                                <a href="<?= base_url('IzinTidakDamping'); ?>/<?= $modalhjd['id_damping']; ?>" class="btn btn-danger btn-sm">Reject</a>
                                            </div>
                                        <?php elseif ($modalhjd['status_damping'] == 'damping_selesai') : ?>
                                            <div class="col-sm-8 mt-1">
                                                <a href="<?= base_url('konfirmasiDamping'); ?>/<?= $modalhjd['id_damping']; ?>" class="btn btn-success btn-sm">Pendampingan Selesai</a>
                                            </div>
                                        <?php else : ?>
                                            <div class="col-sm-8 mt-2">
                                                <i class="far fa-check-square"></i>
                                            </div>
                                        <?php endif; ?>
                                    <?php else : ?>
                                        <!-- Pendamping -->
                                        <?php if (empty($modalhjd['status_damping'])) : ?>
                                            <div class="col-sm-8 mt-2">
                                                -
                                            </div>
                                        <?php elseif ($modalhjd['status_damping'] == 'presensi_hadir') : ?>
                                            <div class="col-sm-8">
                                                <button class="btn btn-success btn-sm mt-1" data-bs-target="#keterangan<?= $modalhjd['id_damping']; ?>" data-bs-toggle="modal" data-bs-dismiss="modal">Presensi Hadir</button>
                                            </div>
                                        <?php elseif ($modalhjd['status_damping'] == 'konfirmasi_presensi_hadir') : ?>
                                            <div class="col-sm-8">
                                                <button class="btn btn-secondary btn-sm mt-1" disabled>Proses...</button>
                                            </div>
                                        <?php elseif ($modalhjd['status_damping'] == 'damping_selesai') : ?>
                                            <div class="col-sm-8">
                                                <button class="btn btn-primary btn-sm mt-1" data-bs-target="#keterangan<?= $modalhjd['id_damping']; ?>" data-bs-toggle="modal" data-bs-dismiss="modal">Pendampingan Selesai</button>
                                            </div>
                                        <?php else : ?>
                                            <div class="col-sm-8 mt-2">
                                                <i class="far fa-check-square"></i>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>

                                <!-- Laporan -->
                                <div class="row">
                                    <label for="staticEmail" class="col-sm-4 col-form-label">Laporan</label>
                                    <?php if ($profile_mhs['madif'] == 1) : ?>
                                        <!-- Madif -->
                                        <?php if ($modalhjd['status_damping'] == 'laporan') : ?>
                                            <div class="col-sm-8">
                                                <button class="btn btn-success btn-sm mt-1" data-bs-target="#keterangan<?= $modalhjd['id_damping']; ?>" data-bs-toggle="modal" data-bs-dismiss="modal">Isi Laporan</button>
                                            </div>
                                        <?php elseif ($modalhjd['status_damping'] == 'madif_review') : ?>
                                            <div class="col-sm-8">
                                                <button class="btn btn-success btn-sm mt-1" data-bs-target="#keterangan<?= $modalhjd['id_damping']; ?>" data-bs-toggle="modal" data-bs-dismiss="modal">Isi Laporan</button>
                                            </div>
                                        <?php elseif ($modalhjd['status_damping'] == 'pendamping_review') : ?>
                                            <div class="col-sm-8">
                                                <button class="btn btn-secondary btn-sm mt-1" disabled>Proses...</button>
                                            </div>
                                        <?php elseif ($modalhjd['status_damping'] == 'selesai') : ?>
                                            <td>
                                                <div class="col-sm-8">
                                                    <button class="btn btn-success btn-sm mt-1" disabled>Selesai</button>
                                                </div>
                                            </td>
                                        <?php else : ?>
                                            <div class="col-sm-8 mt-2">
                                                -
                                            </div>
                                        <?php endif; ?>

                                    <?php else : ?>
                                        <!-- Pendamping -->
                                        <?php if ($modalhjd['status_damping'] == 'laporan') : ?>
                                            <div class="col-sm-8">
                                                <button class="btn btn-success btn-sm mt-1" data-bs-target="#keterangan<?= $modalhjd['id_damping']; ?>" data-bs-toggle="modal" data-bs-dismiss="modal">Isi Laporan</button>
                                            </div>
                                        <?php elseif ($modalhjd['status_damping'] == 'pendamping_review') : ?>
                                            <div class="col-sm-8">
                                                <button class="btn btn-success btn-sm mt-1" data-bs-target="#keterangan<?= $modalhjd['id_damping']; ?>" data-bs-toggle="modal" data-bs-dismiss="modal">Isi Laporan</button>
                                            </div>
                                        <?php elseif ($modalhjd['status_damping'] == 'madif_review') : ?>
                                            <div class="col-sm-8">
                                                <button class="btn btn-secondary btn-sm mt-1" disabled>Proses...</button>
                                            </div>
                                        <?php elseif ($modalhjd['status_damping'] == 'selesai') : ?>
                                            <td>
                                                <div class="col-sm-8">
                                                    <button class="btn btn-success btn-sm mt-1" disabled>Selesai</button>
                                                </div>
                                            </td>
                                        <?php else : ?>
                                            <div class="col-sm-8 mt-2">
                                                -
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
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

        <!-- Modal Keterangan -->
        <div class="modal fade" id="keterangan<?= $modalhjd['id_damping']; ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: rgba(34, 84, 145, 1);">
                        <h5 class="modal-title text-white" id="exampleModalToggleLabel2">Keterangan Pendampingan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="color: black">
                        <?= $modalhjd['jadwal_ujian']['keterangan']; ?>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" data-bs-target="#jadwalDamping<?= $modalhjd['id_damping']; ?>" data-bs-toggle="modal" data-bs-dismiss="modal">Kembali</button>
                    </div>
                </div>
            </div>
        </div>

    <?php endforeach; ?>

<?php endif; ?>

<?= $this->endSection(); ?>