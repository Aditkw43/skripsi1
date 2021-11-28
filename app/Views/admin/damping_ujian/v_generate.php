<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid px-6 py-4">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="row mb-6">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                    <div class="mb-2 mt-2" style="display: flex; justify-content: space-between; align-items:center">
                        <h2><?= $title; ?></h2>
                        <div class="my-2" style="display: flex; align-items:right">
                            <?php if (!count($v_tidak_didampingi) == 0) : ?>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-warning btn-sm mt-3 mx-1 editJadwal" data-bs-toggle="modal" data-bs-target="#cekTidakDamping" ?>
                                    Cek Tidak Didampingi
                                </button>
                            <?php endif; ?>

                            <!-- Button trigger modal -->
                            <a class="btn btn-danger btn-sm mt-3 mx-1" href="<?= base_url('c_damping_ujian'); ?>">Hapus Generate</a>
                            <form action="<?= base_url('c_damping_ujian/saveGenerate'); ?>" method="post">
                                <?php foreach ($value_generate as $vgs) : ?>
                                    <input type="hidden" name="v_damping[id_jadwal_ujian_madif][]" value="<?= $vgs['id_jadwal_ujian_madif']; ?>">
                                    <input type="hidden" name="v_damping[id_profile_madif][]" value="<?= $vgs['id_profile_madif']; ?>">
                                    <input type="hidden" name="v_damping[id_profile_pendamping][]" value="<?= $vgs['id_profile_pendamping']; ?>">
                                    <input type="hidden" name="v_damping[ref_pendampingan][]" value="<?= $vgs['ref_pendampingan']; ?>">
                                    <input type="hidden" name="v_damping[prioritas][]" value="<?= $vgs['prioritas']; ?>">
                                    <input type="hidden" name="v_damping[jenis_ujian][]" value="<?= $vgs['jenis_ujian']; ?>">
                                <?php endforeach; ?>
                                <!-- Button trigger modal -->
                                <button class="btn btn-success btn-sm mt-3 mx-1">Simpan Generate</a>
                            </form>
                        </div>
                    </div>

                    <!-- Basic table -->
                    <div class="table-responsive">
                        <table class="table table-light" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                            <thead class="text-center">
                                <tr>
                                    <th scope="col">Total Madif Didampingi</th>
                                    <th scope="col">Total Madif Tidak Didampingi</th>
                                </tr>
                            </thead>
                            <tbody class="text-center table-light">
                                <tr>
                                    <td><?= count($value_generate) - count($v_tidak_didampingi); ?></td>
                                    <td><?= count($v_tidak_didampingi); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

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
                                <?php $i = 1 ?>
                                <?php foreach ($madif as $m) : ?>
                                    <tr class="align-middle">
                                        <th scope="row"><?= $i; ?></th>
                                        <td><?= $m['nim']; ?></td>
                                        <td><?= $m['nama']; ?></td>
                                        <td><?= $m['fakultas']; ?></td>
                                        <td><?= $m['jumlah_didampingi']; ?></td>
                                        <td><?= $m['jumlah_tidak_didampingi']; ?></td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-info btn-sm editJadwal" data-bs-toggle="modal" data-bs-target="#detailDamping<?= $m['id_profile_madif']; ?>" ?>
                                                Detail
                                            </button>
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php foreach ($madif as $md) : ?>
    <!-- Modal Detail Damping-->
    <div class="modal fade" id="detailDamping<?= $md['id_profile_madif']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color: darkblue">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Detail Pendampingan <?= $md['nama']; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p style="color: red;">catatan: tanda (-) menunjukkan data tidak tersedia</p>
                    <form action="/c_jadwal_ujian/delJadwal" method="post">
                        <!-- Basic table -->
                        <div class="table-responsive">
                            <table class="table table-hover table-dark" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                                <thead>
                                    <tr>
                                        <th scope="col">No.</th>
                                        <th scope="col">Mata Kuliah</th>
                                        <th scope="col">Pendamping</th>
                                        <th scope="col">Ref. Pendampingan</th>
                                        <th scope="col">Prioritas</th>
                                    </tr>
                                </thead>
                                <tbody class="table-light">
                                    <?php $i = 1; ?>
                                    <?php if (!(count($v_tidak_didampingi) == count($hasil_generate))) : ?>
                                        <?php foreach ($hasil_generate as $hg) : ?>
                                            <?php if ($hg['id_profile_madif'] == $md['id_profile_madif'] && $hg['nama_pendamping'] != null) : ?>
                                                <tr class="align-middle">
                                                    <th scope="row"><?= $i; ?></th>
                                                    <td><?= $hg['mata_kuliah']; ?></td>
                                                    <td><?= $hg['nama_pendamping']; ?></td>
                                                    <td><?= $hg['ref_pendampingan']; ?></td>
                                                    <td><?= $hg['prioritas']; ?></td>
                                                </tr>
                                            <?php elseif ($hg['id_profile_madif'] == $md['id_profile_madif']) : ?>
                                                <tr class="align-middle">
                                                    <th scope="row"><?= $i; ?></th>
                                                    <td><?= $hg['mata_kuliah']; ?></td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                </tr>
                                            <?php else : continue; ?>
                                            <?php endif; ?>
                                            <?php $i++; ?>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-black-50">Data tidak tersedia</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php foreach ($hasil_generate as $detail) : ?>
        <!-- Detail jadwal damping ujian -->
        <div class="modal fade" id="detailJadwalDamping<?= $detail['nama_madif']; ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalToggleLabel2"><?= $detail['nama_madif']; ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Hide this modal and show the first with the button below.
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" data-bs-target="detailDamping<?= $detail['id_profile_madif']; ?>" data-bs-toggle="modal" data-bs-dismiss="modal">Back to first</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

<?php endforeach; ?>


<!-- Modal Cek Tidak Didampingi-->
<div class="modal fade" id="cekTidakDamping" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="background-color: rgba(222, 222, 22, 1);">
                <h5 class="modal-title text-black" id="exampleModalLabel">Cek Madif Tidak Didampingi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="/c_jadwal_ujian/delJadwal" method="post">
                    <!-- Basic table -->
                    <div class="table-responsive">
                        <p style="color: red;">Jumlah Madif Tidak Didampingi: <?= count($v_tidak_didampingi); ?></p>
                        <table class="table table-hover table-dark" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                            <thead class="text-center">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Tanggal Ujian</th>
                                    <th scope="col">Mahasiswa Difabel</th>
                                    <th scope="col">Pendamping</th>
                                    <th scope="col">Mata Kuliah</th>
                                    <th scope="col">Waktu Ujian</th>
                                </tr>
                            </thead>
                            <tbody class="text-center table-light">
                                <?php $i = 1 ?>
                                <?php foreach ($v_tidak_didampingi as $vtd) : ?>
                                    <tr class="align-middle">
                                        <th scope="row"><?= $i; ?></th>
                                        <td><?= date('d, M Y', strtotime($vtd['tanggal_ujian'])); ?></td>
                                        <td><?= $vtd['nama_madif']; ?></td>
                                        <td style="color: red;"><?= $vtd['nama_pendamping']; ?></td>
                                        <td><?= $vtd['mata_kuliah']; ?></td>
                                        <td><?= date('H:i', strtotime($vtd['waktu_mulai_ujian'])); ?> - <?= date('H:i', strtotime($vtd['waktu_selesai_ujian'])); ?></td>
                                    </tr>
                                    <?php $i++; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>