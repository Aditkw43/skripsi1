<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid px-6 py-4">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="row mb-6">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <!-- Edit User -->
                    <?php if (session()->getFlashData('user_berhasil_diedit')) : ?>
                        <div class="alert alert-success" role="alert">
                            <?= session()->getFlashData('user_berhasil_diedit'); ?>
                        </div>
                    <?php elseif (session()->getFlashData('user_berhasil_dihapus')) : ?>
                        <div class="alert alert-success" role="alert">
                            <?= session()->getFlashData('user_berhasil_dihapus'); ?>
                        </div>
                    <?php elseif (session()->getFlashData('user_gagal_diedit')) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?= session()->getFlashData('user_gagal_diedit'); ?>
                        </div>
                    <?php endif; ?>
                    <!-- End Edit User -->

                    <!-- Tambah User -->
                    <?php if (session()->getFlashData('berhasil')) : ?>
                        <div class="alert alert-success" role="alert">
                            <?= session()->getFlashData('berhasil'); ?>
                        </div>
                    <?php elseif (session()->getFlashData('errors')) : ?>
                        <?= view('Myth\Auth\Views\_message_block') ?>
                    <?php endif; ?>
                    <!-- END User -->

                    <div class="mb-2 mt-2 d-flex justify-content-lg-between align-content-center">
                        <h2><?= $title; ?></h2>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#tambahUser">
                            Tambah User Admin
                        </button>
                    </div>

                    <!-- Basic table -->
                    <div class="table-responsive">
                        <table class="table table-light" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                            <thead class="text-center">
                                <tr>
                                    <th scope="col">Total User Admin</th>
                                </tr>
                            </thead>
                            <tbody class="text-center table-light">
                                <tr>
                                    <td><?= count($admin); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Basic table -->
                    <div class="table-responsive">
                        <table class="table table-hover table-dark" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Jabatan</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="table-light">

                                <?php $i = 1 ?>
                                <?php foreach ($admin as $ad) : ?>
                                    <tr class="align-middle">
                                        <th scope="row"><?= $i; ?></th>
                                        <td><?= $ad['nickname']; ?></td>
                                        <td><?= $ad['jabatan']; ?></td>
                                        <td>
                                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editUser<?= $ad['id_profile_admin']; ?>" onclick="modal">
                                                Edit
                                            </button>

                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delUser<?= $ad['id_profile_admin']; ?>" ?>
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (isset($admin)) : ?>
    <!-- Modal Tambah User Admin-->
    <div class="modal fade" id="tambahUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

                <!-- Header -->
                <div class="modal-header" style="background-color: rgba(0, 136, 120, 1)">
                    <h5 class="modal-title" id="exampleModalLabel" style=" color:white">Tambah User Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>


                <form action="<?= route_to('register') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <!-- Penanda User Management  -->
                                <input type="hidden" name="user_management" value="true">

                                <!-- Role -->
                                <input type="hidden" name="role" value="admin">

                                <h2 class="text-center mb-3">Form User</h2>

                                <div class="row d-flex justify-content-center">
                                    <!-- Email -->
                                    <div class="col-auto mb-3">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control " name="email" aria-describedby="emailHelp" placeholder="Email" value="">
                                        </div>
                                    </div>
                                    <!-- Username -->
                                    <div class="col-auto mb-3">
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input type="text" class="form-control " name="username" placeholder="Username" value="">
                                        </div>
                                    </div>
                                </div>

                                <div class="row d-flex justify-content-center">
                                    <!-- Password -->
                                    <div class="col-auto mb-3">
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" name="password" class="form-control " placeholder="Password" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-auto mb-3">
                                        <div class="form-group">
                                            <label for="pass_confirm">Repeat Password</label>
                                            <input type="password" name="pass_confirm" class="form-control " placeholder="Repeat Password" autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                                <h2 class="text-center my-3">Form Biodata</h2>
                                <!-- Jenis Kelamin-->
                                <div class="row d-flex justify-content-center">
                                    <div class="col-auto mb-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="laki-laki" value="1">
                                            <label class="form-check-label" for="laki-laki">Laki-laki</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan" value="0">
                                            <label class="form-check-label" for="perempuan">Perempuan</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Jabatan-->
                                <div class="row d-flex justify-content-center">
                                    <div class="col-auto mb-3">
                                        <div class="form-group">
                                            <input type="text" name="jabatan" class="form-control form-control-user" placeholder="Masukkan jabatan..." required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Nama Lengkap dan Panggilan -->
                                <div class="row d-flex justify-content-center">
                                    <div class="col-auto mb-3">
                                        <div class="form-group">
                                            <input type="text" name="nickname" class="form-control form-control-user" placeholder="Panggilan" required>
                                        </div>
                                    </div>
                                    <div class="col-auto mb-3">
                                        <div class="form-group">
                                            <input type="text" name="fullname" class="form-control form-control-user" placeholder="Nama lengkap..." required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Alamat dan Nomor -->
                                <div class="row d-flex justify-content-center">
                                    <div class="col-auto mb-3">
                                        <div class="form-row">
                                            <input type="text" name="alamat" class="form-control form-control-user" placeholder="Alamat malang..." required>
                                        </div>
                                    </div>
                                    <div class="col-auto mb-3">
                                        <div class="form-row">
                                            <input type="text" name="nomor_hp" class="form-control form-control-user" placeholder="Nomor HP (aktif)" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-success">
                                        Simpan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php foreach ($admin as $key1) : ?>
        <!-- Modal Edit Admin-->
        <div class="modal fade" id="editUser<?= $key1['id_profile_admin']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Header -->
                    <div class="modal-header" style="background-color: #ffca2c">
                        <h5 class="modal-title" id="exampleModalLabel">Edit User <?= $key1['nickname']; ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Form -->
                    <form action="/c_user/updateProfile" method="POST">
                        <div class="modal-body">

                            <!-- Usermanagement Sign -->
                            <input type="hidden" name="user_management" value="true">
                            <!-- Role -->
                            <input type="hidden" name="role" value="admin">

                            <!-- USERNAME -->
                            <div class="row g-2 d-flex justify-content-md-center mb-3 text-center">
                                <div class="col">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control-plaintext text-center" id="username" placeholder="name@example.com" value="<?= $key1['username']; ?>" name="username" readonly>
                                </div>

                                <!-- EMAIL -->
                                <div class="col">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control-plaintext text-center" id="email" placeholder="name@example.com" value="<?= $key1['email']; ?>" name="email" readonly>
                                </div>
                            </div>

                            <!-- Jabatan -->
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingInput" placeholder="Jabatan user..." value="<?= $key1['jabatan']; ?>" name="jabatan">
                                <label for="floatingInput">Jabatan User</label>
                            </div>

                            <!-- Nama Lengkap dan Nama Panggilan -->
                            <div class="row g-2 mb-2">
                                <div class="col-md">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="floatingInputGrid" placeholder="<?= $key1['fullname']; ?>" value="<?= $key1['fullname']; ?>" name="fullname">
                                        <label for="floatingInputGrid">Nama Lengkap</label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="floatingInputGrid" placeholder="<?= $key1['nickname']; ?>" value="<?= $key1['nickname']; ?>" name="nickname">
                                        <label for="floatingInputGrid">Nama Panggilan</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Jenis Kelamin dan Nomor HP -->
                            <div class="row g-2 mb-2">
                                <div class="col-md">
                                    <div class="form-floating">
                                        <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example" name="jenis_kelamin">
                                            <option value="null" <?= ($key1['jenis_kelamin'] == null) ? 'selected' : ''; ?>>Pilih Jenis Kelamin</option>
                                            <option value="1" <?= ($key1['jenis_kelamin'] == 1) ? 'selected' : ''; ?>>Laki-laki</option>
                                            <option value="0" <?= ($key1['jenis_kelamin'] == 0) ? 'selected' : ''; ?>>Perempuan</option>
                                        </select>
                                        <label for="floatingSelectGrid">Jenis Kelamin</label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="floatingInputGrid" placeholder="Masukkan nomor HP..." value="<?= $key1['nomor_hp']; ?>" name="nomor_hp">
                                        <label for="floatingInputGrid">Nomor HP</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Alamat -->
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingInput" placeholder="Alamat user..." value="<?= $key1['alamat']; ?>" name="alamat">
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

        <!-- Modal Delete User-->
        <div class="modal fade" id="delUser<?= $key1['id_profile_admin']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: darkred">
                        <h5 class="modal-title text-white" id="exampleModalLabel">Hapus <?= $key1['nickname']; ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="/c_user/delUser" method="post">
                        <div class="modal-body">
                            <div class="container-fluid">
                                <p>Apakah anda yakin ingin menghapus user admin <?= $key1['nickname']; ?> ini?</p>
                                <p>Jika iya, silahkan klik tombol <strong>"Hapus"</strong></p>
                                <?= csrf_field(); ?>
                                <!-- HTTP Spoofing -->
                                <input type="hidden" name="_method" value="DELETE">
                            </div>
                        </div>

                        <input type="hidden" name="role" value="admin">
                        <input type="hidden" name="username" value="<?= $key1['username']; ?>">

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
    <?php endforeach; ?>
<?php endif; ?>

<?= $this->endSection(); ?>