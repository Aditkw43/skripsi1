<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid px-6 py-4">

    <!-- Top Profile -->
    <div class="row align-items-center">
        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
            <!-- Variabel session -->
            <?php
            $fail_kalender = session()->getFlashData('fail_kalender');
            $validasi_kalender = session()->getFlashData('validasi_kalender');
            $validasi_matkul_tanggal = session()->getFlashData('validasi_matkul_tanggal');
            $validasi_tanggal = session()->getFlashData('validasi_tanggal');
            $validasi_waktu = session()->getFlashData('validasi_waktu');
            $validasi_waktu_tidak_sesuai = session()->getFlashData('validasi_waktu_tidak_sesuai');
            ?>
            <!-- End Session -->
            <!-- Edit Profile -->
            <?php if (session()->getFlashData('profile_berhasil_diedit')) : ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashData('profile_berhasil_diedit'); ?>
                </div>
            <?php elseif (session()->getFlashData('profile_gagal_diedit')) : ?>
                <div class="alert alert-warning" role="alert">
                    <?= session()->getFlashData('profile_gagal_diedit'); ?>
                </div>
            <?php endif; ?>
            <!-- End Edit Profile -->
            <!-- Skills Pendamping -->
            <?php if (session()->getFlashData('berhasil_ditambahkan')) : ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashData('berhasil_ditambahkan'); ?>
                </div>
            <?php elseif (session()->getFlashData('gagal_ditambahkan')) : ?>
                <div class="alert alert-warning" role="alert">
                    <?= session()->getFlashData('gagal_ditambahkan'); ?>
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
            <!-- End Skills Pendamping -->
            <!-- Bg -->
            <div class="pt-20 rounded-top" style="background:
                url(../assets/images/background/profile-cover.jpg) no-repeat;
                background-size: cover;">
            </div>

            <!-- Top Profile -->
            <div class="bg-white rounded-bottom smooth-shadow-sm ">
                <div class="d-flex align-items-center justify-content-between pt-4 pb-6 px-4">
                    <div class="d-flex align-items-center">

                        <!-- avatar -->
                        <div class="avatar-xxl me-2 position-relative d-flex justify-content-end align-items-end mt-n10">
                            <img src="/assets/images/avatar/avatar-<?= in_groups('admin') ? '1' : (in_groups('madif') ? '2' : '3') ?>.jpg" class="avatar-xxl rounded-circle border border-4 border-white-color-40" alt="">
                        </div>

                        <!-- text -->
                        <div class="lh-1">
                            <h2 class="mb-0"><?= $biodata['fullname']; ?>
                                <a href="#!" class="text-decoration-none" data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="Beginner">
                                </a>
                            </h2>
                            <p class="mb-2 d-block"><?= (!in_groups('admin') ? 'NIM : ' : 'Username : '); ?><?= $user->username; ?></p>

                            <p class="mb-0 btn <?= (!in_groups('admin') ?  ((in_groups('madif') ? 'btn-success' : 'btn-danger ')) : 'btn-primary '); ?> btn-sm"><?= (!in_groups('admin') ?  ((in_groups('madif') ? 'Mahasiswa Difabel ' : 'Pendamping ')) : 'Admin '); ?></p>
                            <?php if (in_groups('madif')) : ?>
                                ->
                                <p class="d-inline-flex btn-primary btn-sm"><?= $kategori_difabel[$jenis_madif['id_jenis_difabel'] - 1]['jenis']; ?></p>
                            <?php elseif (in_groups('admin')) : ?>
                                ->
                                <p class="d-inline-flex btn-success btn-sm"><?= $profile['jabatan']; ?></p>
                            <?php endif; ?>
                        </div>

                    </div>
                    <div>
                        <button type="button" class="btn btn-outline-primary d-none d-md-block" data-bs-toggle="modal" data-bs-target="#editProfile">Edit Profile</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- content -->
    <div class="py-6">
        <!-- row -->
        <div class="row <?= (in_groups('admin') || in_groups('madif')) ? 'd-flex justify-content-center' : '' ?>">

            <!-- Data User -->
            <div class="col-xl-12 col-lg-12 col-md-12 col-12 mb-6">
                <!-- card -->
                <div class="card">
                    <!-- Card Header -->
                    <h4 class="card-header text-center">
                        Data User
                    </h4>

                    <!-- card body -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 mb-5">
                                <h6 class="text-uppercase fs-5 ls-2"><?= (!in_groups('admin') ? 'NIM ' : 'Username '); ?> </h6>
                                <p class="mb-0"><?= $user->username; ?></p>
                            </div>

                            <div class="col-4 mb-5">
                                <!-- text -->
                                <h6 class="text-uppercase fs-5 ls-2">Email </h6>
                                <p class="mb-0"><?= $user->email; ?></p>
                            </div>

                            <?php if (in_groups('admin')) : ?>
                                <div class="col-4 mb-5">
                                    <h6 class="text-uppercase fs-5 ls-2">Jabatan </h6>
                                    <p class="mb-0"><?= $profile['jabatan']; ?></p>
                                </div>
                            <?php endif; ?>

                            <?php if (!in_groups('admin')) : ?>
                                <div class="col-4 mb-5">
                                    <h6 class="text-uppercase fs-5 ls-2">Fakultas </h6>
                                    <p class="mb-0"><?= $profile['fakultas']; ?></p>
                                </div>
                                <div class="col-4 mb-5">
                                    <h6 class="text-uppercase fs-5 ls-2">Jurusan </h6>
                                    <p class="mb-0"><?= $profile['jurusan']; ?></p>
                                </div>

                                <div class="col-4 mb-5">
                                    <h6 class="text-uppercase fs-5 ls-2">Program Studi </h6>
                                    <p class="mb-0"><?= $profile['prodi']; ?></p>
                                </div>
                                <div class="col-4 mb-5">
                                    <h6 class="text-uppercase fs-5 ls-2">Semester </h6>
                                    <p class="mb-0"><?= $profile['semester']; ?></p>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Selain Pendamping -->
            <?php if (!in_groups('pendamping')) : ?>
                <!-- Biodata -->
                <div class="col-xl-12 col-lg-12 col-md-12 col-12 mb-6">
                    <!-- card -->
                    <div class="card">
                        <!-- Card Header -->
                        <h4 class="card-header text-center">
                            Biodata
                        </h4>

                        <!-- card body -->
                        <div class="card-body">
                            <div class="row">

                                <div class="col-3 mb-5">
                                    <h6 class="text-uppercase fs-5 ls-2">Nama Lengkap </h6>
                                    <p class="mb-0"><?= $biodata['fullname']; ?></p>
                                </div>
                                <div class="col-3 mb-5">
                                    <h6 class="text-uppercase fs-5 ls-2">Nama Panggilan </h6>
                                    <p class="mb-0"><?= $biodata['nickname']; ?></p>
                                </div>

                                <div class="col-3 mb-5">
                                    <h6 class="text-uppercase fs-5 ls-2">Jenis Kelamin </h6>
                                    <p class="mb-0"><?= ($biodata['jenis_kelamin'] == 1) ? 'Laki-laki' : 'Perempuan'; ?></p>
                                </div>

                                <div class="col-3 mb-5">
                                    <h6 class="text-uppercase fs-5 ls-2">Nomor HP </h6>
                                    <p class="mb-0"><?= $biodata['nomor_hp']; ?></p>
                                </div>

                                <div class="col-12 text-center">
                                    <!-- text -->
                                    <h6 class="text-uppercase fs-5 ls-2">Alamat
                                    </h6>
                                    <p class="mb-0"><?= $biodata['alamat']; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Profile Pendamping -->
            <?php if (in_groups('pendamping')) : ?>
                <!-- Biodata -->
                <div class="col-xl-6 col-lg-12 col-md-12 col-12 mb-6">
                    <!-- card -->
                    <div class="card">
                        <!-- Card Header -->
                        <h4 class="card-header text-center">
                            Biodata
                        </h4>

                        <!-- card body -->
                        <div class="card-body">
                            <div class="row">

                                <div class="col-6 mb-5">
                                    <h6 class="text-uppercase fs-5 ls-2">Nama Lengkap </h6>
                                    <p class="mb-0"><?= $biodata['fullname']; ?></p>
                                </div>
                                <div class="col-6 mb-5">
                                    <h6 class="text-uppercase fs-5 ls-2">Nama Panggilan </h6>
                                    <p class="mb-0"><?= $biodata['nickname']; ?></p>
                                </div>

                                <div class="col-6 mb-5">
                                    <h6 class="text-uppercase fs-5 ls-2">Jenis Kelamin </h6>
                                    <p class="mb-0"><?= ($biodata['jenis_kelamin'] == 1) ? 'Laki-laki' : 'Perempuan'; ?></p>
                                </div>

                                <div class="col-6 mb-5">
                                    <h6 class="text-uppercase fs-5 ls-2">Nomor HP </h6>
                                    <p class="mb-0"><?= $biodata['nomor_hp']; ?></p>
                                </div>

                                <div class="col-12 <?= !(in_groups('pendamping')) ? 'text-center' : ''; ?>">
                                    <!-- text -->
                                    <h6 class="text-uppercase fs-5 ls-2">Alamat
                                    </h6>
                                    <p class="mb-0"><?= $biodata['alamat']; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Daftar Skill -->
                <div class="col-xl-6 col-lg-12 col-md-12 col-12 mb-6">
                    <!-- card -->
                    <div class="card">
                        <!-- card title -->
                        <ul class="card-header nav nav-line-bottom d-flex justify-content-between align-items-center" id="pills-tab-table" role="tablist">
                            <li class="nav-item">
                                <h4 class="card-title">Daftar Skills <?= $biodata['nickname']; ?></h4>
                            </li>
                            <li class="nav-item">
                                <button type="submit" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#tambahSkill">Tambah Skill</button>
                            </li>
                        </ul>
                        <!-- card body -->
                        <div class="card-body">
                            <!-- Basic table -->
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="text-center">
                                        <tr>
                                            <th scope="col">Prioritas</th>
                                            <th scope="col">Referensi Pendampingan</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        <?php foreach ($skills as $s) : ?>
                                            <tr class="align-middle">
                                                <td class="text-center"><?= $s['prioritas']; ?></td>

                                                <td class="text-center"><?= $kategori_difabel[$s['ref_pendampingan'] - 1]['jenis'] ?></td>

                                                <?php if (!isset($s['approval'])) : ?>
                                                    <td class="text-center" style="color:orange">Menunggu Verifikasi</td>
                                                <?php elseif ($s['approval'] == true) : ?>
                                                    <td class="text-center" style="color:green">Terverifikasi</td>
                                                <?php else : ?>
                                                    <td class="text-center" style="color:red">Ditolak</td>
                                                <?php endif ?>

                                                <td>
                                                    <!-- Button trigger modal Detail Jadwal Ujian -->
                                                    <button type="button" class="btn btn-<?= ($s['approval'] == '0') ? 'info' : 'warning'; ?> btn-sm editJadwal" data-bs-toggle="modal" data-bs-target="#editSkill<?= $s['id_profile_pendamping'] . $s['ref_pendampingan']; ?>" ?>
                                                        <i class="fas <?= ($s['approval'] == '0') ? 'fa-exchange-alt' : 'fa-pen-square'; ?> "></i>
                                                    </button>

                                                    <!-- Button Trigger Modal Hapus Jadwal Ujian -->
                                                    <button type="submit" class="btn btn-danger btn-sm my-1" data-bs-toggle="modal" data-bs-target="#delSkill<?= $s['id_profile_pendamping'] . $s['ref_pendampingan']; ?>">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php if (!empty($skills)) : ?>
    <?php foreach ($skills as $sp) : ?>
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
                            <?php if ($sp['approval'] == '0') : ?>
                                <div class="modal-header" style="background-color: cyan;">
                                    <h5 class="modal-title" id="exampleModalLabel" style=" color:black">Ganti Referensi Pendampingan <?= $kd['jenis'] ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                            <?php else : ?>
                                <div class="modal-header" style="background-color: gold;">
                                    <h5 class="modal-title" id="exampleModalLabel" style=" color:black">Edit Referensi Pendampingan <?= $kd['jenis'] ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>

                            <?php
                            $skills_lama = [];
                            $jenis_lama = [];
                            for ($i = 0; $i < count($skills); $i++) {
                                if (!empty($skills[$i])) {
                                    foreach ($kategori_difabel as $key) {
                                        if ($key['id'] == $skills[$i]['ref_pendampingan']) {
                                            $skills_lama[$i] = (string) $skills[$i]['prioritas'];
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

                                    <!-- NIM -->
                                    <input type="hidden" name="id_profile_pendamping" value="<?= $profile['id_profile_mhs']; ?>">

                                    <!-- Approval -->
                                    <input type="hidden" name="approval" value="<?= $sp['approval']; ?>">

                                    <!-- Old Referensi Pendampingan-->
                                    <input type="hidden" name="old_ref_pendampingan" value="<?= $kd['id']; ?>">

                                    <!-- Old Prioritas -->
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
                                                    foreach ($skills as $key) {
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
                                                <?php for ($i = 0; $i < count($skills); $i++) : ?>
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

<!-- Tambah Skill Pendamping -->
<?php if (in_groups('pendamping')) : ?>
    <!-- Modal Tambah Skill-->
    <div class="modal fade" id="tambahSkill" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Header -->
                <div class="modal-header" style="background-color: rgba(11, 64, 117, 1);">
                    <h5 class="modal-title" id="exampleModalLabel" style=" color:white">Tambah Skill Pendamping</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Form -->
                <form action="/c_profile_pendamping/saveSkill" method="POST">
                    <div class="modal-body">
                        <?= csrf_field(); ?>

                        <!-- id_profile_pendamping -->
                        <input type="hidden" name="id_profile_pendamping" value="<?= $profile['id_profile_mhs']; ?>">

                        <!--Referensi Pendampingan-->
                        <div class="row mb-3">
                            <label for="ref_pendampingan" class="col-sm-6 col-form-label">Referensi Pendampingan</label>
                            <div class="col-sm-6">
                                <select class="form-select" aria-label="Default select example" name="ref_pendampingan" id="ref_pendampingan" autofocus required>
                                    <option value='0' selected>Pilih Referensi Pendampingan</option>
                                    <?= $count = 1; ?>
                                    <?php for ($i = 0; $i < count($kategori_difabel); $i++) : ?>
                                        <?php
                                        $isset = false;
                                        foreach ($skills as $sp) {
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
                            <label for="mata_kuliah" class="col-sm-6 col-form-label">Prioritas</label>
                            <div class="col-sm-6">
                                <select class="form-select" aria-label="Default select example" name="prioritas" id="prioritas" autofocus required>
                                    <option value='0' selected>Pilih Prioritas Skill</option>
                                    <?php for ($i = 0; $i < count($skills) + 1; $i++) : ?>
                                        <?php if (!empty($skills[$i])) : ?>
                                            <?php foreach ($kategori_difabel as $key) : ?>
                                                <?php if ($key['id'] == $skills[$i]['ref_pendampingan']) : ?>
                                                    <option value="<?= $skills[$i]['prioritas']; ?>"><?= $skills[$i]['prioritas'] . ' - ' . $key['jenis']; ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <option value="<?= $i + 1; ?>" style="background-color: rgba(246, 239, 39, 0.54);"><?= 'Tambah prioritas ke-' . ($i + 1); ?></option>
                                        <?php endif; ?>
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

<!-- Modal Edit Profile-->
<div class="modal fade" id="editProfile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header" style="background-color: rgba(0, 136, 120, 1)">
                <h5 class="modal-title" id="exampleModalLabel" style=" color:white">Edit Profile <?= $biodata['nickname']; ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Form -->
            <form action="/c_user/updateProfile" method="POST">
                <div class="modal-body">

                    <!-- NIM atau USERNAME -->
                    <div class="mb-0 row">
                        <label for="staticUsername" class="col-sm-2 col-form-label"><?= ($user->name == 'admin') ? 'Username' : 'NIM'; ?></label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control-plaintext" id="staticUsername" value="<?= $user->username; ?>" name="username">
                        </div>
                    </div>
                    <!-- EMAIL -->
                    <div class="mb-0 row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" readonly class="form-control-plaintext" id="staticEmail" value="<?= $user->email; ?>" name="email">
                        </div>
                    </div>
                    <!-- ROLE -->
                    <div class="mb-2 row">
                        <label for="staticRole" class="col-sm-2 col-form-label">Role</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control-plaintext" id="staticRole" value="<?= $user->name; ?>" placeholder="<?= ($user->name == 'admin') ? 'Admin' : (($user->name == 'madif') ? 'Mahasiswa Difabel' : 'Pendamping'); ?>" name='role'>
                        </div>
                    </div>

                    <!-- Jabatan -->
                    <?php if (in_groups('admin')) : ?>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" placeholder="<?= $profile['jabatan']; ?>" value="<?= $profile['jabatan']; ?>" name="jabatan">
                            <label for="floatingInput">Jabatan</label>
                        </div>
                    <?php endif; ?>

                    <!-- Jenis Mahasiswa Difabel -->
                    <?php if (in_groups('madif')) : ?>
                        <div class="form-floating mb-2">
                            <select class="form-select <?= ($jenis_madif['approval'] == null || $jenis_madif['approval'] == '0') ? 'is-invalid' : ''; ?>" aria-label="Default select example" name="jenis_madif" id="floatingInput" autofocus required>
                                <?php for ($i = 0; $i < count($kategori_difabel); $i++) : ?>
                                    <option value=<?= $kategori_difabel[$i]['id']; ?> <?= ($kategori_difabel[$i]['id'] == $jenis_madif['id_jenis_difabel']) ? 'selected' : ''; ?>><?= $i + 1 . '. ' . $kategori_difabel[$i]['jenis']; ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                            <label for="floatingInput">Jenis Difabel</label>
                            <?php if ($jenis_madif['approval'] == null) : ?>
                                <div class="invalid-feedback" style="color:blue">*Menunggu Verifikasi dari Admin</div>
                            <?php elseif ($jenis_madif['approval'] == '0') : ?>
                                <div class="invalid-feedback">*Jenis Difabel Ditolak Admin</div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Nama Lengkap dan Nama Panggilan -->
                    <div class="row g-2 mb-2">
                        <div class="col-md">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingInputGrid" placeholder="<?= $biodata['fullname']; ?>" value="<?= $biodata['fullname']; ?>" name="fullname">
                                <label for="floatingInputGrid">Nama Lengkap</label>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingInputGrid" placeholder="<?= $biodata['nickname']; ?>" value="<?= $biodata['nickname']; ?>" name="nickname">
                                <label for="floatingInputGrid">Nama Panggilan</label>
                            </div>
                        </div>
                    </div>

                    <?php if (!in_groups('admin')) : ?>
                        <!-- Fakultas dan Jurusan -->
                        <div class="row g-2 mb-2">
                            <div class="col-md">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="floatingInputGrid" placeholder="<?= $profile['fakultas']; ?>" value="<?= $profile['fakultas']; ?>" name="fakultas">
                                    <label for="floatingInputGrid">Fakultas</label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="floatingInputGrid" placeholder="<?= $profile['jurusan']; ?>" value="<?= $profile['jurusan']; ?>" name="jurusan">
                                    <label for="floatingInputGrid">Jurusan</label>
                                </div>
                            </div>
                        </div>

                        <!-- Prodi dan Semester -->
                        <div class="row g-2 mb-2">
                            <div class="col-md">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="floatingInputGrid" placeholder="<?= $profile['prodi']; ?>" value="<?= $profile['prodi']; ?>" name="prodi">
                                    <label for="floatingInputGrid">Program Studi</label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="floatingInputGrid" placeholder="<?= $profile['semester']; ?>" value="<?= $profile['semester']; ?>" name="semester">
                                    <label for="floatingInputGrid">Semester</label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Jenis Kelamin dan Nomor HP -->
                    <div class="row g-2 mb-2">
                        <div class="col-md">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example" name="jenis_kelamin">
                                    <option value="9" <?= ($biodata['jenis_kelamin'] == null) ? 'selected' : ''; ?>>Pilih Jenis Kelamin</option>
                                    <option value="1" <?= ($biodata['jenis_kelamin'] == 1) ? 'selected' : ''; ?>>Laki-laki</option>
                                    <option value="0" <?= ($biodata['jenis_kelamin'] == 0) ? 'selected' : ''; ?>>Perempuan</option>
                                </select>
                                <label for="floatingSelectGrid">Jenis Kelamin</label>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingInputGrid" placeholder="<?= $biodata['nomor_hp']; ?>" value="<?= $biodata['nomor_hp']; ?>" name="nomor_hp">
                                <label for="floatingInputGrid">Nomor HP</label>
                            </div>
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" placeholder="<?= $biodata['alamat']; ?>" value="<?= $biodata['alamat']; ?>" name="alamat">
                        <label for="floatingInput">Alamat</label>
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

<?= $this->endSection('page-content'); ?>