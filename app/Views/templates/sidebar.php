<nav class="navbar-vertical navbar">
    <div class="nav-scroller">

        <!-- Brand logo -->
        <a class="navbar-brand" href="/index.html">
            <div style="font-size: 2rem; display: inline">
                <?php if (in_groups('madif')) : ?>
                    <i class="fas fa-wheelchair"></i>
                <?php elseif (in_groups('pendamping')) : ?>
                    <i class="fas fa-user-friends"></i>
                <?php elseif (in_groups('admin')) : ?>
                    <i class="fas fa-user-tie"></i>
                <?php endif; ?>

            </div>

            <?php if (in_groups('admin')) : ?>
                <div style="display: inline; font-size: 1.5rem;">
                    Administrator
                <?php elseif (in_groups('madif')) : ?>
                    <div style="display: inline; font-size: 1rem;">
                        Mahasiswa Difabel
                    <?php elseif (in_groups('pendamping')) : ?>
                        <div style="display: inline; font-size: 1.5rem;">
                            Pendamping
                        <?php endif; ?>
                        </div>
        </a>

        <!-- Navbar nav -->
        <ul class="navbar-nav flex-column" id="sideNavbar">
            <!-- Dashboard -->
            <li class="nav-item">
                <a class="nav-link has-arrow  active " href="/index.html">
                    <i class="fas fa-tachometer-alt nav-icon icon-xs me-2"></i>
                    Dashboard
                </a>
            </li>

            <!-- Judul Penjadwalan Pendampingan -->
            <li class="nav-item">
                <div class="navbar-heading">Pendampingan</div>
            </li>

            <?php if (!in_groups('admin')) : ?>
                <!-- Jadwal Ujian -->
                <li class="nav-item">
                    <a class="nav-link " href="<?= base_url('/viewJadwal/' . user()->username); ?>">
                        <i class="fas fa-clipboard-list nav-icon icon-xs me-2"></i>
                        Kelola Jadwal Ujian
                    </a>
                </li>

                <!-- Pendampingan -->
                <li class="nav-item">
                    <a class="nav-link has-arrow  collapsed " href="#!" data-bs-toggle="collapse" data-bs-target="#navAuthentication" aria-expanded="false" aria-controls="navAuthentication">
                        <i class="fas fa-calendar-week nav-icon icon-xs me-2"></i> Pendampingan Ujian
                    </a>

                    <div id="navAuthentication" class="collapse " data-bs-parent="#sideNavbar">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link " href="/pages/sign-in.html"> List Pendampingan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link  " href="/pages/sign-up.html"> Presensi</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="/pages/forget-password.html">
                                    Laporan Pendampingan
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
            <?php endif; ?>

            <?php if (in_groups('admin')) : ?>
                <li class="nav-item">
                    <a class="nav-link has-arrow  collapsed " href="#!" data-bs-toggle="collapse" data-bs-target="#navComponents" aria-expanded="false" aria-controls="navComponents">
                        <i class="fas fa-clipboard-list nav-icon icon-xs me-2"></i> Jadwal Ujian
                    </a>
                    <div id="navComponents" class="collapse " data-bs-parent="#sideNavbar">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link " href="<?= base_url('viewAllJadwal'); ?>/madif" aria-expanded="false">
                                    Jadwal Ujian Madif
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="<?= base_url('viewAllJadwal'); ?>/pendamping" aria-expanded="false">
                                    Jadwal Ujian Pendamping
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Generate Pendampingan -->
                <li class="nav-item">
                    <a class="nav-link " href="<?= base_url('c_damping_ujian'); ?>">
                        <i class="fas fa-cogs nav-icon icon-xs me-2"></i>
                        Generate Pendampingan
                    </a>
                </li>
            <?php endif; ?>

            <!-- Judul Perizinan -->
            <li class="nav-item">
                <div class="navbar-heading">Perizinan</div>
            </li>

            <!-- List Perizinan -->
            <li class="nav-item">
                <a class="nav-link " href="/pages/tables.html">
                    <i class="nav-icon icon-xs me-2 bi bi-table">
                    </i>
                    List Perizinan
                </a>
            </li>

            <!-- Pengajuan Perizinan -->
            <li class="nav-item">
                <a class="nav-link has-arrow  collapsed " href="#!" data-bs-toggle="collapse" data-bs-target="#navComponents" aria-expanded="false" aria-controls="navComponents">
                    <i class="fas fa-file-medical nav-icon icon-xs me-2"></i> Pengajuan Izin
                </a>
                <div id="navComponents" class="collapse " data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link " href="/components/accordions.html" aria-expanded="false">
                                Izin Tidak Damping
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="/components/alerts.html" aria-expanded="false">
                                Izin Cuti
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Konfirmasi Perizinan -->
            <li class="nav-item">
                <a class="nav-link " href="/pages/tables.html">
                    <i class="fas fa-clipboard-check nav-icon icon-xs me-2"></i>
                    Kofirmasi Perizinan
                </a>
            </li>

            <!-- Judul Setting -->
            <li class="nav-item">
                <div class="navbar-heading">Setting</div>
            </li>

            <!-- Nav item -->
            <li class="nav-item">
                <a class="nav-link has-arrow " href="<?= base_url('logout'); ?>">
                    <i class="nav-icon icon-xs me-2 fas fa-sign-out-alt"></i>Logout
                </a>
            </li>

        </ul>
    </div>
</nav>