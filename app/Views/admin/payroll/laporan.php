<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('content') ?>
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

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-filter me-1"></i> Pilih Periode Laporan
            </h6>
        </div>
        <div class="card-body">
            <form action="/admin/payroll/laporan" method="get">
                <div class="row align-items-end">
                    <div class="col-md-5 mb-3">
                        <label for="bulan" class="form-label">Bulan</label>
                        <select name="bulan" id="bulan" class="form-select" required>
                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                <option value="<?= $i ?>" <?= $bulan == $i ? 'selected' : '' ?>>
                                    <?= date('F', mktime(0, 0, 0, $i, 10)) ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-5 mb-3">
                        <label for="tahun" class="form-label">Tahun</label>
                        <input type="number" name="tahun" id="tahun" class="form-control" value="<?= esc($tahun) ?>" required>
                    </div>
                    <div class="col-md-2 mb-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-1"></i> Tampilkan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-table me-1"></i> Laporan Gaji Bulan <?= date('F', mktime(0, 0, 0, $bulan, 10)) ?> Tahun <?= esc($tahun) ?>
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead class="bg-light">
                        <tr>
                            <th>NIK</th>
                            <th>Nama Karyawan</th>
                            <th>Jabatan</th>
                            <th>Gaji Pokok</th>
                            <th>Potongan</th>
                            <th>Gaji Bersih</th>
                            <th class="text-center" width="120px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($laporan)): ?>
                            <?php foreach ($laporan as $item): ?>
                                <tr>
                                    <td><?= esc($item['nik']) ?></td>
                                    <td><?= esc($item['nama_lengkap']) ?></td>
                                    <td><?= esc($item['nama_jabatan']) ?></td>
                                    <td>Rp <?= number_format($item['gaji_pokok'], 0, ',', '.') ?></td>
                                    <td>Rp <?= number_format($item['potongan'], 0, ',', '.') ?></td>
                                    <td class="fw-bold">Rp <?= number_format($item['gaji_bersih'], 0, ',', '.') ?></td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <a href="/admin/payroll/detail/<?= esc($item['id']) ?>" class="btn btn-sm btn-info me-1" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="/admin/payroll/edit/<?= esc($item['id']) ?>" class="btn btn-sm btn-warning me-1" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="/admin/payroll/delete/<?= esc($item['id']) ?>" method="post" class="d-inline">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Anda yakin ingin menghapus data gaji ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-file-invoice fa-2x mb-2"></i>
                                        <p>Tidak ada data payroll untuk periode ini. Silakan generate terlebih dahulu.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>