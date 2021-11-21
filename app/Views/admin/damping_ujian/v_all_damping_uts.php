<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid px-6 py-4">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="row mb-6">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <!-- Pesan Berhasil -->
                    <?php if (session()->getFlashData('berhasil')) : ?>
                        <div class="alert alert-success" role="alert">
                            <?= session()->getFlashData('berhasil'); ?>
                        </div>
                    <?php endif; ?>
                    <div class="mb-2 mt-2" style="display: flex; justify-content: space-between; align-items:center">
                        <h2><?= $title; ?></h2>
                    </div>

                    <!-- Card -->
                    <div class="card">

                        <!-- Tab table -->
                        <ul class="nav nav-line-bottom" id="pills-tab-table" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-table-jadwal_damping-tab" data-bs-toggle="pill" href="#pills-table-jadwal_damping" role="tab" aria-controls="pills-table-jadwal_damping" aria-selected="true">Jadwal Pendampingan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-table-jadwal-tidak-damping-tab" data-bs-toggle="pill" href="#pills-table-jadwal-tidak-damping" role="tab" aria-controls="pills-table-jadwal-tidak-damping" aria-selected="true">Jadwal Tidak Ada Pendamping</a>
                            </li>
                        </ul>

                        <!-- Tab content -->
                        <div class=" tab-content p-4" id="pills-tabContent-table">

                            <!-- Jadwal Damping Table -->
                            <div class="tab-pane tab-example-design fade show active" id="pills-table-jadwal_damping" role="tabpanel" aria-labelledby="pills-table-jadwal_damping-tab">
                                <div class="table-responsive">
                                    <table class="table table-hover table-dark" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                                        <thead>

                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Tanggal Ujian</th>
                                                <th scope="col">Mata Kuliah</th>
                                                <th scope="col">Madif</th>
                                                <th scope="col">Pendamping</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Aksi</th>
                                            </tr>

                                        </thead>
                                        <tbody class="table-light">
                                            <?php if (!empty($jadwal_damping)) : ?>
                                                <?php $i = 1 ?>
                                                <?php foreach ($jadwal_damping as $jd) : ?>
                                                    <tr class="align-middle">

                                                        <!-- Id Pendampingan -->
                                                        <input type="hidden" name="id_damping" value="<?= $jd['id_damping']; ?>">

                                                        <!-- Nomor -->
                                                        <th scope="row"><?= $i; ?></th>

                                                        <!-- Tanggal Ujian -->
                                                        <td><?= date('d, M Y', strtotime($jd['jadwal_ujian']['tanggal_ujian'])); ?></td>

                                                        <!-- Mata Kuliah -->
                                                        <td><?= $jd['jadwal_ujian']['mata_kuliah']; ?></td>

                                                        <!-- Nama Madif -->
                                                        <td><?= $jd['biodata_madif']['nickname']; ?> (<?= $jd['biodata_madif']['jenis_madif']; ?>)</td>

                                                        <!-- Nama Pendamping -->
                                                        <td><?= $jd['biodata_pendamping']['nickname']; ?></td>

                                                        <!-- Status -->
                                                        <?php if (empty($jd['status_damping'])) : ?>
                                                            <td style="color: red">
                                                                Menunggu Konfirmasi Pendamping
                                                            </td>
                                                        <?php elseif ($jd['status_damping'] == 'presensi_hadir' || ($jd['status_damping'] == 'konfirmasi_presensi_hadir')) : ?>
                                                            <td style="color: orange">
                                                                <?= ($jd['status_damping'] == 'presensi_hadir') ? 'Menunggu Pendamping Presensi' : 'Menunggu Konfirmasi Presensi oleh Madif'; ?>
                                                            </td>
                                                        <?php else : ?>
                                                            <td style="color: green">
                                                                Menunggu Laporan Pendampingan
                                                            </td>

                                                        <?php endif; ?>

                                                        <!-- Aksi -->
                                                        <td>
                                                            <button type="button" class="btn btn-warning btn-sm editJadwal my-1" data-bs-toggle="modal" data-bs-target="#jadwalDamping<?= $jd['id_damping']; ?>" ?>
                                                                Detail
                                                            </button>

                                                            <button type="button" class="btn btn-primary btn-sm editJadwal" data-bs-toggle="modal" data-bs-target="#profile<?= $jd['id_damping']; ?>" ?>
                                                                Profile
                                                            </button>
                                                        </td>

                                                    </tr>
                                                    <?php $i++; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Jadwal Tidak Damping Table -->
                            <div class="tab-pane tab-example-html fade" id="pills-table-jadwal-tidak-damping" role="tabpanel" aria-labelledby="pills-table-jadwal-tidak-damping-tab">
                                <div class="table-responsive">
                                    <table class="table table-hover table-dark" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                                        <thead>

                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Tanggal Ujian</th>
                                                <th scope="col">Mata Kuliah</th>
                                                <th scope="col">Madif</th>
                                                <th scope="col">Pendamping</th>
                                                <th scope="col">Aksi</th>
                                            </tr>

                                        </thead>
                                        <tbody class="table-light">

                                            <?php if (!empty($jadwal_tidak_damping)) : ?>
                                                <?php $i = 1 ?>
                                                <?php foreach ($jadwal_tidak_damping as $jtd) : ?>

                                                    <tr class="align-middle">

                                                        <!-- Id Pendampingan -->
                                                        <input type="hidden" name="id_damping" value="<?= $jtd['id_damping']; ?>">

                                                        <!-- Nomor -->
                                                        <th scope="row"><?= $i; ?></th>

                                                        <!-- Tanggal Ujian -->
                                                        <td><?= date('d, M Y', strtotime($jtd['jadwal_ujian']['tanggal_ujian'])); ?></td>

                                                        <!-- Mata Kuliah -->
                                                        <td><?= $jtd['jadwal_ujian']['mata_kuliah']; ?></td>

                                                        <!-- Nama Madif -->
                                                        <td><?= $jtd['biodata_madif']['nickname']; ?> (<?= $jtd['biodata_madif']['jenis_madif']; ?>)</td>

                                                        <!-- Aksi -->
                                                        <td>
                                                            <button type="button" class="btn btn-danger btn-sm my-1" data-bs-toggle="modal" data-bs-target="#pendampingAlt<?= $jtd['id_damping']; ?>" ?>
                                                                Cari
                                                            </button>
                                                        </td>

                                                        <!-- Aksi -->
                                                        <td>
                                                            <button type="button" class="btn btn-warning btn-sm editJadwal my-1" data-bs-toggle="modal" data-bs-target="#jadwalDamping<?= $jtd['id_damping']; ?>" ?>
                                                                Detail
                                                            </button>

                                                            <button type="button" class="btn btn-primary btn-sm editJadwal" data-bs-toggle="modal" data-bs-target="#profile<?= $jtd['id_damping']; ?>" ?>
                                                                Profile
                                                            </button>
                                                        </td>

                                                    </tr>
                                                    <?php $i++; ?>
                                                <?php endforeach; ?>
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

<?php if (!empty($jadwal_damping) || !empty($jadwal_tidak_damping)) : ?>
    <?php foreach ($all_jadwal_damping as $ajd) : ?>

        <!-- Modal Profile-->
        <div class="modal fade" id="profile<?= $ajd['id_damping']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: blueviolet">
                        <h5 class="modal-title text-white" id="exampleModalLabel">Detail Profile</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Form -->
                    <div class="modal-body" style="background-color: white;">

                        <div class="container">
                            <h4 class="text-center">Mahasiswa Difabel</h4>
                            <div class="row mt-5">
                                <div class="col-md-6 mb-2">
                                    <label for="nama_madif" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama_madif" placeholder='<?= $ajd['biodata_madif']['fullname']; ?>' readonly>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="jenis_kelamin_madif" class="form-label">Jenis Kelamin</label>
                                    <input type="text" class="form-control" id="jenis_kelamin_madif" placeholder='<?= ($ajd['biodata_madif']['jenis_kelamin'] == 1) ? 'Laki-laki' : 'Perempuan'; ?>' readonly>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="fakultas_madif" class="form-label">Fakultas</label>
                                    <input type="text" class="form-control" id="fakultas_madif" placeholder='<?= $ajd['biodata_madif']['fakultas']; ?>' readonly>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="jurusan_madif" class="form-label">Jurusan</label>
                                    <input type="text" class="form-control" id="jurusan_madif" placeholder='<?= $ajd['biodata_madif']['jurusan'] ?>' readonly>
                                </div>
                                <label for="nomor_madif" class="col-sm-auto col-form-label">Nomor HP</label>

                                <div class="col-sm-auto">
                                    <input type="text" class="form-control-plaintext" id="nomor_madif" value='<?= $ajd['biodata_madif']['nomor_hp'] ?>'>
                                </div>
                            </div>

                        </div>

                        <?php if (isset($ajd['biodata_pendamping'])) : ?>
                            <hr>
                            <div class="container">
                                <h4 class="text-center">Pendamping</h4>
                                <div class="row mt-5">
                                    <div class="col-md-6 mb-2">
                                        <label for="nama_pendamping" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="nama_pendamping" placeholder='<?= $ajd['biodata_pendamping']['fullname']; ?>' readonly>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="jenis_kelamin_pendamping" class="form-label">Jenis Kelamin</label>
                                        <input type="text" class="form-control" id="jenis_kelamin_pendamping" placeholder='<?= ($ajd['biodata_pendamping']['jenis_kelamin'] == 1) ? 'Laki-laki' : 'Perempuan'; ?>' readonly>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="fakultas_pendamping" class="form-label">Fakultas</label>
                                        <input type="text" class="form-control" id="fakultas_pendamping" placeholder='<?= $ajd['biodata_pendamping']['fakultas']; ?>' readonly>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="jurusan_pendamping" class="form-label">Jurusan</label>
                                        <input type="text" class="form-control" id="jurusan_pendamping" placeholder='<?= $ajd['biodata_pendamping']['jurusan'] ?>' readonly>
                                    </div>
                                    <label for="nomor_pendamping" class="col-sm-auto col-form-label">Nomor HP</label>

                                    <div class="col-sm-auto">
                                        <input type="text" class="form-control-plaintext" id="nomor_pendamping" value='<?= $ajd['biodata_pendamping']['nomor_hp'] ?>'>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div>

                    <!-- Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>

        <!-- Modal Jadwal Ujian -->
        <div class="modal fade" id="jadwalDamping<?= $ajd['id_damping']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: orange">
                        <h5 class="modal-title fw-bold" id="exampleModalLabel">Detail Jadwal Ujian</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="card shadow p-3 mb-5 bg-body rounded">
                            <div class="card-header text-center fw-bold">
                                <?= $ajd['jadwal_ujian']['mata_kuliah']; ?>
                            </div>
                            <div class="card-body">
                                <!--  start hidden jadwal id -->
                                <input type="hidden" name="id_jadwal_ujian" value="<?= $ajd['jadwal_ujian']['id_jadwal_ujian']; ?>">
                                <!-- end hidden jadwal id -->

                                <!-- Tanggal Ujian -->
                                <div class="row">
                                    <label for="tanggal_ujian" class="col-sm-4 col-form-label">Tanggal Ujian</label>
                                    <div class="col-sm-8">
                                        <input type="text" readonly class="form-control-plaintext" id="tanggal_ujian" value="<?= date('d, M Y', strtotime($ajd['jadwal_ujian']['tanggal_ujian'])); ?>">
                                    </div>
                                </div>

                                <!-- Jam Ujian -->
                                <div class="row">
                                    <label for="staticEmail" class="col-sm-4 col-form-label">Jam Ujian</label>
                                    <div class="col-sm-8">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= date('H:i', strtotime($ajd['jadwal_ujian']['waktu_mulai_ujian'])); ?> - <?= date('H:i', strtotime($ajd['jadwal_ujian']['waktu_selesai_ujian'])); ?>">
                                    </div>
                                </div>

                                <!-- Ruangan -->
                                <div class="row">
                                    <label for="staticEmail" class="col-sm-4 col-form-label">Ruangan</label>
                                    <div class="col-sm-8">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $ajd['jadwal_ujian']['ruangan']; ?>">
                                    </div>
                                </div>

                                <!-- Keterangan -->
                                <div class="row">
                                    <label for="staticEmail" class="col-sm-4 col-form-label">Keterangan</label>
                                    <div class="col-sm-8">
                                        <button class="btn btn-primary btn-sm mt-1" data-bs-target="#keterangan<?= $ajd['id_damping']; ?>" data-bs-toggle="modal" data-bs-dismiss="modal">Keterangan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit button -->
                    <div class="modal-footer">
                        <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cancel</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Keterangan-->
        <div class="modal fade" id="keterangan<?= $ajd['id_damping']; ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: rgba(34, 84, 145, 1);">
                        <h5 class="modal-title text-white" id="exampleModalToggleLabel2">Keterangan Pendampingan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="color: black">
                        <?= $ajd['jadwal_ujian']['keterangan']; ?>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" data-bs-target="#jadwalDamping<?= $ajd['id_damping']; ?>" data-bs-toggle="modal" data-bs-dismiss="modal">Kembali</button>
                    </div>
                </div>
            </div>
        </div>

    <?php endforeach; ?>

    <?php foreach ($jadwal_tidak_damping as $key) : ?>
        <!-- Modal Tambah Skill-->
        <div class="modal fade" id="pendampingAlt<?= $key['id_damping']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Header -->
                    <div class="modal-header" style="background-color: rgba(11, 64, 117, 1);">
                        <h5 class="modal-title" id="exampleModalLabel" style=" color:white">Cari Pendamping</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Form -->
                    <form action="/c_damping_ujian/savePendampingAlt" method="POST">
                        <div class="modal-body">
                            <?= csrf_field(); ?>

                            <!-- Id Damping -->
                            <input type="hidden" name="id_damping" value="<?= $key['id_damping']; ?>">

                            <!--Referensi Pendampingan-->
                            <div class="row mb-3">
                                <label for="pendamping_alt" class="col-sm-3 col-form-label">Pendamping</label>
                                <div class="col-sm-9">
                                    <select class="form-select" aria-label="Default select example" name="pendamping_alt" id="pendamping_alt" autofocus required>
                                        <option value='0' selected>Pilih Pendamping</option>
                                        <?= $count = 1; ?>
                                        <?php foreach ($key['pendamping_alt'] as $pa) : ?>
                                            <?php
                                            $status = '';
                                            if ($pa['urutan'] == 1) {
                                                $status = ' (Rekomendasi)';
                                            } elseif ($pa['urutan'] == 2) {
                                                $status = ' (Jadwal Cocok)';
                                            } elseif ($pa['urutan'] == 3) {
                                                $status = ' (Skill Cocok)';
                                            }
                                            ?>
                                            <option value="<?= $pa['id_profile_pendamping']; ?>"> <?= $count . '. ' . $pa['biodata_pendamping']['nickname'] . $status; ?></option>
                                            <?php $count++; ?>
                                        <?php endforeach; ?>
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
    <?php endforeach; ?>
<?php endif; ?>

<?= $this->endSection(); ?>