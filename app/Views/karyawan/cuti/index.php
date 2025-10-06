<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= esc($title) ?></h1>
    <a href="/cuti/ajukan" class="btn btn-primary"><i data-feather="plus" class="me-2"></i>Ajukan Cuti Baru</a>
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
                        <th>Tanggal Pengajuan</th>
                        <th>Tanggal Cuti</th>
                        <th>Jumlah Hari</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($riwayat_cuti)): ?>
                        <?php foreach ($riwayat_cuti as $cuti): ?>
                            <tr>
                                <td><?= date('d M Y', strtotime($cuti['created_at'])) ?></td>
                                <td><?= date('d M Y', strtotime($cuti['tanggal_mulai'])) ?> s/d <?= date('d M Y', strtotime($cuti['tanggal_selesai'])) ?></td>
                                <td><?= esc($cuti['jumlah_hari']) ?> hari</td>
                                <td><?= esc($cuti['keterangan']) ?></td>
                                <td>
                                    <?php
                                        $status_class = 'bg-secondary'; // Pending
                                        if ($cuti['status'] == 'Approved') $status_class = 'bg-success';
                                        if ($cuti['status'] == 'Rejected') $status_class = 'bg-danger';
                                    ?>
                                    <span class="badge <?= $status_class ?>"><?= esc($cuti['status']) ?></span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-4">Belum ada riwayat pengajuan cuti.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
