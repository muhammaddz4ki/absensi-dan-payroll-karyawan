<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('content') ?>
<h1 class="h3 mb-4"><?= esc($title) ?></h1>

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Formulir Pengajuan Cuti</span>
        <span class="badge bg-primary fs-6">Sisa Jatah Cuti Anda: <?= $jatah_cuti ?> Hari</span>
    </div>
    <div class="card-body">
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
        <?php if(session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="/cuti/save" method="post">
            <?= csrf_field() ?>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai Cuti</label>
                    <input type="date" class="form-control" name="tanggal_mulai" id="tanggal_mulai" value="<?= old('tanggal_mulai') ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="tanggal_selesai" class="form-label">Tanggal Selesai Cuti</label>
                    <input type="date" class="form-control" name="tanggal_selesai" id="tanggal_selesai" value="<?= old('tanggal_selesai') ?>" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan/Alasan Cuti</label>
                <textarea name="keterangan" id="keterangan" rows="4" class="form-control" required><?= old('keterangan') ?></textarea>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
                <a href="/cuti" class="btn btn-light">Batal</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
