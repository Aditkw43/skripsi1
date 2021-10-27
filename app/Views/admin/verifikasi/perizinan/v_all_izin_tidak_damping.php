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
                                <a class="nav-link active" id="pills-table-verifikasi-izin-tidak-damping-tab" data-bs-toggle="pill" href="#pills-table-verifikasi-izin-tidak-damping" role="tab" aria-controls="pills-table-verifikasi-izin-tidak-damping" aria-selected="true">Verifikasi Izin</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-table-verifikasi-izin-tanpa-pengganti-tab" data-bs-toggle="pill" href="#pills-table-verifikasi-izin-tanpa-pengganti" role="tab" aria-controls="pills-table-verifikasi-izin-tanpa-pengganti" aria-selected="true">Verifikasi Izin Tanpa Pendamping</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-table-izin-diterima-tab" data-bs-toggle="pill" href="#pills-table-izin-diterima" role="tab" aria-controls="pills-table-izin-diterima" aria-selected="true">Izin Diterima</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-table-izin-ditolak-tab" data-bs-toggle="pill" href="#pills-table-izin-ditolak" role="tab" aria-controls="pills-table-izin-ditolak" aria-selected="true">Izin Ditolak</a>
                            </li>
                        </ul>

                        <!-- Tab content -->
                        <div class=" tab-content p-4" id="pills-tabContent-table">

                            <!-- Verifikasi Izin Table -->
                            <div class="tab-pane tab-example-design fade show active" id="pills-table-verifikasi-izin-tidak-damping" role="tabpanel" aria-labelledby="pills-table-verifikasi-izin-tidak-damping-tab">
                                <div class="table-responsive">
                                    <table class="table table-hover table-dark" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                                        <thead>

                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Pendamping</th>
                                                <th scope="col">Pengganti</th>
                                                <th scope="col">Keterangan</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Dokumen</th>
                                                <th scope="col">Profile</th>
                                            </tr>

                                        </thead>
                                        <tbody class="table-light">
                                            <?php if (!empty($izin_ada_pengganti_approval)) : ?>
                                                <?php $i = 1 ?>
                                                <?php foreach ($izin_ada_pengganti_approval as $approve1) : ?>
                                                    <tr class="align-middle">

                                                        <!-- Id izin -->
                                                        <input type="hidden" name="id_izin" value="<?= $approve1['id_izin']; ?>">

                                                        <!-- Nomor -->
                                                        <th scope="row"><?= $i; ?></th>

                                                        <!-- Pendamping -->
                                                        <td scope="row"><?= $approve1['pendamping_lama']['nickname']; ?></td>

                                                        <!-- Pengganti-->
                                                        <td><?= $approve1['pendamping_baru']['nickname']; ?></td>

                                                        <!-- Keterangan -->
                                                        <td><?= $approve1['keterangan']; ?></td>

                                                        <!-- Status -->
                                                        <td>
                                                            <a href="<?= base_url('c_perizinan/approval_izin/admin'); ?>/<?= $approve1['id_izin'], '/terima/'.$approve1['id_damping'].'/'.$approve1['pendamping_baru']['id_profile_mhs']; ?>" class="btn btn-success btn-sm my-1">Terima</a>
                                                            <a href="<?= base_url('c_perizinan/approval_izin/admin'); ?>/<?= $approve1['id_izin'], '/tolak'; ?>" class="btn btn-danger btn-sm">Tolak</a>
                                                        </td>

                                                        <!-- Dokumen -->
                                                        <td>
                                                            <?php if (isset($approve1['dokumen'])) : ?>
                                                                <a href="/img/dokumen_izin/izin/<?= $approve1['dokumen']; ?>" target="_blank" class="btn btn-secondary btn-sm"><i class="fa fa-download"></i> Dokumen</a>
                                                            <?php else : ?>
                                                                -
                                                            <?php endif; ?>

                                                        </td>

                                                        <!-- Profile -->
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

                            <!-- Verifikasi Izin Tanpa Pendamping Table -->
                            <div class="tab-pane tab-example-design fade" id="pills-table-verifikasi-izin-tanpa-pengganti" role="tabpanel" aria-labelledby="pills-table-verifikasi-izin-tanpa-pengganti-tab">
                                <div class="table-responsive">
                                    <table class="table table-hover table-dark" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                                        <thead>

                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Pendamping</th>
                                                <th scope="col">Pengganti</th>
                                                <th scope="col">Keterangan</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Dokumen</th>
                                                <th scope="col">Profile</th>
                                            </tr>

                                        </thead>
                                        <tbody class="table-light">
                                            <?php if (!empty($izin_tanpa_pengganti_approval)) : ?>
                                                <?php $i = 1 ?>
                                                <?php foreach ($izin_tanpa_pengganti_approval as $approve2) : ?>
                                                    <tr class="align-middle">

                                                        <!-- Id izin -->
                                                        <input type="hidden" name="id_izin" value="<?= $approve2['id_izin']; ?>">

                                                        <!-- Nomor -->
                                                        <th scope="row"><?= $i; ?></th>

                                                        <!-- Pendamping -->
                                                        <td scope="row"><?= $approve2['pendamping_lama']['nickname']; ?></td>

                                                        <!-- Pengganti-->
                                                        <td>-</td>

                                                        <!-- Keterangan -->
                                                        <td><?= $approve2['keterangan']; ?></td>

                                                        <!-- Status -->
                                                        <td>
                                                            <a href="<?= base_url('c_perizinan/approval_izin/admin'); ?>/<?= $approve2['id_izin'], '/terima'; ?>" class="btn btn-success btn-sm my-1">Terima</a>
                                                            <a href="<?= base_url('c_perizinan/approval_izin/admin'); ?>/<?= $approve2['id_izin'], '/tolak'; ?>" class="btn btn-danger btn-sm">Tolak</a>
                                                        </td>

                                                        <!-- Dokumen -->
                                                        <td>
                                                            <?php if (isset($approve2['dokumen'])) : ?>
                                                                <a href="/img/dokumen_izin/izin/<?= $approve2['dokumen']; ?>" target="_blank" class="btn btn-secondary btn-sm"><i class="fa fa-download"></i> Dokumen</a>
                                                            <?php else : ?>
                                                                -
                                                            <?php endif; ?>

                                                        </td>

                                                        <!-- Profile -->
                                                        <td>
                                                            <button type="button" class="btn btn-primary btn-sm editJadwal" data-bs-toggle="modal" data-bs-target="#profile<?= $approve2['id_izin']; ?>" ?>
                                                                Profile
                                                            </button>
                                                            <button type="button" class="btn btn-warning btn-sm editJadwal" data-bs-toggle="modal" data-bs-target="#jadwal<?= $approve2['id_izin']; ?>" ?>
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

                            <!-- Izin Diterima Table -->
                            <div class="tab-pane tab-example-html fade" id="pills-table-izin-diterima" role="tabpanel" aria-labelledby="pills-table-izin-diterima-tab">
                                <div class="table-responsive">
                                    <table class="table table-hover table-dark" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                                        <thead>

                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Pendamping</th>
                                                <th scope="col">Pengganti</th>
                                                <th scope="col">Keterangan</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Dokumen</th>
                                                <th scope="col">Profile</th>
                                            </tr>

                                        </thead>
                                        <tbody class="table-light">
                                            <?php if (!empty($izin_diterima)) : ?>
                                                <?php $i = 1 ?>
                                                <?php foreach ($izin_diterima as $id) : ?>
                                                    <tr class="align-middle">

                                                        <!-- Id izin -->
                                                        <input type="hidden" name="id_izin" value="<?= $id['id_izin']; ?>">

                                                        <!-- Nomor -->
                                                        <th scope="row"><?= $i; ?></th>

                                                        <!-- Pendamping -->
                                                        <td scope="row"><?= $id['pendamping_lama']['nickname']; ?></td>

                                                        <!-- Pengganti-->
                                                        <td><?= (empty($id['pendamping_baru']['nickname'])) ? '-' : $id['pendamping_baru']['nickname']; ?></td>

                                                        <!-- Keterangan -->
                                                        <td><?= $id['keterangan']; ?></td>

                                                        <!-- Status -->
                                                        <td style="color: green;">
                                                            Terverifikasi
                                                        </td>

                                                        <!-- Dokumen -->
                                                        <td>
                                                            <?php if (isset($id['dokumen'])) : ?>
                                                                <a href="/img/dokumen_izin/izin/<?= $id['dokumen']; ?>" target="_blank" class="btn btn-secondary btn-sm"><i class="fa fa-download"></i> Dokumen</a>
                                                            <?php else : ?>
                                                                -
                                                            <?php endif; ?>
                                                        </td>

                                                        <!-- Profile -->
                                                        <td>
                                                            <button type="button" class="btn btn-primary btn-sm editJadwal" data-bs-toggle="modal" data-bs-target="#profile<?= $id['id_izin']; ?>" ?>
                                                                Profile
                                                            </button>
                                                            <button type="button" class="btn btn-warning btn-sm editJadwal" data-bs-toggle="modal" data-bs-target="#jadwal<?= $id['id_izin']; ?>" ?>
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

                            <!-- Izin Ditolak Table -->
                            <div class="tab-pane tab-example-html fade" id="pills-table-izin-ditolak" role="tabpanel" aria-labelledby="pills-table-izin-ditolak-tab">
                                <div class="table-responsive">
                                    <table class="table table-hover table-dark" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                                        <thead>

                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Pendamping</th>
                                                <th scope="col">Pengganti</th>
                                                <th scope="col">Keterangan</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Dokumen</th>
                                                <th scope="col">Profile</th>
                                            </tr>

                                        </thead>
                                        <tbody class="table-light">
                                            <?php if (!empty($izin_ditolak)) : ?>
                                                <?php $i = 1 ?>
                                                <?php foreach ($izin_ditolak as $it) : ?>
                                                    <tr class="align-middle">

                                                        <!-- Id izin -->
                                                        <input type="hidden" name="id_izin" value="<?= $it['id_izin']; ?>">

                                                        <!-- Nomor -->
                                                        <th scope="row"><?= $i; ?></th>

                                                        <!-- Pendamping -->
                                                        <td scope="row"><?= $it['pendamping_lama']['nickname']; ?></td>

                                                        <!-- Pengganti-->
                                                        <td><?= isset($it['pendamping_baru']['nickname']) ? $it['pendamping_baru']['nickname'] : '-'; ?></td>

                                                        <!-- Keterangan -->
                                                        <td><?= $it['keterangan']; ?></td>

                                                        <!-- Status -->
                                                        <td style="color: red">
                                                            Ditolak
                                                        </td>

                                                        <!-- Dokumen -->
                                                        <td>
                                                            <?php if (isset($it['dokumen'])) : ?>
                                                                <a href="/img/dokumen_izin/izin/<?= $it['dokumen']; ?>" target="_blank" class="btn btn-secondary btn-sm"><i class="fa fa-download"></i> Dokumen</a>
                                                            <?php else : ?>
                                                                -
                                                            <?php endif; ?>

                                                        </td>

                                                        <!-- Profile -->
                                                        <td>
                                                            <button type="button" class="btn btn-primary btn-sm editJadwal" data-bs-toggle="modal" data-bs-target="#profile<?= $it['id_izin']; ?>" ?>
                                                                Profile
                                                            </button>
                                                            <button type="button" class="btn btn-warning btn-sm editJadwal" data-bs-toggle="modal" data-bs-target="#jadwal<?= $it['id_izin']; ?>" ?>
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

<?php if (!empty($hasil_izin)) : ?>
    <?php foreach ($hasil_izin as $modalhi) : ?>

        <!-- Modal Profile Pendamping-->
        <div class="modal fade" id="profile<?= $modalhi['id_izin']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: blueviolet">
                        <h5 class="modal-title text-white" id="exampleModalLabel">Profile Pendamping</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Form -->
                    <div class="modal-body" style="background-color: white;">

                        <div class="container">
                            <h4 class="text-center">Pendamping Lama</h4>
                            <div class="row mt-5">
                                <div class="col-md-6 mb-2">
                                    <label for="nama_pendamping_lama" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama_pendamping_lama" placeholder='<?= $modalhi['pendamping_lama']['fullname']; ?>' readonly>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="jenis_kelamin_pendamping_lama" class="form-label">Jenis Kelamin</label>
                                    <input type="text" class="form-control" id="jenis_kelamin_pendamping_lama" placeholder='<?= ($modalhi['pendamping_lama']['jenis_kelamin'] == 1) ? 'Laki-laki' : 'Perempuan'; ?>' readonly>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="fakultas_pendamping_lama" class="form-label">Fakultas</label>
                                    <input type="text" class="form-control" id="fakultas_pendamping_lama" placeholder='<?= $modalhi['pendamping_lama']['fakultas']; ?>' readonly>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="jurusan_pendamping_lama" class="form-label">Jurusan</label>
                                    <input type="text" class="form-control" id="jurusan_pendamping_lama" placeholder='<?= $modalhi['pendamping_lama']['jurusan'] ?>' readonly>
                                </div>
                                <label for="nomor_pendamping_lama" class="col-sm-auto col-form-label">Nomor HP</label>

                                <div class="col-sm-auto">
                                    <input type="text" class="form-control-plaintext" id="nomor_pendamping_lama" value='<?= $modalhi['pendamping_lama']['nomor_hp'] ?>'>
                                </div>
                            </div>

                        </div>
                        <?php if (isset($modalhi['pendamping_baru'])) : ?>
                            <hr>
                            <div class="container">
                                <h4 class="text-center">Pendamping Baru</h4>
                                <div class="row mt-5">
                                    <div class="col-md-6 mb-2">
                                        <label for="nama_pendamping_baru" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="nama_pendamping_baru" placeholder='<?= $modalhi['pendamping_baru']['fullname']; ?>' readonly>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="jenis_kelamin_pendamping_baru" class="form-label">Jenis Kelamin</label>
                                        <input type="text" class="form-control" id="jenis_kelamin_pendamping_baru" placeholder='<?= ($modalhi['pendamping_baru']['jenis_kelamin'] == 1) ? 'Laki-laki' : 'Perempuan'; ?>' readonly>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="fakultas_pendamping_baru" class="form-label">Fakultas</label>
                                        <input type="text" class="form-control" id="fakultas_pendamping_baru" placeholder='<?= $modalhi['pendamping_baru']['fakultas']; ?>' readonly>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="jurusan_pendamping_baru" class="form-label">Jurusan</label>
                                        <input type="text" class="form-control" id="jurusan_pendamping_baru" placeholder='<?= $modalhi['pendamping_baru']['jurusan'] ?>' readonly>
                                    </div>
                                    <label for="nomor_pendamping_baru" class="col-sm-auto col-form-label">Nomor HP</label>

                                    <div class="col-sm-auto">
                                        <input type="text" class="form-control-plaintext" id="nomor_pendamping_baru" value='<?= $modalhi['pendamping_baru']['nomor_hp'] ?>'>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div>

                    <!-- Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Jadwal Ujian -->
        <div class="modal fade" id="jadwal<?= $modalhi['id_izin']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: orange">
                        <h5 class="modal-title fw-bold" id="exampleModalLabel">Detail Jadwal Ujian</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">

                        <div class="card shadow p-3 mb-5 bg-body rounded">

                            <div class="card-header text-center fw-bold">
                                <?= $modalhi['jadwal_ujian']['mata_kuliah']; ?>
                            </div>

                            <div class="card-body">
                                <!--  start hidden jadwal id -->
                                <input type="hidden" name="id_jadwal_ujian" value="<?= $modalhi['jadwal_ujian']['id_jadwal_ujian']; ?>">
                                <!-- end hidden jadwal id -->

                                <!-- Tanggal Ujian -->
                                <div class="row">
                                    <label for="tanggal_ujian" class="col-sm-4 col-form-label">Tanggal Ujian</label>
                                    <div class="col-sm-8">
                                        <input type="text" readonly class="form-control-plaintext" id="tanggal_ujian" value="<?= date('d, M Y', strtotime($modalhi['jadwal_ujian']['tanggal_ujian'])); ?>">
                                    </div>
                                </div>

                                <!-- Jam Ujian -->
                                <div class="row">
                                    <label for="staticEmail" class="col-sm-4 col-form-label">Jam Ujian</label>
                                    <div class="col-sm-8">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= date('H:i', strtotime($modalhi['jadwal_ujian']['waktu_mulai_ujian'])); ?> - <?= date('H:i', strtotime($modalhi['jadwal_ujian']['waktu_selesai_ujian'])); ?>">
                                    </div>
                                </div>

                                <!-- Ruangan -->
                                <div class="row">
                                    <label for="staticEmail" class="col-sm-4 col-form-label">Ruangan</label>
                                    <div class="col-sm-8">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $modalhi['jadwal_ujian']['ruangan']; ?>">
                                    </div>
                                </div>

                                <!-- Keterangan -->
                                <div class="row">
                                    <label for="staticEmail" class="col-sm-4 col-form-label">Keterangan</label>
                                    <div class="col-sm-8">
                                        <button class="btn btn-primary btn-sm mt-1" data-bs-target="#keterangan<?= $modalhi['id_izin']; ?>" data-bs-toggle="modal" data-bs-dismiss="modal">Keterangan</button>
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
        <div class="modal fade" id="keterangan<?= $modalhi['id_izin']; ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: rgba(34, 84, 145, 1);">
                        <h5 class="modal-title text-white" id="exampleModalToggleLabel2">Keterangan Pendampingan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="color: black">
                        <?= $modalhi['jadwal_ujian']['keterangan']; ?>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" data-bs-target="#jadwal<?= $modalhi['id_izin']; ?>" data-bs-toggle="modal" data-bs-dismiss="modal">Kembali</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Dokumen -->
        <div class="modal fade" id="dokumen_izin<?= $modalhi['id_izin']; ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: rgba(34, 84, 145, 1);">
                        <h5 class="modal-title text-white" id="exampleModalToggleLabel2">Dokumen Perizinan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center px-1 mx-1" style="color: black">
                        <embed src="/img/dokumen_izin/izin/<?= $modalhi['dokumen']; ?>" type="application/pdf" style="width: 100%; height: 700px;">
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <a href="/img/dokumen_izin/izin/<?= $modalhi['dokumen']; ?>" download="Surat Izin Tidak Damping - <?= $modalhi['pendamping_lama']['fullname']; ?>"><i class="fa fa-download"></i> Download</a>
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

    <?php endforeach; ?>

<?php endif; ?>

<?= $this->endSection(); ?>