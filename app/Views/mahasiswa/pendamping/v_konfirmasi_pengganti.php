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

                    <!-- Card -->
                    <div class="card">

                        <!-- Tab table -->
                        <ul class="nav nav-line-bottom" id="pills-tab-table" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-table-daftar-konfirmasi-tab" data-bs-toggle="pill" href="#pills-table-daftar-konfirmasi" role="tab" aria-controls="pills-table-daftar-konfirmasi" aria-selected="true">Daftar Konfirmasi</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-table-konfirmasi-diterima-tab" data-bs-toggle="pill" href="#pills-table-konfirmasi-diterima" role="tab" aria-controls="pills-table-konfirmasi-diterima" aria-selected="true">Konfirmasi Diterima</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-table-konfirmasi-ditolak-tab" data-bs-toggle="pill" href="#pills-table-konfirmasi-ditolak" role="tab" aria-controls="pills-table-konfirmasi-ditolak" aria-selected="true">Konfirmasi Ditolak</a>
                            </li>
                        </ul>

                        <!-- Tab content -->
                        <div class=" tab-content p-4" id="pills-tabContent-table">

                            <!-- Daftar Konfirmasi Table -->
                            <div class="tab-pane tab-example-design fade show active" id="pills-table-daftar-konfirmasi" role="tabpanel" aria-labelledby="pills-table-daftar-konfirmasi-tab">
                                <div class="table-responsive">
                                    <table class="table table-hover table-dark" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                                        <thead>
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Tanggal</th>
                                                <th scope="col">Waktu Ujian</th>
                                                <th scope="col">Madif</th>
                                                <th scope="col">Pendamping</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Dokumen</th>
                                                <th scope="col">Detail</th>
                                            </tr>
                                        </thead>

                                        <tbody class="table-light">
                                            <?php if (!empty($get_konfirmasi)) : ?>
                                                <?php $i = 1 ?>
                                                <?php foreach ($get_konfirmasi as $approve1) : ?>
                                                    <tr class="align-middle">

                                                        <!-- Id izin -->
                                                        <input type="hidden" name="id_izin" value="<?= $approve1['id_izin']; ?>">

                                                        <!-- Nomor -->
                                                        <th scope="row"><?= $i; ?></th>

                                                        <!-- Tanggal -->
                                                        <td scope="row"><?= $approve1['jadwal_ujian']['tanggal_ujian']; ?></td>

                                                        <!-- Waktu Ujian -->
                                                        <td scope="row"><?= date('H:i', strtotime($approve1['jadwal_ujian']['waktu_mulai_ujian'])); ?> - <?= date('H:i', strtotime($approve1['jadwal_ujian']['waktu_selesai_ujian'])); ?> </td>

                                                        <!-- Madif -->
                                                        <td scope="row"><?= $approve1['madif']['nickname']; ?></td>

                                                        <!-- Pendamping -->
                                                        <td scope="row"><?= $approve1['pendamping_lama']['nickname']; ?></td>

                                                        <!-- Status -->
                                                        <td>
                                                            <a href="<?= base_url('c_perizinan/approval_izin/pengganti'); ?>/<?= $approve1['id_izin'], '/terima'; ?>" class="btn btn-success btn-sm my-1">Terima</a>
                                                            <a href="<?= base_url('c_perizinan/approval_izin/pengganti'); ?>/<?= $approve1['id_izin'], '/tolak'; ?>" class="btn btn-danger btn-sm">Tolak</a>
                                                        </td>

                                                        <!-- Dokumen -->
                                                        <td>
                                                            <?php if (isset($approve1['dokumen'])) : ?>
                                                                <a href="/img/dokumen_izin/izin/<?= $approve1['dokumen']; ?>" target="_blank" class="btn btn-secondary btn-sm"><i class="fa fa-download"></i> Dokumen</a>
                                                            <?php else : ?>
                                                                -
                                                            <?php endif; ?>

                                                        </td>

                                                        <!-- Detail -->
                                                        <td>
                                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#profile<?= $approve1['id_izin']; ?>" ?>
                                                                Profile
                                                            </button>

                                                            <button type="button" class="btn btn-warning btn-sm editJadwal" data-bs-toggle="modal" data-bs-target="#jadwal<?= $approve1['id_izin']; ?>" ?>
                                                                Jadwal
                                                            </button>
                                                        </td>

                                                    </tr>
                                                    <?php $i++; ?>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>

                                    </table>
                                </div>
                            </div>

                            <!-- Konfirmasi Diterima Table -->
                            <div class="tab-pane tab-example-html fade" id="pills-table-konfirmasi-diterima" role="tabpanel" aria-labelledby="pills-table-konfirmasi-diterima-tab">
                                <div class="table-responsive">
                                    <table class="table table-hover table-dark" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                                        <thead>
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Tanggal</th>
                                                <th scope="col">Waktu Ujian</th>
                                                <th scope="col">Madif</th>
                                                <th scope="col">Pendamping</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Dokumen</th>
                                                <th scope="col">Detail</th>
                                            </tr>
                                        </thead>

                                        <tbody class="table-light">
                                            <?php if (!empty($get_diterima)) : ?>
                                                <?php $i = 1 ?>
                                                <?php foreach ($get_diterima as $diterima) : ?>
                                                    <tr class="align-middle">

                                                        <!-- Id izin -->
                                                        <input type="hidden" name="id_izin" value="<?= $diterima['id_izin']; ?>">

                                                        <!-- Nomor -->
                                                        <th scope="row"><?= $i; ?></th>

                                                        <!-- Tanggal -->
                                                        <td scope="row"><?= $diterima['jadwal_ujian']['tanggal_ujian']; ?></td>

                                                        <!-- Waktu Ujian -->
                                                        <td scope="row"><?= date('H:i', strtotime($diterima['jadwal_ujian']['waktu_mulai_ujian'])); ?> - <?= date('H:i', strtotime($diterima['jadwal_ujian']['waktu_selesai_ujian'])); ?></td>

                                                        <!-- Madif -->
                                                        <td scope="row"><?= $diterima['madif']['nickname']; ?></td>

                                                        <!-- Pendamping -->
                                                        <td scope="row"><?= $diterima['pendamping_lama']['nickname']; ?></td>

                                                        <!-- Status -->
                                                        <?php if ($diterima['approval_admin'] === '1') : ?>
                                                            <td style="color: green">Terverifikasi</td>
                                                        <?php elseif ($diterima['approval_admin'] === '0') : ?>
                                                            <td style="color: red">Ditolak Admin</td>
                                                        <?php elseif (empty($gi['approval_admin'])) : ?>
                                                            <td style="color: blue">Menunggu Verifikasi Admin</td>
                                                        <?php endif; ?>

                                                        <!-- Dokumen -->
                                                        <td>
                                                            <?php if (isset($diterima['dokumen'])) : ?>
                                                                <a href="/img/dokumen_izin/izin/<?= $diterima['dokumen']; ?>" target="_blank" class="btn btn-secondary btn-sm"><i class="fa fa-download"></i> Dokumen</a>
                                                            <?php else : ?>
                                                                -
                                                            <?php endif; ?>

                                                        </td>

                                                        <!-- Detail -->
                                                        <td>
                                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#profile<?= $diterima['id_izin']; ?>" ?>
                                                                Profile
                                                            </button>

                                                            <button type="button" class="btn btn-warning btn-sm editJadwal" data-bs-toggle="modal" data-bs-target="#jadwal<?= $diterima['id_izin']; ?>" ?>
                                                                Jadwal
                                                            </button>
                                                        </td>

                                                    </tr>
                                                    <?php $i++; ?>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>

                                    </table>
                                </div>
                            </div>

                            <!-- Konfirmasi Ditolak Table -->
                            <div class="tab-pane tab-example-html fade" id="pills-table-konfirmasi-ditolak" role="tabpanel" aria-labelledby="pills-table-konfirmasi-ditolak-tab">
                                <div class="table-responsive">
                                    <table class="table table-hover table-dark" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                                        <thead>
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Tanggal</th>
                                                <th scope="col">Waktu Ujian</th>
                                                <th scope="col">Madif</th>
                                                <th scope="col">Pendamping</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Dokumen</th>
                                                <th scope="col">Detail</th>
                                            </tr>
                                        </thead>

                                        <tbody class="table-light">
                                            <?php if (!empty($get_ditolak)) : ?>
                                                <?php $i = 1 ?>
                                                <?php foreach ($get_ditolak as $ditolak) : ?>
                                                    <tr class="align-middle">

                                                        <!-- Id izin -->
                                                        <input type="hidden" name="id_izin" value="<?= $ditolak['id_izin']; ?>">

                                                        <!-- Nomor -->
                                                        <th scope="row"><?= $i; ?></th>

                                                        <!-- Tanggal -->
                                                        <td scope="row"><?= $ditolak['jadwal_ujian']['tanggal_ujian']; ?></td>

                                                        <!-- Waktu Ujian -->
                                                        <td scope="row"><?= date('H:i', strtotime($ditolak['jadwal_ujian']['waktu_mulai_ujian'])); ?> - <?= date('H:i', strtotime($ditolak['jadwal_ujian']['waktu_selesai_ujian'])); ?></td>

                                                        <!-- Madif -->
                                                        <td scope="row"><?= $ditolak['madif']['nickname']; ?></td>

                                                        <!-- Pendamping -->
                                                        <td scope="row"><?= $ditolak['pendamping_lama']['nickname']; ?></td>

                                                        <!-- Status -->
                                                        <td style="color: red">Ditolak</td>

                                                        <!-- Dokumen -->
                                                        <td>
                                                            <?php if (isset($ditolak['dokumen'])) : ?>
                                                                <a href="/img/dokumen_izin/izin/<?= $ditolak['dokumen']; ?>" target="_blank" class="btn btn-secondary btn-sm"><i class="fa fa-download"></i> Dokumen</a>
                                                            <?php else : ?>
                                                                -
                                                            <?php endif; ?>

                                                        </td>

                                                        <!-- Detail -->
                                                        <td>
                                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#profile<?= $ditolak['id_izin']; ?>" ?>
                                                                Profile
                                                            </button>

                                                            <button type="button" class="btn btn-warning btn-sm editJadwal" data-bs-toggle="modal" data-bs-target="#jadwal<?= $ditolak['id_izin']; ?>" ?>
                                                                Jadwal
                                                            </button>
                                                        </td>

                                                    </tr>
                                                    <?php $i++; ?>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
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
        </div>
    </div>
</div>

<!-- Modal -->
<?php if (!empty($get_all_konfirmasi)) : ?>

    <?php foreach ($get_all_konfirmasi as $gak) : ?>

        <!-- Modal Profile Pendamping dan Madif-->
        <div class="modal fade" id="profile<?= $gak['id_izin']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: blueviolet">
                        <h5 class="modal-title text-white" id="exampleModalLabel">Profile Pendampingan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Mahasiswa Difabel dan Pendamping -->
                    <div class="modal-body" style="background-color: white;">
                        <!-- Madif -->
                        <div class="container">
                            <h4 class="text-center">Mahasiswa Difabel</h4>
                            <div class="row mt-5">
                                <!-- Nama Lengkap -->
                                <div class="col-md-6 mb-2">
                                    <label for="nama_madif" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama_madif" placeholder='<?= $gak['madif']['fullname']; ?>' readonly>
                                </div>
                                <!-- Jenis Difabel -->
                                <div class="col-md-6 mb-2">
                                    <label for="madif_jenis_difabel" class="form-label">Jenis Difabel</label>
                                    <input type="text" class="form-control" id="madif_jenis_difabel" placeholder='<?= $gak['madif']['jenis_difabel'] ?>' readonly>
                                </div>
                                <!-- Jenis Kelamin -->
                                <div class="col-md-6 mb-2">
                                    <label for="jenis_kelamin_madif" class="form-label">Jenis Kelamin</label>
                                    <input type="text" class="form-control" id="jenis_kelamin_madif" placeholder='<?= ($gak['madif']['jenis_kelamin'] == 1) ? 'Laki-laki' : 'Perempuan'; ?>' readonly>
                                </div>
                                <!-- Fakultas -->
                                <div class="col-md-6 mb-2">
                                    <label for="fakultas_madif" class="form-label">Fakultas</label>
                                    <input type="text" class="form-control" id="fakultas_madif" placeholder='<?= $gak['madif']['fakultas']; ?>' readonly>
                                </div>
                                <!-- Jurusan -->
                                <div class="col-md-6 mb-2">
                                    <label for="jurusan_madif" class="form-label">Jurusan</label>
                                    <input type="text" class="form-control" id="jurusan_madif" placeholder='<?= $gak['madif']['jurusan'] ?>' readonly>
                                </div>
                                <!-- Nomor HP -->
                                <div class="col-md-6 mb-2">
                                    <label for="nomor_madif" class="form-label">Nomor HP</label>
                                    <input type="text" class="form-control-plaintext" id="nomor_madif" value='<?= $gak['madif']['nomor_hp'] ?>'>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <!-- Pendamping -->
                        <div class="container">
                            <h4 class="text-center">Pendamping Lama</h4>
                            <div class="row mt-5">
                                <!-- Nama Lengkap -->
                                <div class="col-md-6 mb-2">
                                    <label for="nama_pendamping_lama" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama_pendamping_lama" placeholder='<?= $gak['pendamping_lama']['fullname']; ?>' readonly>
                                </div>
                                <!-- Jenis Kelamin -->
                                <div class="col-md-6 mb-2">
                                    <label for="jenis_kelamin_pendamping_lama" class="form-label">Jenis Kelamin</label>
                                    <input type="text" class="form-control" id="jenis_kelamin_pendamping_lama" placeholder='<?= ($gak['pendamping_lama']['jenis_kelamin'] == 1) ? 'Laki-laki' : 'Perempuan'; ?>' readonly>
                                </div>
                                <!-- Fakultas -->
                                <div class="col-md-6 mb-2">
                                    <label for="fakultas_pendamping_lama" class="form-label">Fakultas</label>
                                    <input type="text" class="form-control" id="fakultas_pendamping_lama" placeholder='<?= $gak['pendamping_lama']['fakultas']; ?>' readonly>
                                </div>
                                <!-- Jurusan -->
                                <div class="col-md-6 mb-2">
                                    <label for="jurusan_pendamping_lama" class="form-label">Jurusan</label>
                                    <input type="text" class="form-control" id="jurusan_pendamping_lama" placeholder='<?= $gak['pendamping_lama']['jurusan'] ?>' readonly>
                                </div>
                                <!-- Nomor HP -->
                                <label for="nomor_pendamping_lama" class="col-sm-auto col-form-label">Nomor HP</label>
                                <div class="col-sm-auto">
                                    <input type="text" class="form-control-plaintext" id="nomor_pendamping_lama" value='<?= $gak['pendamping_lama']['nomor_hp'] ?>'>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Jadwal Ujian -->
        <div class="modal fade" id="jadwal<?= $gak['id_izin']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: orange">
                        <h5 class="modal-title fw-bold" id="exampleModalLabel">Detail Jadwal Ujian</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">

                        <div class="card shadow p-3 mb-5 bg-body rounded">

                            <div class="card-header text-center fw-bold">
                                <?= $gak['jadwal_ujian']['mata_kuliah']; ?>
                            </div>

                            <div class="card-body">
                                <!--  start hidden jadwal id -->
                                <input type="hidden" name="id_jadwal_ujian" value="<?= $gak['jadwal_ujian']['id_jadwal_ujian']; ?>">
                                <!-- end hidden jadwal id -->

                                <!-- Tanggal Ujian -->
                                <div class="row">
                                    <label for="tanggal_ujian" class="col-sm-4 col-form-label">Tanggal Ujian</label>
                                    <div class="col-sm-8">
                                        <input type="text" readonly class="form-control-plaintext" id="tanggal_ujian" value="<?= date('d, M Y', strtotime($gak['jadwal_ujian']['tanggal_ujian'])); ?>">
                                    </div>
                                </div>

                                <!-- Jam Ujian -->
                                <div class="row">
                                    <label for="staticEmail" class="col-sm-4 col-form-label">Jam Ujian</label>
                                    <div class="col-sm-8">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= date('H:i', strtotime($gak['jadwal_ujian']['waktu_mulai_ujian'])); ?> - <?= date('H:i', strtotime($gak['jadwal_ujian']['waktu_selesai_ujian'])); ?>">
                                    </div>
                                </div>

                                <!-- Ruangan -->
                                <div class="row">
                                    <label for="staticEmail" class="col-sm-4 col-form-label">Ruangan</label>
                                    <div class="col-sm-8">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $gak['jadwal_ujian']['ruangan']; ?>">
                                    </div>
                                </div>

                                <!-- Keterangan -->
                                <div class="row">
                                    <label for="staticEmail" class="col-sm-4 col-form-label">Keterangan</label>
                                    <div class="col-sm-8">
                                        <button class="btn btn-primary btn-sm mt-1" data-bs-target="#keterangan<?= $gak['id_izin']; ?>" data-bs-toggle="modal" data-bs-dismiss="modal">Keterangan</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- Submit button -->
                    <div class="modal-footer">
                        <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cancel</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Keterangan -->
        <div class="modal fade" id="keterangan<?= $gak['id_izin']; ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: rgba(34, 84, 145, 1);">
                        <h5 class="modal-title text-white" id="exampleModalToggleLabel2">Keterangan Pendampingan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="color: black">
                        <?= $gak['jadwal_ujian']['keterangan']; ?>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" data-bs-target="#jadwal<?= $gak['id_izin']; ?>" data-bs-toggle="modal" data-bs-dismiss="modal">Kembali</button>
                    </div>
                </div>
            </div>
        </div>

    <?php endforeach; ?>

<?php endif; ?>

<?= $this->endSection(); ?>