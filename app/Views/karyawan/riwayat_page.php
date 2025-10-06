<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= esc($title) ?></h1>
    <a href="/cuti/ajukan" class="btn btn-sm btn-primary"><i data-feather="plus" class="me-2"></i>Ajukan Cuti Baru</a>
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
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                        <th>Foto Masuk</th>
                        <th>Jam Pulang</th>
                        <th>Foto Pulang</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($riwayat)): ?>
                        <?php foreach ($riwayat as $item): ?>
                            <tr>
                                <td><?= date('d M Y', strtotime($item['tgl_absen'])) ?></td>
                                
                                <?php if ($item['status'] === 'Hadir'): ?>
                                    <td><?= esc($item['jam_masuk']) ?></td>
                                    <td class="text-center">
                                        <a href="/storage/absensi/<?= $item['foto_masuk'] ?>" target="_blank"><i data-feather="camera"></i></a>
                                    </td>
                                    <td><?= esc($item['jam_pulang'] ?? 'Belum absen pulang') ?></td>
                                    <td class="text-center">
                                        <?php if($item['foto_pulang']): ?>
                                            <a href="/storage/absensi/<?= $item['foto_pulang'] ?>" target="_blank"><i data-feather="camera"></i></a>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                <?php else: ?>
                                    <!-- Jika status bukan 'Hadir' (Sakit, Izin, Cuti) -->
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                <?php endif; ?>

                                <td>
                                    <?php
                                        $status_class = 'bg-secondary'; // Default
                                        if ($item['status'] == 'Hadir') $status_class = 'bg-success';
                                        if ($item['status'] == 'Sakit') $status_class = 'bg-warning text-dark';
                                        if ($item['status'] == 'Izin') $status_class = 'bg-info text-dark';
                                        if ($item['status'] == 'Cuti') $status_class = 'bg-primary';
                                    ?>
                                    <span class="badge <?= $status_class ?>"><?= esc($item['status']) ?></span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4">Anda belum memiliki riwayat absensi.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
