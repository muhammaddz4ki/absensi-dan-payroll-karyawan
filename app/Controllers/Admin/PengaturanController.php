<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PengaturanModel;

class PengaturanController extends BaseController
{
    protected $pengaturanModel;

    public function __construct()
    {
        $this->pengaturanModel = new PengaturanModel();
    }

    public function index()
    {
        $settings_raw = $this->pengaturanModel->findAll();
        $settings = [];
        foreach ($settings_raw as $row) {
            $settings[$row['nama_pengaturan']] = $row['nilai_pengaturan'];
        }

        $data = [
            'title'    => 'Pengaturan Aplikasi',
            'settings' => $settings
        ];
        return view('admin/pengaturan/index', $data);
    }

    public function update()
    {
        $data = $this->request->getPost();

        foreach ($data as $key => $value) {
            // Jangan proses token csrf
            if ($key === 'csrf_test_name') {
                continue;
            }

            // Cek apakah pengaturan sudah ada
            $existing = $this->pengaturanModel->where('nama_pengaturan', $key)->first();

            if ($existing) {
                // Jika sudah ada, UPDATE
                $this->pengaturanModel->update($existing['id'], ['nilai_pengaturan' => $value]);
            } else {
                // Jika belum ada, INSERT baru
                $this->pengaturanModel->insert([
                    'nama_pengaturan'  => $key,
                    'nilai_pengaturan' => $value,
                ]);
            }
        }
        
        return redirect()->to('/admin/pengaturan')->with('success', 'Pengaturan berhasil diperbarui.');
    }
}