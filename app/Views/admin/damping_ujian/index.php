<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid px-6 py-4">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="row mb-6">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="mb-2 mt-2" style="display: flex; justify-content: space-between; align-items:center">
                        <h2><?= $title; ?> Mahasiswa Difabel</h2>
                        <!-- Button trigger modal -->
                        <a class="btn btn-primary btn-sm mt-3" href="<?= base_url('generate'); ?>">Generate Jadwal Damping Ujian</a>
                    </div>
                    <?= view('Myth\Auth\Views\_message_block') ?>

                    <!-- flash data -->
                    <?php if (session()->getFlashdata('pesan')) : ?>
                        <div class="alert alert-success" role="alert">
                            <?= session()->getFlashdata('pesan'); ?>
                        </div>
                    <?php endif; ?>
                    <!-- Basic table -->
                    <div class="table-responsive">
                        <table class="table table-hover table-dark" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                            <thead class="text-center">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">NIM</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Fakultas</th>
                                    <th scope="col">Jumlah Didampingi</th>
                                    <th scope="col">Jumlah Tidak Didampingi</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-center table-light">

                                <tr class="align-middle">
                                    <th scope="row">1</th>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                    <td>@mdo</td>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                    <td class="text-center">
                                        <a class="btn btn-warning btn-sm" href="#">Detail</a>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection(); ?>