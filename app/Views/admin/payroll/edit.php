<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800 fw-bold"><?= esc($title) ?></h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-money-check-alt me-1"></i> Edit Gaji untuk <?= esc($slip['nama_lengkap']) ?>
            </h6>
            <p class="mb-0 text-gray-700">Periode: <?= date('F Y', mktime(0,0,0,$slip['bulan'], 1, $slip['tahun'])) ?></p>
        </div>
        <div class="card-body">
            <?php if(session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h4 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>Terjadi Kesalahan!</h4>
                    <ul class="mb-0">
                        <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="/admin/payroll/update/<?= esc($slip['id']) ?>" method="post">
                <?= csrf_field() ?>
                
                <div class="mb-3">
                    <label for="gaji_pokok" class="form-label">Gaji Pokok</label>
                    <input type="number" class="form-control" name="gaji_pokok" id="gaji_pokok" value="<?= old('gaji_pokok', $slip['gaji_pokok']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="tunjangan" class="form-label">Tunjangan (Bonus, dll)</label>
                    <input type="number" class="form-control" name="tunjangan" id="tunjangan" value="<?= old('tunjangan', $slip['tunjangan']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="potongan" class="form-label">Total Potongan Tambahan</label>
                    <input type="number" class="form-control" name="potongan" id="potongan" value="<?= old('potongan', $slip['potongan']) ?>" required>
                    <small class="form-text text-muted">Potongan ini adalah tambahan di luar potongan 'Alpha' yang sudah dihitung otomatis.</small>
                </div>
                
                <div class="d-flex justify-content-end mt-4">
                    <a href="/admin/payroll/laporan" class="btn btn-secondary me-2">
                        <i class="fas fa-times me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>