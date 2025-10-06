<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Halaman Absensi</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-camera me-1"></i> Absensi Hari Ini: <?= date('d F Y') ?>
            </h6>
        </div>
        <div class="card-body text-center">
            <div id="my_camera" class="mx-auto border border-secondary rounded overflow-hidden" style="width: 320px; height: 240px; background: #ccc;"></div>
            <div id="results" class="mx-auto mt-3 border border-success rounded overflow-hidden" style="width: 320px; height: 240px; display:none; background: #eee;"></div>
            
            <div id="status" class="alert alert-secondary mt-3" role="alert" data-lat="" data-lon="">Mengecek lokasi Anda...</div>

            <?php if (!$absenHariIni): ?>
                <button class="btn btn-primary mt-3 btn-lg" id="btnAbsenMasuk" disabled>
                    <i class="fas fa-sign-in-alt me-2"></i> Absen Masuk
                </button>
            <?php elseif ($absenHariIni && is_null($absenHariIni['jam_pulang'])): ?>
                <div class="alert alert-success mt-3">
                    <i class="fas fa-check-circle me-2"></i> Anda sudah absen masuk pada jam: <strong><?= esc($absenHariIni['jam_masuk']) ?></strong>
                </div>
                <button class="btn btn-danger mt-3 btn-lg" id="btnAbsenPulang" disabled>
                    <i class="fas fa-sign-out-alt me-2"></i> Absen Pulang
                </button>
            <?php else: ?>
                <div class="alert alert-info mt-3">
                    <i class="fas fa-info-circle me-2"></i> Anda sudah melakukan absen masuk dan pulang hari ini.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Setup Webcam
        Webcam.set({
            width: 320,
            height: 240,
            image_format: 'jpeg',
            jpeg_quality: 90,
            flip_horiz: true // Selfie camera look
        });
        Webcam.attach('#my_camera');

        const statusEl = document.getElementById('status');
        const btnMasuk = document.getElementById('btnAbsenMasuk');
        const btnPulang = document.getElementById('btnAbsenPulang');
        const officeLat = <?= json_encode($settings['lokasi_kantor_lat'] ?? 0) ?>;
        const officeLon = <?= json_encode($settings['lokasi_kantor_lon'] ?? 0) ?>;
        const radius   = <?= json_encode($settings['radius_absensi'] ?? 0) ?>;

        // Pilih button utama (masuk/pulang) yang sedang aktif
        const mainButton = btnMasuk || btnPulang;

        // Fungsi hitung jarak
        function getDistance(lat1, lon1, lat2, lon2) {
            const R = 6371e3; // metres
            const φ1 = lat1 * Math.PI/180; const φ2 = lat2 * Math.PI/180;
            const Δφ = (lat2-lat1) * Math.PI/180; const Δλ = (lon2-lon1) * Math.PI/180;
            const a = Math.sin(Δφ/2) * Math.sin(Δφ/2) + Math.cos(φ1) * Math.cos(φ2) * Math.sin(Δλ/2) * Math.sin(Δλ/2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
            return R * c;
        }

        // Cek lokasi & enable tombol
        function checkLocationAndEnableButton() {
            if (!mainButton) {
                statusEl.className = 'alert alert-info mt-3';
                statusEl.innerHTML = '<i class="fas fa-info-circle me-2"></i> Absensi hari ini sudah selesai.';
                return;
            }
            statusEl.className = 'alert alert-secondary mt-3';
            statusEl.innerHTML = '<i class="fas fa-location-arrow me-2"></i> Mengecek lokasi Anda...';

            if (!navigator.geolocation) {
                statusEl.className = 'alert alert-danger mt-3';
                statusEl.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i> Browser Anda tidak mendukung Geolocation.';
                mainButton.disabled = true;
                return;
            }

            navigator.geolocation.getCurrentPosition(position => {
                const userLat = position.coords.latitude;
                const userLon = position.coords.longitude;
                const distance = getDistance(officeLat, officeLon, userLat, userLon);

                // Simpan lokasi di data attribute
                statusEl.dataset.lat = userLat;
                statusEl.dataset.lon = userLon;

                if (distance <= radius) {
                    statusEl.className = 'alert alert-success mt-3';
                    statusEl.innerHTML = `<i class="fas fa-check-circle me-2"></i> Anda berada dalam jangkauan (${distance.toFixed(0)} meter). Silakan absen.`;
                    mainButton.disabled = false;
                } else {
                    statusEl.className = 'alert alert-danger mt-3';
                    statusEl.innerHTML = `<i class="fas fa-times-circle me-2"></i> Anda berada di luar jangkauan (${distance.toFixed(0)} meter). Tombol dinonaktifkan.`;
                    mainButton.disabled = true;
                }
            }, error => {
                statusEl.className = 'alert alert-danger mt-3';
                statusEl.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i> Gagal mendapatkan lokasi. Pastikan izin lokasi diberikan dan coba refresh halaman.';
                mainButton.disabled = true;
            });
        }

        // Jalankan pengecekan lokasi saat halaman dimuat
        checkLocationAndEnableButton();

        // Fungsi proses absen
        async function prosesAbsensi(tipe) {
            mainButton.disabled = true;
            statusEl.className = 'alert alert-warning mt-3';
            statusEl.innerHTML = `<i class="fas fa-camera me-2"></i> Mengambil gambar...`;

            Webcam.snap(async function(data_uri) {
                document.getElementById('results').innerHTML = `<img src="${data_uri}" class="img-fluid rounded"/>`;
                document.getElementById('results').style.display = 'block';
                document.getElementById('my_camera').style.display = 'none';
                statusEl.innerHTML = `<i class="fas fa-upload me-2"></i> Gambar diambil. Mengirim data ke server...`;

                // Gunakan lokasi terbaru
                const userLat = statusEl.dataset.lat;
                const userLon = statusEl.dataset.lon;

                try {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const response = await fetch('/absensi/proses', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            tipe: tipe,
                            latitude: userLat,
                            longitude: userLon,
                            image: data_uri
                        })
                    });
                    // Update CSRF token jika ada header baru
                    const newToken = response.headers.get('X-CSRF-TOKEN');
                    if (newToken) {
                        document.querySelector('meta[name="csrf-token"]').setAttribute('content', newToken);
                    }
                    const result = await response.json();

                    if (result.status === 'success') {
                        statusEl.className = 'alert alert-success mt-3';
                        statusEl.innerHTML = `<i class="fas fa-check-circle me-2"></i> ${result.message}`;
                        setTimeout(() => window.location.reload(), 2000);
                    } else {
                        statusEl.className = 'alert alert-danger mt-3';
                        statusEl.innerHTML = `<i class="fas fa-times-circle me-2"></i> ${result.message}`;
                        mainButton.disabled = false;
                        document.getElementById('results').style.display = 'none';
                        document.getElementById('my_camera').style.display = 'block';
                    }
                } catch (error) {
                    statusEl.className = 'alert alert-danger mt-3';
                    statusEl.innerHTML = `<i class="fas fa-exclamation-circle me-2"></i> Terjadi kesalahan saat mengirim data. Coba lagi.`;
                    mainButton.disabled = false;
                    document.getElementById('results').style.display = 'none';
                    document.getElementById('my_camera').style.display = 'block';
                }
            });
        }

        if (mainButton) {
            mainButton.addEventListener('click', () => {
                // Cek lokasi lagi sebelum absen
                if (!navigator.geolocation) {
                    statusEl.className = 'alert alert-danger mt-3';
                    statusEl.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i> Browser Anda tidak mendukung Geolocation.';
                    return;
                }
                mainButton.disabled = true;
                statusEl.className = 'alert alert-warning mt-3';
                statusEl.innerHTML = '<i class="fas fa-location-arrow me-2"></i> Mengambil lokasi terkini...';

                navigator.geolocation.getCurrentPosition(position => {
                    statusEl.dataset.lat = position.coords.latitude;
                    statusEl.dataset.lon = position.coords.longitude;
                    prosesAbsensi(mainButton.id === 'btnAbsenMasuk' ? 'masuk' : 'pulang');
                }, () => {
                    statusEl.className = 'alert alert-danger mt-3';
                    statusEl.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i> Lokasi dibutuhkan untuk absen. Mohon izinkan akses.';
                    mainButton.disabled = false;
                });
            });
        }

        // Optional: monitor permission state for better UX
        if (navigator.permissions && navigator.permissions.query) {
            navigator.permissions.query({ name: 'geolocation' }).then(result => {
                if (result.state === 'granted') {
                    statusEl.innerHTML = '<i class="fas fa-check-circle me-2"></i> Akses lokasi diizinkan. Silakan lakukan absensi.';
                    statusEl.className = 'alert alert-success mt-3';
                } else if (result.state === 'prompt') {
                    statusEl.innerHTML = '<i class="fas fa-map-marker-alt me-2"></i> Mohon izinkan akses lokasi saat diminta.';
                    statusEl.className = 'alert alert-info mt-3';
                } else if (result.state === 'denied') {
                    statusEl.innerHTML = '<i class="fas fa-times-circle me-2"></i> Akses lokasi ditolak. Anda tidak bisa absen.';
                    statusEl.className = 'alert alert-danger mt-3';
                    if(mainButton) mainButton.disabled = true;
                }
            });
        }
    });
</script>
<?= $this->endSection() ?>
