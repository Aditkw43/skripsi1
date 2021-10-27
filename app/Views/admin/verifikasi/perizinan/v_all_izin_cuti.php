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

                    <!-- Card -->
                    <div class="card">

                        <!-- Tab table -->
                        <ul class="nav nav-line-bottom" id="pills-tab-table" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-table-verifikasi-cuti-semester-tab" data-bs-toggle="pill" href="#pills-table-verifikasi-cuti-semester" role="tab" aria-controls="pills-table-verifikasi-cuti-semester" aria-selected="true">Verifikasi Cuti Semester</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-table-verifikasi-cuti-sementara-tab" data-bs-toggle="pill" href="#pills-table-verifikasi-cuti-sementara" role="tab" aria-controls="pills-table-verifikasi-cuti-sementara" aria-selected="true">Verifikasi Cuti Sementara</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-table-cuti-diterima-tab" data-bs-toggle="pill" href="#pills-table-cuti-diterima" role="tab" aria-controls="pills-table-cuti-diterima" aria-selected="true">Cuti Diterima</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-table-cuti-ditolak-tab" data-bs-toggle="pill" href="#pills-table-cuti-ditolak" role="tab" aria-controls="pills-table-cuti-ditolak" aria-selected="true">Cuti Ditolak</a>
                            </li>
                        </ul>

                        <!-- Tab content -->
                        <div class=" tab-content p-4" id="pills-tabContent-table">

                            <!-- Verifikasi Cuti Semester Table -->
                            <div class="tab-pane tab-example-design fade show active" id="pills-table-verifikasi-cuti-semester" role="tabpanel" aria-labelledby="pills-table-verifikasi-cuti-semester-tab">
                                <div class="table-responsive">
                                    <table class="table table-hover table-dark" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                                        <thead>

                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Nama</th>
                                                <th scope="col">Role</th>
                                                <th scope="col">Semester</th>
                                                <th scope="col">Keterangan</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Dokumen</th>
                                                <th scope="col">Profile</th>
                                            </tr>

                                        </thead>
                                        <tbody class="table-light">
                                            <?php if (!empty($cuti_semester_approval)) : ?>
                                                <?php $i = 1 ?>
                                                <?php foreach ($cuti_semester_approval as $csa) : ?>
                                                    <tr class="align-middle">

                                                        <!-- Id Cuti -->
                                                        <input type="hidden" name="id_cuti" value="<?= $csa['id_cuti']; ?>">

                                                        <!-- Nomor -->
                                                        <th scope="row"><?= $i; ?></th>

                                                        <!-- Nama-->
                                                        <td><?= $csa['biodata']['nickname']; ?></td>

                                                        <!-- Role -->
                                                        <td><?= $csa['role']; ?></td>

                                                        <!-- Semester -->
                                                        <?php if ($csa['tanggal_mulai'] == '2021-02-01') : ?>
                                                            <td><span style="color: red;">Genap</span>, <?= date('Y', strtotime($csa['tanggal_mulai'])); ?></td>
                                                        <?php else : ?>
                                                            <td><span style="color: red">Ganjil</span>, <?= date('Y', strtotime($csa['tanggal_mulai'])); ?></td>
                                                        <?php endif; ?>

                                                        <!-- Keterangan -->
                                                        <td><?= $csa['keterangan']; ?></td>

                                                        <!-- Status -->
                                                        <td>
                                                            <a href="<?= base_url('c_perizinan/approval_cuti'); ?>/<?= $csa['id_cuti'], '/terima'; ?>" class="btn btn-success btn-sm my-1">Terima</a>
                                                            <a href="<?= base_url('c_perizinan/approval_cuti'); ?>/<?= $csa['id_cuti'], '/tolak'; ?>" class="btn btn-danger btn-sm">Tolak</a>
                                                        </td>

                                                        <!-- Dokumen -->
                                                        <td>
                                                            <?php if (isset($csa['dokumen'])) : ?>
                                                                <a href="/img/dokumen_izin/cuti/<?= $csa['dokumen']; ?>" target="_blank" class="btn btn-secondary btn-sm"><i class="fa fa-download"></i> Dokumen</a>
                                                            <?php else : ?>
                                                                -
                                                            <?php endif; ?>
                                                        </td>

                                                        <!-- Profile -->
                                                        <td>
                                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#profile<?= $csa['id_cuti']; ?>" ?>
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

                            <!-- Verifikasi Cuti Sementara Table -->
                            <div class="tab-pane tab-example-design fade" id="pills-table-verifikasi-cuti-sementara" role="tabpanel" aria-labelledby="pills-table-verifikasi-cuti-sementara-tab">
                                <div class="table-responsive">
                                    <table class="table table-hover table-dark" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                                        <thead>

                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Nama</th>
                                                <th scope="col">Role</th>
                                                <th scope="col">Waktu Cuti</th>
                                                <th scope="col">Keterangan</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Dokumen</th>
                                                <th scope="col">Profile</th>
                                            </tr>

                                        </thead>
                                        <tbody class="table-light">
                                            <?php if (!empty($cuti_sementara_approval)) : ?>
                                                <?php $i = 1 ?>
                                                <?php foreach ($cuti_sementara_approval as $cra) : ?>
                                                    <tr class="align-middle">
                                                        <!-- Id Cuti Sementara -->
                                                        <input type="hidden" name="id_cuti" value="<?= $cra['id_cuti']; ?>">

                                                        <!-- Nomor -->
                                                        <th scope="row"><?= $i++; ?></th>

                                                        <!-- Nama-->
                                                        <td><?= $cra['biodata']['nickname']; ?></td>

                                                        <!-- Role -->
                                                        <td><?= $cra['role']; ?></td>

                                                        <!-- Tanggal Cuti -->
                                                        <td><?= date('d, M Y', strtotime($cra['tanggal_mulai'])); ?> - <?= date('d, M Y', strtotime($cra['tanggal_selesai'])); ?></td>

                                                        <!-- Keterangan -->
                                                        <td><?= $cra['keterangan']; ?></td>

                                                        <!--  status -->
                                                        <td>
                                                            <a href="<?= base_url('c_perizinan/approval_cuti'); ?>/<?= $cra['id_cuti'], '/terima'; ?>" class="btn btn-success btn-sm my-1">Terima</a>
                                                            <a href="<?= base_url('c_perizinan/approval_cuti'); ?>/<?= $cra['id_cuti'], '/tolak'; ?>" class="btn btn-danger btn-sm">Tolak</a>
                                                        </td>

                                                        <!-- Dokumen -->
                                                        <td>
                                                            <?php if (isset($cra['dokumen'])) : ?>
                                                                <a href="/img/dokumen_izin/cuti/<?= $cra['dokumen']; ?>" target="_blank" class="btn btn-secondary btn-sm"><i class="fa fa-download"></i> Dokumen</a>
                                                            <?php else : ?>
                                                                -
                                                            <?php endif; ?>
                                                        </td>

                                                        <!-- Profile -->
                                                        <td>
                                                            <button type="button" class="btn btn-primary btn-sm editJadwal" data-bs-toggle="modal" data-bs-target="#profile<?= $cra['id_cuti']; ?>" ?>
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
                            <div class="tab-pane tab-example-html fade" id="pills-table-cuti-diterima" role="tabpanel" aria-labelledby="pills-table-cuti-diterima-tab">
                                <div class="table-responsive">
                                    <table class="table table-hover table-dark" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                                        <thead>

                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Jenis Cuti</th>
                                                <th scope="col">Nama</th>
                                                <th scope="col">Role</th>
                                                <th scope="col">Keterangan</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Dokumen</th>
                                                <th scope="col">Profile</th>
                                            </tr>

                                        </thead>
                                        <tbody class="table-light">
                                            <?php if (!empty($cuti_diterima)) : ?>
                                                <?php $i = 1 ?>
                                                <?php foreach ($cuti_diterima as $cd) : ?>
                                                    <tr class="align-middle">
                                                        <!-- Id Cuti Sementara -->
                                                        <input type="hidden" name="id_cuti" value="<?= $cd['id_cuti']; ?>">

                                                        <!-- Nomor -->
                                                        <th scope="row"><?= $i++; ?></th>

                                                        <!-- Jenis Cuti -->
                                                        <td scope="row"><?= ($cd['jenis_cuti'] == 'cuti_semester') ? 'Cuti Semester' : 'Cuti Sementara'; ?></td>

                                                        <!-- Nama -->
                                                        <td scope="row"><?= $cd['biodata']['nickname']; ?></td>
                                                        <!-- Role -->
                                                        <td scope="row"><?= $cd['role']; ?></td>

                                                        <!-- Keterangan -->
                                                        <td><?= $cd['keterangan']; ?></td>

                                                        <!--  status -->
                                                        <td style="color:green">
                                                            Terverifikasi
                                                        </td>

                                                        <!-- Dokumen -->
                                                        <td>
                                                            <?php if (isset($cd['dokumen'])) : ?>
                                                                <a href="/img/dokumen_izin/cuti/<?= $cd['dokumen']; ?>" target="_blank" class="btn btn-secondary btn-sm"><i class="fa fa-download"></i> Dokumen</a>
                                                            <?php else : ?>
                                                                -
                                                            <?php endif; ?>
                                                        </td>

                                                        <!-- Profile -->
                                                        <td>
                                                            <button type="button" class="btn btn-primary btn-sm editJadwal" data-bs-toggle="modal" data-bs-target="#profile<?= $cd['id_cuti']; ?>" ?>
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
                            <div class="tab-pane tab-example-html fade" id="pills-table-cuti-ditolak" role="tabpanel" aria-labelledby="pills-table-cuti-ditolak-tab">
                                <div class="table-responsive">
                                    <table class="table table-hover table-dark" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                                        <thead>

                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Jenis Cuti</th>
                                                <th scope="col">Nama</th>
                                                <th scope="col">Role</th>
                                                <th scope="col">Keterangan</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Dokumen</th>
                                                <th scope="col">Profile</th>
                                            </tr>

                                        </thead>
                                        <tbody class="table-light">
                                            <?php if (!empty($cuti_ditolak)) : ?>
                                                <?php $i = 1 ?>
                                                <?php foreach ($cuti_ditolak as $ct) : ?>
                                                    <tr class="align-middle">
                                                        <!-- Id Cuti Sementara -->
                                                        <input type="hidden" name="id_cuti" value="<?= $ct['id_cuti']; ?>">

                                                        <!-- Nomor -->
                                                        <th scope="row"><?= $i++; ?></th>

                                                        <!-- Jenis Cuti -->
                                                        <td scope="row"><?= ($ct['jenis_cuti'] == 'cuti_semester') ? 'Cuti Semester' : 'Cuti Sementara'; ?></td>

                                                        <!-- Nama -->
                                                        <td scope="row"><?= $ct['biodata']['nickname']; ?></td>
                                                        <!-- Role -->
                                                        <td scope="row"><?= $ct['role']; ?></td>

                                                        <!-- Keterangan -->
                                                        <td><?= $ct['keterangan']; ?></td>

                                                        <!--  status -->
                                                        <td style="color:red">
                                                            Ditolak
                                                        </td>

                                                        <!-- Dokumen -->
                                                        <td>
                                                            <?php if (isset($ct['dokumen'])) : ?>
                                                                <a href="/img/dokumen_izin/cuti/<?= $ct['dokumen']; ?>" target="_blank" class="btn btn-secondary btn-sm"><i class="fa fa-download"></i> Dokumen</a>
                                                            <?php else : ?>
                                                                -
                                                            <?php endif; ?>
                                                        </td>

                                                        <!-- Profile -->
                                                        <td>
                                                            <button type="button" class="btn btn-primary btn-sm editJadwal" data-bs-toggle="modal" data-bs-target="#profile<?= $ct['id_cuti']; ?>" ?>
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

<?php if (!empty($hasil_cuti)) : ?>
    <?php foreach ($hasil_cuti as $modalhc) : ?>

        <!-- Modal Profile Pendamping-->
        <div class="modal fade" id="profile<?= $modalhc['id_cuti']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: blueviolet">
                        <h5 class="modal-title text-white" id="exampleModalLabel">Profile</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Form -->
                    <div class="modal-body" style="background-color: white;">
                        <div class="container">
                            <h4 class="text-center"><?= $modalhc['biodata']['fullname']; ?></h4>
                            <div class="row mt-5">
                                <div class="col-md-6 mb-2">
                                    <label for="nama" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama" placeholder='<?= $modalhc['biodata']['fullname']; ?>' readonly>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                    <input type="text" class="form-control" id="jenis_kelamin" placeholder='<?= ($modalhc['biodata']['jenis_kelamin'] == 1) ? 'Laki-laki' : 'Perempuan'; ?>' readonly>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="fakultas" class="form-label">Fakultas</label>
                                    <input type="text" class="form-control" id="fakultas" placeholder='<?= $modalhc['profile']['fakultas']; ?>' readonly>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="jurusan" class="form-label">Jurusan</label>
                                    <input type="text" class="form-control" id="jurusan" placeholder='<?= $modalhc['profile']['jurusan'] ?>' readonly>
                                </div>
                                <label for="nomor" class="col-sm-auto col-form-label">Nomor HP</label>

                                <div class="col-sm-auto">
                                    <input type="text" class="form-control-plaintext" id="nomor" value='<?= $modalhc['biodata']['nomor_hp'] ?>'>
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

    <?php endforeach; ?>

<?php endif; ?>


<?= $this->endSection(); ?>