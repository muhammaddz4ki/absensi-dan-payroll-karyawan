<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 fw-bold"><?= esc($title) ?></h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-filter me-1"></i> Filter Laporan
            </h6>
        </div>
        <div class="card-body">
            <form action="/admin/riwayat" method="get">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="karyawan_id" class="form-label">Pilih Karyawan</label>
                        <select name="karyawan_id" id="karyawan_id" class="form-select">
                            <option value="">Semua Karyawan</option>
                            <?php foreach($karyawan_list as $k): ?>
                                <option value="<?= esc($k['id']) ?>" <?= (isset($filters['karyawan_id']) && $filters['karyawan_id'] == $k['id']) ? 'selected' : '' ?>>
                                    <?= esc($k['nama_lengkap']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="start_date" class="form-label">Dari Tanggal</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" value="<?= esc($filters['start_date'] ?? '') ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="end_date" class="form-label">Sampai Tanggal</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" value="<?= esc($filters['end_date'] ?? '') ?>">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-1"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-history me-1"></i> Riwayat Absensi
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>NIK</th>
                            <th>Nama Karyawan</th>
                            <th>Jam Masuk</th>
                            <th class="text-center">Foto Masuk</th>
                            <th>Jam Pulang</th>
                            <th class="text-center">Foto Pulang</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                            <th class="text-center">Dokumen</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($riwayat)): ?>
                            <?php foreach ($riwayat as $item): ?>
                                <tr>
                                    <td><?= date('d M Y', strtotime($item['tgl_absen'])) ?></td>
                                    <td><?= esc($item['nik']) ?></td>
                                    <td><?= esc($item['nama_lengkap']) ?></td>
                                    <td><?= esc($item['jam_masuk'] ?? '-') ?></td>
                                    <td class="text-center">
                                        <?php if(!empty($item['foto_masuk'])): ?>
                                            <a href="/storage/absensi/<?= esc($item['foto_masuk']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc($item['jam_pulang'] ?? '-') ?></td>
                                    <td class="text-center">
                                        <?php if(!empty($item['foto_pulang'])): ?>
                                            <a href="/storage/absensi/<?= esc($item['foto_pulang']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php
                                            $status_class = 'bg-secondary'; // Default if status is unknown/null
                                            if ($item['status'] == 'Hadir') $status_class = 'bg-success';
                                            if ($item['status'] == 'Sakit') $status_class = 'bg-warning text-dark';
                                            if ($item['status'] == 'Izin') $status_class = 'bg-info text-dark';
                                            if ($item['status'] == 'Cuti') $status_class = 'bg-primary'; // Status Cuti
                                            if ($item['status'] == 'Tidak Hadir') $status_class = 'bg-danger'; // Jika ada status tidak hadir
                                        ?>
                                        <span class="badge <?= $status_class ?>"><?= esc($item['status']) ?></span>
                                    </td>
                                    <td><?= esc($item['keterangan'] ?? '-') ?></td>
                                    <td class="text-center">
                                        <?php if(!empty($item['dokumen'])): ?>
                                            <a href="/storage/dokumen/<?= esc($item['dokumen']) ?>" target="_blank" class="btn btn-sm btn-outline-success">
                                                <i class="fas fa-file-alt"></i>
                                            </a>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="10" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-inbox fa-2x mb-2"></i>
                                        <p>Tidak ada data untuk ditampilkan</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <?php if (isset($pager) && !empty($riwayat)): ?>
                <div class="d-flex justify-content-end mt-3">
                    <?= $pager->links('default', 'bootstrap_full') ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<?php /*
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/2.0.8/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('.table').DataTable({
            // Konfigurasi DataTables Anda di sini
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true, // DataTables responsive feature
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json" // Bahasa Indonesia
            }
        });
    });
</script>
*/ ?>
<?= $this->endSection() ?>
