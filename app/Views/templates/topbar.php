<div class="header @@classList">

    <!-- sidebar expand-->
    <nav class="navbar-classic navbar navbar-expand-lg">
        <a id="nav-toggle" href="#"><i data-feather="menu" class="nav-icon me-2 icon-xs"></i></a>

        <!--Navbar nav -->
        <ul class="navbar-nav navbar-right-wrap ms-auto d-flex nav-top-wrap">
            <!-- Notification -->
            <li class="dropdown stopevent">
                <a class="btn btn-light btn-icon rounded-circle indicator indicator-primary text-muted position-relative" href="#" role="button" id="dropdownNotification" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-xs" data-feather="bell"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">+<?= $notifikasi['total']; ?> <span class="visually-hidden">unread messages</span></span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end" aria-labelledby="dropdownNotification">
                    <div class="">
                        <div class="border-bottom px-3 pt-2 pb-3 d-flex justify-content-between align-items-center">
                            <p class="mb-0 text-dark fw-medium fs-4">Notifications</p>
                        </div>
                        <!-- List group -->
                        <ul class="list-group list-group-flush notification-list-scroll">
                            <?php foreach ($notifikasi['notif'] as $key_no) : ?>
                                <!-- List group item -->
                                <li class="list-group-item list-group-item-action">
                                    <a href="<?= $key_no['detail']['link_jenis_notif']; ?>" class="text-muted">
                                        <h5 class="fw-bold mb-1"><?= $key_no['detail']['jenis_notif']; ?></h5>
                                        <p class="mb-0">
                                            <?= $key_no['pesan']; ?>
                                        </p>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="border-top px-3 py-2 text-center">
                            <?php
                            $role = (in_groups('admin')) ? 'Admin' : ((in_groups('madif')) ? 'Madif' : 'Pendamping');
                            ?>
                            <a href="<?= base_url('notif' . $role); ?>" class="text-inherit fw-semi-bold">
                                View all Notifications
                            </a>
                        </div>
                    </div>
                </div>
            </li>

            <!-- Profile List -->
            <li class="dropdown ms-2">
                <a class="rounded-circle" href="#" role="button" id="dropdownUser" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="avatar avatar-md">
                        <img alt="avatar" src="/assets/images/avatar/avatar-<?= in_groups('admin') ? '1' : (in_groups('madif') ? '2' : '3') ?>.jpg" class="rounded-circle">
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">

                    <div class="px-4 pb-0 pt-2">
                        <div class="lh-1 ">
                            <h5 class="mb-1"><?= user()->username; ?></h5>
                            <a href="<?= base_url('/viewProfile'); ?>/<?= user()->username; ?>" class="text-inherit fs-6">View my profile</a>
                        </div>
                        <div class=" dropdown-divider mt-3 mb-2"></div>
                    </div>

                    <ul class="list-unstyled">
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="me-2 icon-xxs dropdown-item-icon" data-feather="activity"></i>Activity Log
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= base_url('logout'); ?>">
                                <i class="me-2 icon-xxs dropdown-item-icon" data-feather="power"></i>Sign Out
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </nav>