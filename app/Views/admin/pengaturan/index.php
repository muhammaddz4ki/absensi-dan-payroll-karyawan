<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800 fw-bold"><?= esc($title) ?></h1>
    </div>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i><?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-cogs me-1"></i> Konfigurasi Aplikasi
            </h6>
        </div>
        <div class="card-body">
            <form action="/admin/pengaturan/update" method="post">
                <?= csrf_field() ?>
                
                <h5 class="mb-3 text-primary">Lokasi Kantor</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="lokasi_kantor_lat" class="form-label">Latitude</label>
                        <input type="text" class="form-control" id="lokasi_kantor_lat" name="lokasi_kantor_lat" value="<?= esc($settings['lokasi_kantor_lat'] ?? '') ?>" placeholder="-7.7956">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="lokasi_kantor_lon" class="form-label">Longitude</label>
                        <input type="text" class="form-control" id="lokasi_kantor_lon" name="lokasi_kantor_lon" value="<?= esc($settings['lokasi_kantor_lon'] ?? '') ?>" placeholder="110.3695">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="radius_absensi" class="form-label">Radius Toleransi Absensi (meter)</label>
                    <input type="number" class="form-control" id="radius_absensi" name="radius_absensi" value="<?= esc($settings['radius_absensi'] ?? '') ?>" placeholder="50">
                    <small class="form-text text-muted">Jarak maksimal karyawan bisa absen dari lokasi kantor.</small>
                </div>

                <hr class="my-4">
                
                <h5 class="mb-3 text-primary">Jam Kerja</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="jam_masuk_mulai" class="form-label">Jam Masuk (Mulai)</label>
                        <input type="time" step="1" class="form-control" id="jam_masuk_mulai" name="jam_masuk_mulai" value="<?= esc($settings['jam_masuk_mulai'] ?? '') ?>">
                        <small class="form-text text-muted">Awal rentang waktu untuk jam masuk.</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="jam_masuk_selesai" class="form-label">Jam Masuk (Selesai)</label>
                        <input type="time" step="1" class="form-control" id="jam_masuk_selesai" name="jam_masuk_selesai" value="<?= esc($settings['jam_masuk_selesai'] ?? '') ?>">
                        <small class="form-text text-muted">Akhir rentang waktu untuk jam masuk.</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="jam_pulang_mulai" class="form-label">Jam Pulang (Mulai)</label>
                        <input type="time" step="1" class="form-control" id="jam_pulang_mulai" name="jam_pulang_mulai" value="<?= esc($settings['jam_pulang_mulai'] ?? '') ?>">
                        <small class="form-text text-muted">Waktu awal yang diizinkan untuk jam pulang.</small>
                    </div>
                </div>

                <hr class="my-4">

                <h5 class="mb-3 text-primary">Pengaturan Gaji</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="potongan_alpha_per_hari" class="form-label">Potongan per Hari (Alpha)</label>
                        <input type="number" class="form-control" id="potongan_alpha_per_hari" name="potongan_alpha_per_hari" value="<?= esc($settings['potongan_alpha_per_hari'] ?? '50000') ?>" placeholder="50000">
                        <small class="form-text text-muted">Potongan gaji untuk absen alpha per hari (dalam rupiah).</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="upah_lembur_per_jam" class="form-label">Upah Lembur per Jam</label>
                        <input type="number" class="form-control" name="upah_lembur_per_jam" value="<?= esc($settings['upah_lembur_per_jam'] ?? '20000') ?>">
                        <small class="form-text text-muted">Upah lembur untuk setiap jam (dalam rupiah).</small>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
