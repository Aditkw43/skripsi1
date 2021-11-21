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
                <a class="nav-link has-arrow  active " href="<?= in_groups('admin') ? base_url('/dashboardAdmin') : base_url('/dashboardMhs'); ?>">
                    <i class="fas fa-tachometer-alt nav-icon icon-xs me-2"></i>
                    Dashboard
                </a>
            </li>

            <!-- Judul Penjadwalan Pendampingan -->
            <li class="nav-item">
                <div class="navbar-heading">Pendampingan</div>
            </li>

            <?php if (!in_groups('admin')) : ?>
                <!-- Kelola Jadwal Ujian -->
                <li class="nav-item">
                    <a class="nav-link has-arrow  collapsed " href="#!" data-bs-toggle="collapse" data-bs-target="#kelolaJadwalUjian" aria-expanded="false" aria-controls="kelolaJadwalUjian">
                        <i class="fas fa-clipboard-list nav-icon icon-xs me-2"></i> Kelola Jadwal Ujian
                    </a>

                    <div id="kelolaJadwalUjian" class="collapse " data-bs-parent="#sideNavbar">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link " href="<?= base_url('/viewJadwalUTS/' . user()->username); ?>"> Jadwal Ujian UTS</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="<?= base_url('/viewJadwalUAS/' . user()->username); ?>">
                                    Jadwal Ujian UAS
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Pendampingan -->
                <li class="nav-item">
                    <a class="nav-link has-arrow  collapsed " href="#!" data-bs-toggle="collapse" data-bs-target="#pendampinganUjian" aria-expanded="false" aria-controls="pendampinganUjian">
                        <i class="fas fa-calendar-week nav-icon icon-xs me-2"></i> Pendampingan Ujian
                    </a>

                    <div id="pendampinganUjian" class="collapse " data-bs-parent="#sideNavbar">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link " href="<?= base_url('/viewDampingUTS/' . user()->username); ?>">UTS</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="<?= base_url('/viewDampingUAS/' . user()->username); ?>">UAS</a>
                            </li>
                            <?php if (in_groups('madif')) : ?>
                                <li class="nav-item">
                                    <a class="nav-link  " href="<?= base_url('/viewTidakDamping/' . user()->username); ?>"> List Tidak Didampingi</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </li>

                <!-- Laporan -->
                <li class="nav-item">
                    <a class="nav-link has-arrow  collapsed " href="#!" data-bs-toggle="collapse" data-bs-target="#laporan-pendampingan" aria-expanded="false" aria-controls="laporan-pendampingan">
                        <i class="fas fa-clipboard-check nav-icon icon-xs me-2"></i> Laporan
                    </a>

                    <div id="laporan-pendampingan" class="collapse " data-bs-parent="#sideNavbar">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link " href="<?= base_url('/viewLaporanUTS/' . user()->username); ?>"> UTS</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="<?= base_url('/viewLaporanUAS/' . user()->username); ?>"> UAS</a>
                            </li>
                        </ul>
                    </div>
                </li>
            <?php endif; ?>

            <?php if (in_groups('admin')) : ?>
                <!-- Jadwal Ujian -->
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

                <!-- Pendampingan -->
                <li class="nav-item">
                    <a class="nav-link has-arrow  collapsed " href="#!" data-bs-toggle="collapse" data-bs-target="#navAuthentication" aria-expanded="false" aria-controls="navAuthentication">
                        <i class="fas fa-calendar-week nav-icon icon-xs me-2"></i> Pendampingan Ujian
                    </a>

                    <div id="navAuthentication" class="collapse " data-bs-parent="#sideNavbar">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link " href="<?= base_url('/viewAllDampingUTS'); ?>"> UTS</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="<?= base_url('/viewAllDampingUAS'); ?>"> UAS</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Laporan -->
                <li class="nav-item">
                    <a class="nav-link has-arrow  collapsed " href="#!" data-bs-toggle="collapse" data-bs-target="#laporan-pendampingan" aria-expanded="false" aria-controls="laporan-pendampingan">
                        <i class="fas fa-clipboard-check nav-icon icon-xs me-2"></i> Laporan
                    </a>

                    <div id="laporan-pendampingan" class="collapse " data-bs-parent="#sideNavbar">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link " href="<?= base_url('/viewAllLaporanUTS'); ?>"> UTS</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="<?= base_url('/viewAllLaporanUAS'); ?>"> UAS</a>
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

            <?php if (!in_groups('admin')) : ?>
                <!-- Judul Perizinan -->
                <li class="nav-item">
                    <div class="navbar-heading">Perizinan</div>
                </li>

                <!-- Pengajuan Perizinan Pendamping -->
                <?php if (in_groups('pendamping')) : ?>
                    <li class="nav-item">
                        <a class="nav-link has-arrow  collapsed " href="#!" data-bs-toggle="collapse" data-bs-target="#navComponents" aria-expanded="false" aria-controls="navComponents">
                            <i class="fas fa-file-medical nav-icon icon-xs me-2"></i> Pengajuan Izin
                        </a>
                        <div id="navComponents" class="collapse " data-bs-parent="#sideNavbar">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link " href="<?= base_url('/viewIzin/' . user()->username); ?>" aria-expanded="false">
                                        Izin Tidak Damping
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="<?= base_url('/viewCuti/' . user()->username); ?>" aria-expanded="false">
                                        Izin Cuti
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link " href="<?= base_url('/konfirmasi_pengganti/' . user()->username); ?>">
                            <i class="nav-icon icon-xs me-2 bi bi-check2-square">
                            </i>
                            Konfirmasi Pengganti
                        </a>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link " href="<?= base_url('/viewCuti/' . user()->username); ?>" aria-expanded="false">
                            <i class="nav-icon icon-xs me-2 fas fa-envelope"></i>
                            Izin Cuti
                        </a>
                    </li>
                <?php endif; ?>

            <?php else : ?>
                <!-- Judul Konfirmasi -->
                <li class="nav-item">
                    <div class="navbar-heading">Verifikasi</div>
                </li>

                <!-- Konfirmasi Perizinan -->
                <li class="nav-item">
                    <a class="nav-link has-arrow  collapsed " href="#!" data-bs-toggle="collapse" data-bs-target="#konfirmasi_izin_admin" aria-expanded="false" aria-controls="konfirmasi_izin_admin">
                        <i class="fas fa-calendar-week nav-icon icon-xs me-2"></i> Perizinan
                    </a>

                    <div id="konfirmasi_izin_admin" class="collapse " data-bs-parent="#sideNavbar">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link " href="<?= base_url('/viewAllCuti'); ?>"> Izin Cuti</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="<?= base_url('/viewAllIzin'); ?>">
                                    Izin Tidak Damping
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link " href="<?= base_url('/viewAllSkill'); ?>">
                        <i class="fas fa-clipboard-check nav-icon icon-xs me-2"></i>
                        Skill Pendamping
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="<?= base_url('/viewAllJenisMadif'); ?>">
                        <i class="fas fa-clipboard-check nav-icon icon-xs me-2"></i>
                        Jenis Difabel Madif
                    </a>
                </li>
            <?php endif; ?>

            <!-- Judul Setting -->
            <li class="nav-item">
                <div class="navbar-heading">Setting</div>
            </li>

            <?php if (in_groups('admin')) : ?>
                <!-- User Management Setting -->
                <li class="nav-item">
                    <a class="nav-link has-arrow  collapsed " href="#!" data-bs-toggle="collapse" data-bs-target="#user_management" aria-expanded="false" aria-controls="user_management">
                        <i class="fas fa-user-cog nav-icon icon-xs me-2"></i> User Management
                    </a>

                    <div id="user_management" class="collapse " data-bs-parent="#sideNavbar">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link " href="<?= base_url('/viewUserAdmin'); ?>"> Admin </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="<?= base_url('/viewUserMadif'); ?>">
                                    Mahasiswa Difabel
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="<?= base_url('/viewUserPendamping'); ?>">
                                    Pendamping
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
            <?php endif; ?>
            <!-- Nav item -->
            <li class="nav-item">
                <a class="nav-link has-arrow " href="<?= base_url('logout'); ?>">
                    <i class="nav-icon icon-xs me-2 fas fa-sign-out-alt"></i>Logout
                </a>
            </li>

        </ul>
    </div>
</nav>