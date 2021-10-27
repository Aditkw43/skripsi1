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
                        <ul class="nav nav-line-bottom d-flex justify-content-between" id="pills-tab-table" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-table-daftar-cuti-sementara-tab" data-bs-toggle="pill" href="#pills-table-daftar-cuti-sementara" role="tab" aria-controls="pills-table-daftar-cuti-sementara" aria-selected="true">Daftar Cuti Sementara</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-table-daftar-cuti-semester-tab" data-bs-toggle="pill" href="#pills-table-daftar-cuti-semester" role="tab" aria-controls="pills-table-daftar-cuti-semester" aria-selected="true">Daftar Cuti Semester</a>
                            </li>

                            <li class="nav-item">
                                <a class="input-jadwal" id="pills-table-pengajuan-cuti-tab" data-bs-toggle="pill" href="#pills-table-pengajuan-cuti" role="tab" aria-controls="pills-table-pengajuan-cuti" aria-selected="false">Pengajuan Cuti</a>
                            </li>
                        </ul>

                        <!-- Tab content -->
                        <div class=" tab-content p-4" id="pills-tabContent-table">

                            <!-- Daftar Cuti Sementara Tabel -->
                            <div class="tab-pane tab-example-design fade show active" id="pills-table-daftar-cuti-sementara" role="tabpanel" aria-labelledby="pills-table-daftar-cuti-sementara-tab">
                                <!-- Basic table -->
                                <div class="table-responsive">
                                    <table class="table table-hover table-dark" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">

                                        <thead>
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Waktu Cuti</th>
                                                <th scope="col">Sisa Waktu</th>
                                                <th scope="col">Keterangan</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Dokumen</th>
                                            </tr>
                                        </thead>

                                        <tbody class="table-light">
                                            <?php $i = 1; ?>
                                            <?php foreach ($get_cuti as $gt) : ?>
                                                <?php if ($gt['jenis_cuti'] == 'cuti_sementara') : ?>
                                                    <tr class="align-middle" style="color: <?= ($gt['approval'] == 0) ? 'grey' : '' ?>;">
                                                        <!-- Nomor -->
                                                        <th scope="row"><?= $i++; ?></th>

                                                        <!-- Tanggal Cuti -->
                                                        <td><?= date('d, M Y', strtotime($gt['tanggal_mulai'])); ?> - <?= date('d, M Y', strtotime($gt['tanggal_selesai'])); ?></td>

                                                        <!-- Sisa Waktu Cuti -->
                                                        <td><span style="color: <?= ($gt['approval'] == 0 && isset($gt['approval'])) ? 'grey' : 'red' ?>;"><?= $gt['sisa_waktu']; ?></span> hari</td>

                                                        <!-- Keterangan -->
                                                        <td><?= $gt['keterangan']; ?></td>

                                                        <!--  status -->
                                                        <?php if (!isset($gt['approval'])) : ?>
                                                            <td style="color: blue;">Menunggu Verifikasi Admin</td>
                                                        <?php elseif ($gt['approval'] == 1) : ?>
                                                            <td style="color: green;">Diterima</td>
                                                        <?php elseif ($gt['approval'] == 0) : ?>
                                                            <td style="color: red;">Ditolak</td>
                                                        <?php endif; ?>

                                                        <!-- Dokumen -->
                                                        <td><a href="/public/img/default.svg" class="btn btn-info btn-sm">Dokumen</a></td>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </tbody>

                                    </table>
                                </div>
                            </div>

                            <!-- Daftar Cuti Semester Tabel -->
                            <div class="tab-pane tab-example-design fade" id="pills-table-daftar-cuti-semester" role="tabpanel" aria-labelledby="pills-table-daftar-cuti-semester-tab">
                                <!-- Basic table -->
                                <div class="table-responsive">
                                    <table class="table table-hover table-dark" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">

                                        <thead>
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Semester</th>
                                                <th scope="col">Keterangan</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Dokumen</th>
                                            </tr>
                                        </thead>

                                        <tbody class="table-light">
                                            <?php $i = 1; ?>
                                            <?php foreach ($get_cuti as $gt) : ?>
                                                <?php if ($gt['jenis_cuti'] == 'cuti_semester') : ?>
                                                    <tr class="align-middle" style="color: <?= ($gt['approval'] == 0 && isset($gt['approval'])) ? 'grey' : '' ?>;">
                                                        <!-- Nomor -->
                                                        <th scope="row"><?= $i++; ?></th>

                                                        <!-- Semester-->
                                                        <?php if ($gt['tanggal_mulai'] == '2021-02-01') : ?>
                                                            <td><span style="color: <?= ($gt['approval'] == 0 && isset($gt['approval'])) ? 'grey' : 'red' ?>;">Genap</span>, <?= date('Y', strtotime($gt['tanggal_mulai'])); ?></td>
                                                        <?php else : ?>
                                                            <td><span style="color: <?= ($gt['approval'] == 0 && isset($gt['approval'])) ? 'grey' : 'red' ?>;">Ganjil</span>, <?= date('Y', strtotime($gt['tanggal_mulai'])); ?></td>
                                                        <?php endif; ?>

                                                        <!-- Keterangan -->
                                                        <td><?= $gt['keterangan']; ?></td>

                                                        <!--  status -->
                                                        <?php if (!isset($gt['approval'])) : ?>
                                                            <td style="color: blue;">Menunggu Verifikasi Admin</td>
                                                        <?php elseif ($gt['approval'] == 1) : ?>
                                                            <td style="color: green;">Diterima</td>
                                                        <?php elseif ($gt['approval'] == 0) : ?>
                                                            <td style="color: red;">Ditolak</td>
                                                        <?php endif; ?>

                                                        <!-- Dokumen -->
                                                        <td><a href="/public/img/default.svg" class="btn btn-<?= ($gt['approval'] == 0 && isset($gt['approval'])) ? 'secondary' : 'info' ?> btn-sm">Dokumen</a></td>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </tbody>

                                    </table>
                                </div>
                            </div>

                            <!-- Pengajuan Cuti Table -->
                            <div class="tab-pane tab-example-html fade" id="pills-table-pengajuan-cuti" role="tabpanel" aria-labelledby="pills-table-pengajuan-cuti-tab">
                                <div class="copy-content copy-content-height">
                                    <div class="code-toolbar">
                                        <div class="container-fluid">
                                            <div class="row d-flex justify-content-center">
                                                <div class="col-6">

                                                    <p class="fs-4 fw-bolder mb-5 text-center">Mengajukan Perizinan Cuti</p>

                                                    <!-- Form Pengajuan Cuti -->
                                                    <form action="/c_perizinan/saveCuti" method="POST" enctype="multipart/form-data">

                                                        <?= csrf_field(); ?>

                                                        <!-- id_profile_mhs -->
                                                        <input type="hidden" name="id_profile_mhs" value="<?= $id_mhs; ?>">

                                                        <!--Jenis Cuti-->
                                                        <div class="row mb-3">
                                                            <label for="mata_kuliah" class="col-sm-3 col-form-label">Jenis Cuti</label>

                                                            <div class="col-sm-9">
                                                                <select class="form-select" aria-label="Default select example" onchange="showDiv(this)" name="jenis_cuti" required>
                                                                    <option selected value="">Pilih Jenis Cuti</option>
                                                                    <option value="cuti_semester">Cuti Semester</option>
                                                                    <option value="cuti_sementara">Cuti Sementara</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <!--Tanggal Cuti Semester-->
                                                        <div class="row mb-3 g-6" id="hidden_tanggal_cuti_semester" style="display: none;">
                                                            <label for="semester_cuti" class="col-sm-3 col-form-label">Semester Cuti</label>
                                                            <div class="col-sm-9">
                                                                <select class="form-select" aria-label="Default select example" name="semester">
                                                                    <option selected value="">Pilih Semester</option>
                                                                    <option value="ganjil">Ganjil</option>
                                                                    <option value="genap">Genap</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <!--Tanggal Cuti Sementara-->
                                                        <div class="row mb-3 g-6" id="hidden_tanggal_cuti_sementara" style="display: none;">
                                                            <label for="cuti_sementara" class="col-sm-3 col-form-label">Tanggal Cuti</label>
                                                            <div class="col-sm-4">
                                                                <input type="date" class="form-control" id="tanggal_mulai_cuti" name="tanggal_mulai_cuti" value="<?= old('tanggal_mulai_cuti') ?>">
                                                            </div>
                                                            <div class="col-1 text-xl-center">-</div>
                                                            <div class="col-sm-4">
                                                                <input type="date" class="form-control" id="tanggal_selesai_cuti" name="tanggal_selesai_cuti" value="<?= old('tanggal_selesai_cuti') ?>">
                                                            </div>
                                                        </div>

                                                        <!--Alasan Cuti -->
                                                        <div class="row mb-3">
                                                            <label for="alasan" class="col-sm-3 col-form-label">Alasan</label>

                                                            <div class="form col-9">
                                                                <textarea class="form-control" placeholder="Tulis Alasan Cuti" id="floatingTextarea2" style="height: 100px" name="alasan" required></textarea>
                                                            </div>
                                                        </div>

                                                        <!--Dokumen Cuti -->
                                                        <div class="row mb-3">
                                                            <label for="dokumen" class="col-sm-3 col-form-label">Surat Cuti <span class="fs-6" style="color:red">(optional)</span></label>

                                                            <div class="col-sm-9 mb-3">
                                                                <input type="file" class="form-control" id="inputGroupFile02" name="dokumen">
                                                            </div>
                                                        </div>

                                                        <!-- Submit -->
                                                        <div class="d-grid mt-3 gap-2 d-md-flex justify-content-md-end">
                                                            <button type="submit" class="btn btn-primary">Ajukan</button>
                                                        </div>

                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>