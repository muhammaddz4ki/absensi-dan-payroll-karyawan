<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-end align-items-center mb-3">
    <a href="/slip_gaji" class="btn btn-secondary me-2">Kembali</a>
    <button onclick="window.print()" class="btn btn-outline-primary"><i data-feather="printer" class="me-2"></i> Cetak</button>
</div>

<div class="card shadow-sm">
    <div class="card-body p-4">

        <table class="table table-borderless">
            <tbody>
                <tr>
                    <td style="width: 50%; border: none; vertical-align: bottom;">
                        <img src="/images/logo.png" alt="Company Logo" style="width: 120px; height: auto;">
                    </td>
                    <td style="width: 50%; border: none; vertical-align: bottom;">
                        <h2 class="text-end fw-bolder m-0">Slip Gaji</h2>
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="table table-borderless mb-4">
            <tbody>
                <tr>
                    <td style="width: 50%; vertical-align: top; border: none; padding-top: 0;">
                        <p class="mb-0" style="line-height: 1.6;">
                            <strong>PT. ANTARA PERSADA SUKSES</strong><br>
                            Gedung VIatama 2nd Floor<br>
                            Jl. Manunggal Pratama No. 8, Komplek Kodam<br>
                            Jakarta Timur
                        </p>
                    </td>

                    <td style="width: 50%; vertical-align: top; border: none; padding-top: 0;">
                        <p class="mb-0" style="line-height: 1.6;">
                            <span class="fw-bold" style="display: inline-block; width: 100px;">Nama</span> : <?= esc($slip['nama_lengkap']) ?><br>
                            <span class="fw-bold" style="display: inline-block; width: 100px;">NIK</span> : <?= esc($slip['nik']) ?><br>
                            <span class="fw-bold" style="display: inline-block; width: 100px;">Jabatan</span> : <?= esc($slip['nama_jabatan']) ?><br>
                            <span class="fw-bold" style="display: inline-block; width: 100px;">Periode Gaji</span> : <?= date('F Y', mktime(0, 0, 0, $slip['bulan'], 1, $slip['tahun'])) ?>
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <hr>

        <div class="row">
            <div class="col-md-6">
                <h5>Penerimaan</h5>
                <table class="table table-sm table-borderless">
                    <tr>
                        <td>Gaji Pokok</td>
                        <td class="text-end">Rp <?= number_format($slip['gaji_pokok'] ?? 0, 0, ',', '.') ?></td>
                    </tr>
                    <tr>
                        <td>Upah Lembur (<?= number_format($slip['total_jam_lembur'] ?? 0, 2, ',', '.') ?> Jam)</td>
                        <td class="text-end">Rp <?= number_format($slip['total_upah_lembur'] ?? 0, 0, ',', '.') ?></td>
                    </tr>
                    <tr>
                        <td>Tunjangan Jabatan</td>
                        <td class="text-end">Rp <?= number_format($slip['tunjangan'] ?? 0, 0, ',', '.') ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <h5>Potongan</h5>
                <table class="table table-sm table-borderless">
                    <tr>
                        <td>Potongan (Alpha: <?= $slip['total_alpha'] ?? 0 ?> hari)</td>
                        <td class="text-end">Rp <?= number_format($slip['potongan'] ?? 0, 0, ',', '.') ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <hr>

        <div class="row mt-3 bg-light p-3 rounded">
            <div class="col text-end">
                <h5 class="m-0">Gaji Bersih (Take Home Pay)</h5>
                <h3 class="m-0 font-weight-bold">Rp <?= number_format($slip['gaji_bersih'] ?? 0, 0, ',', '.') ?></h3>
            </div>
        </div>
        
        <div class="row mt-5">
            <div class="col-md-6">
                <p><strong>Rekap Kehadiran Bulan Ini:</strong></p>
                <ul class="list-unstyled">
                    <li>Hadir: <?= $slip['total_hadir'] ?? 0 ?> hari</li>
                    <li>Sakit: <?= $slip['total_sakit'] ?? 0 ?> hari</li>
                    <li>Izin: <?= $slip['total_izin'] ?? 0 ?> hari</li>
                    <li>Alpha: <?= $slip['total_alpha'] ?? 0 ?> hari</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<style>

    @media print {
        nav, header, .navbar, .d-flex, .mt-5 {
            display: none !important;
        }
        .card-body {
            margin-top: 0 !important;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
        body {
            background-color: white !important;
        }
    }
</style>
<?= $this->endSection() ?>