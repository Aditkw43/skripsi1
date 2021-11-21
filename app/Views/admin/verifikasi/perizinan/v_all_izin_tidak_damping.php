<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid px-6 py-4">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="row mb-6">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <?php if (session()->getFlashData('berhasil')) : ?>
                        <div class="alert alert-success" role="alert">
                            <?= session()->getFlashData('berhasil'); ?>
                        </div>
                    <?php elseif (session()->getFlashData('tolak')) : ?>
                        <div class="alert alert-success" role="alert">
                            <?= session()->getFlashData('tolak'); ?>
                        </div>
                    <?php endif; ?>
                    <div class="mb-2 mt-2" style="display: flex; justify-content: space-between; align-items:center">
                        <h2><?= $title; ?></h2>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-sm btn-primary d-none d-md-block" data-bs-toggle="modal" data-bs-target="#addIzin">Tambah Izin Tidak Damping</button>
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
                                                            <a href="<?= base_url('c_perizinan/approval_izin/admin'); ?>/<?= $approve1['id_izin'], '/terima/' . $approve1['id_damping'] . '/' . $approve1['pendamping_baru']['id_profile_mhs']; ?>" class="btn btn-success btn-sm my-1">Terima</a>
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
                                                        <td>
                                                            -
                                                        </td>

                                                        <!-- Keterangan -->
                                                        <td><?= $approve2['keterangan']; ?></td>

                                                        <!-- Status -->
                                                        <td>
                                                            <!-- Button trigger modal -->
                                                            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#terimaIzin<?= $approve2['id_izin']; ?>">Terima</button>
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

<!-- Modal Tambah Izin Tidak Damping-->
<?php if (!empty($tambah_izin)) : ?>

    <!-- Tambah Izin -->
    <div class="modal fade" id="addIzin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

                <!-- Header -->
                <div class="modal-header" style="background-color: rgba(0, 136, 120, 1)">
                    <h5 class="modal-title" id="exampleModalLabel" style=" color:white">Tambah Izin Tidak Damping</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="<?= base_url('/c_perizinan/saveIzin'); ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    <div class="modal-body">
                        <?= csrf_field(); ?>

                        <!-- Id_admin -->
                        <input type="hidden" name="admin" value="admin">

                        <!-- Pilih Mahasiswa-->
                        <div class="row mb-3">
                            <label for="id_profile_mhs" class="col-sm-4 col-form-label">Pendamping</label>
                            <div class="col-sm-8">
                                <select class="form-select" aria-label="Default select example" name="id_profile_mhs" id="id_profile_mhs" autofocus required onchange="showDamping('hidden_detail_jadwal','hidden_pendamping_alt',this.value)">
                                    <option value='null' selected>Pilih Pendamping</option>
                                    <?= $count = 1; ?>
                                    <?php foreach ($tambah_izin as $key2 => $value2) : ?>
                                        <option value="<?= $key2; ?>"> <?= $count . '. ' . $value2['nickname_pendamping']; ?></option>
                                        <?php $count++; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!--Jadwal Damping -->
                        <div class="row mb-3">
                            <label for="id_damping" class="col-sm-4 col-form-label">Jadwal Damping</label>
                            <div class="col-sm-8">
                                <select class="form-select" aria-label="Default select example" name="id_damping" id="mata_kuliah" autofocus required onchange="showDetailJadwal('hidden_detail_jadwal','hidden_pendamping_alt',this.value)">
                                    <option value='null' selected>Pilih Mata Kuliah</option>
                                    <?php foreach ($tambah_izin as $key3) : ?>
                                        <?php $count = 1; ?>
                                        <?php foreach ($key3 as $value4) : ?>
                                            <?php if (!is_array($value4)) : continue;
                                            endif; ?>
                                            <option value="<?= $value4['id_damping']; ?>" class="matkul_modal" id="matkul<?= $value4['profile_pendamping']['id_profile_mhs']; ?>"> <?= $count . '. ' . $value4['jadwal_ujian']['mata_kuliah']; ?></option>
                                            <?php $count++; ?>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Detail Jadwal -->
                        <div class="row mb-3" id="hidden_detail_jadwal" style="display:none;">
                            <label for="detailJadwal" class="col-sm-4 col-form-label">Detail Jadwal</label>
                            <div class="col-sm-8">
                                <button class="btn btn-primary btn-sm mt-1 modal-detail-jadwal" data-bs-target="#detailJadwal" data-bs-toggle="modal" data-bs-dismiss="modal">Detail</button>
                            </div>
                        </div>

                        <!--Pendamping Alt -->
                        <div class="row mb-3" id="hidden_pendamping_alt" style="display:none;">
                            <label for="rekomen_pengganti" class="col-sm-4 col-form-label">Pendamping Pengganti</label>
                            <div class="col-sm-8">
                                <select class="form-select" aria-label="Default select example" name="rekomen_pengganti" id="pendamping_alt" autofocus required>
                                    <option value='null' selected>Pilih Pengganti</option>
                                    <?php foreach ($tambah_izin as $key5) : ?>
                                        <?php foreach ($key5 as $value5) : ?>
                                            <?php if (!is_array($value5)) : continue;
                                            endif; ?>
                                            <?php $count = 1; ?>
                                            <?php foreach ($value5['pendamping_alt'] as $key6) : ?>
                                                <?php
                                                $status = '';
                                                if ($key6['urutan'] == 1) {
                                                    $status = ' (Rekomendasi)';
                                                } elseif ($key6['urutan'] == 2) {
                                                    $status = ' (Jadwal Cocok)';
                                                } elseif ($key6['urutan'] == 3) {
                                                    $status = ' (Skill Cocok)';
                                                }
                                                ?>
                                                <option value="<?= $key6['id_profile_pendamping']; ?>" class="pendamping_alt_modal" id="pendamping_alt<?= $value5['id_damping']; ?>"> <?= $count . '. ' . $key6['nickname'] . $status; ?></option>
                                                <?php $count++; ?>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!--Alasan Tidak Bisa Damping -->
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Leave a comment here" id="alasan" style="height: 100px" name="alasan" required></textarea>
                            <label for="alasan">Alasan</label>
                        </div>

                        <!--Dokumen Izin-->
                        <div class="row mb-3">
                            <label for="dokumen" class="col-form-label">Surat Izin <span class="fs-6" style="color:red">(optional)</span></label>

                            <div class="mb-3">
                                <input type="file" class="form-control" id="dokumen" name="dokumen">
                            </div>
                        </div>

                        <!-- Submit button -->
                        <div class="modal-footer">
                            <button class="btn btn-warning" type="button" id="btn-reset">Reset</button>
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">
                                Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Detail Jadwal -->
    <?php foreach ($tambah_izin as $key4) : ?>
        <?php foreach ($key4 as $key5) : ?>
            <?php if (is_array($key5)) : ?>
                <div class="modal fade" id="detailJadwal<?= $key5['id_damping']; ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: rgba(34, 84, 145, 1);">
                                <h5 class="modal-title" id="exampleModalLabel" style=" color:white">Detail Jadwal</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <div class="card shadow p-3 mb-5 bg-body rounded">
                                    <div class="card-header text-center fw-bold">
                                        <?= $key5['jadwal_ujian']['mata_kuliah']; ?>
                                    </div>
                                    <div class="card-body">
                                        <!-- Tanggal Ujian -->
                                        <div class="row">
                                            <label for="tanggal_ujian" class="col-sm-4 col-form-label">Tanggal Ujian</label>
                                            <div class="col-sm-8">
                                                <input type="text" readonly class="form-control-plaintext" id="tanggal_ujian" value="<?= date('d, M Y', strtotime($key5['jadwal_ujian']['tanggal_ujian'])); ?>">
                                            </div>
                                        </div>

                                        <!-- Jam Ujian -->
                                        <div class="row">
                                            <label for="staticEmail" class="col-sm-4 col-form-label">Jam Ujian</label>
                                            <div class="col-sm-8">
                                                <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= date('H:i', strtotime($key5['jadwal_ujian']['waktu_mulai_ujian'])); ?> - <?= date('H:i', strtotime($key5['jadwal_ujian']['waktu_selesai_ujian'])); ?>">
                                            </div>
                                        </div>

                                        <!-- Ruangan -->
                                        <div class="row">
                                            <label for="staticEmail" class="col-sm-4 col-form-label">Ruangan</label>
                                            <div class="col-sm-8">
                                                <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $key5['jadwal_ujian']['ruangan']; ?>">
                                            </div>
                                        </div>

                                        <!-- Keterangan -->
                                        <div class="row">
                                            <label for="staticEmail" class="col-sm-4 col-form-label">Keterangan</label>
                                            <div class="col-sm-8">
                                                <button class="btn btn-primary btn-sm mt-1" data-bs-target="#keterangan<?= $key5['id_damping']; ?>" data-bs-toggle="modal" data-bs-dismiss="modal">Keterangan</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Kembali button -->
                            <div class="modal-footer">
                                <button class="btn btn-danger" data-bs-target="#addIzin" data-bs-toggle="modal" data-bs-dismiss="modal">Kembali</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Keterangan-->
                <div class="modal fade" id="keterangan<?= $key5['id_damping']; ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: rgba(34, 84, 145, 1);">
                                <h5 class="modal-title text-white" id="exampleModalToggleLabel2">Keterangan Pendampingan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body" style="color: black">
                                <?= $key5['jadwal_ujian']['keterangan']; ?>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-danger" data-bs-target="#detailJadwal<?= $key5['id_damping']; ?>" data-bs-toggle="modal" data-bs-dismiss="modal">Kembali</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endforeach; ?>

<?php endif; ?>

<!-- Modal Izin tanpa pendamping -->
<?php if (!empty($izin_tanpa_pengganti_approval)) : ?>
    <?php foreach ($izin_tanpa_pengganti_approval as $itpa) : ?>
        <!-- Tambah Izin -->
        <div class="modal fade" id="terimaIzin<?= $itpa['id_izin']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Header -->
                    <div class="modal-header" style="background-color: rgba(0, 136, 120, 1)">
                        <h5 class="modal-title" id="exampleModalLabel" style=" color:white">Mencari Pengganti</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="<?= base_url('c_perizinan/approval_izin/admin/' . $itpa['id_izin'] . '/terima'); ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <div class="modal-body">
                            <?= csrf_field(); ?>
                            <!-- ID Daping -->
                            <input type="hidden" name="id_damping" value="<?= $itpa['id_damping']; ?>">

                            <!-- Pilih Mahasiswa-->
                            <div class="row mb-3">
                                <label for="pendamping_pengganti" class="col-sm-4 col-form-label">Pengganti</label>
                                <div class="col-sm-8">
                                    <select class="form-select" aria-label="Default select example" name="pendamping_pengganti" id="pendamping_pengganti" autofocus required>
                                        <option value='null' selected>Pilih Pengganti</option>
                                        <?= $count = 1; ?>
                                        <?php foreach ($itpa['pendamping_alt'] as $key7) : ?>
                                            <?php
                                            $status = '';
                                            if ($key7['urutan'] == 1) {
                                                $status = ' (Rekomendasi)';
                                            } elseif ($key7['urutan'] == 2) {
                                                $status = ' (Jadwal Cocok)';
                                            } elseif ($key7['urutan'] == 3) {
                                                $status = ' (Skill Cocok)';
                                            }
                                            ?>
                                            <option value="<?= $key7['id_profile_pendamping']; ?>"> <?= $count . '. ' . $key7['nickname'] . $status; ?></option>
                                            <?php $count++; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Submit button -->
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success">
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<!-- My JS -->
<script>
    function showDamping(showDetailJadwal, showPendampingAlt, element) {
        var nama_matkul_id = 'matkul' + element;
        var matkul_id = document.querySelectorAll('#' + nama_matkul_id);
        var matkul_class = document.querySelectorAll('.matkul_modal');
        // console.log(nama_matkul_id);
        // console.log(matkul_id);
        // console.log(matkul_class);
        // console.log(matkul_id.length);
        // console.log(matkul_class.length);        

        for (var i = 0; i < matkul_class.length; i++) {
            console.log(matkul_class[i]);
            matkul_class[i].style.display = 'none';
        }
        for (var j = 0; j < matkul_id.length; j++) {
            console.log(matkul_id[j]);
            matkul_id[j].removeAttribute("style");
        }

        if (element == 'null') {
            document.getElementById(showDetailJadwal).style.display = 'none';
            document.getElementById(showPendampingAlt).style.display = 'none';
            var options = document.querySelectorAll('#mata_kuliah option');
            for (var i = 0, l = options.length; i < l; i++) {
                options[i].selected = options[i].defaultSelected;
            }
        }
    }

    function showDetailJadwal(showDetailJadwal, showPendampingAlt, id_damping) {
        var detail_jadwal = '#detailJadwal' + id_damping;
        var modal_detail_jadwal = document.querySelector('.modal-detail-jadwal');

        var pendamping_alt_id = document.querySelectorAll('#pendamping_alt' + id_damping);
        var pendamping_alt_class = document.querySelectorAll('.pendamping_alt_modal');

        modal_detail_jadwal.setAttribute('data-bs-target', detail_jadwal);
        console.log(id_damping);
        console.log(id_damping == 'null');

        if (id_damping == 'null') {
            document.getElementById(showDetailJadwal).style.display = 'none';
            document.getElementById(showPendampingAlt).style.display = 'none';
        } else {
            document.getElementById(showDetailJadwal).removeAttribute("style");
            document.getElementById(showPendampingAlt).removeAttribute("style");
            for (var i = 0; i < pendamping_alt_class.length; i++) {
                console.log(pendamping_alt_class[i]);
                pendamping_alt_class[i].style.display = 'none';
            }
            for (var j = 0; j < pendamping_alt_id.length; j++) {
                console.log(pendamping_alt_id[j]);
                pendamping_alt_id[j].style.display = 'block';
            }
        }
    }

    var button = document.getElementById('btn-reset'); // Assumes element with id='button'

    button.onclick = function() {
        var div1 = document.getElementById('hidden_pendamping_alt');
        var div2 = document.getElementById('hidden_detail_jadwal');
        var div3 = document.getElementById('alasan');
        var div4 = document.getElementById('dokumen');
        div1.style.display = 'none';
        div2.style.display = 'none';
        div3.value = '';
        div4.value = '';
        var options1 = document.querySelectorAll('#mata_kuliah option');
        var options2 = document.querySelectorAll('#id_profile_mhs option');
        var options3 = document.querySelectorAll('#pendamping_alt option');
        for (var i = 0, l = options1.length; i < l; i++) {
            options1[i].selected = options1[i].defaultSelected;
        }
        for (var i = 0, l = options2.length; i < l; i++) {
            options2[i].selected = options2[i].defaultSelected;
        }
        for (var i = 0, l = options3.length; i < l; i++) {
            options3[i].selected = options3[i].defaultSelected;
        }
    };
</script>

<?= $this->endSection(); ?>