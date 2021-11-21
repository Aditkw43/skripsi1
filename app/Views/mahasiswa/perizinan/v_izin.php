<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid px-6 py-4">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="row mb-6">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                    <div id="examples" class="mb-4">
                        <h2><?= $title; ?></h2>
                    </div>

                    <!-- Card -->
                    <div class="card">

                        <!-- Tab table -->
                        <ul class="nav nav-line-bottom" id="pills-tab-table" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-table-daftar-izin-tidak-damping-tab" data-bs-toggle="pill" href="#pills-table-daftar-izin-tidak-damping" role="tab" aria-controls="pills-table-daftar-izin-tidak-damping" aria-selected="true">Daftar Izin Tidak Damping</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="pills-table-daftar-pendampingan-tab" data-bs-toggle="pill" href="#pills-table-daftar-pendampingan" role="tab" aria-controls="pills-table-daftar-pendampingan" aria-selected="false">Daftar Pendampingan</a>
                            </li>
                        </ul>

                        <!-- Tab content -->
                        <div class=" tab-content p-2" id="pills-tabContent-table">

                            <!-- Daftar Izin Tidak Damping Tabel -->
                            <div class="tab-pane tab-example-design fade show active" id="pills-table-daftar-izin-tidak-damping" role="tabpanel" aria-labelledby="pills-table-daftar-izin-tidak-damping-tab">
                                <!-- Basic table -->
                                <div class="table-responsive">
                                    <table class="table table-hover table-dark" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">

                                        <thead>
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Tanggal</th>
                                                <th scope="col">Mata Kuliah</th>
                                                <th scope="col">Madif</th>
                                                <th scope="col">Pengganti</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Dokumen</th>
                                            </tr>
                                        </thead>

                                        <tbody class="table-light">
                                            <?php $i = 1; ?>
                                            <?php if (!empty($get_izin)) : ?>
                                                <?php foreach ($get_izin as $gi) : ?>
                                                    <tr class="align-middle">
                                                        <!-- Nomor -->
                                                        <th scope="row"><?= $i++; ?></th>

                                                        <!-- Tanggal Ujian-->
                                                        <td><?= date('d, M Y', strtotime($gi['jadwal_ujian']['tanggal_ujian'])); ?></td>

                                                        <!-- Mata Kuliah -->
                                                        <td><?= $gi['jadwal_ujian']['mata_kuliah']; ?></td>

                                                        <!-- Madif -->
                                                        <td><?= $gi['madif']; ?></td>

                                                        <?php if (isset($gi['pendamping_baru'])) : ?>
                                                            <!-- Pendamping Pengganti -->
                                                            <td><?= $gi['pendamping_baru']; ?></td>

                                                            <!--  status -->
                                                            <?php if ($gi['approval_admin'] && $gi['approval_pengganti']) : ?>
                                                                <td style="color: green">Berhasil</td>
                                                            <?php elseif ($gi['approval_pengganti'] === null && $gi['approval_admin'] === null) : ?>
                                                                <td style="color: blue">Menunggu verifikasi dari pendamping</td>
                                                            <?php elseif ($gi['approval_pengganti'] && $gi['approval_admin'] === null) : ?>
                                                                <td style="color: blue">Menunggu verifikasi admin</td>

                                                            <?php elseif (($gi['approval_pengganti'] === '0') && $gi['approval_admin'] === null) : ?>
                                                                <td style="color: red">Ditolak pengganti</td>

                                                            <?php elseif ($gi['approval_admin'] === '0') : ?>
                                                                <td style="color: red">Ditolak admin</td>
                                                            <?php endif; ?>
                                                        <?php else : ?>
                                                            <td>-</td>
                                                            <?php if ($gi['approval_admin']) : ?>
                                                                <td style="color: green">Berhasil</td>
                                                            <?php elseif ($gi['approval_admin'] === '0') : ?>
                                                                <td style="color: red">Ditolak admin</td>
                                                            <?php else : ?>
                                                                <td style="color: blue">Menunggu konfirmasi admin</td>
                                                            <?php endif; ?>
                                                        <?php endif; ?>

                                                        <!-- Dokumen -->
                                                        <td><a href="/public/img/dokumen_izin/izin/<?= $gi['dokumen']; ?>" class="btn btn-info btn-sm">Dokumen</a></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <?php for ($i = 0; $i < 10; $i++) : ?>
                                                    <tr>
                                                        <th></th>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                <?php endfor; ?>
                                            <?php endif; ?>

                                        </tbody>

                                    </table>
                                </div>
                            </div>

                            <!-- Daftar Pendampingan Tabel -->
                            <div class="tab-pane tab-example-design fade" id="pills-table-daftar-pendampingan" role="tabpanel" aria-labelledby="pills-table-daftar-pendampingan-tab">
                                <!-- Basic table -->
                                <div class="table-responsive">
                                    <table class="table table-hover table-dark" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">

                                        <thead>
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Tanggal</th>
                                                <th scope="col">Waktu</th>
                                                <th scope="col">Mata Kuliah</th>
                                                <th scope="col">Madif</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Aksi</th>
                                            </tr>
                                        </thead>

                                        <tbody class="table-light">
                                            <?php $i = 1; ?>
                                            <?php if (!empty($get_damping)) : ?>
                                                <?php foreach ($get_damping as $gd) : ?>
                                                    <tr class="align-middle">
                                                        <!-- Nomor -->
                                                        <th scope="row"><?= $i++; ?></th>

                                                        <!-- Tanggal Ujian-->
                                                        <td><?= date('d, M Y', strtotime($gd['jadwal_ujian']['tanggal_ujian'])); ?></td>

                                                        <!-- Waktu Ujian -->
                                                        <td class="text-center"><?= date('H:i', strtotime($gd['jadwal_ujian']['waktu_mulai_ujian'])); ?> - <?= date('H:i', strtotime($gd['jadwal_ujian']['waktu_selesai_ujian'])); ?></td>

                                                        <!-- Mata Kuliah -->
                                                        <td><?= $gd['jadwal_ujian']['mata_kuliah']; ?></td>

                                                        <!-- Madif -->
                                                        <td><?= $gd['biodata_madif']['nickname']; ?></td>

                                                        <!--  status -->
                                                        <td style="color: orangered;"><?= (isset($gd['status_damping'])) ? $gd['status_damping'] : 'Lakukan Konfirmasi Damping'; ?></td>

                                                        <!--  Aksi -->
                                                        <td>
                                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#izinTidakDamping<?= $gd['id_damping']; ?>" ?>Izin</button>
                                                        </td>

                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <?php for ($i = 0; $i < 10; $i++) : ?>
                                                    <tr>
                                                        <th></th>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                <?php endfor; ?>
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

<!-- Modal Izin Tidak Damping -->
<?php if (!empty($get_damping)) : ?>
    <?php foreach ($get_damping as $gd) : ?>

        <!-- Modal Edit Jadwal -->
        <div class="modal fade" id="izinTidakDamping<?= $gd['id_damping']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: rgba(223, 7, 36, 1);">
                        <h4 class="modal-title" id="exampleModalLabel" style="color: whitesmoke;"> Pengajuan Izin Tidak Damping</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class=" modal-body">
                        <form action="<?= base_url('/c_perizinan/saveIzin'); ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <!-- Inputan tersembunyi id_damping -->
                            <input type="hidden" name="id_damping" value=<?= $gd['id_damping']; ?>>

                            <!-- id profile mhs -->
                            <input type="hidden" name="id_profile_mhs" value=<?= $gd['biodata_pendamping']['id_profile_mhs']; ?>>

                            <!-- Rekomendasi Pendamping -->
                            <div class="row mb-2">
                                <label for="rekomen_pengganti" class="col-form-label">Rekomendasi Pengganti <span class="fs-6" style="color:red">(urutan berdasarkan kecocokan)</span></label>

                                <div>
                                    <?php if (!empty($gd['pendamping_pengganti'])) : ?>
                                        <select class="form-select" name="rekomen_pengganti" id="rekomen_pengganti" required>
                                            <option selected value="">Pilih Pendamping</option>
                                            <?php $i = 1; ?>
                                            <?php foreach ($gd['pendamping_pengganti'] as $rekomen) : ?>
                                                <option value="<?= $rekomen['profile']['id_profile_mhs']; ?>"><?= $i++ . '. ' . $rekomen['profile']['nickname']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    <?php else : ?>
                                        <select class="form-select" name="rekomen_pengganti" id="rekomen_pengganti" disabled>
                                            <option selected value="null" disabled>Rekomendasi Pendamping Tidak Tersedia</option>
                                        </select>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!--Alasan Tidak Bisa Damping -->
                            <div class="form-floating mb-3">
                                <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px" name="alasan" required></textarea>
                                <label for="floatingTextarea2">Alasan</label>
                            </div>

                            <!--Dokumen Izin-->
                            <div class="row mb-3">
                                <label for="dokumen" class="col-form-label">Surat Izin <span class="fs-6" style="color:red">(optional)</span></label>

                                <div class="mb-3">
                                    <input type="file" class="form-control" id="dokumen" name="dokumen">
                                </div>
                            </div>

                            <!-- Submit button -->
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
<?= $this->endSection(); ?>