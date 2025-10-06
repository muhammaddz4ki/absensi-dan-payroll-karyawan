<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('content') ?>
<h1 class="h3 mb-4"><?= esc($title) ?></h1>

<div class="card shadow-sm">
    <div class="card-header">Formulir Edit Jabatan</div>
    <div class="card-body">
        <form action="/admin/jabatan/<?= esc($jabatan['id']) ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">
            <div class="mb-3">
                <label for="nama_jabatan" class="form-label">Nama Jabatan</label>
                <input type="text" class="form-control" id="nama_jabatan" name="nama_jabatan" value="<?= old('nama_jabatan', $jabatan['nama_jabatan']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="gaji_pokok" class="form-label">Gaji Pokok</label>
                <input type="number" class="form-control" id="gaji_pokok" name="gaji_pokok" value="<?= old('gaji_pokok', $jabatan['gaji_pokok']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="tunjangan_jabatan" class="form-label">Tunjangan Jabatan</label>
                <input type="number" class="form-control" id="tunjangan_jabatan" name="tunjangan_jabatan" value="<?= old('tunjangan_jabatan', $jabatan['tunjangan_jabatan']) ?>" required>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="/admin/jabatan" class="btn btn-light">Batal</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>