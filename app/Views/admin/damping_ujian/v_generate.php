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
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-warning btn-sm mt-3 mx-1 editJadwal" data-bs-toggle="modal" data-bs-target="#cekDamping" ?>
                                Cek Tidak Didampingi
                            </button>

                            <!-- Button trigger modal -->
                            <a class="btn btn-danger btn-sm mt-3 mx-1" href="<?= base_url('c_damping_ujian'); ?>">Hapus Generate</a>

                            <!-- Button trigger modal -->
                            <a class="btn btn-success btn-sm mt-3 mx-1" href="<?= base_url('saveGenerate'); ?>">Simpan Generate</a>
                        </div>
                    </div>

                    <!-- Basic table -->
                    <div class="table-responsive">
                        <table class="table table-hover table-dark" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                            <thead class="text-center">
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
                            <tbody class="text-center table-light">

                                <?php $i = 1 ?>
                                <?php foreach ($v_damping as $v) : ?>
                                    <tr class="align-middle">
                                        <th scope="row"><?= $i; ?></th>
                                        <td><?= $v['nim']; ?></td>
                                        <td><?= $v['nama']; ?></td>
                                        <td><?= $v['fakultas']; ?></td>
                                        <td><?= $v['jumlah_didampingi']; ?></td>
                                        <td><?= $v['jumlah_tidak_didampingi']; ?></td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-info btn-sm editJadwal" data-bs-toggle="modal" data-bs-target="#detailDamping<?= $v['id_profile_madif']; ?>" ?>
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

<?php foreach ($v_damping as $vd) : ?>
    <!-- Modal Detail Damping-->
    <div class="modal fade" id="detailDamping<?= $vd['id_profile_madif']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background-color: darkblue">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Detail Pendampingan <?= $vd['nama']; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/c_jadwal_ujian/delJadwal" method="post">
                    <div class="modal-body">
                        <div class="container-fluid">
                            <p>Apakah anda yakin ingin menghapus jadwal ujian ini?</p>
                            <p>Jika iya, silahkan klik tombol <strong>"Hapus"</strong></p>
                            <?= csrf_field(); ?>
                            <!-- HTTP Spoofing -->
                            <input type="hidden" name="_method" value="DELETE">
                        </div>
                    </div>

                    <input type="hidden" name="id_jadwal_ujian" value="">

                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<!-- Modal Cek Tidak Didampingi-->
<div class="modal fade" id="cekDamping" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: rgba(222, 222, 22, 1);">
                <h5 class="modal-title text-black" id="exampleModalLabel">Cek Madif Tidak Didampingi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/c_jadwal_ujian/delJadwal" method="post">
                <div class="modal-body">
                    <div class="container-fluid">
                        <p>Apakah anda yakin ingin menghapus jadwal ujian ini?</p>
                        <p>Jika iya, silahkan klik tombol <strong>"Hapus"</strong></p>
                        <?= csrf_field(); ?>
                        <!-- HTTP Spoofing -->
                        <input type="hidden" name="_method" value="DELETE">
                    </div>
                </div>

                <input type="hidden" name="id_jadwal_ujian" value="">

                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?= $this->endSection(); ?>