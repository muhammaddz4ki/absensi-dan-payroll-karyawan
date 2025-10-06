<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= esc($title) ?></h1>
    <a href="/admin/jabatan/new" class="btn btn-sm btn-primary"><i data-feather="plus" class="me-2"></i>Tambah Jabatan</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nama Jabatan</th>
                        <th>Gaji Pokok</th>
                        <th>Tunjangan Jabatan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($jabatan)): ?>
                        <?php foreach ($jabatan as $item): ?>
                            <tr>
                                <td><?= esc($item['nama_jabatan']) ?></td>
                                <td>Rp <?= number_format($item['gaji_pokok'], 0, ',', '.') ?></td>
                                <td>Rp <?= number_format($item['tunjangan_jabatan'], 0, ',', '.') ?></td>
                                <td class="text-center">
                                    <a href="/admin/jabatan/edit/<?= esc($item['id']) ?>" class="btn btn-sm btn-outline-warning" title="Edit"><i data-feather="edit-2"></i></a>
                                    <form action="/admin/jabatan/<?= esc($item['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Anda yakin ingin menghapus data ini?')">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus"><i data-feather="trash-2"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-4">Belum ada data jabatan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>