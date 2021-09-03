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
                        <button type="button" class="btn btn-primary btn-sm mt-3" data-toggle="modal" data-target="#addAdmin">
                            Tambah Jadwal Ujian
                        </button>
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
                                    <th scope="col">Detail</th>
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
                                            <a class="btn btn-warning btn-sm" href="<?= base_url('/viewJadwal/' . $j['nim']); ?>">Detail</a>
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


<?= $this->endSection(); ?>