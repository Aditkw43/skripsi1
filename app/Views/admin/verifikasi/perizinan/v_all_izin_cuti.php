<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>


<div class="container-fluid px-6 py-4">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="row mb-6">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <?php if (session()->getFlashData('berhasil')) : ?>
                        <div class="alert alert-success" role="alert">
                            <?= session()->getFlashData('berhasil'); ?>
                        </div>
                    <?php endif; ?>
                    <div class="mb-2 mt-2" style="display: flex; justify-content: space-between; align-items:center">
                        <h2><?= $title; ?></h2>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-sm btn-primary d-none d-md-block" data-bs-toggle="modal" data-bs-target="#addCuti">Tambah Izin Cuti</button>
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
                                                        <th scope="row"><?= $i++; ?></th>

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
                                                        <td class="col-sm-3"><?= $csa['keterangan']; ?></td>

                                                        <!-- Status -->
                                                        <td>
                                                            <a href="<?= base_url('c_perizinan/approval_cuti'); ?>/<?= $csa['id_cuti'], '/terima/' . $csa['profile']['nim']; ?>" class="btn btn-success btn-sm my-1">Terima</a>
                                                            <a href="<?= base_url('c_perizinan/approval_cuti'); ?>/<?= $csa['id_cuti'] . '/tolak'; ?>" class="btn btn-danger btn-sm">Tolak</a>
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
                                                        <td class="col-sm-3"><?= $cra['keterangan']; ?></td>

                                                        <!--  status -->
                                                        <td>
                                                            <a href="<?= base_url('c_perizinan/approval_cuti'); ?>/<?= $cra['id_cuti'], '/terima/' . $cra['profile']['nim']; ?>" class="btn btn-success btn-sm my-1">Terima</a>
                                                            <a href="<?= base_url('c_perizinan/approval_cuti'); ?>/<?= $cra['id_cuti'] . '/tolak'; ?>" class="btn btn-danger btn-sm">Tolak</a>
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
                                                        <td class="col-sm-3"><?= $cd['keterangan']; ?></td>

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
                                                        <td class="col-sm-3"><?= $ct['keterangan']; ?></td>

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

<!-- Modal Tambah Izin Cuti-->
<div class="modal fade" id="addCuti" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header" style="background-color: rgba(0, 136, 120, 1)">
                <h5 class="modal-title" id="exampleModalLabel" style=" color:white">Tambah Cuti Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="<?= base_url('/c_perizinan/saveCuti'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <?= csrf_field(); ?>

                    <!-- Id_admin -->
                    <input type="hidden" name="admin" value="admin">

                    <!-- Jenis Mahasiswa-->
                    <div class="row mb-3">
                        <label for="jenis_mhs" class="col-sm-3 col-form-label">Jenis Mahasiswa</label>
                        <div class="col-sm-9">
                            <select class="form-select" aria-label="Default select example" name="jenis_mhs" id="jenis_mhs" autofocus required onchange="showMahasiswa(this.value)">
                                <option value='null' selected>Pilih Jenis Mahasiswa</option>
                                <option value='madif'>Mahasiswa Difabel</option>
                                <option value='pendamping'>Pendamping</option>
                            </select>
                        </div>
                    </div>

                    <!-- Pilih Mahasiswa-->
                    <div class="row mb-3">
                        <label for="id_profile_mhs" class="col-sm-3 col-form-label">Mahasiswa</label>
                        <div class="col-sm-9">
                            <select class="form-select" aria-label="Default select example" name="id_profile_mhs" id="pilih_mhs" autofocus required>
                                <option value='null' selected>Pilih Mahasiswa</option>

                                <?= $count1 = 1; ?>
                                <?= $count2 = 1; ?>
                                <?php foreach ($tambah_cuti as $key1) : ?>
                                    <option value="<?= $key1['id_profile_mhs']; ?>" class="hidden-modal-mhs" id="<?= $key1['role']; ?>"> <?= (($key1['role'] == 'madif') ? $count1++ : $count2++) . '. ' . $key1['nickname']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

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
                    <div class="form-floating">
                        <textarea class="form-control" placeholder="Leave a comment here" id="alasan" style="height: 100px" name="alasan" required></textarea>
                        <label for="alasan">Alasan</label>
                    </div>

                    <!--Dokumen Cuti-->
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
                </div>
            </form>
        </div>
    </div>
</div>

<?php if (!empty($hasil_cuti)) : ?>
    <?php foreach ($hasil_cuti as $key2) : ?>
        <!-- Modal Profile Pendamping-->
        <div class="modal fade" id="profile<?= $key2['id_cuti']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: blueviolet">
                        <h5 class="modal-title text-white" id="exampleModalLabel">Profile</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Form -->
                    <div class="modal-body" style="background-color: white;">

                        <div class="container">
                            <h4 class="text-center"><?= ($key2['role'] == 'Madif') ? 'Mahasiswa Difabel' : 'Pendamping'; ?></h4>
                            <div class="row mt-5">
                                <div class="col-md-6 mb-2">
                                    <label for="nama_pendamping_lama" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama_pendamping_lama" placeholder='<?= $key2['biodata']['fullname']; ?>' readonly>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="jenis_kelamin_pendamping_lama" class="form-label">Jenis Kelamin</label>
                                    <input type="text" class="form-control" id="jenis_kelamin_pendamping_lama" placeholder='<?= ($key2['biodata']['jenis_kelamin'] == 1) ? 'Laki-laki' : 'Perempuan'; ?>' readonly>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="fakultas_pendamping_lama" class="form-label">Fakultas</label>
                                    <input type="text" class="form-control" id="fakultas_pendamping_lama" placeholder='<?= $key2['profile']['fakultas']; ?>' readonly>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="jurusan_pendamping_lama" class="form-label">Jurusan</label>
                                    <input type="text" class="form-control" id="jurusan_pendamping_lama" placeholder='<?= $key2['profile']['jurusan'] ?>' readonly>
                                </div>
                                <label for="nomor_pendamping_lama" class="col-sm-auto col-form-label">Nomor HP</label>

                                <div class="col-sm-auto">
                                    <input type="text" class="form-control-plaintext" id="nomor_pendamping_lama" value='<?= $key2['biodata']['nomor_hp'] ?>'>
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
<?php endif ?>

<script>
    function showMahasiswa(element) {
        var mhs_id = document.querySelectorAll('#' + element);
        var mhs_class = document.querySelectorAll('.hidden-modal-mhs');
        // console.log(nama_mhs_id);
        // console.log(mhs_id);
        // console.log(mhs_class);
        // console.log(mhs_id.length);
        // console.log(mhs_class.length);        

        for (var i = 0; i < mhs_class.length; i++) {
            console.log(mhs_class[i]);
            mhs_class[i].style.display = 'none';
        }
        for (var j = 0; j < mhs_id.length; j++) {
            console.log(mhs_id[j]);
            mhs_id[j].removeAttribute("style");
        }
    }
</script>

<?= $this->endSection(); ?>