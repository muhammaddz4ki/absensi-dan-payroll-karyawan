<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UserModel;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $userModel = new UserModel();

        // Cek jika username 'admin' sudah ada
        if ($userModel->where('username', 'admin')->first()) {
            // Jika sudah ada, tidak melakukan apa-apa
            echo "Akun admin sudah ada.\n";
            return;
        }

        // Data untuk admin baru
        $adminData = [
            'username' => 'admin',
            'password' => 'admin123', // Password akan di-hash otomatis oleh UserModel
            'role'     => 'admin',
        ];

        // Masukkan data ke database melalui model
        $userModel->insert($adminData);

        echo "Akun admin berhasil dibuat.\nUsername: admin\nPassword: admin123\n";
    }
}