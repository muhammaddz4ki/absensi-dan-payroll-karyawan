<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KaryawanModel;
use App\Models\JabatanModel;
use App\Models\AbsensiModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $karyawanModel = new KaryawanModel();
        $jabatanModel = new JabatanModel();
        $absensiModel = new AbsensiModel();

        // Data untuk Chart
        $rekapHarianRaw = $absensiModel->getRekapHarian();
        $chartData = $this->prepareChartData($rekapHarianRaw);

        $data = [
            'title'           => 'Dashboard Admin',
            'total_karyawan'  => $karyawanModel->countAllResults(),
            'total_jabatan'   => $jabatanModel->countAllResults(),
            'hadir_hari_ini'  => $absensiModel->getHadirHariIni(),
            'chart_labels'    => json_encode($chartData['labels']),
            'chart_data'      => json_encode($chartData['data']),
        ];

        return view('admin/dashboard_page', $data);
    }

    /**
     * Menyiapkan data untuk Chart.js dari hasil query database.
     * Mengisi tanggal yang kosong dengan nilai 0.
     */
    private function prepareChartData($rekapHarianRaw)
    {
        $labels = [];
        $dataPoints = [];

        // Buat array tanggal untuk 7 hari terakhir
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = date('Y-m-d', strtotime("-$i days"));
            $labels[] = date('d M', strtotime($tanggal));
            $dataPoints[$tanggal] = 0; // Inisialisasi dengan 0
        }

        // Isi data dari database
        foreach ($rekapHarianRaw as $row) {
            if (isset($dataPoints[$row['tgl_absen']])) {
                $dataPoints[$row['tgl_absen']] = (int)$row['jumlah_hadir'];
            }
        }

        return [
            'labels' => $labels,
            'data'   => array_values($dataPoints)
        ];
    }
}