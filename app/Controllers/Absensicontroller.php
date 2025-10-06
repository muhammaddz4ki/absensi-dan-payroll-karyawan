<?php

namespace App\Controllers;

use App\Models\AbsensiModel;
use App\Models\PengaturanModel;

class AbsensiController extends BaseController
{
    protected $absensiModel;
    protected $pengaturanModel;

    public function __construct()
    {
        $this->absensiModel = new AbsensiModel();
        $this->pengaturanModel = new PengaturanModel();
    }
    
    public function index()
    {
        $karyawanId = session()->get('karyawan_id'); 

        $today = date('Y-m-d');
        $absenHariIni = $this->absensiModel->where('karyawan_id', $karyawanId)
                                        ->where('tgl_absen', $today)
                                        ->first();
        
        $settings_raw = $this->pengaturanModel->findAll();
        $settings = [];
        foreach ($settings_raw as $row) {
            $settings[$row['nama_pengaturan']] = $row['nilai_pengaturan'];
        }

        $data = [
            'title'         => 'Halaman Absensi',
            'absenHariIni'  => $absenHariIni,
            'settings'      => $settings
        ];

        return view('karyawan/absensi_page', $data);
    }

    public function prosesAbsen()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403, 'Forbidden');
        }

        $karyawanId = session()->get('karyawan_id');
        $data = $this->request->getJSON();
        $tipe = $data->tipe;
        $currentTime = date('H:i:s');
        $today = date('Y-m-d');

        // Ambil pengaturan dari DB
        $settings_raw = $this->pengaturanModel->findAll();
        $settings = [];
        foreach ($settings_raw as $row) {
            $settings[$row['nama_pengaturan']] = $row['nilai_pengaturan'];
        }

        // 1. Validasi Waktu
        if ($tipe == 'masuk' && ($currentTime < $settings['jam_masuk_mulai'] || $currentTime > $settings['jam_masuk_selesai'])) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Absen masuk hanya bisa dilakukan antara jam ' . $settings['jam_masuk_mulai'] . ' - ' . $settings['jam_masuk_selesai']]);
        } elseif ($tipe == 'pulang' && $currentTime < $settings['jam_pulang_mulai']) {
             return $this->response->setJSON(['status' => 'error', 'message' => 'Absen pulang hanya bisa dilakukan setelah jam ' . $settings['jam_pulang_mulai']]);
        }

        // 2. Validasi Lokasi (di server juga)
        $jarak = $this->hitungJarak($settings['lokasi_kantor_lat'], $settings['lokasi_kantor_lon'], $data->latitude, $data->longitude);

        if ($jarak > $settings['radius_absensi']) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Anda berada di luar radius yang diizinkan.']);
        }
        
        // 3. Proses Simpan Gambar
        $img = $data->image;
        $img = str_replace('data:image/jpeg;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $imgData = base64_decode($img);
        $namaFile = $karyawanId . '_' . date('Y-m-d_H-i-s') . '_' . $tipe . '.jpeg';
        $file = WRITEPATH . 'uploads/absensi/' . $namaFile;
        if (!is_dir(WRITEPATH . 'uploads/absensi/')) {
            mkdir(WRITEPATH . 'uploads/absensi/', 0777, true);
        }
        file_put_contents($file, $imgData);
        
        // ==========================================================
        // 4. LOGIKA BARU UNTUK SIMPAN KE DATABASE
        // ==========================================================
        $absenHariIni = $this->absensiModel
                            ->where('karyawan_id', $karyawanId)
                            ->where('tgl_absen', $today)
                            ->first();

        if ($tipe == 'masuk') {
            // Jika sudah ada record, jangan insert lagi.
            if ($absenHariIni) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Anda sudah absen masuk hari ini.']);
            }

            // Jika belum ada, insert baru.
            $this->absensiModel->insert([
                'karyawan_id'   => $karyawanId,
                'tgl_absen'     => $today,
                'jam_masuk'     => $currentTime,
                'foto_masuk'    => $namaFile,
                'lokasi_masuk'  => "{$data->latitude},{$data->longitude}",
                'status'        => 'Hadir'
            ]);
        } else { // Jika tipe pulang
            // Jika tidak ada record masuk, tidak bisa absen pulang.
            if (!$absenHariIni) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Anda belum absen masuk, tidak bisa absen pulang.']);
            }
            // Jika sudah absen pulang, jangan update lagi.
            if ($absenHariIni['jam_pulang'] !== null) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Anda sudah absen pulang hari ini.']);
            }

            // Update data absen pulang ke record yang sudah ada
            $this->absensiModel->update($absenHariIni['id'], [
                'jam_pulang'    => $currentTime,
                'foto_pulang'   => $namaFile,
                'lokasi_pulang' => "{$data->latitude},{$data->longitude}"
            ]);
        }
        // ==========================================================

        return $this->response->setJSON(['status' => 'success', 'message' => 'Absen '. $tipe .' berhasil!']);
    }

    private function hitungJarak($lat1, $lon1, $lat2, $lon2) {
        $earthRadius = 6371000;
        $latFrom = deg2rad($lat1); $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2); $lonTo = deg2rad($lon2);
        $latDelta = $latTo - $latFrom; $lonDelta = $lonTo - $lonFrom;
        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return $angle * $earthRadius;
    }
}
