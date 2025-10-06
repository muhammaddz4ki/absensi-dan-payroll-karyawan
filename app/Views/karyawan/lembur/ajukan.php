<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('content') ?>
<h1 class="h3 mb-4"><?= esc($title) ?></h1>

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Formulir Pengajuan Lembur</span>
        <span class="badge bg-info fs-6">Upah Lembur: Rp <?= number_format($upah_per_jam, 0, ',', '.') ?> / Jam</span>
    </div>
    <div class="card-body">
        <?php if(session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="/lembur/save" method="post">
            <?= csrf_field() ?>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="tanggal_lembur" class="form-label">Tanggal Lembur</label>
                    <input type="date" class="form-control" name="tanggal_lembur" id="tanggal_lembur" value="<?= old('tanggal_lembur', date('Y-m-d')) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="jumlah_jam" class="form-label">Jumlah Jam Lembur</label>
                    <input type="number" class="form-control" name="jumlah_jam" id="jumlah_jam" value="<?= old('jumlah_jam') ?>" min="1" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan/Tugas Lembur</label>
                <textarea name="keterangan" id="keterangan" rows="4" class="form-control" required><?= old('keterangan') ?></textarea>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
                <a href="/lembur" class="btn btn-light">Batal</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
