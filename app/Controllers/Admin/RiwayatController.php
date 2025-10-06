<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AbsensiModel;
use App\Models\KaryawanModel;

class RiwayatController extends BaseController
{
    public function index()
    {
        $absensiModel = new AbsensiModel();
        $karyawanModel = new KaryawanModel();

        // Ambil data filter dari URL (GET request)
        $filters = [
            'karyawan_id' => $this->request->getGet('karyawan_id'),
            'start_date'  => $this->request->getGet('start_date'),
            'end_date'    => $this->request->getGet('end_date'),
        ];

        $data = [
            'title'         => 'Laporan Riwayat Absensi',
            'riwayat'       => $absensiModel->getLaporanAbsensi($filters),
            'karyawan_list' => $karyawanModel->findAll(),
            'filters'       => $filters, // Kirim filter kembali ke view
        ];

        return view('admin/riwayat/index', $data);
    }
}