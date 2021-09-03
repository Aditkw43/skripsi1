<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid px-6 py-4">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="row mb-6">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="mb-2 mt-2" style="display: flex; justify-content: space-between; align-items:center">
                        <h2><?= $title; ?></h2>
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
                                    <th scope="col">Tanggal Ujian</th>
                                    <th scope="col">Nama Madif</th>
                                    <th scope="col">Mata Kuliah</th>
                                    <th scope="col">Jam Ujian</th>
                                    <th scope="col">Ruangan</th>
                                    <th scope="col">Keterangan</th>
                                    <th scope="col">Nama Pendamping</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-center table-light">
                                <?php $i = 1 ?>
                                <?php foreach ($hasil_generate as $h) : ?>
                                    <?php if (isset($h['nama_pendamping'])) : ?>
                                        <tr class="align-middle" style="font-size: 1rem;">
                                            <th scope="row"><?= $i; ?></th>
                                            <td><?= date('d M Y', strtotime($h['tanggal_ujian'])); ?></td>
                                            <td><?= $h['nama_madif']; ?></td>
                                            <td><?= $h['mata_kuliah']; ?></td>
                                            <td><?= date('H:i', strtotime($h['waktu_mulai_ujian'])); ?> - <?= date('H:i', strtotime($h['waktu_selesai_ujian'])); ?></td>
                                            <td><?= $h['ruangan']; ?></td>
                                            <td><?= $h['keterangan']; ?></td>
                                            <td><?= $h['nama_pendamping']; ?></td>
                                            <td class="text-center">
                                                <!-- Button trigger modal Detail Jadwal Ujian -->
                                                <button type="button" class="btn btn-warning editJadwal" data-bs-toggle="modal" data-bs-target="#editJadwal<?= $value_generate[$i - 1]['id_jadwal_ujian_madif']; ?>" ?>
                                                    <i class="fas fa-pen-square"></i>
                                                </button>


                                                <!-- Button Trigger Modal Hapus Jadwal Ujian -->
                                                <button type="submit" class="btn btn-danger my-1" data-bs-toggle="modal" data-bs-target="#delJadwal<?= $value_generate[$i - 1]['id_jadwal_ujian_madif']; ?>">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <?php $i++ ?>
                                    <?php endif; ?>
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