<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('content') ?>
<h1 class="h3 mb-4"><?= esc($title) ?></h1>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>
<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<!-- Tabel Pengajuan Pending -->
<div class="card shadow-sm mb-4">
    <div class="card-header">
        <h6 class="m-0 font-weight-bold text-primary">Menunggu Persetujuan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nama Karyawan</th>
                        <th>Tanggal Lembur</th>
                        <th>Jumlah Jam</th>
                        <th>Keterangan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pending_lembur)): ?>
                        <?php foreach ($pending_lembur as $lembur): ?>
                            <tr>
                                <td><?= esc($lembur['nama_lengkap']) ?></td>
                                <td><?= date('d M Y', strtotime($lembur['tanggal_lembur'])) ?></td>
                                <td><?= esc($lembur['jumlah_jam']) ?> Jam</td>
                                <td><?= esc($lembur['keterangan']) ?></td>
                                <td class="text-center">
                                    <form action="/admin/lembur/process/<?= $lembur['id'] ?>" method="post" class="d-inline">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="status" value="Approved">
                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Anda yakin ingin menyetujui pengajuan ini?')">Approve</button>
                                    </form>
                                    <form action="/admin/lembur/process/<?= $lembur['id'] ?>" method="post" class="d-inline">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="status" value="Rejected">
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin ingin menolak pengajuan ini?')">Reject</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-3">Tidak ada pengajuan lembur yang menunggu persetujuan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Tabel Riwayat Pengajuan yang Sudah Diproses -->
<div class="card shadow-sm">
    <div class="card-header">
        <h6 class="m-0 font-weight-bold text-primary">Riwayat Pengajuan Diproses</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nama Karyawan</th>
                        <th>Tanggal Lembur</th>
                        <th>Jumlah Jam</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($processed_lembur)): ?>
                        <?php foreach ($processed_lembur as $lembur): ?>
                            <tr>
                                <td><?= esc($lembur['nama_lengkap']) ?></td>
                                <td><?= date('d M Y', strtotime($lembur['tanggal_lembur'])) ?></td>
                                <td><?= esc($lembur['jumlah_jam']) ?> Jam</td>
                                <td>
                                    <?php
                                        $status_class = $lembur['status'] == 'Approved' ? 'bg-success' : 'bg-danger';
                                    ?>
                                    <span class="badge <?= $status_class ?>"><?= esc($lembur['status']) ?></span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-3">Belum ada riwayat pengajuan yang diproses.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>