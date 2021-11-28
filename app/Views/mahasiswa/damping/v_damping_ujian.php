<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<!--     
    Isi Status:
    1)Tidak ada pendamping
    2)Menunggu konfirmasi pendampingan
    3)Melakukan konfirmasi oleh pendamping
    4)Menunggu presensi kehadiran pendamping
    5)Melakukan presensi oleh pendamping
    6)Menunggu konfirmasi presensi
    7)Melakukan konfirmasi presensi oleh madif
    8)Menunggu konfirmasi pendampingan selesai oleh madif maupun pendamping
    9)Melakukan konfirmasi pendampingan selesai
    10)Melakukan pengisian review/evaluasi pendampingan
    11)Menunggu pengisian review dari madif/pendamping
    12)Jika review pendampingan sudah terkirim dari madif dan pendamping, maka status menjadi pendampingan selesai

    Status:
    a. empty, tidak ada pendamping (List Tidak Didampingi)
    b. null, konfirmasi_pendampingan (Konfirmasi Pendampingan)
    c. presensi_hadir, Presensi pendamping (Presensi)
    d. konfirmasi_presensi_hadir, Konfirmasi presensi (Presensi)
    e. pendampingan (Presensi)
    f. laporan (Evaluasi)
    g. madif_review/pendamping_review (Evaluasi)
    h. pendamping_review/madif_review (Evaluasi)
    i. selesai, Pendampingan Selesai (Laporan)

    Indikator warna:
    a. Kuning: Menunggu Konfirmasi Pendampingan
    b. Merah: Harus Melakukan sesuatu
    c. Hijau: Menunggu Konfirmasi dari pendamping/madif
    d. Biru: Konfirmasi jika pendampingan telah selesai
-->

<div class="container-fluid px-6 py-4">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="row mb-6">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="mb-2 mt-2" style="display: flex; justify-content: space-between; align-items:center">
                        <h2><?= $title; ?></h2>
                        <?php if (!empty($gagal_damping)) : ?>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-danger btn-sm mt-3 mx-1" data-bs-toggle="modal" data-bs-target="#gagalDamping" ?>
                                Gagal Pendampingan
                            </button>
                        <?php endif; ?>
                    </div>
                    <?php if (session()->getFlashData('berhasil_digenerate')) : ?>
                        <div class="alert alert-success" role="alert">
                            <?= session()->getFlashData('berhasil_digenerate'); ?>
                        </div>
                    <?php elseif (session()->getFlashData('berhasil_dihapus')) : ?>
                        <div class="alert alert-success" role="alert">
                            <?= session()->getFlashData('berhasil_dihapus'); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Card -->
                    <div class="card">

                        <!-- Tab table -->
                        <ul class="nav nav-line-bottom" id="pills-tab-table" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-table-konfirmasi-damping-tab" data-bs-toggle="pill" href="#pills-table-konfirmasi-damping" role="tab" aria-controls="pills-table-konfirmasi-damping" aria-selected="true">Konfirmasi Pendampingan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-table-presensi-tab" data-bs-toggle="pill" href="#pills-table-presensi" role="tab" aria-controls="pills-table-presensi" aria-selected="true">Presensi</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-table-laporan-tab" data-bs-toggle="pill" href="#pills-table-laporan" role="tab" aria-controls="pills-table-laporan" aria-selected="true">Evaluasi</a>
                            </li>
                        </ul>

                        <!-- Tab content -->
                        <div class=" tab-content p-4" id="pills-tabContent-table">

                            <!-- Konfirmasi Damping Table -->
                            <div class="tab-pane tab-example-design fade show active" id="pills-table-konfirmasi-damping" role="tabpanel" aria-labelledby="pills-table-konfirmasi-damping-tab">
                                <div class="table-responsive">
                                    <table class="table table-hover table-dark" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                                        <thead>
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Tanggal Ujian</th>
                                                <th scope="col">Mata Kuliah</th>
                                                <?php if ($profile_mhs['madif'] == 1) : ?>
                                                    <th scope="col">Pendamping</th>
                                                <?php else : ?>
                                                    <th scope="col">Mahasiswa Difabel</th>
                                                <?php endif; ?>
                                                <th scope="col">Status</th>
                                                <th scope="col">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-light">
                                            <?php $i = 1 ?>
                                            <?php foreach ($hasil_jadwal_damping as $hjd) : ?>
                                                <?php if (!empty($hjd['biodata_pendamping'])) : ?>
                                                    <?php if (empty($hjd['status_damping']) || $hjd['status_damping'] == 'izin_verifikasi_pendamping' || $hjd['status_damping'] == 'izin_verifikasi_admin') : ?>

                                                        <tr class="align-middle" style="color:<?= (empty($hjd['biodata_pendamping'])) ? 'grey' : '' ?>">

                                                            <!-- Id Pendampingan -->
                                                            <input type="hidden" name="id_damping" value="<?= $hjd['id_damping']; ?>">

                                                            <!-- Nomor -->
                                                            <th scope="row"><?= $i; ?></th>

                                                            <!-- Tanggal Ujian -->
                                                            <td><?= date('d, M Y', strtotime($hjd['jadwal_ujian']['tanggal_ujian'])); ?></td>

                                                            <!-- Mata Kuliah -->
                                                            <td><?= $hjd['jadwal_ujian']['mata_kuliah']; ?></td>

                                                            <!-- Nama madif dan pendamping -->
                                                            <?php if ($profile_mhs['madif'] == 1) : ?>

                                                                <!-- Nama pendamping -->
                                                                <?php if (!empty($hjd['biodata_pendamping'])) : ?>
                                                                    <td><?= $hjd['biodata_pendamping']['nickname']; ?></td>
                                                                <?php else : ?>
                                                                    <td>-</td>
                                                                <?php endif; ?>

                                                            <?php else : ?>
                                                                <!-- Nama Madif -->
                                                                <td><?= $hjd['biodata_madif']['nickname']; ?> (<?= $hjd['biodata_madif']['jenis_madif']; ?>)</td>
                                                            <?php endif; ?>

                                                            <!-- Status -->
                                                            <?php if ($profile_mhs['madif'] == 1) : ?>
                                                                <?php if (empty($hjd['status_damping'])) : ?>
                                                                    <td style="color: rgba(237, 136, 0, 1);">
                                                                        Menunggu Konfirmasi Pendamping
                                                                    </td>
                                                                <?php else : ?>
                                                                    <td style="color: blue;">
                                                                        Menunggu Pencarian Pendamping Pengganti
                                                                    </td>
                                                                <?php endif; ?>
                                                            <?php else : ?>
                                                                <!-- Red: Ada task, green: menunggu task atau selesai -->
                                                                <?php if (empty($hjd['status_damping'])) : ?>
                                                                    <td>
                                                                        <a href="<?= base_url('changeStatus/presensi_hadir'); ?>/<?= $hjd['id_damping']; ?>" class="btn btn-success btn-sm">Confirm</a>
                                                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#izinTidakDamping<?= $hjd['id_damping']; ?>" ?>Izin</button>
                                                                    </td>
                                                                <?php elseif ($hjd['status_damping'] == 'izin_verifikasi_pendamping') : ?>
                                                                    <td style="color: blue">
                                                                        Menunggu verifikasi izin pengganti
                                                                    </td>
                                                                <?php elseif ($hjd['status_damping'] == 'izin_verifikasi_pendamping') : ?>
                                                                    <td style="color: blue">
                                                                        Menunggu verifikasi izin admin
                                                                    </td>
                                                                <?php endif; ?>
                                                            <?php endif; ?>

                                                            <!-- Aksi -->
                                                            <td>
                                                                <button type="button" class="btn btn-warning btn-sm my-1" data-bs-toggle="modal" data-bs-target="#jadwalDamping<?= $hjd['id_damping']; ?>" ?>
                                                                    Detail
                                                                </button>

                                                                <?php if (!empty($hjd['biodata_pendamping'])) : ?>
                                                                    <?php if (isset($hjd['profile_mhs']['madif'])) : ?>
                                                                        <button type="button" class="btn btn-primary btn-sm editJadwal" data-bs-toggle="modal" data-bs-target="#profile<?= $hjd['biodata_pendamping']['id_profile_mhs']; ?>" ?>
                                                                            Profile
                                                                        </button>
                                                                    <?php else : ?>
                                                                        <button type="button" class="btn btn-primary btn-sm editJadwal" data-bs-toggle="modal" data-bs-target="#profile<?= $hjd['biodata_madif']['id_profile_mhs']; ?>" ?>
                                                                            Profile
                                                                        </button>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                        <?php $i++; ?>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Presensi Table -->
                            <div class="tab-pane tab-example-html fade" id="pills-table-presensi" role="tabpanel" aria-labelledby="pills-table-presensi-tab">
                                <div class="table-responsive">
                                    <table class="table table-hover table-dark" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">

                                        <thead>

                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Tanggal Ujian</th>
                                                <th scope="col">Mata Kuliah</th>
                                                <?php if ($profile_mhs['madif'] == 1) : ?>
                                                    <th scope="col">Pendamping</th>
                                                <?php else : ?>
                                                    <th scope="col">Mahasiswa Difabel</th>
                                                <?php endif; ?>
                                                <th scope="col">Status</th>
                                                <th scope="col">Aksi</th>
                                            </tr>

                                        </thead>

                                        <tbody class="table-light">
                                            <?php $i = 1 ?>
                                            <?php foreach ($hasil_jadwal_damping as $presensi) : ?>
                                                <?php if (!empty($presensi['biodata_pendamping'])) : ?>

                                                    <?php
                                                    $presensi_hadir = ($presensi['status_damping'] == 'presensi_hadir');
                                                    $konfirmasi_presensi = ($presensi['status_damping'] == 'konfirmasi_presensi_hadir');
                                                    $pendampingan = ($presensi['status_damping'] == 'pendampingan');
                                                    ?>

                                                    <?php if ($presensi_hadir || $konfirmasi_presensi || $pendampingan) : ?>

                                                        <tr class="align-middle" style="color:<?= (empty($presensi['biodata_pendamping'])) ? 'grey' : '' ?>">

                                                            <!-- Id Pendampingan -->
                                                            <input type="hidden" name="id_damping" value="<?= $presensi['id_damping']; ?>">

                                                            <!-- Nomor -->
                                                            <th scope="row"><?= $i; ?></th>

                                                            <!-- Tanggal Ujian -->
                                                            <td><?= date('d, M Y', strtotime($presensi['jadwal_ujian']['tanggal_ujian'])); ?></td>

                                                            <!-- Mata Kuliah -->
                                                            <td><?= $presensi['jadwal_ujian']['mata_kuliah']; ?></td>

                                                            <!-- Nama madif dan pendamping -->
                                                            <?php if ($profile_mhs['madif'] == 1) : ?>

                                                                <!-- Nama pendamping -->
                                                                <?php if (!empty($presensi['biodata_pendamping'])) : ?>
                                                                    <td><?= $presensi['biodata_pendamping']['nickname']; ?></td>
                                                                <?php else : ?>
                                                                    <td>-</td>
                                                                <?php endif; ?>

                                                            <?php else : ?>
                                                                <!-- Nama Madif -->
                                                                <td><?= $presensi['biodata_madif']['nickname']; ?> (<?= $presensi['biodata_madif']['jenis_madif']; ?>)</td>
                                                            <?php endif; ?>

                                                            <!-- Status -->
                                                            <?php if ($profile_mhs['madif'] == 1) : ?>

                                                                <!-- Jika Ada Pendamping -->
                                                                <?php if (!empty($presensi['biodata_pendamping'])) : ?>

                                                                    <?php if (empty($presensi['status_damping'])) : ?>
                                                                        <td style="color: rgba(237, 136, 0, 1);">
                                                                            Menunggu Konfirmasi Pendamping
                                                                        </td>
                                                                    <?php elseif ($presensi_hadir) : ?>
                                                                        <td style="color: green;">
                                                                            Menunggu Presensi
                                                                        </td>
                                                                    <?php elseif ($konfirmasi_presensi) : ?>
                                                                        <td style="color:red">
                                                                            Lakukan Konfirmasi Presensi
                                                                        </td>
                                                                    <?php elseif ($pendampingan) : ?>
                                                                        <td style="color:blue">
                                                                            Lakukan Konfirmasi Presensi Jika<br>Pendampingan Telah Selesai
                                                                        </td>
                                                                    <?php elseif ($presensi['status_damping'] == 'laporan') : ?>
                                                                        <td style="color: red;">
                                                                            Lakukan Pengisian Review Pendampingan
                                                                        </td>
                                                                    <?php elseif ($presensi['status_damping'] == 'madif_review') : ?>
                                                                        <td style="color: red;">
                                                                            Lakukan Pengisian Review Pendampingan
                                                                        </td>
                                                                    <?php elseif ($presensi['status_damping'] == 'pendamping_review') : ?>
                                                                        <td style="color: green;">
                                                                            Menunggu Laporan Review dari Pendamping
                                                                        </td>
                                                                    <?php elseif ($presensi['status_damping'] == 'selesai') : ?>
                                                                        <td style="color: green;">
                                                                            Pendampingan Selesai
                                                                        </td>
                                                                    <?php endif; ?>


                                                                    <!-- Jika Tidak Ada Pendamping -->
                                                                <?php else : ?>
                                                                    <td>
                                                                        Tidak Ada Pendamping
                                                                    </td>
                                                                <?php endif; ?>

                                                            <?php else : ?>

                                                                <!-- Red: Ada task, green: menunggu task atau selesai -->
                                                                <?php if (empty($presensi['status_damping'])) : ?>
                                                                    <td style="color: <?= (empty($presensi['status_damping'])) ? 'red' : '' ?>;">
                                                                        <a href="<?= base_url('konfirmasiDamping'); ?>/<?= $presensi['id_damping']; ?>" class="btn btn-success btn-sm">Confirm</a>
                                                                        <a href="<?= base_url('IzinTidakDamping'); ?>/<?= $presensi['id_damping']; ?>" class="btn btn-danger btn-sm">Izin</a>
                                                                    </td>
                                                                <?php elseif ($presensi_hadir) : ?>
                                                                    <td style="color:red">
                                                                        Lakukan Presensi Kehadiran
                                                                    </td>
                                                                <?php elseif ($konfirmasi_presensi) : ?>
                                                                    <td style="color: green;">
                                                                        Menunggu Konfirmasi Presensi
                                                                    </td>
                                                                <?php elseif ($pendampingan) : ?>
                                                                    <td style="color: blue;">
                                                                        Lakukan Konfirmasi Presensi Jika<br>Pendampingan Telah Selesai
                                                                    </td>
                                                                <?php elseif ($presensi['status_damping'] == 'laporan') : ?>
                                                                    <td style="color: red;">
                                                                        Lakukan Pengisian Review Pendampingan
                                                                    </td>
                                                                <?php elseif ($presensi['status_damping'] == 'pendamping_review') : ?>
                                                                    <td style="color: red;">
                                                                        Lakukan Pengisian Review Pendampingan
                                                                    </td>
                                                                <?php elseif ($presensi['status_damping'] == 'madif_review') : ?>
                                                                    <td style="color: green;">
                                                                        Menunggu Laporan Review dari Madif
                                                                    </td>
                                                                <?php elseif ($presensi['status_damping'] == 'selesai') : ?>
                                                                    <td style="color: green;">
                                                                        Pendampingan Selesai
                                                                    </td>
                                                                <?php endif; ?>

                                                            <?php endif; ?>

                                                            <!-- Aksi -->
                                                            <td>
                                                                <button type="button" class="btn btn-warning btn-sm editJadwal my-1" data-bs-toggle="modal" data-bs-target="#jadwalDamping<?= $presensi['id_damping']; ?>" ?>
                                                                    Detail
                                                                </button>

                                                                <?php if (!empty($presensi['biodata_pendamping'])) : ?>
                                                                    <?php if (isset($presensi['profile_mhs']['madif'])) : ?>
                                                                        <button type="button" class="btn btn-primary btn-sm editJadwal" data-bs-toggle="modal" data-bs-target="#profile<?= $presensi['biodata_pendamping']['id_profile_mhs']; ?>" ?>
                                                                            Profile
                                                                        </button>
                                                                    <?php else : ?>
                                                                        <button type="button" class="btn btn-primary btn-sm editJadwal" data-bs-toggle="modal" data-bs-target="#profile<?= $presensi['biodata_madif']['id_profile_mhs']; ?>" ?>
                                                                            Profile
                                                                        </button>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                            </td>

                                                        </tr>

                                                        <?php $i++; ?>
                                                    <?php endif; ?>

                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </tbody>

                                    </table>
                                </div>
                            </div>

                            <!-- Evaluasi Table -->
                            <div class="tab-pane tab-example-html fade" id="pills-table-laporan" role="tabpanel" aria-labelledby="pills-table-laporan-tab">
                                <div class="table-responsive">
                                    <table class="table table-hover table-dark" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                                        <thead>

                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Tanggal Ujian</th>
                                                <th scope="col">Mata Kuliah</th>
                                                <?php if ($profile_mhs['madif'] == 1) : ?>
                                                    <th scope="col">Pendamping</th>
                                                <?php else : ?>
                                                    <th scope="col">Mahasiswa Difabel</th>
                                                <?php endif; ?>
                                                <th scope="col">Status</th>
                                                <th scope="col">Aksi</th>
                                            </tr>

                                        </thead>
                                        <tbody class="table-light">
                                            <?php $i = 1 ?>
                                            <?php foreach ($hasil_jadwal_damping as $evaluasi) : ?>
                                                <?php if (!empty($evaluasi['biodata_pendamping'])) : ?>

                                                    <?php
                                                    $laporan = ($evaluasi['status_damping'] == 'laporan');
                                                    $madif_review = ($evaluasi['status_damping'] == 'madif_review');
                                                    $pendamping_review = ($evaluasi['status_damping'] == 'pendamping_review');
                                                    ?>

                                                    <?php if ($laporan || $madif_review || $pendamping_review) : ?>

                                                        <tr class="align-middle" style="color:<?= (empty($evaluasi['biodata_pendamping'])) ? 'grey' : '' ?>">

                                                            <!-- Id Pendampingan -->
                                                            <input type="hidden" name="id_damping" value="<?= $evaluasi['id_damping']; ?>">

                                                            <!-- Nomor -->
                                                            <th scope="row"><?= $i; ?></th>

                                                            <!-- Tanggal Ujian -->
                                                            <td><?= date('d, M Y', strtotime($evaluasi['jadwal_ujian']['tanggal_ujian'])); ?></td>

                                                            <!-- Mata Kuliah -->
                                                            <td><?= $evaluasi['jadwal_ujian']['mata_kuliah']; ?></td>

                                                            <!-- Nama madif dan pendamping -->
                                                            <?php if ($profile_mhs['madif'] == 1) : ?>

                                                                <!-- Nama pendamping -->
                                                                <?php if (!empty($evaluasi['biodata_pendamping'])) : ?>
                                                                    <td><?= $evaluasi['biodata_pendamping']['nickname']; ?></td>
                                                                <?php else : ?>
                                                                    <td>-</td>
                                                                <?php endif; ?>

                                                            <?php else : ?>
                                                                <!-- Nama Madif -->
                                                                <td><?= $evaluasi['biodata_madif']['nickname']; ?> (<?= $evaluasi['biodata_madif']['jenis_madif']; ?>)</td>
                                                            <?php endif; ?>

                                                            <!-- Status -->
                                                            <?php if ($profile_mhs['madif'] == 1) : ?>

                                                                <!-- Jika Ada Pendamping -->
                                                                <?php if (!empty($evaluasi['biodata_pendamping'])) : ?>

                                                                    <?php if (empty($evaluasi['status_damping'])) : ?>
                                                                        <td style="color: rgba(237, 136, 0, 1);">
                                                                            Menunggu Konfirmasi Pendamping
                                                                        </td>
                                                                    <?php elseif ($evaluasi['status_damping'] == 'presensi_hadir') : ?>
                                                                        <td style="color: green;">
                                                                            Menunggu Presensi
                                                                        </td>
                                                                    <?php elseif ($evaluasi['status_damping'] == 'konfirmasi_presensi_hadir') : ?>
                                                                        <td style="color:red">
                                                                            Lakukan Konfirmasi Presensi
                                                                        </td>
                                                                    <?php elseif ($evaluasi['status_damping'] == 'pendampingan') : ?>
                                                                        <td style="color:blue">
                                                                            Lakukan Konfirmasi Selesai Pendampingan
                                                                        </td>
                                                                    <?php elseif ($evaluasi['status_damping'] == 'laporan') : ?>
                                                                        <td style="color: red;">
                                                                            Lakukan Pengisian Evaluasi Pendampingan
                                                                        </td>
                                                                    <?php elseif ($evaluasi['status_damping'] == 'madif_review') : ?>
                                                                        <td style="color: red;">
                                                                            Lakukan Pengisian Evaluasi Pendampingan
                                                                        </td>
                                                                    <?php elseif ($evaluasi['status_damping'] == 'pendamping_review') : ?>
                                                                        <td style="color: green;">
                                                                            Menunggu Laporan Evaluasi dari Pendamping
                                                                        </td>
                                                                    <?php elseif ($evaluasi['status_damping'] == 'selesai') : ?>
                                                                        <td style="color: green;">
                                                                            Pendampingan Selesai
                                                                        </td>
                                                                    <?php endif; ?>


                                                                    <!-- Jika Tidak Ada Pendamping -->
                                                                <?php else : ?>
                                                                    <td>
                                                                        Tidak Ada Pendamping
                                                                    </td>
                                                                <?php endif; ?>

                                                            <?php else : ?>

                                                                <!-- Red: Ada task, green: menunggu task atau selesai -->
                                                                <?php if (empty($evaluasi['status_damping'])) : ?>
                                                                    <td style="color: <?= (empty($evaluasi['status_damping'])) ? 'red' : '' ?>;">
                                                                        <a href="<?= base_url('konfirmasiDamping'); ?>/<?= $evaluasi['id_damping']; ?>" class="btn btn-success btn-sm">Confirm</a>
                                                                        <a href="<?= base_url('IzinTidakDamping'); ?>/<?= $evaluasi['id_damping']; ?>" class="btn btn-danger btn-sm">Izin</a>
                                                                    </td>
                                                                <?php elseif ($evaluasi['status_damping'] == 'presensi_hadir') : ?>
                                                                    <td style="color:red">
                                                                        Lakukan Presensi Kehadiran
                                                                    </td>
                                                                <?php elseif ($evaluasi['status_damping'] == 'konfirmasi_presensi_hadir') : ?>
                                                                    <td style="color: green;">
                                                                        Menunggu Konfirmasi Presensi
                                                                    </td>
                                                                <?php elseif ($evaluasi['status_damping'] == 'pendampingan') : ?>
                                                                    <td style="color: blue;">
                                                                        Lakukan Konfirmasi Selesai Pendampingan
                                                                    </td>
                                                                <?php elseif ($evaluasi['status_damping'] == 'laporan') : ?>
                                                                    <td style="color: red;">
                                                                        Lakukan Pengisian Evaluasi Pendampingan
                                                                    </td>
                                                                <?php elseif ($evaluasi['status_damping'] == 'pendamping_review') : ?>
                                                                    <td style="color: red;">
                                                                        Lakukan Pengisian Evaluasi Pendampingan
                                                                    </td>
                                                                <?php elseif ($evaluasi['status_damping'] == 'madif_review') : ?>
                                                                    <td style="color: green;">
                                                                        Menunggu Laporan Evaluasi dari Madif
                                                                    </td>
                                                                <?php elseif ($evaluasi['status_damping'] == 'selesai') : ?>
                                                                    <td style="color: green;">
                                                                        Pendampingan Selesai
                                                                    </td>
                                                                <?php endif; ?>

                                                            <?php endif; ?>

                                                            <!-- Aksi -->
                                                            <td>
                                                                <button type="button" class="btn btn-warning btn-sm editJadwal my-1" data-bs-toggle="modal" data-bs-target="#jadwalDamping<?= $evaluasi['id_damping']; ?>" ?>
                                                                    Detail
                                                                </button>

                                                                <?php if (!empty($evaluasi['biodata_pendamping'])) : ?>
                                                                    <?php if (isset($evaluasi['profile_mhs']['madif'])) : ?>
                                                                        <button type="button" class="btn btn-primary btn-sm editJadwal" data-bs-toggle="modal" data-bs-target="#profile<?= $evaluasi['biodata_pendamping']['id_profile_mhs']; ?>" ?>
                                                                            Profile
                                                                        </button>
                                                                    <?php else : ?>
                                                                        <button type="button" class="btn btn-primary btn-sm editJadwal" data-bs-toggle="modal" data-bs-target="#profile<?= $evaluasi['biodata_madif']['id_profile_mhs']; ?>" ?>
                                                                            Profile
                                                                        </button>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                            </td>

                                                        </tr>
                                                        <?php $i++; ?>

                                                    <?php endif; ?>
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
        </div>
    </div>
</div>

<?php foreach ($all_damping as $modalhjd) : ?>

    <!-- Modal Profile -->
    <?php if ($profile_mhs['madif'] == 1) : ?>
        <?php if ($modalhjd['biodata_pendamping']) : ?>
            <!-- Modal Profile Pendamping-->
            <div class="modal fade" id="profile<?= $modalhjd['biodata_pendamping']['id_profile_mhs']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: blueviolet">
                            <h5 class="modal-title text-white" id="exampleModalLabel">Profile Pendamping <?= $modalhjd['biodata_pendamping']['nickname']; ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <!-- Form -->
                        <form action="<?= base_url('c_damping_ujian/generate'); ?>" method="POST">
                            <div class="modal-body text-center" style="background-color: white;">
                                <?= csrf_field(); ?>

                                <!--NIM-->
                                <div class="row mb-2" style="background-color: inherit;">
                                    <div class="col-sm-12 text-center">
                                        <label for="nim" class="form-label mb-0 fw-bold">NIM</label>
                                        <input type="text" readonly class="my-0 form-control-plaintext text-center" id="nim" value="<?= $modalhjd['biodata_pendamping']['nim']; ?>" style="color:darkslategray">
                                    </div>
                                </div>

                                <div class="shadow p-3 mb-5 rounded-2 my-0" style="background-color: rgba(241, 241, 230, 0.8);">
                                    <!--NIM-->
                                    <div class="row mb-2">
                                        <div class="col-sm-6">
                                            <label for="nama" class="form-label mb-0 ">Nama</label>
                                            <input type="text" readonly class="form-control-plaintext text-center" id="nama" value="<?= $modalhjd['biodata_pendamping']['fullname']; ?>">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="nama" class="form-label mb-0 ">Jenis Kelamin</label>
                                            <input type="text" readonly class="form-control-plaintext text-center" id="nama" value="<?= ($modalhjd['biodata_pendamping']['jenis_kelamin'] == 1) ? 'Laki-laki' : 'Perempuan'; ?>">
                                        </div>
                                    </div>
                                    <!--Jenis Kelamin-->
                                    <div class="row mb-2">
                                        <div class="col-sm-6">
                                            <label for="fakultas" class="form-label mb-0 ">Fakultas</label>
                                            <input type="text" readonly class="form-control-plaintext text-center" id="fakultas" value="<?= $modalhjd['biodata_pendamping']['fakultas']; ?>">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="semester" class="form-label mb-0 ">Semester</label>
                                            <input type="text" readonly class="form-control-plaintext text-center" id="semester" value="<?= $modalhjd['biodata_pendamping']['semester']; ?>">
                                        </div>
                                    </div>
                                </div>

                                <!--Semester-->
                                <div class="row mb-2" style="background-color: inherit;">
                                    <div class="col-sm-12 text-center">
                                        <label for="contact" class="form-label mb-0 fw-bold">Contact</label>
                                        <input type="text" readonly class="my-0 form-control-plaintext text-center" id="contact" value="<?= $modalhjd['biodata_pendamping']['nomor_hp']; ?>" style="color:darkslategray">
                                    </div>
                                </div>

                            </div>
                            <!-- Submit button -->
                            <div class="modal-footer">
                                <!--Contact-->
                                <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php else : ?>

        <!-- Modal Profile Madif-->
        <div class="modal fade" id="profile<?= $modalhjd['biodata_madif']['id_profile_mhs']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: blueviolet">
                        <h5 class="modal-title text-white" id="exampleModalLabel">Profile Madif <?= $modalhjd['biodata_madif']['nickname']; ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Form -->
                    <form action="<?= base_url('c_damping_ujian/generate'); ?>" method="POST">
                        <div class="modal-body text-center" style="background-color: white;">
                            <?= csrf_field(); ?>

                            <!--NIM-->
                            <div class="row mb-2" style="background-color: inherit;">
                                <div class="col-6 text-center">
                                    <label for="nim" class="form-label mb-0 fw-bold">NIM</label>
                                    <input type="text" readonly class="my-0 form-control-plaintext text-center" id="nim" value="<?= $modalhjd['biodata_madif']['nim']; ?>" style="color:darkslategray">
                                </div>
                                <div class="col-6 text-center">
                                    <label for="nim" class="form-label mb-0 fw-bold">Jenis Difabel</label>
                                    <input type="text" readonly class="my-0 form-control-plaintext text-center" id="nim" value="<?= $modalhjd['biodata_madif']['jenis_madif']; ?>" style="color:darkslategray">
                                </div>
                            </div>

                            <div class="shadow p-3 mb-5 rounded-2 my-0" style="background-color: rgba(241, 241, 230, 0.8);">
                                <!--NIM-->
                                <div class="row mb-2">
                                    <div class="col-sm-6">
                                        <label for="nama" class="form-label mb-0 ">Nama</label>
                                        <input type="text" readonly class="form-control-plaintext text-center" id="nama" value="<?= $modalhjd['biodata_madif']['fullname']; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="nama" class="form-label mb-0 ">Jenis Kelamin</label>
                                        <input type="text" readonly class="form-control-plaintext text-center" id="nama" value="<?= ($modalhjd['biodata_madif']['jenis_kelamin'] == 1) ? 'Laki-laki' : 'Perempuan'; ?>">
                                    </div>
                                </div>
                                <!--Jenis Kelamin-->
                                <div class="row mb-2">
                                    <div class="col-sm-6">
                                        <label for="fakultas" class="form-label mb-0 ">Fakultas</label>
                                        <input type="text" readonly class="form-control-plaintext text-center" id="fakultas" value="<?= $modalhjd['biodata_madif']['fakultas']; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="semester" class="form-label mb-0 ">Semester</label>
                                        <input type="text" readonly class="form-control-plaintext text-center" id="semester" value="<?= $modalhjd['biodata_madif']['semester']; ?>">
                                    </div>
                                </div>
                            </div>

                            <!--Semester-->
                            <div class="row mb-2" style="background-color: inherit;">
                                <div class="col-sm-12 text-center">
                                    <label for="contact" class="form-label mb-0 fw-bold">Contact</label>
                                    <input type="text" readonly class="my-0 form-control-plaintext text-center" id="contact" value="<?= $modalhjd['biodata_madif']['nomor_hp']; ?>" style="color:darkslategray">
                                </div>
                            </div>

                        </div>
                        <!-- Submit button -->
                        <div class="modal-footer">
                            <!--Contact-->
                            <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php if (!isset($modalhjd['status_damping'])) : ?>
            <!-- Modal Perizinan -->
            <div class="modal fade" id="izinTidakDamping<?= $modalhjd['id_damping']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: rgba(223, 7, 36, 1);">
                            <h4 class="modal-title" id="exampleModalLabel" style="color: whitesmoke;"> Pengajuan Izin Tidak Damping</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class=" modal-body">
                            <form action="<?= base_url('/c_perizinan/saveIzin'); ?>" method="post" enctype="multipart/form-data">
                                <?= csrf_field(); ?>
                                <!-- Inputan tersembunyi id_damping -->
                                <input type="hidden" name="id_damping" value=<?= $modalhjd['id_damping']; ?>>

                                <!-- id profile mhs -->
                                <input type="hidden" name="id_profile_mhs" value=<?= $modalhjd['biodata_pendamping']['id_profile_mhs']; ?>>

                                <!-- Rekomendasi Pendamping -->
                                <div class="row mb-2">
                                    <label for="rekomen_pengganti" class="col-form-label">Rekomendasi Pengganti <span class="fs-6" style="color:red">(urutan berdasarkan kecocokan)</span></label>

                                    <div>
                                        <?php if (!empty($modalhjd['pendamping_pengganti'])) : ?>
                                            <select class="form-select" name="rekomen_pengganti" id="rekomen_pengganti" required>
                                                <option selected value="">Pilih Pendamping</option>
                                                <?php $i = 1; ?>
                                                <?php foreach ($modalhjd['pendamping_pengganti'] as $rekomen) : ?>
                                                    <option value="<?= $rekomen['profile']['id_profile_mhs']; ?>"><?= $i++ . '. ' . $rekomen['profile']['nickname'] . (isset($rekomen['prioritas']) ? ' (Rekomendasi)' : ''); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        <?php else : ?>
                                            <select class="form-select" name="rekomen_pengganti" id="rekomen_pengganti" disabled>
                                                <option selected value="null" disabled>Rekomendasi Pendamping Tidak Tersedia</option>
                                            </select>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!--Alasan Tidak Bisa Damping -->
                                <div class="form-floating mb-3">
                                    <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px" name="alasan" required></textarea>
                                    <label for="floatingTextarea2">Alasan</label>
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
                                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-success">
                                        Simpan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Modal Jadwal Ujian -->
    <div class="modal fade" id="jadwalDamping<?= $modalhjd['id_damping']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background-color: orange">
                    <h5 class="modal-title fw-bold" id="exampleModalLabel">Detail Jadwal Ujian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="card shadow p-3 mb-5 bg-body rounded">
                        <div class="card-header text-center fw-bold">
                            <?= $modalhjd['jadwal_ujian']['mata_kuliah']; ?>
                        </div>
                        <div class="card-body">
                            <!--  start hidden jadwal id -->
                            <input type="hidden" name="id_jadwal_ujian" value="<?= $modalhjd['jadwal_ujian']['id_jadwal_ujian']; ?>">
                            <!-- end hidden jadwal id -->

                            <!-- Tanggal Ujian -->
                            <div class="row">
                                <label for="tanggal_ujian" class="col-sm-4 col-form-label">Tanggal Ujian</label>
                                <div class="col-sm-8">
                                    <input type="text" readonly class="form-control-plaintext" id="tanggal_ujian" value="<?= date('d, M Y', strtotime($modalhjd['jadwal_ujian']['tanggal_ujian'])); ?>">
                                </div>
                            </div>

                            <!-- Jam Ujian -->
                            <div class="row">
                                <label for="staticEmail" class="col-sm-4 col-form-label">Jam Ujian</label>
                                <div class="col-sm-8">
                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= date('H:i', strtotime($modalhjd['jadwal_ujian']['waktu_mulai_ujian'])); ?> - <?= date('H:i', strtotime($modalhjd['jadwal_ujian']['waktu_selesai_ujian'])); ?>">
                                </div>
                            </div>

                            <!-- Ruangan -->
                            <div class="row">
                                <label for="staticEmail" class="col-sm-4 col-form-label">Ruangan</label>
                                <div class="col-sm-8">
                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $modalhjd['jadwal_ujian']['ruangan']; ?>">
                                </div>
                            </div>

                            <!-- Keterangan -->
                            <div class="row">
                                <label for="staticEmail" class="col-sm-4 col-form-label">Keterangan</label>
                                <div class="col-sm-8">
                                    <button class="btn btn-primary btn-sm mt-1" data-bs-target="#keterangan<?= $modalhjd['id_damping']; ?>" data-bs-toggle="modal" data-bs-dismiss="modal">Keterangan</button>
                                </div>
                            </div>

                            <!-- Presensi -->
                            <div class="row">
                                <label for="staticEmail" class="col-sm-4 col-form-label">Presensi</label>

                                <?php if ($profile_mhs['madif'] == 1) : ?>
                                    <!-- Madif -->
                                    <?php if (empty($modalhjd['status_damping'])) : ?>
                                        <div class="col-sm-8 mt-2">
                                            -
                                        </div>
                                    <?php elseif ($modalhjd['status_damping'] == 'presensi_hadir') : ?>
                                        <div class="col-sm-8">
                                            <button class="btn btn-secondary btn-sm mt-1" disabled>Proses...</button>
                                        </div>
                                    <?php elseif ($modalhjd['status_damping'] == 'konfirmasi_presensi_hadir') : ?>
                                        <div class="col-sm-8 mt-1">
                                            <button class="btn btn-success btn-sm mt-1" data-bs-target="#presensi<?= $modalhjd['id_damping']; ?>" data-bs-toggle="modal" data-bs-dismiss="modal">Detail</button>
                                        </div>
                                    <?php elseif ($modalhjd['status_damping'] == 'pendampingan') : ?>
                                        <div class="col-sm-8 mt-1">
                                            <a href="<?= base_url('changeStatus/laporan'); ?>/<?= $modalhjd['id_damping']; ?>" class="btn btn-success btn-sm">Pendampingan Selesai</a>
                                        </div>
                                    <?php else : ?>
                                        <div class="col-sm-8 mt-2">
                                            <i class="far fa-check-square"></i>
                                        </div>
                                    <?php endif; ?>
                                <?php else : ?>
                                    <!-- Pendamping -->
                                    <?php if (empty($modalhjd['status_damping'])) : ?>
                                        <div class="col-sm-8 mt-2">
                                            -
                                        </div>
                                    <?php elseif ($modalhjd['status_damping'] == 'presensi_hadir') : ?>
                                        <div class="col-sm-8">
                                            <button class="btn btn-success btn-sm mt-1" data-bs-target="#presensi<?= $modalhjd['id_damping']; ?>" data-bs-toggle="modal" data-bs-dismiss="modal">Detail</button>
                                        </div>
                                    <?php elseif ($modalhjd['status_damping'] == 'konfirmasi_presensi_hadir') : ?>
                                        <div class="col-sm-8">
                                            <button class="btn btn-secondary btn-sm mt-1" disabled>Proses...</button>
                                        </div>
                                    <?php elseif ($modalhjd['status_damping'] == 'pendampingan') : ?>
                                        <div class="col-sm-8">
                                            <a href="<?= base_url('changeStatus/laporan'); ?>/<?= $modalhjd['id_damping']; ?>" class="btn btn-success btn-sm">Pendampingan Selesai</a>
                                        </div>
                                    <?php else : ?>
                                        <div class="col-sm-8 mt-2">
                                            <i class="far fa-check-square"></i>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>

                            <!-- Laporan -->
                            <div class="row">
                                <label for="staticEmail" class="col-sm-4 col-form-label">Laporan</label>
                                <?php if ($profile_mhs['madif'] == 1) : ?>
                                    <!-- Madif -->
                                    <?php if ($modalhjd['status_damping'] == 'laporan') : ?>
                                        <div class="col-sm-8">
                                            <button class="btn btn-success btn-sm mt-1" data-bs-target="#evaluasi<?= $modalhjd['id_damping']; ?>" data-bs-toggle="modal" data-bs-dismiss="modal">Evaluasi</button>
                                        </div>
                                    <?php elseif ($modalhjd['status_damping'] == 'madif_review') : ?>
                                        <div class="col-sm-8">
                                            <button class="btn btn-success btn-sm mt-1" data-bs-target="#evaluasi<?= $modalhjd['id_damping']; ?>" data-bs-toggle="modal" data-bs-dismiss="modal">Evaluasi</button>
                                        </div>
                                    <?php elseif ($modalhjd['status_damping'] == 'pendamping_review') : ?>
                                        <div class="col-sm-8">
                                            <button class="btn btn-secondary btn-sm mt-1" disabled>Proses...</button>
                                        </div>
                                    <?php elseif ($modalhjd['status_damping'] == 'selesai') : ?>
                                        <td>
                                            <div class="col-sm-8">
                                                <button class="btn btn-success btn-sm mt-1" disabled>Selesai</button>
                                            </div>
                                        </td>
                                    <?php else : ?>
                                        <div class="col-sm-8 mt-2">
                                            -
                                        </div>
                                    <?php endif; ?>

                                <?php else : ?>
                                    <!-- Pendamping -->
                                    <?php if ($modalhjd['status_damping'] == 'laporan') : ?>
                                        <div class="col-sm-8">
                                            <button class="btn btn-success btn-sm mt-1" data-bs-target="#evaluasi<?= $modalhjd['id_damping']; ?>" data-bs-toggle="modal" data-bs-dismiss="modal">Evaluasi</button>
                                        </div>
                                    <?php elseif ($modalhjd['status_damping'] == 'pendamping_review') : ?>
                                        <div class="col-sm-8">
                                            <button class="btn btn-success btn-sm mt-1" data-bs-target="#evaluasi<?= $modalhjd['id_damping']; ?>" data-bs-toggle="modal" data-bs-dismiss="modal">Evaluasi</button>
                                        </div>
                                    <?php elseif ($modalhjd['status_damping'] == 'madif_review') : ?>
                                        <div class="col-sm-8">
                                            <button class="btn btn-secondary btn-sm mt-1" disabled>Proses...</button>
                                        </div>
                                    <?php elseif ($modalhjd['status_damping'] == 'selesai') : ?>
                                        <td>
                                            <div class="col-sm-8">
                                                <button class="btn btn-success btn-sm mt-1" disabled>Selesai</button>
                                            </div>
                                        </td>
                                    <?php else : ?>
                                        <div class="col-sm-8 mt-2">
                                            -
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
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
    <div class="modal fade" id="keterangan<?= $modalhjd['id_damping']; ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background-color: rgba(34, 84, 145, 1);">
                    <h5 class="modal-title text-white" id="exampleModalToggleLabel2">Keterangan Pendampingan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="color: black">
                    <?= $modalhjd['jadwal_ujian']['keterangan']; ?>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-bs-target="#jadwalDamping<?= $modalhjd['id_damping']; ?>" data-bs-toggle="modal" data-bs-dismiss="modal">Kembali</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Presensi -->
    <div class="modal fade" id="presensi<?= $modalhjd['id_damping']; ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header" style="background-color: rgba(12, 124, 79, 1);">
                    <h5 class="modal-title text-white fw-bold" id="exampleModalToggleLabel2">Presensi Pendampingan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="color: black">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Jam Presensi Hadir <span style="color: red;"><?= (isset($modalhjd['presensi']) && ($modalhjd['presensi']['tepat_waktu'] == 0)) ? '*Terlambat' : ''; ?></span></label>
                        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="<?= (isset($modalhjd['presensi'])) ? date('H:i', strtotime($modalhjd['presensi']['waktu_hadir'])) : ''; ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Jam Selesai Pendampingan</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="" disabled>
                    </div>
                    <div class="col-12 d-flex justify-content-center">
                        <?php if ($profile_mhs['pendamping'] == 1) : ?>
                            <a href="<?= base_url('changeStatus/konfirmasi_presensi_hadir'); ?>/<?= $modalhjd['id_damping']; ?>" class="btn btn-primary btn-sm">Absen</a>
                        <?php endif; ?>

                        <?php if ($profile_mhs['madif'] == 1) : ?>
                            <a href="<?= base_url('changeStatus/pendampingan'); ?>/<?= $modalhjd['id_damping']; ?>" class="btn btn-success btn-sm mx-1">Confirm</a>
                            <a href="<?= base_url('changeStatus/tolak_presensi_hadir'); ?>/<?= $modalhjd['id_damping']; ?>" class="btn btn-danger btn-sm mx-1">Reject</a>
                        <?php endif; ?>

                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary btn-sm" data-bs-target="#jadwalDamping<?= $modalhjd['id_damping']; ?>" data-bs-toggle="modal" data-bs-dismiss="modal">Kembali</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Evaluasi -->
    <div class="modal fade" id="evaluasi<?= $modalhjd['id_damping']; ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background-color: rgba(12, 124, 79, 1);">
                    <h5 class="modal-title text-white fw-bold" id="exampleModalToggleLabel2">Evaluasi Pendampingan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body" style="color: black">
                    <form action="<?= base_url('c_damping_ujian/saveLaporan'); ?>/<?= $modalhjd['id_damping']; ?>" method="get" class="row gy-2 gx-0 align-items-center justify-content-center">

                        <!-- ID Damping -->
                        <input type="hidden" name="id_damping" value="<?= $modalhjd['id_damping']; ?>">

                        <!-- Jenis Mahasiswa -->
                        <input type="hidden" name="madif" value="<?= $profile_mhs['madif']; ?>">

                        <!-- Waktu Presensi -->
                        <div class="row mt-0 mb-2 g-3 align-items-center justify-content-center text-center">
                            <label for="" class="form-label mb-2 fw-bold">Waktu Presensi <span style="color: red;" class="fs-6"><?= (isset($modalhjd['presensi']) && ($modalhjd['presensi']['tepat_waktu'] == 0)) ? '*Terlambat' : ''; ?></span></label>
                            <div class="col-3 mt-0">
                                <input type="text" class="form-control" placeholder="kehadiran" value="<?= (isset($modalhjd['presensi'])) ? date('H:i', strtotime($modalhjd['presensi']['waktu_hadir'])) : ''; ?>" aria-label="First name" disabled>
                            </div>
                            -
                            <div class="col-3 mt-0">
                                <input type="text" class="form-control" placeholder="selesai" value="<?= (isset($modalhjd['presensi'])) ? date('H:i', strtotime($modalhjd['presensi']['waktu_selesai'])) : ''; ?>" aria-label="Last name" disabled>
                            </div>
                        </div>

                        <hr>

                        <!-- Rating -->
                        <label for="rating_pendampingan" class="form-label text-center fw-bold">Rating (1-5)</label>
                        <input type="range" class="form-range" min="1" max="5" id="rating_pendampingan" name='rating'>

                        <!-- Evaluasi -->
                        <div class="form-floating mb-2">
                            <textarea class="form-control" placeholder="Leave a comment here" id="evaluasi_pendampingan" style="height: 100px" name="review_pendampingan"></textarea>
                            <label for="evaluasi_pendampingan" class="text-muted">Evaluasi</label>
                        </div>

                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary">
                                Kirim
                            </button>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary btn-sm" data-bs-target="#jadwalDamping<?= $modalhjd['id_damping']; ?>" data-bs-toggle="modal" data-bs-dismiss="modal">Kembali</button>
                </div>
            </div>
        </div>
    </div>

<?php endforeach; ?>

<?php if (!empty($gagal_damping)) : ?>
    <!-- Modal Cek Tidak Didampingi-->
    <div class="modal fade" id="gagalDamping" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header" style="background-color: darkred;">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Daftar Gagal Pendampingan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form action="/c_jadwal_ujian/delJadwal" method="post">
                        <!-- Basic table -->
                        <div class="table-responsive">
                            <p class="text-center" style="color: red;">Jumlah Gagal Pendampingan: <?= count($gagal_damping); ?></p>
                            <table class="table table-hover table-dark" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Tanggal Ujian</th>
                                        <th scope="col">Mata Kuliah</th>
                                        <?php if ($profile_mhs['madif'] == 1) : ?>
                                            <th scope="col">Pendamping</th>
                                        <?php else : ?>
                                            <th scope="col">Mahasiswa Difabel</th>
                                        <?php endif; ?>
                                        <th scope="col">Status</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="table-light">
                                    <?php $i = 1 ?>
                                    <?php foreach ($gagal_damping as $modalgd) : ?>
                                        <tr class="align-middle" style="color:grey">

                                            <!-- Id Pendampingan -->
                                            <input type="hidden" name="id_damping" value="<?= $modalgd['id_damping']; ?>">

                                            <!-- Nomor -->
                                            <th scope="row"><?= $i++; ?></th>

                                            <!-- Tanggal Ujian -->
                                            <td><?= date('d, M Y', strtotime($modalgd['jadwal_ujian']['tanggal_ujian'])); ?></td>

                                            <!-- Mata Kuliah -->
                                            <td><?= $modalgd['jadwal_ujian']['mata_kuliah']; ?></td>

                                            <!-- Nama madif dan pendamping -->
                                            <?php if ($profile_mhs['madif'] == 1) : ?>

                                                <!-- Nama pendamping -->
                                                <?php if (!empty($modalgd['biodata_pendamping'])) : ?>
                                                    <td><?= $modalgd['biodata_pendamping']['nickname']; ?></td>
                                                <?php else : ?>
                                                    <td>-</td>
                                                <?php endif; ?>

                                            <?php else : ?>
                                                <!-- Nama Madif -->
                                                <td><?= $modalgd['biodata_madif']['nickname']; ?> (<?= $modalgd['biodata_madif']['jenis_madif']; ?>)</td>
                                            <?php endif; ?>

                                            <!-- Status -->
                                            <td style="color: red;">
                                                Gagal Pendampingan
                                            </td>

                                            <!-- Aksi -->
                                            <td>
                                                <a href="<?= base_url('c_damping_ujian/delDamping/' . $modalgd['id_damping']); ?>" class="btn btn-danger btn-sm my-1">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection(); ?>