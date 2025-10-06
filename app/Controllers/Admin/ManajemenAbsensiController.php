<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AbsensiModel;
use App\Models\KaryawanModel;

class ManajemenAbsensiController extends BaseController
{
    public function index()
    {
        $karyawanModel = new KaryawanModel();

        $data = [
            'title'         => 'Manajemen Absensi (Sakit/Izin)',
            'karyawan_list' => $karyawanModel->findAll(),
        ];

        return view('admin/manajemen_absensi/index', $data);
    }

    public function save()
    {
        $absensiModel = new AbsensiModel();

        // Validasi input
        $rules = [
            'karyawan_id' => 'required',
            'tgl_absen'   => 'required|valid_date',
            'status'      => 'required|in_list[Sakit,Izin]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $karyawanId = $this->request->getPost('karyawan_id');
        $tglAbsen = $this->request->getPost('tgl_absen');
        $status = $this->request->getPost('status');

        // Cek apakah sudah ada data absen di tanggal tersebut untuk karyawan ini
        $existingAbsen = $absensiModel->where('karyawan_id', $karyawanId)
                                      ->where('tgl_absen', $tglAbsen)
                                      ->first();

        $dataToSave = [
            'karyawan_id' => $karyawanId,
            'tgl_absen'   => $tglAbsen,
            'status'      => $status,
            // Kosongkan data lainnya karena ini bukan absensi selfie
            'jam_masuk'   => null,
            'jam_pulang'  => null,
            'foto_masuk'  => null,
            'foto_pulang' => null,
            'lokasi_masuk'=> null,
            'lokasi_pulang'=> null,
        ];

        if ($existingAbsen) {
            // Jika sudah ada (misal karyawan sudah terlanjur absen), update statusnya
            $absensiModel->update($existingAbsen['id'], $dataToSave);
            $message = 'Status absensi berhasil diperbarui.';
        } else {
            // Jika belum ada, buat data baru
            $absensiModel->insert($dataToSave);
            $message = 'Status absensi berhasil ditambahkan.';
        }

        return redirect()->to('/admin/riwayat')->with('success', $message);
    }
}