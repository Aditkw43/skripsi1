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
                        <h2>Daftar Jadwal Ujian</h2>
                        <!-- Pesan keberhasilan hapus -->
                        <?php if (session()->getFlashData('berhasil_dihapus')) : ?>
                            <div class="alert alert-success" role="alert">
                                <?= session()->getFlashData('berhasil_dihapus'); ?>
                            </div>
                        <?php elseif (session()->getFlashData('berhasil_ditambahkan')) : ?>
                            <div class="alert alert-success" role="alert">
                                <?= session()->getFlashData('berhasil_ditambahkan'); ?>
                            </div>
                        <?php elseif (session()->getFlashData('gagal_ditambahkan')) : ?>
                            <div class="alert alert-danger" role="alert">
                                <?= session()->getFlashData('gagal_ditambahkan'); ?>
                            </div>
                            <!-- Saran  -->
                            <?php if ($validasi_kalender) : ?>
                                <div class="alert alert-warning" role="alert">
                                    Saran : <?= session()->getFlashData('saran_kalender'); ?>
                                </div>
                            <?php elseif ($validasi_matkul_tanggal) : ?>
                                <div class="alert alert-warning" role="alert">
                                    Saran : <?= session()->getFlashData('saran_matkul_tanggal'); ?>
                                </div>
                            <?php elseif ($validasi_tanggal) : ?>
                                <div class="alert alert-warning" role="alert">
                                    Saran : <?= session()->getFlashData('saran_tanggal_waktu'); ?>
                                </div>
                            <?php elseif ($validasi_waktu_tidak_sesuai) : ?>
                                <div class="alert alert-warning" role="alert">
                                    Saran : <?= session()->getFlashData('saran_waktu_tidak_sesuai'); ?>
                                </div>
                            <?php endif; ?>
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
                                <a class="nav-link active" id="pills-table-daftar-ujian-tab" data-bs-toggle="pill" href="#pills-table-daftar-ujian" role="tab" aria-controls="pills-table-daftar-ujian" aria-selected="true">Daftar Jadwal Ujian</a>
                            </li>
                            <li class="nav-item">
                                <a class="input-jadwal <?= (session()->getFlashData('gagal_ditambahkan')) ? 'text-white bg-danger' : '' ?>" id="pills-table-add-ujian-tab" data-bs-toggle="pill" href="#pills-table-add" role="tab" aria-controls="pills-table-add" aria-selected="false">Input Jadwal Ujian</a>
                            </li>
                        </ul>
                        <!-- Tab content -->
                        <div class=" tab-content p-4" id="pills-tabContent-table">

                            <!-- Daftar Tabel -->
                            <div class="tab-pane tab-example-design fade show active" id="pills-table-daftar-ujian" role="tabpanel" aria-labelledby="pills-table-daftar-ujian-tab">
                                <!-- Basic table -->
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="text-center">
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Mata Kuliah</th>
                                                <th scope="col">Tanggal</th>
                                                <th scope="col">Jam</th>
                                                <th scope="col">Ruangan</th>
                                                <th scope="col">Keterangan</th>
                                                <?php if (in_groups('admin')) : ?>
                                                    <th scope="col">Presensi</th>
                                                    <th scope="col">Laporan</th>
                                                <?php endif; ?>
                                                <th scope="col">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php foreach ($jadwal as $j) : ?>
                                                <tr class="align-middle <?= (session()->getFlashData('idUjian') == $j['id_jadwal_ujian']) ? 'table-danger' : '' ?>">
                                                    <th scope="row"><?= $i++; ?></th>
                                                    <td><?= $j['mata_kuliah']; ?></td>
                                                    <td class="text-center"><?= $j['tanggal_ujian']; ?></td>

                                                    <!-- Start hidden jam ujian -->
                                                    <!-- Untuk di fetch di modal edit -->
                                                    <td style="display: none;"><?= date('H:i', strtotime($j['waktu_mulai_ujian'])); ?></td>
                                                    <td style="display: none;"><?= date('H:i', strtotime($j['waktu_selesai_ujian'])); ?></td>
                                                    <!-- End hidden jam ujian -->

                                                    <td class="text-center"><?= date('H:i', strtotime($j['waktu_mulai_ujian'])); ?> - <?= date('H:i', strtotime($j['waktu_selesai_ujian'])); ?></td>

                                                    <td><?= $j['ruangan']; ?></td>
                                                    <td><?= $j['keterangan']; ?></td>

                                                    <!--  start hidden jadwal id -->
                                                    <td style="display: none;"><?= $j['id_jadwal_ujian']; ?></td>
                                                    <!-- end hidden jadwal id -->

                                                    <td class="text-center">
                                                        <!-- Cara kerja:
                                                        1. Buat button/a.href
                                                        2. Buat atribut data-toggle, data-target, dan data-* untuk isi valuenya
                                                        3. Buat Modal diakhir, disamakan dengan data-target dan id modal
                                                        4. Buat Script javascript untuk memasukkan data valuenya ke modal, dan ditaruh di akhir sebelum tag body -->

                                                        <!-- Button trigger modal Detail Jadwal Ujian -->
                                                        <button type="button" class="btn btn-warning editJadwal" data-bs-toggle="modal" data-bs-target="#editJadwal<?= $j['id_jadwal_ujian']; ?>" ?>
                                                            <i class="fas fa-pen-square"></i>
                                                        </button>


                                                        <!-- Button Trigger Modal Hapus Jadwal Ujian -->
                                                        <button type="submit" class="btn btn-danger my-1" data-bs-toggle="modal" data-bs-target="#delJadwal<?= $j['id_jadwal_ujian']; ?>">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Input Jadwal Table -->
                            <div class="tab-pane tab-example-html fade" id="pills-table-add" role="tabpanel" aria-labelledby="pills-table-add-ujian-tab">
                                <div class="copy-content copy-content-height">
                                    <div class="code-toolbar d-flex justify-content-center">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col">
                                                    <p class="fs-4 text-center">Masukkan Jadwal Ujian</p>
                                                    <!-- Form Tambah Jadwal Ujian -->
                                                    <form action="/jadwalUjian/save" method="POST">
                                                        <?= csrf_field(); ?>
                                                        <!--Mata Kuliah -->
                                                        <div class="row mb-3">
                                                            <label for="mata_kuliah" class="col-sm-3 col-form-label">Mata Kuliah</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control <?= $validasi_matkul_tanggal ? 'is-invalid' : ' '; ?>" id="mata_kuliah" name="mata_kuliah" value="<?= old('mata_kuliah') ?>" autofocus required>

                                                                <!-- Validasi Mata Kuliah_Tanggal -->
                                                                <?php if (session()->getFlashData('validasi_matkul_tanggal')) : ?>
                                                                    <div class="invalid-feedback">
                                                                        <?= session()->getFlashData('validasi_matkul_tanggal'); ?>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>

                                                        <!-- Input Tanggal Ujian -->
                                                        <div class="row mb-3">
                                                            <label for="tanggal_ujian" class="col-sm-3 col-form-label">Tanggal Ujian</label>
                                                            <div class="col-sm-9">
                                                                <input type="date" class="form-control <?= (($fail_kalender == 'tanggal') || $validasi_matkul_tanggal || $validasi_tanggal)  ? 'is-invalid' : ' '; ?>" id="tanggal_ujian" name="tanggal_ujian" value="<?= old('tanggal_ujian') ?>" required>

                                                                <!-- Validasi Tanggal_ujian -->
                                                                <?php if ($validasi_kalender) : ?>
                                                                    <?php if ($fail_kalender == "tanggal_waktu") : ?>
                                                                        <div class="invalid-feedback">
                                                                            <?= session()->getFlashData('validasi_kalender'); ?>
                                                                        </div>
                                                                    <?php elseif ($fail_kalender == "tanggal") : ?>
                                                                        <div class="invalid-feedback">
                                                                            <?= session()->getFlashData('validasi_kalender'); ?>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                <?php elseif ($validasi_matkul_tanggal) : ?>
                                                                    <div class="invalid-feedback">
                                                                        <?= $validasi_matkul_tanggal; ?>
                                                                    </div>
                                                                <?php elseif ($validasi_tanggal) : ?>
                                                                    <div class="invalid-feedback">
                                                                        <?= $validasi_tanggal; ?>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>

                                                        <!-- Waktu ujian -->
                                                        <div class="row mb-3 g-6">
                                                            <label for="mata_kuliah" class="col-sm-3 col-form-label">Jam Ujian</label>
                                                            <div class="col">
                                                                <input type="time" class="form-control  <?= (($fail_kalender == 'waktu') || $validasi_waktu)  ? 'is-invalid' : ' '; ?>" id="waktu_mulai_ujian" name="waktu_mulai_ujian" value="<?= old('waktu_mulai_ujian') ?>" required>

                                                                <!-- Validasi waktu mulai ujian -->
                                                                <?php if ($validasi_kalender) : ?>
                                                                    <div class="invalid-feedback">
                                                                        <?php if ($fail_kalender == "tanggal_waktu") : ?>
                                                                            <?= session()->getFlashData('validasi_kalender'); ?>
                                                                        <?php elseif ($fail_kalender == "waktu") : ?>
                                                                            <?= session()->getFlashData('validasi_kalender'); ?>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                <?php elseif ($validasi_waktu) : ?>
                                                                    <div class="invalid-feedback">
                                                                        <?= $validasi_waktu; ?>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="col-1 text-xl-center">-</div>
                                                            <div class="col">
                                                                <input type="time" class="form-control <?= ($validasi_waktu_tidak_sesuai || $validasi_waktu) ? 'is-invalid' : ' '; ?>" id="waktu_selesai_ujian" name="waktu_selesai_ujian" value="<?= old('waktu_selesai_ujian') ?>" required>

                                                                <!-- validasi waktu selesai ujian -->
                                                                <?php if ($validasi_waktu_tidak_sesuai) : ?>
                                                                    <div class="invalid-feedback">
                                                                        <?= $validasi_waktu_tidak_sesuai; ?>
                                                                    </div>
                                                                <?php elseif ($validasi_waktu) : ?>
                                                                    <div class="invalid-feedback">
                                                                        <?= $validasi_waktu; ?>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>

                                                        <!--Ruangan -->
                                                        <div class="row mb-3">
                                                            <label for="ruangan" class="col-sm-3 col-form-label">Ruang Ujian</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control" id="ruangan" name="ruangan" value="<?= old('ruangan') ?>" required>
                                                            </div>
                                                        </div>

                                                        <!-- Keterangan -->
                                                        <div class="form-floating">
                                                            <textarea class="form-control" placeholder="Masukan keterangan tambahan (opsional)" id="keterangan" name="keterangan"><?= old('keterangan') ?></textarea>
                                                            <label for="floatingTextarea">Keterangan (opsional)</label>
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

<!-- Modal jadwal ujian -->
<?php if (!empty($jadwal)) : ?>
    <?php foreach ($jadwal as $j) : ?>
        <!-- Modal Delete Jadwal-->
        <div class="modal fade" id="delJadwal<?= $j['id_jadwal_ujian']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: darkred">
                        <h5 class="modal-title text-white" id="exampleModalLabel">Hapus <?= $j['mata_kuliah']; ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="/jadwalUjian/<?= $j['id_jadwal_ujian']; ?>" method="post">
                        <div class="modal-body">
                            <div class="container-fluid">
                                <p>Apakah anda yakin ingin menghapus jadwal ujian <?= $j['mata_kuliah']; ?> ini?</p>
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

        <!-- Modal Edit Jadwal -->
        <div class="modal fade" id="editJadwal<?= $j['id_jadwal_ujian']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: gold;">
                        <h4 class="modal-title" id="exampleModalLabel" style=" color:black"> Edit Jadwal <?= $j['mata_kuliah']; ?></h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Pesan Keberhasilan Edit -->
                    <?php
                    $matkul_invalid = '';
                    $tanggal_invalid = '';
                    $waktu_mulai_invalid = '';
                    $waktu_selesai_invalid = '';
                    $old_matkul = $j['mata_kuliah'];
                    $old_tanggal = $j['tanggal_ujian'];
                    $old_waktu_mulai = $j['waktu_mulai_ujian'];
                    $old_waktu_selesai = $j['waktu_selesai_ujian'];
                    $old_ruangan =  $j['ruangan'];
                    $old_keterangan =  $j['keterangan'];
                    ?>
                    <?php if (session()->getFlashData('idUjian') == $j['id_jadwal_ujian']) : ?>
                        <?php
                        $old_ruangan = old('ruangan');
                        $old_keterangan = old('keterangan');
                        ?>
                        <?php if (session()->getFlashData('berhasil')) : ?>
                            <div class="alert alert-success" role="alert">
                                <?= session()->getFlashData('berhasil'); ?>
                            </div>
                        <?php elseif ($validasi_matkul_tanggal) : ?>
                            <?php
                            $matkul_invalid = 'is-invalid';
                            $tanggal_invalid = 'is-invalid';
                            $old_matkul = old('mata_kuliah');
                            ?>
                            <div class="alert alert-warning" role="alert">
                                Saran : <?= session()->getFlashData('saran_matkul_tanggal'); ?>
                            </div>
                        <?php elseif ($validasi_kalender) : ?>
                            <?php
                            if ($fail_kalender == 'tanggal') {
                                $tanggal_invalid = 'is-invalid';
                                $old_tanggal = old('tanggal_ujian');
                            } else {
                                $waktu_mulai_invalid = 'is-invalid';
                                $old_waktu_mulai = old('waktu_mulai_ujian');
                            }
                            ?>
                            <div class="alert alert-warning" role="alert">
                                Saran : <?= session()->getFlashData('saran_kalender'); ?>
                            </div>

                        <?php elseif ($validasi_tanggal) : ?>
                            <?php
                            $tanggal_invalid = 'is-invalid';
                            $old_tanggal = old('tanggal_ujian');
                            $waktu_mulai_invalid = 'is-invalid';
                            $old_waktu_mulai = old('waktu_mulai_ujian');
                            $waktu_selesai_invalid = 'is-invalid';
                            $old_waktu_selesai = old('waktu_selesai_ujian');
                            ?>
                            <div class="alert alert-warning" role="alert">
                                Saran : <?= session()->getFlashData('saran_tanggal_waktu'); ?>
                            </div>
                        <?php elseif ($validasi_waktu_tidak_sesuai) : ?>
                            <?php
                            $waktu_mulai_invalid = 'is-invalid';
                            $old_waktu_mulai = old('waktu_selesai_ujian');
                            $waktu_selesai_invalid = 'is-invalid';
                            $old_waktu_selesai = old('waktu_selesai_ujian');
                            ?>
                            <div class="alert alert-warning" role="alert">
                                Saran : <?= session()->getFlashData('saran_waktu_tidak_sesuai'); ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <div class=" modal-body">
                        <form action="/jadwalUjian/editJadwal" method="post">
                            <?= csrf_field(); ?>
                            <!-- Inputan tersembunyi id_jadwal untuk mengirimkan id_jadwal ke form -->
                            <input type="hidden" id="validasi_id_jadwal_ujian" name="id_jadwal_ujian" value=<?= $j['id_jadwal_ujian']; ?>>

                            <!--Mata Kuliah -->
                            <div class="row mb-3">
                                <label for="mata_kuliah" class="fw-bold col-sm-3 col-form-label-sm">Mata Kuliah</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control <?= $matkul_invalid ?>" id="mata_kuliah" name="mata_kuliah" value="<?= $old_matkul ?>" autofocus required>

                                    <!-- Validasi Mata Kuliah_Tanggal -->
                                    <?php if (session()->getFlashData('idUjian') == $j['id_jadwal_ujian']) : ?>
                                        <?php if (session()->getFlashData('validasi_matkul_tanggal')) : ?>
                                            <div class="invalid-feedback">
                                                <?= session()->getFlashData('validasi_matkul_tanggal'); ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Input Tanggal Ujian -->
                            <div class="row mb-3">
                                <label for="tanggal_ujian" class="fw-bold col-sm-3 col-form-label-sm">Tanggal Ujian</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control <?= $tanggal_invalid ?>" id="tanggal_ujian" name="tanggal_ujian" value="<?= $old_tanggal ?>" required>

                                    <!-- Validasi Tanggal_ujian -->
                                    <?php if (session()->getFlashData('idUjian') == $j['id_jadwal_ujian']) : ?>
                                        <?php if ($validasi_kalender) : ?>
                                            <?php if ($fail_kalender == "tanggal_waktu") : ?>
                                                <div class="invalid-feedback">
                                                    <?= session()->getFlashData('validasi_kalender'); ?>
                                                </div>
                                            <?php elseif ($fail_kalender == "tanggal") : ?>
                                                <div class="invalid-feedback">
                                                    <?= session()->getFlashData('validasi_kalender'); ?>
                                                </div>
                                            <?php endif; ?>
                                        <?php elseif ($validasi_matkul_tanggal) : ?>
                                            <div class="invalid-feedback">
                                                <?= $validasi_matkul_tanggal; ?>
                                            </div>
                                        <?php elseif ($validasi_tanggal) : ?>
                                            <div class="invalid-feedback">
                                                <?= $validasi_tanggal; ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Waktu ujian -->
                            <div class="row mb-3">
                                <label for="waktu_mulai_ujian" class="fw-bold col-sm-3 col-form-label-sm">Jam Ujian</label>
                                <!-- waktu mulai ujian -->
                                <div class="col-sm-4">
                                    <input type="time" class="form-control <?= $waktu_mulai_invalid ?>" id="waktu_mulai_ujian" name="waktu_mulai_ujian" value="<?= $old_waktu_mulai ?>" required>

                                    <!-- Validasi waktu mulai ujian -->
                                    <?php if (session()->getFlashData('idUjian') == $j['id_jadwal_ujian']) : ?>
                                        <?php if ($validasi_kalender) : ?>
                                            <div class="invalid-feedback">
                                                <?= session()->getFlashData('validasi_kalender'); ?>
                                            </div>
                                        <?php elseif ($validasi_waktu) : ?>
                                            <div class="invalid-feedback">
                                                <?= $validasi_waktu; ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>

                                <div class="col-1 d-inline-flex flex-shrink-1 justify-content-center align-items-center px-0">-</div>

                                <!-- Waktu selesai ujian -->
                                <div class="col-sm-4">
                                    <input type="time" class="form-control <?= $waktu_selesai_invalid ?>" id="waktu_selesai_ujian" name="waktu_selesai_ujian" value="<?= $old_waktu_selesai ?>" required>
                                    <!-- validasi waktu selesai ujian -->
                                    <?php if (session()->getFlashData('idUjian') == $j['id_jadwal_ujian']) : ?>
                                        <?php if ($validasi_waktu_tidak_sesuai) : ?>
                                            <div class="invalid-feedback">
                                                <?= $validasi_waktu_tidak_sesuai; ?>
                                            </div>
                                        <?php elseif ($validasi_waktu) : ?>
                                            <div class="invalid-feedback">
                                                <?= $validasi_waktu; ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!--Ruangan -->
                            <div class="row mb-3">
                                <label for="ruangan" class="fw-bold col-sm-3 col-form-label-sm">Ruang Ujian</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="ruangan" name="ruangan" value="<?= $old_ruangan ?>" required>
                                </div>
                            </div>

                            <!-- Keterangan -->
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Masukan keterangan tambahan (opsional)" id="keterangan" name="keterangan"><?= $old_keterangan ?></textarea>
                                <label for="floatingTextarea">Keterangan (opsional)</label>
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
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?= $this->endSection(); ?>