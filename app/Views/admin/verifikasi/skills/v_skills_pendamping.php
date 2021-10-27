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
                        <table class="table table-hover table-dark" style="border-radius: 5px 5px 0px 0px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">NIM</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Fakultas</th>
                                    <th scope="col">Skill</th>
                                    <th scope="col">Prioritas</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="table-light">

                                <?php $i = 1 ?>
                                <?php foreach ($v_skill as $vs) : ?>
                                    <tr class="align-middle">
                                        <th scope="row"><?= $i; ?></th>
                                        <td><?= $vs['nim']; ?></td>
                                        <td><?= $vs['nickname']; ?></td>
                                        <td><?= $vs['fakultas']; ?></td>
                                        <td><?= $vs['nama_skill']; ?></td>
                                        <td><?= $vs['prioritas']; ?></td>
                                        <td>
                                            <a href="<?= base_url('c_user/approval_skill/' . $vs['id_profile_pendamping'] . '/' . $vs['ref_pendampingan'] . '/' . 'terima'); ?>" class="btn btn-success btn-sm my-1">Terima</a>
                                            <a href="<?= base_url('c_user/approval_skill/' . $vs['id_profile_pendamping'] . '/' . $vs['ref_pendampingan'] . '/' . 'tolak'); ?>" class="btn btn-danger btn-sm">Tolak</a>
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