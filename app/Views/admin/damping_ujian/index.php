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
                    <?php if (session()->getFlashData('berhasil_digenerate')) : ?>
                        <div class="alert alert-success" role="alert">
                            <?= session()->getFlashData('berhasil_digenerate'); ?>
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
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="table-light">
                                <tr>
                                    <th></th>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
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
                                <option value='null' selected>Jenis Ujian</option>
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

<?= $this->endSection(); ?>