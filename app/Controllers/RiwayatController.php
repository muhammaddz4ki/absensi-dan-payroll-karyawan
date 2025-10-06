<?php

namespace App\Controllers;

use App\Models\AbsensiModel;

class RiwayatController extends BaseController
{
    public function index()
    {
        $absensiModel = new AbsensiModel();
        $karyawanId = session()->get('karyawan_id');

        $data = [
            'title'   => 'Riwayat Absensi Saya',
            'riwayat' => $absensiModel->getRiwayatAbsen($karyawanId),
        ];

        return view('karyawan/riwayat_page', $data);
    }
}