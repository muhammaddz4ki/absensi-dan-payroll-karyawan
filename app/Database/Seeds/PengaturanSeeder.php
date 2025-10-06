<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PengaturanSeeder extends Seeder
{
    public function run()
    {
        $pengaturanModel = new \App\Models\PengaturanModel();

        $data = [
            'lokasi_kantor_lat' => '-7.8612038',
            'lokasi_kantor_lon' => '110.3973365',
            'radius_absensi' => '100',
            'jam_masuk_mulai' => '07:00:00',
            'jam_masuk_selesai' => '08:00:00',
            'jam_pulang_mulai' => '16:00:00',
            // Pengaturan baru ditambahkan di sini
            'potongan_alpha_per_hari' => '50000',
            'upah_lembur_per_jam' => '20000',
        ];

        // Loop untuk insert atau update data
        foreach ($data as $key => $value) {
            $existing = $pengaturanModel->where('nama_pengaturan', $key)->first();

            if ($existing) {
                // Jika sudah ada, lewati (atau update jika perlu)
                // $pengaturanModel->update($existing['id'], ['nilai_pengaturan' => $value]);
            } else {
                // Jika belum ada, insert baru
                $pengaturanModel->insert([
                    'nama_pengaturan' => $key,
                    'nilai_pengaturan' => $value,
                ]);
            }
        }
    }
}