<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800 fw-bold"><?= esc($title) ?></h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-edit me-1"></i> Input Data Absensi Karyawan
            </h6>
        </div>
        <div class="card-body">
            <p class="card-text text-muted mb-4">Gunakan form ini untuk mencatat karyawan yang tidak masuk karena Sakit atau Izin. Jika data sudah ada di tanggal yang sama, statusnya akan diperbarui.</p>

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

            <form action="/admin/manajemen-absensi/save" method="post">
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="karyawan_id" class="form-label">Pilih Karyawan</label>
                        <select name="karyawan_id" id="karyawan_id" class="form-select" required>
                            <option value="">-- Pilih Karyawan --</option>
                            <?php foreach($karyawan_list as $k): ?>
                                <option value="<?= $k['id'] ?>" <?= old('karyawan_id') == $k['id'] ? 'selected' : '' ?>>
                                    <?= esc($k['nama_lengkap']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="tgl_absen" class="form-label">Tanggal Tidak Masuk</label>
                        <input type="date" name="tgl_absen" id="tgl_absen" class="form-control" value="<?= old('tgl_absen', date('Y-m-d')) ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="Sakit" <?= old('status') == 'Sakit' ? 'selected' : '' ?>>Sakit</option>
                            <option value="Izin" <?= old('status') == 'Izin' ? 'selected' : '' ?>>Izin</option>
                        </select>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Simpan Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>