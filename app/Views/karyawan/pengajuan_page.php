<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 fw-bold"><?= esc($title) ?></h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-file-alt me-1"></i> Formulir Pengajuan Sakit / Izin
            </h6>
        </div>
        <div class="card-body">
            <?php if(session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                    <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= esc(session()->getFlashdata('success')) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="/pengajuan/save" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label for="tgl_pengajuan" class="form-label">
                        <i class="fas fa-calendar-alt me-1"></i> Tanggal Tidak Masuk
                    </label>
                    <input type="date" name="tgl_pengajuan" id="tgl_pengajuan" class="form-control" value="<?= old('tgl_pengajuan', date('Y-m-d')) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">
                        <i class="fas fa-list-alt me-1"></i> Jenis Pengajuan
                    </label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="Sakit" <?= old('status') == 'Sakit' ? 'selected' : '' ?>>Sakit</option>
                        <option value="Izin" <?= old('status') == 'Izin' ? 'selected' : '' ?>>Izin</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="keterangan" class="form-label">
                        <i class="fas fa-comment-alt me-1"></i> Keterangan / Alasan
                    </label>
                    <textarea name="keterangan" id="keterangan" class="form-control" rows="3" required><?= old('keterangan') ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="dokumen" class="form-label">
                        <i class="fas fa-paperclip me-1"></i> Dokumen Pendukung (Opsional)
                    </label>
                    <input class="form-control" type="file" id="dokumen" name="dokumen" accept=".pdf,.jpg,.jpeg,.png">
                    <small class="form-text text-muted">Contoh: Surat Dokter. Tipe file: PDF, JPG, PNG. Maks: 2MB.</small>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane me-2"></i> Kirim Pengajuan
                </button>
            </form>
        </div>
    </div>

    <?php /*
    <div class="card shadow mt-4 mb-4">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-history me-1"></i> Riwayat Pengajuan Anda
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Jenis</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th>Dokumen</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($riwayat_pengajuan)): ?>
                            <?php foreach ($riwayat_pengajuan as $r): ?>
                            <tr>
                                <td><?= date('d M Y', strtotime($r['tgl_pengajuan'])) ?></td>
                                <td>
                                    <?php 
                                        $badge_class = 'bg-secondary';
                                        if ($r['status'] == 'Sakit') $badge_class = 'bg-warning text-dark';
                                        if ($r['status'] == 'Izin') $badge_class = 'bg-info text-dark';
                                        if ($r['status'] == 'Diterima') $badge_class = 'bg-success';
                                        if ($r['status'] == 'Ditolak') $badge_class = 'bg-danger';
                                    ?>
                                    <span class="badge <?= $badge_class ?>"><?= esc($r['status']) ?></span>
                                </td>
                                <td><?= esc($r['keterangan']) ?></td>
                                <td>
                                    <?php 
                                        $badge_approval = 'bg-secondary';
                                        if ($r['status_approval'] == 'Menunggu') $badge_approval = 'bg-warning text-dark';
                                        if ($r['status_approval'] == 'Disetujui') $badge_approval = 'bg-success';
                                        if ($r['status_approval'] == 'Ditolak') $badge_approval = 'bg-danger';
                                    ?>
                                    <span class="badge <?= $badge_approval ?>"><?= esc($r['status_approval']) ?></span>
                                </td>
                                <td class="text-center">
                                    <?php if(!empty($r['dokumen'])): ?>
                                        <a href="/storage/dokumen_pengajuan/<?= esc($r['dokumen']) ?>" target="_blank" class="btn btn-sm btn-outline-success">
                                            <i class="fas fa-file-alt"></i>
                                        </a>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($r['status_approval'] == 'Menunggu'): ?>
                                        <a href="/pengajuan/edit/<?= esc($r['id']) ?>" class="btn btn-sm btn-info text-white me-1" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="/pengajuan/batal/<?= esc($r['id']) ?>" class="btn btn-sm btn-warning" title="Batalkan" onclick="return confirm('Apakah Anda yakin ingin membatalkan pengajuan ini?');">
                                            <i class="fas fa-ban"></i>
                                        </a>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-inbox fa-2x mb-2"></i>
                                        <p>Belum ada riwayat pengajuan.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    */ ?>

</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<?= $this->endSection() ?>