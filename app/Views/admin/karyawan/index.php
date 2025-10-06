<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= esc($title) ?></h1>
    <a href="/admin/karyawan/new" class="btn btn-sm btn-primary"><i data-feather="plus" class="feather-icon me-2"></i>Tambah Karyawan</a>
</div>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Karyawan</th>
                        <th>Jabatan</th>
                        <th>No. Telepon</th>
                        <th class="text-center">Jatah Cuti</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($karyawan)): ?>
                        <?php foreach ($karyawan as $item): ?>
                            <tr>
                                <td>
                                    <div><?= esc($item['nama_lengkap']) ?></div>
                                    <small class="text-muted">NIK: <?= esc($item['nik']) ?></small>
                                </td>
                                <td><?= esc($item['nama_jabatan']) ?></td>
                                <td><?= esc($item['no_telepon']) ?></td>
                                <td class="text-center fw-bold"><?= esc($item['jatah_cuti'] ?? 0) ?></td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <!-- Tombol Atur Cuti -->
                                        <button type="button" class="btn btn-sm btn-outline-info"
                                            data-bs-toggle="modal" data-bs-target="#editCutiModal-<?= $item['id'] ?>"
                                            title="Atur Jatah Cuti">
                                            <i data-feather="calendar" class="feather-icon"></i>
                                        </button>

                                        <!-- Tombol Edit -->
                                        <a href="/admin/karyawan/edit/<?= esc($item['id']) ?>"
                                            class="btn btn-sm btn-outline-warning" title="Edit Karyawan">
                                            <i data-feather="edit-2" class="feather-icon"></i>
                                        </a>

                                        <!-- Tombol Hapus -->
                                        <form action="/admin/karyawan/<?= esc($item['id']) ?>" method="post" class="d-inline"
                                            onsubmit="return confirm('Menghapus karyawan juga akan menghapus data login mereka. Anda yakin?')">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Karyawan">
                                                <i data-feather="trash-2" class="feather-icon"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-4">Belum ada data karyawan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL UNTUK EDIT JATAH CUTI -->
<?php if (!empty($karyawan)): ?>
    <?php foreach ($karyawan as $item): ?>
    <div class="modal fade" id="editCutiModal-<?= $item['id'] ?>" tabindex="-1" aria-labelledby="editCutiModalLabel-<?= $item['id'] ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCutiModalLabel-<?= $item['id'] ?>">Atur Jatah Cuti: <?= esc($item['nama_lengkap']) ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/admin/karyawan/update-jatah-cuti/<?= $item['id'] ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="jatah_cuti" class="form-label">Jatah Cuti Tahunan</label>
                            <input type="number" class="form-control" name="jatah_cuti" id="jatah_cuti" value="<?= esc($item['jatah_cuti'] ?? 0) ?>" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
<?php endif; ?>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<!-- Pastikan Feather Icons di-load dan di-replace -->
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<script>
    // Jalankan feather.replace() setelah dokumen dimuat
    document.addEventListener('DOMContentLoaded', function() {
        feather.replace();
        
        // Jalankan lagi setelah modal dibuka (untuk ikon dalam modal)
        document.querySelectorAll('.modal').forEach(function(modal) {
            modal.addEventListener('shown.bs.modal', function() {
                feather.replace();
            });
        });
    });
</script>
<?= $this->endSection() ?>