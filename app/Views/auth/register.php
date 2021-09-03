<?= $this->extend("auth/templatesLogin/index"); ?>
<?= $this->section('auth-content'); ?>

<?php

use App\Models\m_profile_mhs;

$kategori_difabel = model(m_profile_mhs::class);
$daftar_jenis = $kategori_difabel->getAllKategoriDifabel();

?>


<div class="page-content">
    <div class="form-v10-content">
        <?= view('Myth\Auth\Views\_message_block') ?>

        <form class="form-detail" action="<?= route_to('register') ?>" method="post" id="myform">

            <!-- Form Kiri -->
            <div class="form-left">
                <h2>Registrasi Akun</h2>

                <!-- Role -->
                <div class="form-row">

                    <?php $madif = false ?>
                    <select name="role" onchange="showDiv('hidden_jenis_madif', this)" required>
                        <option class="option" value="">Role...</option>
                        <option class="option" value="madif">Mahasiswa Difabel</option>
                        <option class="option" value="pendamping">Pendamping</option>
                    </select>

                    <span class="select-btn">
                        <i class="zmdi zmdi-chevron-down"></i>
                    </span>
                </div>

                <!-- Jenis Difabel -->
                <div class="form-row" id="hidden_jenis_madif">
                    <?php $madif = false ?>
                    <select name="jenis_difabel" required>
                        <option value="0" selected>Pilih jenis difabel...</option>
                        <?php for ($i = 0; $i < count($daftar_jenis); $i++) : ?>
                            <option value=<?= $daftar_jenis[$i]['id']; ?>><?= $i + 1 . '. ' . $daftar_jenis[$i]['jenis']; ?>
                            </option>
                        <?php endfor; ?>
                    </select>

                    <span class="select-btn">
                        <i class="zmdi zmdi-chevron-down"></i>
                    </span>
                </div>

                <!-- NIM -->
                <div class="form-row">
                    <input type="text" class="form-control form-control-user <?php if (session('errors.username')) : ?>is-invalid<?php endif ?>" name="username" placeholder="NIM..." value="<?= old('username') ?>" required>
                </div>

                <!-- Email -->
                <div class=" form-row">
                    <input type="email" name="email" class="form-control form-control-user <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" aria-describedby="emailHelp" placeholder="example@email.com" pattern="[^@]+@[^@]+.[a-zA-Z]{2,6}" value="<?= old('email') ?>" required>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <div class="form-row form-row-1">
                        <input type="password" name="password" class="form-control form-control-user <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="Password Anda..." autocomplete="off" required>
                    </div>
                    <div class="form-row form-row-2">
                        <input type="password" name="pass_confirm" class="form-control form-control-user <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" placeholder="Ulangi Password..." autocomplete="off" required>
                    </div>
                </div>

                <div class="text-center">
                    <p><a class="small" href="<?= route_to('login') ?>" style="text-decoration: none;">Sudah punya akun? Login</a></p>
                </div>
            </div>

            <!-- Form Kanan -->
            <div class="form-right">
                <h2>Form Data Diri</h2>

                <!-- Nama Lengkap dan Panggilan -->
                <div class="form-group">
                    <div class="form-row form-row-1">
                        <input type="text" name="nickname" class="form-control form-control-user" placeholder="Panggilan" required>
                    </div>
                    <div class="form-row form-row-2">
                        <input type="text" name="fullname" class="form-control form-control-user" placeholder="Nama lengkap..." required>
                    </div>
                </div>

                <!-- Jenis Kelamin-->
                <div class="form-row">
                    <select name="jenis_kelamin">
                        <option class="option" value="">Jenis Kelamin</option>
                        <option class="option" value="1">Laki-laki</option>
                        <option class="option" value="0">Perempuan</option>
                    </select>

                    <span class="select-btn">
                        <i class="zmdi zmdi-chevron-down"></i>
                    </span>
                </div>

                <!-- Fakultas-->
                <div class="form-row">
                    <input type="text" name="fakultas" class="form-control form-control-user" placeholder="Fakultas..." required>
                </div>
                <!-- Jurusan-->
                <div class="form-row">
                    <input type="text" name="jurusan" class="form-control form-control-user" placeholder="Jurusan..." required>
                </div>
                <!-- Prodi-->
                <div class="form-row">
                    <input type="text" name="prodi" class="form-control form-control-user" placeholder="Program Studi..." required>
                </div>

                <!-- Semester-->
                <div class="form-row">
                    <input type="number" name="semester" class="form-control form-control-user" placeholder="Semester..." required>
                </div>

                <!-- Alamat Malang -->
                <div class="form-row">
                    <input type="text" name="alamat" class="form-control form-control-user" placeholder="Alamat malang..." required>
                </div>
                <!-- Nomor HP -->
                <div class="form-row">
                    <input type="text" name="nomor_hp" class="form-control form-control-user" placeholder="Nomor HP (aktif)" required>
                </div>

                <!-- Tombol Submit -->
                <div class="form-row-last">
                    <input type="submit" name="register" class="register d-inline" value=" <?= lang('Auth.register') ?>">
                </div>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>