<?= $this->extend('templatesUser/index'); ?>
<?= $this->section('page-content'); ?>

<div class="container">
    <div class="row">
        <div class="col-8">
            <h2 style="display:flex;">Form Memasukkan Jadwal Ujian</h2>
            <hr>
            <!-- Variabel session -->
            <?php
            $fail_kalender = session()->getFlashData('fail_kalender');
            $validasi_kalender = session()->getFlashData('validasi_kalender');
            $validasi_waktu_tidak_sesuai = session()->getFlashData('validasi_waktu_tidak_sesuai');
            $validasi_matkul_tanggal = session()->getFlashData('validasi_matkul_tanggal');
            $validasi_tanggal = session()->getFlashData('validasi_tanggal');
            $validasi_waktu = session()->getFlashData('validasi_waktu');
            ?>

            <!-- Pesan Keberhasilan Input -->
            <?php if (session()->getFlashData('berhasil')) : ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashData('berhasil'); ?>
                </div>
            <?php elseif ($validasi_kalender) : ?>
                <div class="alert alert-warning" role="alert">
                    Saran : <?= session()->getFlashData('saran_kalender'); ?>
                </div>
            <?php elseif ($validasi_waktu_tidak_sesuai) : ?>
                <div class="alert alert-warning" role="alert">
                    Saran : <?= session()->getFlashData('saran_waktu_tidak_sesuai'); ?>
                </div>
            <?php elseif ($validasi_matkul_tanggal) : ?>
                <div class="alert alert-warning" role="alert">
                    Saran : <?= session()->getFlashData('saran_matkul_tanggal'); ?>
                </div>
            <?php elseif ($validasi_tanggal) : ?>
                <div class="alert alert-warning" role="alert">
                    Saran : <?= session()->getFlashData('saran_tanggal_waktu'); ?>
                </div>

            <?php endif; ?>

            <!-- Form Tambah Jadwal Ujian -->
            <form action="/jadwalUjian/save" method="POST">
                <?= csrf_field(); ?>
                
                <!-- Input Mata Kuliah -->
                <div class="form-group row">
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
                <div class="form-group row">
                    <label for="tanggal_ujian" class="col-sm-3 col-form-label">Tanggal Ujian</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control <?= (($fail_kalender == 'tanggal') || $validasi_matkul_tanggal || $validasi_tanggal)  ? 'is-invalid' : ' '; ?>" id="tanggal_ujian" name="tanggal_ujian" value="<?= old('tanggal_ujian') ?>" required>

                        <!-- Validasi Mata Kuliah_Tanggal -->
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

                <!-- Input Waktu Mulai Ujian -->
                <div class="form-group row">
                    <label for="mulai_waktu_ujian" class="col-sm-3 col-form-label">Jam Mulai Ujian</label>
                    <div class="col-sm-9">
                        <input type="time" class="form-control <?= (($fail_kalender == 'waktu') || $validasi_waktu)  ? 'is-invalid' : ' '; ?>" id="mulai_waktu_ujian" name="mulai_waktu_ujian" value="<?= old('mulai_waktu_ujian') ?>" required>
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
                </div>

                <!-- Input Waktu Selesai Ujian -->
                <div class="form-group row">
                    <label for="selesai_waktu_ujian" class="col-sm-3 col-form-label">Jam Selesai Ujian</label>
                    <div class="col-sm-9">
                        <input type="time" class="form-control <?= ($validasi_waktu_tidak_sesuai || $validasi_waktu) ? 'is-invalid' : ' '; ?>" id="selesai_waktu_ujian" name="selesai_waktu_ujian" value="<?= old('selesai_waktu_ujian') ?>" required>
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

                <!-- Input Ruangan Ujian -->
                <div class="form-group row">
                    <label for="ruangan" class="col-sm-3 col-form-label">Ruangan</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="ruangan" name="ruangan" value="<?= old('ruangan') ?>" required>
                    </div>
                </div>

                <!-- Input Keterangan -->
                <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <textarea class="form-control" id="keterangan" rows="3" name="keterangan"></textarea>
                </div>

                <!-- Submit button -->
                <div class="form-group row">
                    <div class="col-sm-9">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>