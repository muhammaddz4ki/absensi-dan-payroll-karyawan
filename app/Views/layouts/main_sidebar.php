<aside class="sidebar">
    <div class="sidebar-header">
        <a href="<?= session()->get('role') === 'admin' ? '/admin/dashboard' : '/dashboard' ?>">
            <img src="/images/logo.png" alt="Logo" class="sidebar-logo">
            <span class="sidebar-brand"></span>
        </a>
    </div>

    <nav class="sidebar-nav">
        <ul class="list-unstyled">
            <?php if (session()->get('role') === 'admin'): ?>
                <li class="sidebar-item">
                    <a href="/admin/dashboard" class="sidebar-link <?= service('uri')->getSegment(2) == 'dashboard' ? 'active' : '' ?>">
                        <i class="fas fa-fw fa-tachometer-alt"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="/admin/karyawan" class="sidebar-link <?= service('uri')->getSegment(2) == 'karyawan' ? 'active' : '' ?>">
                        <i class="fas fa-fw fa-users"></i> <span>Karyawan</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="/admin/jabatan" class="sidebar-link <?= service('uri')->getSegment(2) == 'jabatan' ? 'active' : '' ?>">
                        <i class="fas fa-fw fa-briefcase"></i> <span>Jabatan</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="/admin/riwayat" class="sidebar-link <?= service('uri')->getSegment(2) == 'riwayat' ? 'active' : '' ?>">
                        <i class="fas fa-fw fa-history"></i> <span>Riwayat Absensi</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="/admin/manajemen-absensi" class="sidebar-link <?= service('uri')->getSegment(2) == 'manajemen-absensi' ? 'active' : '' ?>">
                        <i class="fas fa-fw fa-tasks"></i> <span>Manajemen Absensi</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="/admin/cuti" class="sidebar-link <?= service('uri')->getSegment(1) == 'cuti' ? 'active' : '' ?>">
                        <i class="fas fa-fw fa-mug-hot"></i> <span>Cuti</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="/admin/lembur" class="sidebar-link <?= service('uri')->getSegment(2) == 'lembur' ? 'active' : '' ?>">
                        <i class="fas fa-fw fa-clock"></i> <span>Manajemen Lembur</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="/admin/payroll" class="sidebar-link <?= service('uri')->getSegment(2) == 'payroll' && service('uri')->getSegment(3) === null ? 'active' : '' ?>">
                        <i class="fas fa-fw fa-calculator"></i> <span>Generate Payroll</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="/admin/payroll/laporan" class="sidebar-link <?= service('uri')->getSegment(2) == 'payroll' && service('uri')->getSegment(3) == 'laporan' ? 'active' : '' ?>">
                        <i class="fas fa-fw fa-file-invoice-dollar"></i> <span>Laporan Payroll</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="/admin/pengaturan" class="sidebar-link <?= service('uri')->getSegment(2) == 'pengaturan' ? 'active' : '' ?>">
                        <i class="fas fa-fw fa-cogs"></i> <span>Pengaturan</span>
                    </a>
                </li>
            <?php else: ?>
                <li class="sidebar-item">
                    <a href="/dashboard" class="sidebar-link <?= service('uri')->getSegment(1) == 'dashboard' && service('uri')->getSegment(2) === null ? 'active' : '' ?>">
                        <i class="fas fa-fw fa-home"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="/absensi" class="sidebar-link <?= service('uri')->getSegment(1) == 'absensi' ? 'active' : '' ?>">
                        <i class="fas fa-fw fa-camera"></i> <span>Halaman Absensi</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="/riwayat" class="sidebar-link <?= service('uri')->getSegment(1) == 'riwayat' ? 'active' : '' ?>">
                        <i class="fas fa-fw fa-history"></i> <span>Riwayat Absensi</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="/cuti" class="sidebar-link <?= service('uri')->getSegment(1) == 'cuti' ? 'active' : '' ?>">
                        <i class="fas fa-fw fa-mug-hot"></i> <span>Cuti</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="/lembur" class="sidebar-link <?= service('uri')->getSegment(1) == 'lembur' ? 'active' : '' ?>">
                        <i class="fas fa-fw fa-clock"></i> <span>Lembur</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="/pengajuan" class="sidebar-link <?= service('uri')->getSegment(1) == 'pengajuan' ? 'active' : '' ?>">
                        <i class="fas fa-fw fa-file-alt"></i> <span>Pengajuan Sakit/Izin</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="/slip-gaji" class="sidebar-link <?= service('uri')->getSegment(1) == 'slip-gaji' ? 'active' : '' ?>">
                        <i class="fas fa-fw fa-receipt"></i> <span>Slip Gaji</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="/profil" class="sidebar-link <?= service('uri')->getSegment(1) == 'profil' ? 'active' : '' ?>">
                        <i class="fas fa-fw fa-user"></i> <span>Profil Saya</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>

    <div class="sidebar-footer">
        <a href="/logout" class="sidebar-link logout-link">
            <i class="fas fa-fw fa-sign-out-alt"></i> <span>Logout</span>
        </a>
        <div class="user-info">
            <small>Login sebagai:</small>
            <span><?= esc(session()->get('nama_lengkap') ?? session()->get('username')) ?></span>
        </div>
    </div>
</aside>
