<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid px-6 py-4">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="row mb-6">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <!-- Pesan keberhasilan hapus -->
                    <?php if (session()->getFlashData('berhasil')) : ?>
                        <div class="alert alert-success" role="alert">
                            <?= session()->getFlashData('berhasil'); ?>
                        </div>
                    <?php elseif (session()->getFlashData('berhasil_dihapus')) : ?>
                        <div class="alert alert-success" role="alert">
                            <?= session()->getFlashData('berhasil_dihapus'); ?>
                        </div>
                    <?php elseif (session()->getFlashData('cuti_pernah_diajukan')) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?= session()->getFlashData('cuti_pernah_diajukan'); ?>
                        </div>
                    <?php elseif (session()->getFlashData('gagal_ditambahkan')) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?= session()->getFlashData('gagal_ditambahkan'); ?>
                        </div>
                    <?php endif; ?>
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
                                                <th scope="col">Detail</th>
                                            </tr>
                                        </thead>

                                        <tbody class="table-light">
                                            <?php $i = 1; ?>
                                            <?php foreach ($cuti_sementara as $key1) : ?>
                                                <tr class="align-middle" style="color: <?= ($key1['approval'] == "0") ? 'grey' : '' ?>;">
                                                    <!-- Nomor -->
                                                    <th scope="row"><?= $i++; ?></th>

                                                    <!-- Tanggal Cuti -->
                                                    <td><?= date('d, M Y', strtotime($key1['tanggal_mulai'])); ?> - <?= date('d, M Y', strtotime($key1['tanggal_selesai'])); ?></td>

                                                    <!-- Sisa Waktu Cuti -->
                                                    <td>
                                                        <?php if (empty($key1['sisa_waktu']) && ($key1['approval'] == "1")) : ?>
                                                            <span style="color:green">Selesai</span>
                                                        <?php elseif ($key1['approval'] == "0") : ?>
                                                            <span style="color: grey;">-</span>
                                                        <?php else : ?>
                                                            <span style="color: red;"><?= $key1['sisa_waktu']; ?></span> hari
                                                        <?php endif; ?>
                                                    </td>

                                                    <!-- Keterangan -->
                                                    <td><?= $key1['keterangan']; ?></td>

                                                    <!--  status -->
                                                    <?php if (!isset($key1['approval'])) : ?>
                                                        <td style="color: blue;">Menunggu Verifikasi Admin</td>
                                                    <?php elseif ($key1['approval'] == 1) : ?>
                                                        <td style="color: green;">Diterima</td>
                                                    <?php elseif ($key1['approval'] == 0) : ?>
                                                        <td style="color: red;">Ditolak</td>
                                                    <?php endif; ?>

                                                    <!-- Dokumen -->
                                                    <td>
                                                        <a href="/img/dokumen_izin/cuti/<?= $key1['dokumen']; ?>" target="_blank" class="btn btn-secondary btn-sm"><i class="fa fa-download"></i> Dokumen</a>
                                                        <?php if ($key1['approval'] == '0') : ?>
                                                            <a href="<?= base_url('c_perizinan/delCuti/' . $key1['id_cuti']); ?>" class="btn btn-danger btn-sm my-1">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                        <?php endif ?>
                                                    </td>
                                                </tr>
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
                                                <th scope="col">Detail</th>
                                            </tr>
                                        </thead>

                                        <tbody class="table-light">
                                            <?php $i = 1; ?>
                                            <?php foreach ($cuti_semester as $key2) : ?>
                                                <tr class="align-middle" style="color: <?= ($key2['approval'] == "0") ? 'grey' : '' ?>;">
                                                    <!-- Nomor -->
                                                    <th scope="row"><?= $i++; ?></th>

                                                    <!-- Semester-->
                                                    <td>
                                                        <span style="color: <?= ($key2['approval'] == 0 && isset($key2['approval'])) ? 'grey' : 'red' ?>;"><?= $key2['semester']; ?></span>, <?= date('Y', strtotime($key2['tanggal_mulai'])); ?>
                                                    </td>

                                                    <!-- Keterangan -->
                                                    <td><?= $key2['keterangan']; ?></td>

                                                    <!--  status -->
                                                    <?php if (!isset($key2['approval'])) : ?>
                                                        <td style="color: blue;">Menunggu Verifikasi Admin</td>
                                                    <?php elseif ($key2['approval'] == 1) : ?>
                                                        <td style="color: green;">Diterima</td>
                                                    <?php elseif ($key2['approval'] == 0) : ?>
                                                        <td style="color: red;">Ditolak</td>
                                                    <?php endif; ?>

                                                    <!-- Dokumen -->
                                                    <td>
                                                        <a href="/img/dokumen_izin/cuti/<?= $key2['dokumen']; ?>" target="_blank" class="btn btn-secondary btn-sm"><i class="fa fa-download"></i> Dokumen</a>
                                                        <?php if ($key2['approval'] == '0') : ?>
                                                            <a href="<?= base_url('c_perizinan/delCuti/' . $key2['id_cuti']); ?>" class="btn btn-danger btn-sm my-1">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                        <?php endif ?>
                                                    </td>
                                                </tr>
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
                                                                    <option value="ganjil"><?= $tahun_semester['ganjil']; ?></option>
                                                                    <option value="genap"><?= $tahun_semester['genap']; ?></option>
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