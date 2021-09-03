<?= $this->extend('templatesUser/index'); ?>
<?= $this->section('page-content'); ?>

<h2 class="ml-3">Detail Jadwal Ujian</h2>
<hr>
<div class="justify-content-center" style="display: flex;">
    <div>
        <div class="card-header">
            <?= $jadwal['mata_kuliah']; ?>
        </div>

        <div class="card-body">
            <table class="mb-2">
                <tr>
                    <th>Tanggal</th>
                    <td>: <?= $jadwal['tanggal_ujian']; ?></td>
                </tr>
                <tr>
                    <th>Jam</th>
                    <td>: <?= $jadwal['waktu_ujian']; ?></td>
                </tr>
                <tr>
                    <th>Ruangan</th>
                    <td>: <?= $jadwal['ruang']; ?></td>
                </tr>
                <tr>
                    <th>Keterangan</th>
                    <td>: <?= $jadwal['keterangan']; ?></td>
                </tr>
                <tr>
                    <th>Presensi</th>
                    <td>: -</td>
                </tr>
                <tr>
                    <th>Laporan</th>
                    <td>: -</td>
                </tr>
                <tr>
                    <th>Aksi</th>
                    <td>: <span class="badge badge-<?= ($user->name == 'admin') ? 'danger' : (($user->name == 'madif') ? 'success' : 'info'); ?>"><?= $user->name; ?></span></td>
                </tr>
            </table>
        </div>

        <div class="card-footer text-muted">
            2 days ago
        </div>
    </div>
</div>

<?= $this->endSection(); ?>