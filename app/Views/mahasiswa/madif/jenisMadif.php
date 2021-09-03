<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid px-6 py-4">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="row mb-6">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div id="examples" class="mb-4">
                        <h2>Jenis Mahasiswa Difabel <?= user()->username; ?></h2>

                        <?php if (session()->getFlashData('berhasil_diedit')) : ?>
                            <div class="alert alert-success" role="alert">
                                <?= session()->getFlashData('berhasil_diedit'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <!-- Card -->
                    <div class="card">
                        <!-- Tab table -->
                        <ul class="nav nav-line-bottom d-flex justify-content-between" id="pills-tab-table" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-table-daftar-ujian-tab" data-bs-toggle="pill" href="#pills-table-daftar-ujian" role="tab" aria-controls="pills-table-daftar-ujian" aria-selected="true">Jenis Mahasiswa Difabel</a>
                            </li>
                        </ul>
                        <!-- Tab content -->
                        <div class=" tab-content p-4" id="pills-tabContent-table">

                            <!-- Daftar Tabel -->
                            <div class="tab-pane tab-example-design fade show active" id="pills-table-daftar-ujian" role="tabpanel" aria-labelledby="pills-table-daftar-ujian-tab">
                                <!-- Basic table -->
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Jenis Mahasiswa Difabel</th>
                                                <th scope="col">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <?= $madif; ?>
                                                </td>
                                                <td>
                                                    <!-- Button trigger modal Detail Jadwal Ujian -->
                                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editJenisMadif" ?>
                                                        <i class="fas fa-pen-square"></i>
                                                    </button>
                                                </td>
                                            </tr>
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

<!-- Modal Edit Skill-->
<div class="modal fade" id="editJenisMadif" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header" style="background-color: gold;">
                <h5 class="modal-title" id="exampleModalLabel" style=" color:black">Edit Jenis Difabel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Form -->
            <form action="/jenisMadif/editJenisMadif/<?= user()->username; ?>a<?= $madif; ?>" method="post">
                <div class="modal-body">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="id_pendamping" value="<?= user()->username; ?>">
                    <!--Referensi Pendampingan-->
                    <div class="row mb-3">
                        <label for="jenis_difabel" class="col-sm-6 col-form-label">Jenis Difabel</label>
                        <div class="col-sm-6">
                            <select class="form-select" aria-label="Default select example" name="jenis_difabel" id="jenis_difabel" autofocus required>
                                <?php for ($i = 0; $i < count($jenis_difabel); $i++) : ?>
                                    <option value=<?= $jenis_difabel[$i]['id']; ?> <?= ($jenis_difabel[$i]['jenis'] == $madif) ? 'selected' : ''; ?>><?= $i + 1 . '. ' . $jenis_difabel[$i]['jenis']; ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
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

<?= $this->endSection(); ?>