<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<!-- Variabel session -->
<?php
$fail_kalender = session()->getFlashData('fail_kalender');
$validasi_kalender = session()->getFlashData('validasi_kalender');
$validasi_matkul_tanggal = session()->getFlashData('validasi_matkul_tanggal');
$validasi_tanggal = session()->getFlashData('validasi_tanggal');
$validasi_waktu = session()->getFlashData('validasi_waktu');
$validasi_waktu_tidak_sesuai = session()->getFlashData('validasi_waktu_tidak_sesuai');
?>

<?php if (in_groups('admin')) : ?>
    <hr>
    <div class="ml-4">
        <img src="/img/<?= $user->user_image; ?>" style=" width:5em" class="mb-2" alt="">
        <table style="display: flex" class="mb-2">
            <tr>
                <th>Nama</th>
                <td>: <?= $user->username; ?></td>
            </tr>
            <tr>
                <th>Fakultas</th>
                <td>: FILKOM</td>
            </tr>
            <tr>
                <th>Angkatan</th>
                <td>: 2017</td>
            </tr>
            <tr>
                <th>Semester</th>
                <td>: 9</td>
            </tr>
            <tr>
                <th>Jumlah Ujian</th>
                <td>: 2</td>
            </tr>
            <tr>
                <th>Role</th>
                <td>: <span class="badge badge-<?= ($user->name == 'admin') ? 'danger' : (($user->name == 'madif') ? 'success' : 'info'); ?>"><?= $user->name; ?></span></td>
            </tr>
        </table>
    </div>
<?php endif; ?>

<div class="container-fluid px-6 py-4">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="row mb-6">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div id="examples" class="mb-4">
                        <h2>Daftar Skills <?= $biodata['fullname']; ?></h2>
                        <?php if (session()->getFlashData('berhasil_ditambahkan')) : ?>
                            <div class="alert alert-success" role="alert">
                                <?= session()->getFlashData('berhasil_ditambahkan'); ?>
                            </div>
                        <?php elseif (session()->getFlashData('berhasil_dihapus')) : ?>
                            <div class="alert alert-success" role="alert">
                                <?= session()->getFlashData('berhasil_dihapus'); ?>
                            </div>
                        <?php elseif (session()->getFlashData('berhasil_diedit')) : ?>
                            <div class="alert alert-success" role="alert">
                                <?= session()->getFlashData('berhasil_diedit'); ?>
                            </div>
                        <?php elseif (session()->getFlashData('tidak_diedit')) : ?>
                            <div class="alert alert-warning" role="alert">
                                <?= session()->getFlashData('tidak_diedit'); ?>
                            </div>
                        <?php elseif (session()->getFlashData('gagal_diedit')) : ?>
                            <div class="alert alert-danger" role="alert">
                                <?= session()->getFlashData('gagal_diedit'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <!-- Card -->
                    <div class="card">
                        <!-- Tab table -->
                        <ul class="nav nav-line-bottom d-flex justify-content-between" id="pills-tab-table" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-table-daftar-ujian-tab" data-bs-toggle="pill" href="#pills-table-daftar-ujian" role="tab" aria-controls="pills-table-daftar-ujian" aria-selected="true">Daftar Skills</a>
                            </li>
                            <li class="nav-item">
                                <a class="input-jadwal <?= (session()->getFlashData('gagal_ditambahkan')) ? 'text-white bg-danger' : '' ?>" id="pills-table-add-ujian-tab" data-bs-toggle="pill" href="#pills-table-add" role="tab" aria-controls="pills-table-add" aria-selected="false">Tambah Skill</a>
                            </li>
                        </ul>
                        <!-- Tab content -->
                        <div class=" tab-content p-4" id="pills-tabContent-table">

                            <!-- Daftar Tabel -->
                            <div class="tab-pane tab-example-design fade show active" id="pills-table-daftar-ujian" role="tabpanel" aria-labelledby="pills-table-daftar-ujian-tab">
                                <!-- Basic table -->
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Prioritas</th>
                                                <th scope="col">Referensi Pendampingan</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($skills_pendamping as $sp) : ?>
                                                <tr>

                                                    <th scope="row"><?= $sp['prioritas']; ?></th>

                                                    <td><?= $kategori_difabel[$sp['ref_pendampingan'] - 1]['jenis'] ?></td>

                                                    <td><?= ($sp['approval']) ? $sp['approval'] : 'Pending'  ?></td>

                                                    <td>
                                                        <!-- Cara kerja:
                                                        1. Buat button/a.href
                                                        2. Buat atribut data-toggle, data-target, dan data-* untuk isi valuenya
                                                        3. Buat Modal diakhir, disamakan dengan data-target dan id modal
                                                        4. Buat Script javascript untuk memasukkan data valuenya ke modal, dan ditaruh di akhir sebelum tag body -->

                                                        <!-- Button trigger modal Detail Jadwal Ujian -->
                                                        <button type="button" class="btn btn-warning editJadwal" data-bs-toggle="modal" data-bs-target="#editSkill<?= $sp['id_profile_pendamping'] . $sp['ref_pendampingan']; ?>" ?>
                                                            <i class="fas fa-pen-square"></i>
                                                        </button>

                                                        <!-- Button Trigger Modal Hapus Jadwal Ujian -->
                                                        <button type="submit" class="btn btn-danger my-1" data-bs-toggle="modal" data-bs-target="#delSkill<?= $sp['id_profile_pendamping'] . $sp['ref_pendampingan']; ?>">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Input Skills -->
                            <div class="tab-pane tab-example-html fade" id="pills-table-add" role="tabpanel" aria-labelledby="pills-table-add-ujian-tab">
                                <div class="copy-content copy-content-height">
                                    <div class="code-toolbar d-flex justify-content-center">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col">
                                                    <p class="fs-4 text-center">Tambah Skill Pendamping</p>
                                                    <!-- Form Tambah Jadwal Ujian -->
                                                    <form action="/c_profile_pendamping/saveSkill" method="POST">
                                                        <?= csrf_field(); ?>

                                                        <!-- id_profile_pendamping -->
                                                        <input type="hidden" name="id_profile_pendamping" value="<?= $id_profile_pendamping; ?>">

                                                        <!--Referensi Pendampingan-->
                                                        <div class="row mb-3">
                                                            <label for="ref_pendampingan" class="col-sm-3 col-form-label">Referensi Pendampingan</label>
                                                            <div class="col-sm-9">
                                                                <select class="form-select" aria-label="Default select example" name="ref_pendampingan" id="ref_pendampingan" autofocus required>
                                                                    <option selected>Pilih Referensi Pendampingan</option>
                                                                    <?= $count = 1; ?>
                                                                    <?php for ($i = 0; $i < count($kategori_difabel); $i++) : ?>
                                                                        <?php
                                                                        $isset = false;
                                                                        foreach ($skills_pendamping as $sp) {
                                                                            if ($sp['ref_pendampingan'] == $i + 1) {
                                                                                $isset = true;
                                                                            }
                                                                        } ?>
                                                                        <?php if ($isset) : ?>
                                                                            <?php continue; ?>
                                                                        <?php else : ?>
                                                                            <option value="<?= $kategori_difabel[$i]['id']; ?>"> <?= $count . '. ' . $kategori_difabel[$i]['jenis']; ?></option>
                                                                            <?php $count++; ?>
                                                                        <?php endif; ?>
                                                                    <?php endfor; ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <!--Prioritas-->
                                                        <div class="row mb-3">
                                                            <label for="mata_kuliah" class="col-sm-3 col-form-label">Prioritas</label>
                                                            <div class="col-sm-9">
                                                                <select class="form-select" aria-label="Default select example" name="prioritas" id="prioritas" autofocus required>
                                                                    <option selected>Pilih Prioritas Skill</option>
                                                                    <?php for ($i = 0; $i < count($skills_pendamping) + 1; $i++) : ?>
                                                                        <?php if (!empty($skills_pendamping[$i])) : ?>
                                                                            <?php foreach ($kategori_difabel as $key) : ?>
                                                                                <?php if ($key['id'] == $skills_pendamping[$i]['ref_pendampingan']) : ?>
                                                                                    <option value="<?= $skills_pendamping[$i]['prioritas']; ?>"><?= $skills_pendamping[$i]['prioritas'] . ' - ' . $key['jenis']; ?></option>
                                                                                <?php endif; ?>
                                                                            <?php endforeach; ?>
                                                                        <?php else : ?>
                                                                            <option value="<?= $i + 1; ?>" style="background-color: rgba(246, 239, 39, 0.54);"><?= 'Tambah prioritas ' . ($i + 1); ?></option>
                                                                        <?php endif; ?>
                                                                    <?php endfor; ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <!-- Submit -->
                                                        <div class="d-grid mt-3 gap-2 d-md-flex justify-content-md-end">
                                                            <button type="submit" class="btn btn-primary">Submit</button>
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

<?php if (!empty($skills_pendamping)) : ?>
    <?php foreach ($skills_pendamping as $sp) : ?>
        <?php foreach ($kategori_difabel as $kd) : ?>
            <?php if ($sp['ref_pendampingan'] == $kd['id']) : ?>

                <!-- Modal Delete Skill-->
                <div class="modal fade" id="delSkill<?= $sp['id_profile_pendamping'] . $sp['ref_pendampingan']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: darkred">
                                <h5 class="modal-title text-white" id="exampleModalLabel">Hapus Referensi Pendampingan <?= $kd['jenis'] ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="/c_profile_pendamping/delSkill" method="post">
                                <div class="modal-body">
                                    <div class="container-fluid">
                                        <input type="hidden" name="id_profile_pendamping" value="<?= $sp['id_profile_pendamping']; ?>">
                                        <input type="hidden" name="ref_pendampingan" value="<?= $sp['ref_pendampingan']; ?>">
                                        <input type="hidden" name="prioritas" value="<?= $sp['prioritas']; ?>">
                                        <p>Apakah anda yakin ingin menghapus skill referensi pendampingan ini?</p>
                                        <p>Jika iya, silahkan klik tombol <strong>"Hapus"</strong></p>
                                        <?= csrf_field(); ?>
                                        <!-- HTTP Spoofing -->
                                        <input type="hidden" name="_method" value="DELETE">
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">
                                        Hapus
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal Edit Skill-->
                <div class="modal fade" id="editSkill<?= $sp['id_profile_pendamping'] . $sp['ref_pendampingan']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">

                            <!-- Header -->
                            <div class="modal-header" style="background-color: gold;">
                                <h5 class="modal-title" id="exampleModalLabel" style=" color:black">Edit Referensi Pendampingan <?= $kd['jenis'] ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <?php
                            $skills_lama = [];
                            $jenis_lama = [];
                            for ($i = 0; $i < count($skills_pendamping); $i++) {
                                if (!empty($skills_pendamping[$i])) {
                                    foreach ($kategori_difabel as $key) {
                                        if ($key['id'] == $skills_pendamping[$i]['ref_pendampingan']) {
                                            $skills_lama[$i] = (string) $skills_pendamping[$i]['prioritas'];
                                            $jenis_lama[$i] = $key['jenis'];
                                        }
                                    }
                                }
                            };
                            ?>

                            <!-- Form -->
                            <form action="/c_profile_pendamping/editSkill" method="post">
                                <div class="modal-body">
                                    <?= csrf_field(); ?>
                                    <input type="hidden" name="nim" value="<?= user()->username; ?>">
                                    <input type="hidden" name="old_ref_pendampingan" value="<?= $kd['id']; ?>">
                                    <input type="hidden" name="old_prioritas" value="<?= $sp['prioritas']; ?>">

                                    <!--Referensi Pendampingan-->
                                    <div class="row mb-3">
                                        <label for="ref_pendampingan" class="col-sm-6 col-form-label">Referensi Pendampingan</label>
                                        <div class="col-sm-6">
                                            <select class="form-select" aria-label="Default select example" name="ref_pendampingan" id="ref_pendampingan" autofocus required>
                                                <option selected value="<?= $kd['id']; ?>" style="background-color: rgba(246, 239, 39, 0.54);"><?= $kd['jenis']; ?></option>
                                                <?= $count = 1; ?>
                                                <?php for ($i = 0; $i < count($kategori_difabel); $i++) : ?>
                                                    <?php
                                                    $isset = false;
                                                    foreach ($skills_pendamping as $key) {
                                                        if ($key['ref_pendampingan'] == $i + 1) {
                                                            $isset = true;
                                                        }
                                                    } ?>
                                                    <?php if ($isset) : ?>
                                                        <?php continue; ?>
                                                    <?php else : ?>
                                                        <option value=<?= $kategori_difabel[$i]['id']; ?>><?= $count . '. ' . $kategori_difabel[$i]['jenis']; ?>
                                                        </option>
                                                        <?php $count++; ?>
                                                    <?php endif; ?>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <!--Prioritas-->
                                    <div class="row mb-3">
                                        <label for="mata_kuliah" class="col-sm-6 col-form-label">Prioritas</label>
                                        <div class="col-sm-6">
                                            <select class="form-select" aria-label="Default select example" name="prioritas" id="prioritas" autofocus required>
                                                <?php for ($i = 0; $i < count($skills_pendamping); $i++) : ?>
                                                    <option value=<?= $skills_lama[$i]; ?> <?= ($skills_lama[$i] == $sp['prioritas']) ? 'selected' : ''; ?>><?= $skills_lama[$i] . ' - ' . $jenis_lama[$i]; ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
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
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endforeach; ?>
<?php endif; ?>
<?= $this->endSection(); ?>