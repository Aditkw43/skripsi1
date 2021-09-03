<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<?php

use App\Models\m_profile_mhs;

?>

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
                                    <th scope="col">NIM</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Fakultas</th>
                                    <th scope="col">Semester</th>
                                    <th scope="col">Jumlah Ujian</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-center table-light">
                                <?php $i = 1; ?>
                                <?php if ($jenis_mhs == 'madif') : ?>
                                    <?php foreach ($jadwal_madif as $j) : ?>
                                        <tr class="align-middle">
                                            <th scope="row"><?= $i++; ?></th>
                                            <td><?= $j['nim']; ?></td>
                                            <td><?= $j['fullname']; ?></td>
                                            <td><?= $j['fakultas']; ?></td>
                                            <td><?= $j['semester']; ?></td>
                                            <td><?php

                                                $jadwal_ujian = model(m_profile_mhs::class);
                                                $jumlah_ujian = $jadwal_ujian->getJumlahUjianMHS($j['nim']);
                                                echo $jumlah_ujian;

                                                ?></td>
                                            <td class="text-center">
                                                <a href="<?= base_url('admin/getJadwalMHS'); ?>/<?= $j['nim']; ?>" class="btn btn-info btn-sm">Detail</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <?php foreach ($jadwal_pendamping as $j) : ?>
                                        <tr class="align-middle">
                                            <th scope="row"><?= $i++; ?></th>
                                            <td><?= $j['nim']; ?></td>
                                            <td><?= $j['fullname']; ?></td>
                                            <td><?= $j['fakultas']; ?></td>
                                            <td><?= $j['semester']; ?></td>
                                            <td><?php

                                                $jadwal_ujian = model(m_profile_mhs::class);
                                                $jumlah_ujian = $jadwal_ujian->getJumlahUjianMHS($j['nim']);
                                                echo $jumlah_ujian;

                                                ?></td>
                                            <td class="text-center">
                                                <a href="<?= base_url('admin/getJadwalMHS'); ?>/<?= $j['nim']; ?>" class="btn btn-info btn-sm">Detail</a>
                                            </td>
                                        </tr>
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


<?= $this->endSection(); ?>