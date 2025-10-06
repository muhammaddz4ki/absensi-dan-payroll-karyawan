<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 fw-bold"><?= esc($title) ?></h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-file-invoice-dollar me-1"></i> Daftar Slip Gaji Anda
            </h6>
        </div>
        <div class="card-body">
            <div class="list-group">
                <?php if (!empty($slip_gaji)): ?>
                    <?php foreach ($slip_gaji as $slip): ?>
                        <a href="/slip-gaji/detail/<?= esc($slip['id']) ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3">
                            <div class="d-flex flex-column">
                                <h5 class="mb-1 text-gray-800">
                                    <i class="fas fa-calendar-alt me-2 text-muted"></i>
                                    Slip Gaji Bulan <?= date('F Y', mktime(0,0,0,$slip['bulan'], 1, $slip['tahun'])) ?>
                                </h5>
                                <small class="text-muted">Klik untuk melihat detail.</small>
                            </div>
                            <div>
                                <span class="fw-bold text-success">Rp <?= number_format($slip['gaji_bersih'], 2, ',', '.') ?></span>
                                <i class="fas fa-chevron-right ms-2 text-gray-400"></i>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="alert alert-info text-center py-4 my-3">
                        <i class="fas fa-info-circle fa-2x mb-3"></i>
                        <p class="mb-0">Belum ada data slip gaji yang tersedia untuk Anda.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<?= $this->endSection() ?>