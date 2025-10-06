<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\KaryawanModel;

class LoginController extends BaseController
{
    protected $userModel;
    protected $karyawanModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->karyawanModel = new KaryawanModel();
    }

    // Menampilkan halaman login
    public function index()
    {
        return view('login_page');
    }

    // Memproses upaya login
    public function process()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Cari user berdasarkan username
        $user = $this->userModel->where('username', $username)->first();

        // Cek apakah user ada dan verifikasi password
        if ($user && password_verify($password, $user['password'])) {

            // Jika login berhasil, siapkan data untuk session
            $sessionData = [
                'user_id'    => $user['id'],
                'username'   => $user['username'],
                'role'       => $user['role'],
                'isLoggedIn' => true,
            ];

            // Jika rolenya karyawan, cari data karyawan untuk dapat nama & id karyawan
            if ($user['role'] === 'karyawan') {
                $karyawan = $this->karyawanModel->where('user_id', $user['id'])->first();
                if ($karyawan) {
                    $sessionData['karyawan_id'] = $karyawan['id'];
                    $sessionData['nama_lengkap'] = $karyawan['nama_lengkap'];
                }
            }

            // Set session
            session()->set($sessionData);

            // Arahkan berdasarkan role
            if ($user['role'] === 'admin') {
                return redirect()->to('/admin/karyawan');
            } else {
                return redirect()->to('/absensi');
            }

        } else {
            // Jika login gagal
            return redirect()->to('/login')->with('error', 'Username atau Password salah.');
        }
    }

    // Proses logout
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Anda berhasil logout.');
    }
}