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

<div class="container-fluid px-6 py-4">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="row mb-6">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
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
                    <div class="mb-2 mt-2" style="display: flex; justify-content: space-between; align-items:center">
                        <h2><?= $title; ?></h2>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-sm btn-primary d-none d-md-block" data-bs-toggle="modal" data-bs-target="#addJadwal">Tambah Jadwal Ujian</button>
                    </div>

                    <!-- Basic table -->
                    <div class="table-responsive">
                        <table class="table table-hover table-dark" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                            <thead class="text-center">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">NIM</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Fakultas</th>
                                    <th scope="col">Semester</th>
                                    <th scope="col">Jumlah Ujian</th>
                                    <th scope="col">UTS</th>
                                    <th scope="col">UAS</th>
                                </tr>
                            </thead>
                            <tbody class="text-center table-light">
                                <?php $i = 1 ?>
                                <?php foreach ($jadwal_ujian as $j) : ?>
                                    <tr class="align-middle">
                                        <th scope="row"><?= $i++; ?></th>
                                        <td><?= $j['nim']; ?></td>
                                        <td><?= $j['nama']; ?></td>
                                        <td><?= $j['fakultas']; ?></td>
                                        <td><?= $j['semester']; ?></td>
                                        <td><?= $j['jumlah_ujian']; ?></td>
                                        <td class="text-center">
                                            <a class="btn btn-warning btn-sm" href="<?= base_url('/viewJadwalUTS/' . $j['nim']); ?>">Detail</a>
                                        </td>
                                        <td class="text-center">
                                            <a class="btn btn-warning btn-sm" href="<?= base_url('/viewJadwalUAS/' . $j['nim']); ?>">Detail</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Jadwal Ujian-->
<div class="modal fade" id="addJadwal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header" style="background-color: rgba(0, 136, 120, 1)">
                <h5 class="modal-title" id="exampleModalLabel" style=" color:white">Tambah Jadwal Ujian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Form -->
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
            <form action="/c_jadwal_ujian/saveJadwal" method="POST">
                <div class="modal-body">
                    <?= csrf_field(); ?>

                    <!-- Id_admin -->
                    <input type="hidden" name="admin" value="admin">

                    <!-- Pilih Mahasiswa-->
                    <div class="row mb-3">
                        <label for="id_profile_mhs" class="col-sm-4 col-form-label">Mahasiswa</label>
                        <div class="col-sm-8">
                            <select class="form-select" aria-label="Default select example" name="id_profile_mhs" id="id_profile_mhs" autofocus required>
                                <option value='null' selected>Pilih <?= $jenis_mhs; ?></option>
                                <?= $count = 1; ?>
                                <?php for ($i = 0; $i < count($all_mhs); $i++) : ?>
                                    <option value="<?= $all_mhs[$i]['id_profile_mhs']; ?>"> <?= $count . '. ' . $all_mhs[$i]['nickname'] . ' (' . $all_mhs[$i]['fakultas'] . ')'; ?></option>
                                    <?php $count++; ?>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>

                    <!--Mata Kuliah -->
                    <div class="row mb-3">
                        <label for="mata_kuliah" class="col-sm-4 col-form-label">Mata Kuliah</label>
                        <div class="col-sm-8">
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
                        <label for="tanggal_ujian" class="col-sm-4 col-form-label">Tanggal Ujian</label>
                        <div class="col-sm-8">
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
                        <label for="mata_kuliah" class="col-sm-4 col-form-label">Jam Ujian</label>
                        <div class="col-sm-3">
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
                        <p class="col-sm-2 text-center px-0">-</p>
                        <div class="col-sm-3">
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
                        <label for="ruangan" class="col-sm-4 col-form-label">Ruang Ujian</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="ruangan" name="ruangan" value="<?= old('ruangan') ?>" required>
                        </div>
                    </div>

                    <!-- Keterangan -->
                    <div class="form-floating">
                        <textarea class="form-control" placeholder="Masukan keterangan tambahan (opsional)" id="keterangan" name="keterangan"><?= old('keterangan') ?></textarea>
                        <label for="floatingTextarea">Keterangan (opsional)</label>
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

<?= $this->endSection(); ?>