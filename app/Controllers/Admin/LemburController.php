<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LemburModel;

class LemburController extends BaseController
{
    public function index()
    {
        $lemburModel = new LemburModel();

        $data = [
            'title' => 'Manajemen Pengajuan Lembur',
            'pending_lembur' => $lemburModel->select('lembur.*, karyawan.nama_lengkap')
                                        ->join('karyawan', 'karyawan.id = lembur.karyawan_id')
                                        ->where('status', 'Pending')->findAll(),
            'processed_lembur' => $lemburModel->select('lembur.*, karyawan.nama_lengkap')
                                          ->join('karyawan', 'karyawan.id = lembur.karyawan_id')
                                          ->whereIn('status', ['Approved', 'Rejected'])
                                          ->orderBy('updated_at', 'DESC')->findAll(),
        ];

        return view('admin/lembur/index', $data);
    }

    public function process($lemburId)
    {
        $status = $this->request->getPost('status');
        if (!in_array($status, ['Approved', 'Rejected'])) {
            return redirect()->back()->with('error', 'Status tidak valid.');
        }

        $lemburModel = new LemburModel();
        $pengajuanLembur = $lemburModel->find($lemburId);

        if (!$pengajuanLembur) {
            return redirect()->back()->with('error', 'Pengajuan lembur tidak ditemukan.');
        }

        // Update status pengajuan lembur
        $lemburModel->update($lemburId, ['status' => $status]);

        return redirect()->to('/admin/lembur')->with('success', 'Pengajuan lembur berhasil diproses.');
    }
}