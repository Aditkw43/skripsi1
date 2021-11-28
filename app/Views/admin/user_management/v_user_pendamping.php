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

                    <!-- Skill Pendamping -->
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
                    <?php elseif (session()->getFlashData('form_tidak_lengkap')) : ?>
                        <div class="alert alert-warning" role="alert">
                            <?= session()->getFlashData('form_tidak_lengkap'); ?>
                        </div>
                    <?php elseif (session()->getFlashData('gagal_ditambahkan')) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?= session()->getFlashData('gagal_ditambahkan'); ?>
                        </div>
                    <?php elseif (session()->getFlashData('tolak')) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?= session()->getFlashData('tolak'); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Tambah User -->
                    <?php if (session()->getFlashData('berhasil')) : ?>
                        <div class="alert alert-success" role="alert">
                            <?= session()->getFlashData('berhasil'); ?>
                        </div>
                    <?php elseif (session()->getFlashData('berhasil_activate')) : ?>
                        <div class="alert alert-success" role="alert">
                            <?= session()->getFlashData('berhasil_activate'); ?>
                        </div>
                    <?php elseif (session()->getFlashData('errors')) : ?>
                        <?= view('Myth\Auth\Views\_message_block') ?>
                    <?php endif; ?>
                    <div class="mb-2 mt-2" style="display: flex; justify-content: space-between; align-items:center">
                        <h2><?= $title; ?></h2>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#tambahUser">
                            Tambah User Pendamping
                        </button>
                    </div>

                    <!-- Basic table -->
                    <div class="table-responsive">
                        <table class="table table-light" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                            <thead class="text-center">
                                <tr>
                                    <th scope="col">Total Jumlah Pendamping</th>
                                    <th scope="col">Total Pendamping Aktif</th>
                                    <th scope="col">Total Pendamping Non-Aktif</th>
                                </tr>
                            </thead>
                            <tbody class="text-center table-light">
                                <tr>
                                    <td><?= count($pendamping); ?></td>
                                    <td><?= count($pendamping_aktif); ?></td>
                                    <td><?= count($pendamping_nonaktif); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Card -->
                    <div class="card">
                        <!-- Tab table -->
                        <ul class="nav nav-line-bottom" id="pills-tab-table" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-table-pendamping-aktif-tab" data-bs-toggle="pill" href="#pills-table-pendamping-aktif" role="tab" aria-controls="pills-table-pendamping-aktif" aria-selected="true">Pendamping Aktif</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-table-pendamping-tidak-aktif-tab" data-bs-toggle="pill" href="#pills-table-pendamping-tidak-aktif" role="tab" aria-controls="pills-table-pendamping-tidak-aktif" aria-selected="true">Pendamping Tidak Aktif</a>
                            </li>
                        </ul>

                        <!-- Tab content -->
                        <div class=" tab-content p-4" id="pills-tabContent-table">
                            <!-- Pendamping Aktif Table -->
                            <div class="tab-pane tab-example-design fade show active" id="pills-table-pendamping-aktif" role="tabpanel" aria-labelledby="pills-table-pendamping-aktif-tab">
                                <div class="table-responsive">
                                    <table class="table table-hover table-dark" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                                        <thead>
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Nama</th>
                                                <th scope="col">NIM</th>
                                                <th scope="col">Fakultas</th>
                                                <th scope="col">Semester</th>
                                                <th scope="col">Detail</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-light">

                                            <?php $i = 1 ?>
                                            <?php foreach ($pendamping_aktif as $pa) : ?>
                                                <tr class="align-middle">
                                                    <th scope="row"><?= $i; ?></th>
                                                    <td><?= $pa['nickname']; ?></td>
                                                    <td><?= $pa['nim']; ?></td>
                                                    <td><?= $pa['fakultas']; ?></td>
                                                    <td><?= $pa['semester']; ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editUser<?= $pa['id_profile_mhs']; ?>" onclick="modal">
                                                            Edit
                                                        </button>

                                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#skillsUser<?= $pa['id_profile_mhs']; ?>" ?>
                                                            Skills
                                                        </button>

                                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delUser<?= $pa['id_profile_mhs']; ?>" ?>
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

                            <!-- Pendamping Tidak Aktif Table -->
                            <div class="tab-pane tab-example-design fade" id="pills-table-pendamping-tidak-aktif" role="tabpanel" aria-labelledby="pills-table-pendamping-tidak-aktif-tab">
                                <div class="table-responsive">
                                    <table class="table table-hover table-dark" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                                        <thead>
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Nama</th>
                                                <th scope="col">NIM</th>
                                                <th scope="col">Fakultas</th>
                                                <th scope="col">Semester</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Detail</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-light">

                                            <?php $i = 1 ?>
                                            <?php foreach ($pendamping_nonaktif as $pn) : ?>
                                                <tr class="align-middle">
                                                    <th scope="row"><?= $i; ?></th>
                                                    <td><?= $pn['nickname']; ?></td>
                                                    <td><?= $pn['nim']; ?></td>
                                                    <td><?= $pn['fakultas']; ?></td>
                                                    <td><?= $pn['semester']; ?></td>
                                                    <td>
                                                        <a href="<?= base_url('c_user/activate_user/' . $pn['nim']); ?>" class="btn btn-success btn-sm my-1">Activate</a>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editUser<?= $pn['id_profile_mhs']; ?>" onclick="modal">
                                                            Edit
                                                        </button>

                                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#skillsUser<?= $pn['id_profile_mhs']; ?>" ?>
                                                            Skills
                                                        </button>

                                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delUser<?= $pn['id_profile_mhs']; ?>" ?>
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

<?php if (isset($pendamping)) : ?>

    <!-- Modal Tambah User Madif-->
    <div class="modal fade" id="tambahUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

                <!-- Header -->
                <div class="modal-header" style="background-color: rgba(0, 136, 120, 1)">
                    <h5 class="modal-title" id="exampleModalLabel" style=" color:white">Tambah User Pendamping</h5>
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
                                <input type="hidden" name="role" value="pendamping">

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

    <?php foreach ($pendamping as $key1) : ?>
        <!-- Modal Edit User-->
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
                            <input type="hidden" name="role" value="pendamping">

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

                            <!-- Jenis Kelamin-->
                            <div class="row g-2 mb-3 d-flex justify-content-center align-content-center my-auto">
                                <!-- Jenis Kelamin -->
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

        <!-- Modal Skills User-->
        <div class="modal fade" id="skillsUser<?= $key1['id_profile_mhs']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">

                    <!-- Header -->
                    <div class="modal-header" style="background-color: #ffca2c">
                        <h5 class="modal-title" id="exampleModalLabel">Skills Pendamping <?= $key1['nickname']; ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Form -->
                    <form action="/c_profile_pendamping/saveSkill" method="POST">
                        <div class="modal-body">

                            <!-- id_profile_pendamping -->
                            <input type="hidden" name="id_profile_pendamping" value="<?= $key1['id_profile_mhs']; ?>">

                            <!-- Usermanagement Sign -->
                            <input type="hidden" name="user_management" value="true">

                            <!-- Table -->
                            <div class="table-responsive">
                                <table class="table table-hover table-dark" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                                    <thead>
                                        <tr>
                                            <th scope="col">Prioritas</th>
                                            <th scope="col">Referensi Pendampingan</th>
                                            <th scope="col">Approval</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-light">
                                        <?php foreach ($key1['skills'] as $s1) : ?>
                                            <tr class="align-middle">
                                                <td><?= $s1['prioritas']; ?></td>
                                                <td><?= $s1['skill']; ?></td>
                                                <?php if ($s1['approval'] == '1') : ?>
                                                    <td style="color:green">Terverifikasi</td>
                                                <?php elseif ($s1['approval'] == '0') : ?>
                                                    <td style="color:red">Ditolak</td>
                                                <?php else : ?>
                                                    <td>
                                                        <a href="<?= base_url('c_user/approval_skill/' . $key1['id_profile_mhs'] . '/terima/' . $s1['id']); ?>" class="btn btn-success btn-sm my-1"><i class="fas fa-check"></i></a>
                                                        <a href="<?= base_url('c_user/approval_skill/' . $key1['id_profile_mhs'] . '/tolak/' . $s1['id']); ?>" class="btn btn-danger btn-sm"><i class="fas fa-times"></i></a>
                                                    </td>
                                                <?php endif; ?>
                                                <td>
                                                    <!-- Button trigger modal Detail Jadwal Ujian -->
                                                    <button type="button" class="btn btn-<?= ($s1['approval'] == '0') ? 'info' : 'warning'; ?> btn-sm" data-bs-toggle="modal" data-bs-target="#editSkill<?= $key1['id_profile_mhs'] . $s1['prioritas'] ?>" data-bs-dismiss="modal">
                                                        <i class="fas <?= ($s1['approval'] == '0') ? 'fa-exchange-alt' : 'fa-pen-square'; ?> "></i>
                                                    </button>

                                                    <!-- Button Trigger Modal Hapus Jadwal Ujian -->
                                                    <button type="submit" class="btn btn-danger btn-sm my-1" data-bs-toggle="modal" data-bs-target="#delSkill<?= $key1['id_profile_mhs'] . $s1['prioritas'] ?>" data-bs-dismiss="modal">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Skills Pendamping -->
                            <div class="row g-2 mb-2">
                                <div class="col">
                                    <div class="form-floating">
                                        <select class="form-select" id="ref_pendampingan" aria-label="Floating label select example" name="ref_pendampingan">
                                            <option value="null" selected>Pilih Skills...</option>
                                            <?php $count = 1; ?>
                                            <?php foreach ($all_jenis_skill as $key2) : ?>
                                                <?php $cek_skill = true; ?>
                                                <?php foreach ($key1['skills'] as $skills) : ?>
                                                    <?php if ($key2['id'] == $skills['id']) $cek_skill = false; ?>
                                                <?php endforeach; ?>
                                                <?php if ($cek_skill) : ?>
                                                    <option value="<?= $key2['id']; ?>"><?= $count++ . '. ' . $key2['jenis']; ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                        <label for="ref_pendampingan">Skill Pendamping</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating">
                                        <select class="form-select" aria-label="Default select example" name="prioritas" id="prioritas" autofocus required>
                                            <option value='0' selected>Pilih Prioritas Skill</option>
                                            <?php for ($i = 0; $i < count($key1["skills"]) + 1; $i++) : ?>
                                                <?php if (!empty($key1["skills"][$i])) : ?>
                                                    <option value="<?= $i + 1; ?>"><?= $i + 1 . ' - ' . $key1["skills"][$i]['skill']; ?></option>
                                                <?php else : ?>
                                                    <option value="<?= $i + 1; ?>" style="background-color: rgba(246, 239, 39, 0.54);"><?= 'Tambah prioritas ke-' . ($i + 1); ?></option>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                        </select>
                                        <label for="prioritas">Prioritas</label>
                                    </div>
                                </div>
                                <div class="col-auto my-auto py-auto mx-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Submit button -->
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php foreach ($key1['skills'] as $s1) : ?>
            <?php if (!empty($s1)) : ?>
                <!-- Modal Delete Skill-->
                <div class="modal fade" id="delSkill<?= $key1['id_profile_mhs'] . $s1['prioritas']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: darkred">
                                <h5 class="modal-title text-white" id="exampleModalLabel">Hapus Skill <?= $s1['skill'] ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="/c_profile_pendamping/delSkill" method="post">
                                <div class="modal-body">
                                    <div class="container-fluid">
                                        <input type="hidden" name="id_profile_pendamping" value="<?= $key1['id_profile_mhs']; ?>">
                                        <input type="hidden" name="ref_pendampingan" value="<?= $s1['id']; ?>">
                                        <input type="hidden" name="prioritas" value="<?= $s1['prioritas']; ?>">
                                        <p>Apakah anda yakin ingin menghapus skill referensi pendampingan ini?</p>
                                        <p>Jika iya, silahkan klik tombol <strong>"Hapus"</strong></p>
                                        <?= csrf_field(); ?>
                                        <!-- HTTP Spoofing -->
                                        <input type="hidden" name="_method" value="DELETE">
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-target="#skillsUser<?= $key1['id_profile_mhs']; ?>" data-bs-toggle="modal" type="button" data-bs-dismiss="modal">Kembali</button>
                                    <button type="submit" class="btn btn-danger">
                                        Hapus
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal Edit Skill-->
                <div class="modal fade" id="editSkill<?= $key1['id_profile_mhs'] . $s1['prioritas']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">

                            <!-- Header -->
                            <?php if ($s1['approval'] == '0') : ?>
                                <div class="modal-header" style="background-color: cyan;">
                                    <h5 class="modal-title" id="exampleModalLabel" style=" color:black">Ganti Referensi Pendampingan <?= $s1['skill'] ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                            <?php else : ?>
                                <div class="modal-header" style="background-color: gold;">
                                    <h5 class="modal-title" id="exampleModalLabel" style=" color:black">Edit Referensi Pendampingan <?= $s1['skill'] ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>

                            <?php
                            $skills_lama = [];
                            $jenis_lama = [];
                            for ($i = 0; $i < count($key1['skills']); $i++) {
                                if (!empty($key1['skills'][$i])) {
                                    foreach ($all_jenis_skill as $key) {
                                        if ($key['id'] == $key1["skills"][$i]['id']) {
                                            $skills_lama[$i] = (string) $key1["skills"][$i]['prioritas'];
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
                                    <input type="hidden" name="id_profile_pendamping" value="<?= $key1['id_profile_mhs']; ?>">

                                    <!-- Approval -->
                                    <input type="hidden" name="approval" value="<?= $s1['approval']; ?>">

                                    <!-- Old Referensi Pendampingan-->
                                    <input type="hidden" name="old_ref_pendampingan" value="<?= $s1['id']; ?>">

                                    <!-- Old Prioritas -->
                                    <input type="hidden" name="old_prioritas" value="<?= $s1['prioritas']; ?>">

                                    <!--Referensi Pendampingan-->
                                    <div class="row mb-3">
                                        <label for="ref_pendampingan" class="col-sm-6 col-form-label">Referensi Pendampingan</label>
                                        <div class="col-sm-6">
                                            <select class="form-select" aria-label="Default select example" name="ref_pendampingan" id="ref_pendampingan" autofocus required>
                                                <option selected value="<?= $s1['id']; ?>" style="background-color: rgba(246, 239, 39, 0.54);"><?= $s1['skill']; ?></option>
                                                <?= $count = 1; ?>
                                                <?php for ($i = 0; $i < count($all_jenis_skill); $i++) : ?>
                                                    <?php
                                                    $isset = false;
                                                    foreach ($key1["skills"] as $key) {
                                                        if ($key['id'] == $i + 1) {
                                                            $isset = true;
                                                        }
                                                    } ?>
                                                    <?php if ($isset) : ?>
                                                        <?php continue; ?>
                                                    <?php else : ?>
                                                        <option value=<?= $all_jenis_skill[$i]['id']; ?>><?= $count . '. ' . $all_jenis_skill[$i]['jenis']; ?>
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
                                                <?php for ($i = 0; $i < count($key1["skills"]); $i++) : ?>
                                                    <option value=<?= $skills_lama[$i]; ?> <?= ($skills_lama[$i] == $s1['prioritas']) ? 'selected' : ''; ?>><?= $skills_lama[$i] . ' - ' . $jenis_lama[$i]; ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit button -->
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-target="#skillsUser<?= $key1['id_profile_mhs']; ?>" data-bs-toggle="modal" type="button" data-bs-dismiss="modal">Kembali</button>
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