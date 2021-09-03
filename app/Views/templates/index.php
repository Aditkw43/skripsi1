<!DOCTYPE html>
<html lang="en">

<head>
    <?= $this->include('templates/header'); ?>
    <title>Sistem Pendampingan Ujian</title>
</head>

<body>
    <div id="db-wrapper">
        <!-- navbar vertical -->

        <!-- Sidebar -->
        <?= $this->include('templates/sidebar'); ?>

        <!-- Page content -->
        <div id="page-content">
            <!-- Topbar -->
            <?= $this->include('templates/topbar'); ?>

            <!-- Page-content -->
            <?= $this->renderSection('page-content'); ?>
            <!-- End Page Content -->
        </div>
    </div>

    <!-- Footer -->
    <?= $this->include('templates/footer'); ?>

</body>

</html>