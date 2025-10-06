<?php

namespace App\Controllers;

use App\Models\LemburModel;
use App\Models\PengaturanModel;

class LemburController extends BaseController
{
    public function index()
    {
        $lemburModel = new LemburModel();
        $karyawanId = session()->get('karyawan_id');

        $data = [
            'title' => 'Riwayat Pengajuan Lembur',
            'riwayat_lembur' => $lemburModel->where('karyawan_id', $karyawanId)->orderBy('tanggal_lembur', 'DESC')->findAll(),
        ];

        return view('karyawan/lembur/index', $data);
    }

    public function ajukan()
    {
        $pengaturanModel = new PengaturanModel();
        $upahLemburSetting = $pengaturanModel->where('nama_pengaturan', 'upah_lembur_per_jam')->first();

        $data = [
            'title' => 'Form Pengajuan Lembur',
            'upah_per_jam' => $upahLemburSetting['nilai_pengaturan'] ?? 0,
        ];

        return view('karyawan/lembur/ajukan', $data);
    }

    public function save()
    {
        $rules = [
            'tanggal_lembur' => 'required|valid_date',
            'jumlah_jam' => 'required|numeric|greater_than[0]',
            'keterangan' => 'required|min_length[10]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $lemburModel = new LemburModel();
        $pengaturanModel = new PengaturanModel();

        $upahLemburSetting = $pengaturanModel->where('nama_pengaturan', 'upah_lembur_per_jam')->first();
        $upahPerJam = $upahLemburSetting['nilai_pengaturan'] ?? 20000;
        
        $jumlahJam = $this->request->getPost('jumlah_jam');
        $totalUpah = $jumlahJam * $upahPerJam;

        $lemburModel->save([
            'karyawan_id' => session()->get('karyawan_id'),
            'tanggal_lembur' => $this->request->getPost('tanggal_lembur'),
            'jumlah_jam' => $jumlahJam,
            'upah_per_jam_saat_pengajuan' => $upahPerJam,
            'total_upah_lembur' => $totalUpah,
            'keterangan' => $this->request->getPost('keterangan'),
            'status' => 'Pending',
        ]);

        return redirect()->to('/lembur')->with('success', 'Pengajuan lembur berhasil dikirim dan sedang menunggu persetujuan.');
    }
}
