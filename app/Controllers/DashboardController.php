<?php

namespace App\Controllers;

use App\Models\AbsensiModel;

class DashboardController extends BaseController
{
    public function index()
    {
        // Pastikan hanya karyawan yang bisa mengakses
        if (session()->get('role') !== 'karyawan') {
            // Jika bukan, arahkan ke dashboard admin
            return redirect()->to('/admin/dashboard');
        }

        $absensiModel = new AbsensiModel();
        $karyawanId = session()->get('karyawan_id');

        $data = [
            'title' => 'Dashboard Karyawan',
            'rekap' => $absensiModel->getRekapBulanIni($karyawanId)
        ];

        return view('karyawan/dashboard_page', $data);
    }
}