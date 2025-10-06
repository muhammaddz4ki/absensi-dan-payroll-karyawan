<?= $this->extend('layouts/main_layout') ?>
<?= $this->section('content') ?>
<h1 class="h3 mb-4"><?= esc($title) ?></h1>
<div class="card shadow-sm" style="max-width: 600px;">
    <div class="card-header">Formulir Ganti Password</div>
    <div class="card-body">
        <?php if(session()->getFlashdata('success')): ?> <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div> <?php endif; ?>
        <?php if(session()->getFlashdata('error')): ?> <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div> <?php endif; ?>
        <?php if(session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger"><ul class="mb-0"><?php foreach (session()->getFlashdata('errors') as $error) : ?><li><?= esc($error) ?></li><?php endforeach; ?></ul></div>
        <?php endif; ?>
        <form action="/profil/update-password" method="post">
            <?= csrf_field() ?>
            <div class="mb-3"><label for="password_lama" class="form-label">Password Lama</label><input type="password" class="form-control" name="password_lama" required></div>
            <div class="mb-3"><label for="password_baru" class="form-label">Password Baru</label><input type="password" class="form-control" name="password_baru" required></div>
            <div class="mb-3"><label for="konfirmasi_password" class="form-label">Konfirmasi Password Baru</label><input type="password" class="form-control" name="konfirmasi_password" required></div>
            <button type="submit" class="btn btn-primary">Simpan Password</button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>