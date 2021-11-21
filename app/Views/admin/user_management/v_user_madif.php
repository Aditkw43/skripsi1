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
                    <?php elseif (session()->getFlashData('tolak')) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?= session()->getFlashData('tolak'); ?>
                        </div>
                    <?php elseif (session()->getFlashData('errors')) : ?>
                        <?= view('Myth\Auth\Views\_message_block') ?>
                    <?php endif; ?>
                    <!-- END User -->
                    <div class="mb-2 mt-2 d-flex justify-content-lg-between align-content-center">
                        <h2><?= $title; ?></h2>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#tambahUser">
                            Tambah User Madif
                        </button>
                    </div>

                    <!-- Table count -->
                    <div class="table-responsive">
                        <table class="table table-light" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                            <thead class="text-center">
                                <tr>
                                    <th scope="col">Total Jumlah Madif</th>
                                    <th scope="col">Total Madif Aktif</th>
                                    <th scope="col">Total Madif Non-Aktif</th>
                                </tr>
                            </thead>
                            <tbody class="text-center table-light">
                                <tr>
                                    <td><?= count($madif); ?></td>
                                    <td><?= count($madif_aktif); ?></td>
                                    <td><?= count($madif_nonaktif); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Basic table -->
                    <div class="card">
                        <!-- Tab table -->
                        <ul class="nav nav-line-bottom" id="pills-tab-table" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-table-madif-aktif-tab" data-bs-toggle="pill" href="#pills-table-madif-aktif" role="tab" aria-controls="pills-table-madif-aktif" aria-selected="true">Mahasiswa Difabel Aktif</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-table-madif-tidak-aktif-tab" data-bs-toggle="pill" href="#pills-table-madif-tidak-aktif" role="tab" aria-controls="pills-table-madif-tidak-aktif" aria-selected="true">Mahasiswa Difabel Tidak Aktif</a>
                            </li>
                        </ul>

                        <!-- Tab content -->
                        <div class=" tab-content p-4" id="pills-tabContent-table">
                            <!-- Madif Aktif Table -->
                            <div class="tab-pane tab-example-design fade show active" id="pills-table-madif-aktif" role="tabpanel" aria-labelledby="pills-table-madif-aktif-tab">
                                <div class="table-responsive">
                                    <table class="table table-hover table-dark" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                                        <thead>
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Nama</th>
                                                <th scope="col">NIM</th>
                                                <th scope="col">Fakultas</th>
                                                <th scope="col">Semester</th>
                                                <th scope="col">Difabel</th>
                                                <th scope="col">Detail</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-light">

                                            <?php $i = 1 ?>
                                            <?php foreach ($madif_aktif as $ma) : ?>
                                                <tr class="align-middle">
                                                    <th scope="row"><?= $i; ?></th>
                                                    <td><?= $ma['nickname']; ?></td>
                                                    <td><?= $ma['nim']; ?></td>
                                                    <td><?= $ma['fakultas']; ?></td>
                                                    <td><?= $ma['semester']; ?></td>
                                                    <td style="color: <?= (($ma['approval_jenis_difabel']) ? '' : 'red'); ?>"><?= $ma['jenis_difabel']; ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editUser<?= $ma['id_profile_mhs']; ?>" onclick="modal">
                                                            Edit
                                                        </button>

                                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delUser<?= $ma['id_profile_mhs']; ?>" ?>
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

                            <!-- Madif Tidak Aktif Table -->
                            <div class="tab-pane tab-example-design fade" id="pills-table-madif-tidak-aktif" role="tabpanel" aria-labelledby="pills-table-madif-tidak-aktif-tab">
                                <div class="table-responsive">
                                    <table class="table table-hover table-dark" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                                        <thead>
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Nama</th>
                                                <th scope="col">NIM</th>
                                                <th scope="col">Fakultas</th>
                                                <th scope="col">Semester</th>
                                                <th scope="col">Difabel</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Detail</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-light">

                                            <?php $i = 1 ?>
                                            <?php foreach ($madif_nonaktif as $mn) : ?>
                                                <tr class="align-middle">
                                                    <th scope="row"><?= $i; ?></th>
                                                    <td><?= $mn['nickname']; ?></td>
                                                    <td><?= $mn['nim']; ?></td>
                                                    <td><?= $mn['fakultas']; ?></td>
                                                    <td><?= $mn['semester']; ?></td>
                                                    <td><?= $mn['jenis_difabel']; ?></td>
                                                    <td>
                                                        <a href="<?= base_url('c_user/activate_user/' . $mn['nim']); ?>" class="btn btn-success btn-sm my-1">Activate</a>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editUser<?= $mn['id_profile_mhs']; ?>" onclick="modal">
                                                            Edit
                                                        </button>

                                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delUser<?= $mn['id_profile_mhs']; ?>" ?>
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
        </div>
    </div>
</div>

<?php if (isset($madif)) : ?>

    <!-- Modal Tambah User Madif-->
    <div class="modal fade" id="tambahUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

                <!-- Header -->
                <div class="modal-header" style="background-color: rgba(0, 136, 120, 1)">
                    <h5 class="modal-title" id="exampleModalLabel" style=" color:white">Tambah User Mahasiswa Difabel</h5>
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
                                <input type="hidden" name="role" value="madif">

                                <h2 class="text-center mb-3">Form User</h2>

                                <!-- Email dan Username -->
                                <div class="row d-flex justify-content-center">
                                    <div class="col-auto mb-3">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control " name="email" aria-describedby="emailHelp" placeholder="Email" value="">
                                        </div>
                                    </div>
                                    <div class="col-auto mb-3">
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input type="text" class="form-control " name="username" placeholder="Username" value="">
                                        </div>
                                    </div>
                                </div>

                                <!-- Password -->
                                <div class="row d-flex justify-content-center">
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

                                <h2 class="text-center mb-3">Form Biodata</h2>

                                <!-- Jenis Kelamin -->
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

                                <!-- Jenis difabel-->
                                <div class="row d-flex justify-content-center">
                                    <div class="col-auto mb-3">
                                        <select name="jenis_difabel" class="form-select" aria-label="Default select example" required>
                                            <option value="0" selected>Jenis difabel...</option>
                                            <?php for ($i = 0; $i < count($kategori_difabel); $i++) : ?>
                                                <option value=<?= $kategori_difabel[$i]['id']; ?>><?= $i + 1 . '. ' . $kategori_difabel[$i]['jenis']; ?>
                                                </option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Nama Lengkap dan Panggilan -->
                                <div class="row d-flex justify-content-center">
                                    <div class="col-auto mb-3">
                                        <div class="form-group">
                                            <input type="text" name="nickname" class="form-control form-control-user" placeholder="Panggilan" required="">
                                        </div>
                                    </div>
                                    <div class="col-auto mb-3">
                                        <div class="form-group">
                                            <input type="text" name="fullname" class="form-control form-control-user" placeholder="Nama lengkap..." required="">
                                        </div>
                                    </div>
                                </div>

                                <!-- Fakultas dan Jurusan -->
                                <div class="row d-flex justify-content-center">
                                    <div class="col-auto mb-3">
                                        <div class="form-row">
                                            <input type="text" name="fakultas" class="form-control form-control-user" placeholder="Fakultas..." required="">
                                        </div>
                                    </div>

                                    <div class="col-auto mb-3">
                                        <div class="form-row">
                                            <input type="text" name="jurusan" class="form-control form-control-user" placeholder="Jurusan..." required="">
                                        </div>
                                    </div>
                                </div>

                                <!-- Prodi dan Semester -->
                                <div class="row d-flex justify-content-center">
                                    <div class="col-auto mb-3">
                                        <div class="form-row">
                                            <input type="text" name="prodi" class="form-control form-control-user" placeholder="Program Studi..." required="">
                                        </div>
                                    </div>

                                    <div class="col-auto mb-3">
                                        <div class="form-row">
                                            <input type="number" name="semester" class="form-control form-control-user" placeholder="Semester..." required="">
                                        </div>
                                    </div>
                                </div>

                                <!-- Alamat dan Nomor -->
                                <div class="row d-flex justify-content-center">
                                    <div class="col-auto mb-3">
                                        <div class="form-row">
                                            <input type="text" name="alamat" class="form-control form-control-user" placeholder="Alamat malang..." required="">
                                        </div>
                                    </div>
                                    <div class="col-auto mb-3">
                                        <div class="form-row">
                                            <input type="text" name="nomor_hp" class="form-control form-control-user" placeholder="Nomor HP (aktif)" required="">
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

    <?php foreach ($madif as $key1) : ?>
        <!-- Modal Edit Madif-->
        <div class="modal fade" id="editUser<?= $key1['id_profile_mhs']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
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
                            <input type="hidden" name="role" value="madif">

                            <!-- USERNAME -->
                            <div class="row g-2 d-flex justify-content-md-center mb-3 text-center">
                                <div class="col">
                                    <label for="username" class="form-label">NIM</label>
                                    <input type="text" class="form-control-plaintext text-center" id="username" placeholder="name@example.com" value="<?= $key1['nim']; ?>" name="username" readonly>
                                </div>
                                <div class="col">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control-plaintext text-center" id="email" placeholder="name@example.com" value="<?= $key1['email']; ?>" name="email" readonly>
                                </div>
                            </div>
                            <hr>
                            <!-- Jenis Kelamin dan Jenis Difabel-->
                            <div class="row g-2 mb-2">
                                <div class="col d-flex justify-content-center align-content-center my-auto">
                                    <!-- Jenis Kelamin -->
                                    <div class="row d-flex justify-content-center align-content-center my-auto">
                                        <div class="col-auto my-auto">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="laki-laki" value="1" <?= ($key1['jenis_kelamin'] == 1) ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="laki-laki">Laki-laki</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan" value="0" <?= ($key1['jenis_kelamin'] == 0) ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="perempuan">Perempuan</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-floating">
                                        <select class="form-select <?= ($key1['approval_jenis_difabel'] == null || $key1['approval_jenis_difabel'] == '0') ? 'is-invalid' : ''; ?>" aria-label="Default select example" name="jenis_madif" id="floatingInput" autofocus required>
                                            <?php for ($i = 0; $i < count($kategori_difabel); $i++) : ?>
                                                <option value=<?= $kategori_difabel[$i]['id']; ?> <?= ($kategori_difabel[$i]['jenis'] == $key1['jenis_difabel']) ? 'selected' : ''; ?>><?= $i + 1 . '. ' . $kategori_difabel[$i]['jenis']; ?>
                                                </option>
                                            <?php endfor; ?>
                                        </select>
                                        <label for="floatingInput">Jenis Difabel</label>
                                        <?php if ($key1['approval_jenis_difabel'] == null) : ?>
                                            <div class="invalid-feedback my-0 py-0 d-inline mr-2" style="color:blue">*Menunggu Verifikasi dari Admin
                                            </div>
                                            <a href="<?= base_url('c_user/approval_jenis_madif/' . $key1['id_profile_mhs'] . '/' . 'terima'); ?>" class="btn btn-success btn-sm my-1">Terima</a>
                                            <a href="<?= base_url('c_user/approval_jenis_madif/' . $key1['id_profile_mhs'] . '/' . 'tolak'); ?>" class="btn btn-danger btn-sm">Tolak</a>
                                        <?php elseif ($key1['approval_jenis_difabel'] == '0') : ?>
                                            <div class="invalid-feedback my-0 py-0">*Jenis Difabel Ditolak Admin</div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Nama Lengkap dan Nama Panggilan -->
                            <div class="row g-2 mb-2">
                                <div class="col-auto">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="floatingInputGrid" placeholder="<?= $key1['nickname']; ?>" value="<?= $key1['nickname']; ?>" name="nickname">
                                        <label for="floatingInputGrid">Nama Panggilan</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="floatingInputGrid" placeholder="<?= $key1['fullname']; ?>" value="<?= $key1['fullname']; ?>" name="fullname">
                                        <label for="floatingInputGrid">Nama Lengkap</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Fakultas dan Jurusan -->
                            <div class="row g-2 mb-2">
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="fakultas" placeholder="Fakultas..." value="<?= $key1['fakultas']; ?>" name="fakultas">
                                        <label for="fakultas">Fakultas</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="jurusan" placeholder="Jurusan..." value="<?= $key1['jurusan']; ?>" name="jurusan">
                                        <label for="jurusan">Jurusan</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Prodi dan Semester -->
                            <div class="row g-2 mb-2">
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="prodi" placeholder="Program Studi..." value="<?= $key1['prodi']; ?>" name="prodi">
                                        <label for="prodi">Program Studi</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="semester" placeholder="Semester" value="<?= $key1['semester']; ?>" name="semester">
                                        <label for="semester">Semester</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Alamat dan Nomor HP-->
                            <div class="row g-2 mb-2">
                                <div class="col">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" placeholder="Alamat user..." value="<?= $key1['alamat']; ?>" name="alamat">
                                        <label for="floatingInput">Alamat</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="floatingInputGrid" placeholder="Masukkan nomor HP..." value="<?= $key1['nomor_hp']; ?>" name="nomor_hp">
                                        <label for="floatingInputGrid">Nomor HP</label>
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
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Delete User-->
        <div class="modal fade" id="delUser<?= $key1['id_profile_mhs']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: darkred">
                        <h5 class="modal-title text-white" id="exampleModalLabel">Hapus <?= $key1['nickname']; ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="/c_user/delUser" method="post">
                        <div class="modal-body">
                            <input type="hidden" name="role" value="madif">
                            <input type="hidden" name="username" value="<?= $key1['nim']; ?>">

                            <div class="container-fluid">
                                <p>Apakah anda yakin ingin menghapus user admin <?= $key1['nickname']; ?> ini?</p>
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
    <?php endforeach; ?>
<?php endif; ?>

<?= $this->endSection(); ?>