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

                    <!-- Tab content -->
                    <div class=" tab-content p-4" id="pills-tabContent-table">

                        <!-- Konfirmasi Damping Table -->
                        <div class="tab-pane tab-example-design fade show active" id="pills-table-konfirmasi-damping" role="tabpanel" aria-labelledby="pills-table-konfirmasi-damping-tab">
                            <div class="table-responsive">
                                <table class="table table-hover table-dark" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                                    <thead>

                                        <tr>
                                            <th scope="col">Konfirmasi</th>
                                            <th scope="col">Tanggal Ujian</th>
                                            <th scope="col">Mata Kuliah</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Aksi</th>
                                        </tr>

                                    </thead>
                                    <tbody class="table-light">

                                        <?php if (!empty($data)) : ?>
                                            <?php $i = 1 ?>
                                            <?php foreach ($hasil_jadwal_damping as $hjd) : ?>
                                                <?php if (empty($hjd['biodata_pendamping'])) : ?>

                                                    <tr class="align-middle" style="color:<?= (empty($hjd['biodata_pendamping'])) ? 'grey' : '' ?>">

                                                        <!-- Id Pendampingan -->
                                                        <input type="hidden" name="id_damping" value="<?= $hjd['id_damping']; ?>">

                                                        <!-- Nomor -->
                                                        <th scope="row"><?= $i; ?></th>

                                                        <!-- Tanggal Ujian -->
                                                        <td><?= date('d, M Y', strtotime($hjd['jadwal_ujian']['tanggal_ujian'])); ?></td>

                                                        <!-- Mata Kuliah -->
                                                        <td><?= $hjd['jadwal_ujian']['mata_kuliah']; ?></td>

                                                        <!-- Status -->
                                                        <td style="color: red;">
                                                            Tidak Ada Pendamping
                                                        </td>


                                                        <!-- Aksi -->
                                                        <td>
                                                            <button type="button" class="btn btn-warning btn-sm editJadwal my-1" data-bs-toggle="modal" data-bs-target="#jadwalDamping<?= $hjd['id_damping']; ?>" ?>
                                                                Detail
                                                            </button>
                                                        </td>

                                                    </tr>
                                                    <?php $i++; ?>
                                                <?php endif; ?>
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
    </div>
</div>

<?php if (!empty($data)) : ?>

    <?php foreach ($hasil_jadwal_damping as $modalhjd) : ?>
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
                                                <button class="btn btn-success btn-sm mt-1" data-bs-target="#presensi<?= $modalhjd['id_damping']; ?>" data-bs-toggle="modal" data-bs-dismiss="modal">Detail</button>
                                            </div>
                                        <?php elseif ($modalhjd['status_damping'] == 'damping_selesai') : ?>
                                            <div class="col-sm-8 mt-1">
                                                <a href="<?= base_url('changeStatus/laporan'); ?>/<?= $modalhjd['id_damping']; ?>" class="btn btn-success btn-sm">Pendampingan Selesai</a>
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
                                                <button class="btn btn-success btn-sm mt-1" data-bs-target="#presensi<?= $modalhjd['id_damping']; ?>" data-bs-toggle="modal" data-bs-dismiss="modal">Detail</button>
                                            </div>
                                        <?php elseif ($modalhjd['status_damping'] == 'konfirmasi_presensi_hadir') : ?>
                                            <div class="col-sm-8">
                                                <button class="btn btn-secondary btn-sm mt-1" disabled>Proses...</button>
                                            </div>
                                        <?php elseif ($modalhjd['status_damping'] == 'damping_selesai') : ?>
                                            <div class="col-sm-8">
                                                <a href="<?= base_url('changeStatus/laporan'); ?>/<?= $modalhjd['id_damping']; ?>" class="btn btn-success btn-sm">Pendampingan Selesai</a>
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
                                                <button class="btn btn-success btn-sm mt-1" data-bs-target="#evaluasi<?= $modalhjd['id_damping']; ?>" data-bs-toggle="modal" data-bs-dismiss="modal">Evaluasi</button>
                                            </div>
                                        <?php elseif ($modalhjd['status_damping'] == 'madif_review') : ?>
                                            <div class="col-sm-8">
                                                <button class="btn btn-success btn-sm mt-1" data-bs-target="#evaluasi<?= $modalhjd['id_damping']; ?>" data-bs-toggle="modal" data-bs-dismiss="modal">Evaluasi</button>
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
                                                <button class="btn btn-success btn-sm mt-1" data-bs-target="#evaluasi<?= $modalhjd['id_damping']; ?>" data-bs-toggle="modal" data-bs-dismiss="modal">Evaluasi</button>
                                            </div>
                                        <?php elseif ($modalhjd['status_damping'] == 'pendamping_review') : ?>
                                            <div class="col-sm-8">
                                                <button class="btn btn-success btn-sm mt-1" data-bs-target="#evaluasi<?= $modalhjd['id_damping']; ?>" data-bs-toggle="modal" data-bs-dismiss="modal">Evaluasi</button>
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