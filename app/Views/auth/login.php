<?= $this->extend("auth/templatesLogin/index"); ?>
<?= $this->section('auth-content'); ?>

<div class="wrapper">
    <h2 class="judul">Sistem Pendampingan Ujian</h2>
    <div class="card">

        <form action="<?= route_to('login') ?>" method="post" class="flex-column">
            <?= csrf_field() ?>
            <div class="h3 text-center text-white">Login</div>
            <?= view('Myth\Auth\Views\_message_block') ?>

            <!-- Input NIM atau Email -->
            <?php if ($config->validFields === ['email']) : ?>
                <div class="d-flex align-items-center input-field my-3 mb-4">
                    <span class="far fa-user p-2"></span>
                    <input type="email" placeholder="NIM atau Email" required class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>" name="login">
                    <div class="invalid-feedback">
                        <?= session('errors.login') ?>
                    </div>
                </div>
            <?php else : ?>
                <div class="d-flex align-items-center input-field my-3 mb-4">
                    <span class="far fa-user p-2"></span>
                    <input type="text" placeholder="NIM atau Email" required class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>" name="login">
                    <div class="invalid-feedback">
                        <?= session('errors.login') ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Input Password -->
            <div class="d-flex align-items-center input-field mb-4">
                <span class="fas fa-lock p-2"></span>
                <input type="password" placeholder="Password" required class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" id="pwd" name="password">
                <button class="btn" onclick="showPassword()">
                </button>
                <div class="invalid-feedback">
                    <?= session('errors.password') ?>
                </div>
            </div>

            <div class="my-3 text-center">
                <input type="submit" value="Login" class="btn btn-primary">
            </div>
            <?php if ($config->allowRegistration) : ?>
                <div class="mb-3 text-center">
                    <span class="text-light-white">Tidak punya akun?</span>
                    <a href="<?= route_to('register') ?>"><strong> Sign Up</strong></a>
                </div>
            <?php endif; ?>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>