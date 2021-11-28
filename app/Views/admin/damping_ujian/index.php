<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid px-6 py-4">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="row mb-6">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="mb-2 mt-2" style="display: flex; justify-content: space-between; align-items:center">
                        <h2><?= $title; ?></h2>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#generate" ?>
                            Generate Pendampingan Ujian
                        </button>
                    </div>
                    <div class="row">
                        <div class="col-auto">
                            <h4><span class="badge bg-success text-dark-50">Jenis Ujian: <?= $jenis_ujian; ?></span></h4>
                        </div>
                        <div class="col-auto">
                            <h4><span class="badge bg-warning text-dark">Tanggal Generate: <?= $tanggal_generate; ?></span></h4>
                        </div>
                    </div>
                    <?php if (session()->getFlashData('berhasil_digenerate')) : ?>
                        <div class="alert alert-success" role="alert">
                            <?= session()->getFlashData('berhasil_digenerate'); ?>
                        </div>
                    <?php elseif (session()->getFlashData('gagal_jenis_ujian')) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?= session()->getFlashData('gagal_jenis_ujian'); ?>
                        </div>
                    <?php elseif (session()->getFlashData('jadwal_madif_tidak_tersedia')) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?= session()->getFlashData('jadwal_madif_tidak_tersedia'); ?>
                        </div>
                    <?php elseif (session()->getFlashData('gagal_generate_madif')) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?= session()->getFlashData('gagal_generate_madif'); ?>
                        </div>
                    <?php elseif (session()->getFlashData('gagal_generate_pendamping')) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?= session()->getFlashData('gagal_generate_pendamping'); ?>
                        </div>
                    <?php elseif (session()->getFlashData('gagal_generate_status_pendamping')) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?= session()->getFlashData('gagal_generate_status_pendamping'); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Basic table -->
                    <div class="table-responsive">
                        <table class="table table-hover table-dark" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">NIM</th>
                                    <th scope="col">Mahasiswa Difabel</th>
                                    <th scope="col">Fakultas</th>
                                    <th scope="col">Jumlah Didampingi</th>
                                    <th scope="col">Jumlah Tidak Didampingi</th>
                                    <th scope="col">Detail</th>
                                </tr>
                            </thead>
                            <tbody class="table-light">
                                <?php if ($data) : ?>
                                    <?php $count = 1; ?>
                                    <?php foreach ($himpunan_damping_madif as $key_hm) : ?>
                                        <tr>
                                            <th><?= $count++; ?></th>
                                            <td><?= $key_hm['nim']; ?></td>
                                            <td><?= $key_hm['nama']; ?></td>
                                            <td><?= $key_hm['fakultas']; ?></td>
                                            <td><?= $key_hm['jumlah_didampingi']; ?></td>
                                            <td><?= $key_hm['jumlah_tidak_didampingi']; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-info btn-sm editJadwal" data-bs-toggle="modal" data-bs-target="#detailDamping<?= $key_hm['id_profile_madif']; ?>" ?>
                                                    Detail
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td class="text-center text-black-50" colspan="7">Data tidak ditemukan</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Generate-->
<div class="modal fade" id="generate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header" style="background-color: blueviolet">
                <h5 class="modal-title text-white" id="exampleModalLabel">Generate Jadwal Pendampingan Ujian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Form -->
            <form action="<?= base_url('c_damping_ujian/generate'); ?>" method="POST">
                <div class="modal-body">
                    <?= csrf_field(); ?>

                    <!--Jenis Ujian-->
                    <div class="row mb-3">
                        <label for="jenis_ujian" class="col-sm-6 col-form-label">Jenis Ujian</label>
                        <div class="col-sm-6">
                            <select class="form-select" aria-label="Default select example" name="jenis_ujian" id="jenis_ujian" autofocus required>
                                <option value='' selected>Jenis Ujian</option>
                                <option value='UTS'>UTS</option>
                                <option value='UAS'>UAS</option>
                            </select>
                        </div>
                    </div>

                </div>
                <!-- Submit button -->
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        Generate
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php if (isset($hasil_jadwal_damping)) : ?>
    <?php foreach ($hasil_jadwal_damping as $key_hjd => $value_hjd) : ?>
        <!-- Modal Detail Damping-->
        <div class="modal fade" id="detailDamping<?= $key_hjd; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered  modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: darkblue">
                        <h5 class="modal-title text-white" id="exampleModalLabel">Detail Pendampingan <?= $value_hjd[0]['biodata_madif']['nickname']; ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p style="color: red;">catatan: tanda (-) menunjukkan tidak ada pendamping</p>
                        <form action="/c_jadwal_ujian/delJadwal" method="post">
                            <!-- Basic table -->
                            <div class="table-responsive">
                                <table class="table table-hover table-dark" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                                    <thead>
                                        <tr>
                                            <th scope="col">No.</th>
                                            <th scope="col">Mata Kuliah</th>
                                            <th scope="col">Tanggal Ujian</th>
                                            <th scope="col">Waktu Ujian</th>
                                            <th scope="col">Pendamping</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-light">
                                        <?php $i = 1; ?>
                                        <?php foreach ($value_hjd as $jadwal_damping) : ?>
                                            <tr class="align-middle">
                                                <th scope="row"><?= $i; ?></th>
                                                <td><?= $jadwal_damping['jadwal_ujian']['mata_kuliah']; ?></td>
                                                <td><?= $jadwal_damping['jadwal_ujian']['tanggal_ujian']; ?></td>
                                                <td><?= date('H:i', strtotime($jadwal_damping['jadwal_ujian']['waktu_mulai_ujian'])) . ' - ' . date('H:i', strtotime($jadwal_damping['jadwal_ujian']['waktu_selesai_ujian'])); ?></td>
                                                <td><?= isset($jadwal_damping['biodata_pendamping']) ? $jadwal_damping['biodata_pendamping']['nickname'] : '-'; ?></td>
                                                <?php $i++; ?>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?= $this->endSection(); ?>