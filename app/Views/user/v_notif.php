<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid px-6 py-4">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="row mb-6">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="mb-2 mt-2" style="display: flex; justify-content: space-between; align-items:center">
                        <h2><?= $title; ?></h2>
                        <div style="display: flex; align-items:right">
                            <a href="#" class="btn btn-success btn-sm my-1 mx-1">
                                Tandai Semua Sudah Dibaca
                            </a>
                            <a href="#" class="btn btn-danger btn-sm my-1 mx-1">
                                Hapus Semua Notifikasi
                            </a>
                        </div>
                    </div>

                    <!-- Card -->
                    <div class="card">

                        <!-- Tab table -->
                        <ul class="nav nav-line-bottom" id="pills-tab-table" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-table-verifikasi-tab" data-bs-toggle="pill" href="#pills-table-verifikasi" role="tab" aria-controls="pills-table-verifikasi" aria-selected="true">Verifikasi</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-table-notifikasi-tab" data-bs-toggle="pill" href="#pills-table-notifikasi" role="tab" aria-controls="pills-table-notifikasi" aria-selected="true">Notifikasi</a>
                            </li>
                        </ul>

                        <!-- Tab content -->
                        <div class=" tab-content p-4" id="pills-tabContent-table">

                            <!-- Verifikasi Table -->
                            <div class="tab-pane tab-example-design fade show active" id="pills-table-verifikasi" role="tabpanel" aria-labelledby="pills-table-verifikasi-tab">
                                <div class="table-responsive">
                                    <table class="table table-hover table-dark" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                                        <thead>
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Tanggal</th>
                                                <th scope="col">Jenis Verifikasi</th>
                                                <th scope="col">Pesan</th>
                                                <?php if (in_groups('admin')) : ?>
                                                    <th scope="col">Admin</th>
                                                <?php endif; ?>
                                                <th scope="col">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-light">
                                            <?php $i = 1 ?>
                                            <?php foreach ($verifikasi as $key_v) : ?>
                                                <tr class="align-middle" style="color: <?= ($key_v['is_read'] == true) ? 'grey' : ''; ?>">
                                                    <th><?= $i++; ?></th>
                                                    <td><?= date('Y/m/d', strtotime($key_v['created_at'])); ?></td>
                                                    <td><a href="<?= $key_v['detail']['link_jenis_notif']; ?>" class="text-inherit btn btn-<?= ($key_v['is_read'] == 1) ? 'secondary' : 'primary'; ?> btn-sm"><?= $key_v['detail']['jenis_notif']; ?></a></td>
                                                    <td class="<?= ($key_v['is_read'] == false) ? 'fw-bold' : ''; ?>"><?= $key_v['pesan']; ?></td>
                                                    <?php if (in_groups('admin')) : ?>
                                                        <td><?= ($key_v['is_read'] == 1) ? $key_v['nickname_admin'] : '-'; ?></td>
                                                    <?php endif; ?>
                                                    <td>
                                                        <?php if ($key_v['is_read'] == false) : ?>
                                                            <a href="<?= $key_v['detail']['link_is_read']; ?>" class="btn btn-success btn-sm my-1"><i class="far fa-eye"></i></a>
                                                        <?php else : ?>
                                                            <a href="<?= $key_v['detail']['link_del_notif']; ?>" class="btn btn-danger btn-sm my-1"><i class="fas fa-trash"></i></a>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Notifikasi Table -->
                            <div class="tab-pane tab-example-html fade" id="pills-table-notifikasi" role="tabpanel" aria-labelledby="pills-table-notifikasi-tab">
                                <div class="table-responsive">
                                    <table class="table table-hover table-dark" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">

                                        <thead>

                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Tanggal</th>
                                                <th scope="col">Jenis Notif</th>
                                                <th scope="col">Pesan</th>
                                                <?php if (in_groups('admin')) : ?>
                                                    <th scope="col">Admin</th>
                                                <?php endif; ?>
                                                <th scope="col">Aksi</th>
                                            </tr>

                                        </thead>

                                        <tbody class="table-light">
                                            <?php $i = 1 ?>
                                            <?php foreach ($notifikasi as $key_n) : ?>
                                                <tr class="align-middle" style="color: <?= ($key_n['is_read'] == true) ? 'grey' : ''; ?>">
                                                    <th><?= $i++; ?></th>
                                                    <td><?= date('Y/m/d', strtotime($key_n['created_at'])); ?></td>
                                                    <td>
                                                        <a href="<?= $key_n['detail']['link_jenis_notif']; ?>" class="text-inherit btn btn-<?= ($key_n['is_read'] == 1) ? 'secondary' : 'primary'; ?> btn-sm"><?= $key_n['detail']['jenis_notif']; ?></a>
                                                    </td>
                                                    <td class="<?= ($key_n['is_read'] == false) ? 'fw-bold' : ''; ?>"><?= $key_n['pesan']; ?></td>
                                                    <?php if (in_groups('admin')) : ?>
                                                        <td><?= ($key_n['is_read'] == 1) ? $key_n['nickname_admin'] : '-'; ?></td>
                                                    <?php endif; ?>
                                                    <td>
                                                        <?php if ($key_n['is_read'] == false) : ?>
                                                            <a href="<?= $key_n['detail']['link_is_read']; ?>" class="btn btn-success btn-sm my-1"><i class="far fa-eye"></i></a>
                                                        <?php else : ?>
                                                            <a href="<?= $key_n['detail']['link_del_notif']; ?>" class="btn btn-danger btn-sm my-1"><i class="fas fa-trash"></i></a>
                                                        <?php endif; ?>
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
        </div>
    </div>
</div>

<!-- 
    Modal
    1)Jadwal Ujian
    2)Laporan
    3)Cuti
    4)Izin Tidak Damping
    5)Jenis Madif
    6)Skills Pendamping
    7)Verifikasi presensi oleh madif
    8)Konfirmasi Pendamping Pengganti
 -->
<?= $this->endSection(); ?>