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

                    <!-- Basic table -->
                    <div class="table-responsive">
                        <table class="table table-light" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                            <thead class="text-center">
                                <tr>
                                    <th scope="col">Total User Admin</th>
                                </tr>
                            </thead>
                            <tbody class="text-center table-light">
                                <tr>
                                    <td><?= count($admin); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Basic table -->
                    <div class="my-2 d-flex justify-content-end">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary btn-sm mt-3" data-toggle="modal" data-target="#addAdmin">
                            Tambah Jadwal Ujian
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-dark" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Jabatan</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="table-light">

                                <?php $i = 1 ?>
                                <?php foreach ($admin as $ad) : ?>
                                    <tr class="align-middle">
                                        <th scope="row"><?= $i; ?></th>
                                        <td><?= $ad['nickname']; ?></td>
                                        <td><?= $ad['jabatan']; ?></td>
                                        <td>
                                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit<?= $ad['id_profile_admin']; ?>" ?>
                                                Edit
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#edit<?= $ad['id_profile_admin']; ?>" ?>
                                                Hapus
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

<?= $this->endSection(); ?>