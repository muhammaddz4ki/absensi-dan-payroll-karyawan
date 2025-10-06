<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= esc($title) ?></h1>
    <a href="/lembur/ajukan" class="btn btn-primary"><i data-feather="plus" class="me-2"></i>Ajukan Lembur Baru</a>
</div>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Tanggal Lembur</th>
                        <th>Jumlah Jam</th>
                        <th>Total Upah</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($riwayat_lembur)): ?>
                        <?php foreach ($riwayat_lembur as $lembur): ?>
                            <tr>
                                <td><?= date('d M Y', strtotime($lembur['tanggal_lembur'])) ?></td>
                                <td><?= esc($lembur['jumlah_jam']) ?> Jam</td>
                                <td>Rp <?= number_format($lembur['total_upah_lembur'], 0, ',', '.') ?></td>
                                <td><?= esc($lembur['keterangan']) ?></td>
                                <td>
                                    <?php
                                        $status_class = 'bg-secondary'; // Pending
                                        if ($lembur['status'] == 'Approved') $status_class = 'bg-success';
                                        if ($lembur['status'] == 'Rejected') $status_class = 'bg-danger';
                                    ?>
                                    <span class="badge <?= $status_class ?>"><?= esc($lembur['status']) ?></span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-4">Belum ada riwayat pengajuan lembur.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
