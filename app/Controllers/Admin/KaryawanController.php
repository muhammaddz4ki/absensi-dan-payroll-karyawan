<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KaryawanModel;
use App\Models\JabatanModel;
use App\Models\UserModel;

class KaryawanController extends BaseController
{
    protected $karyawanModel;
    protected $jabatanModel;
    protected $userModel;
    protected $db;

    public function __construct()
    {
        $this->karyawanModel = new KaryawanModel();
        $this->jabatanModel = new JabatanModel();
        $this->userModel = new UserModel();
        $this->db = \Config\Database::connect(); // Load database connection
    }

    public function index()
    {
        $data = [
            'title'     => 'Manajemen Karyawan',
            'karyawan'  => $this->karyawanModel->getKaryawanWithJabatan()
        ];
        return view('admin/karyawan/index', $data);
    }

    public function new()
    {
        $data = [
            'title'     => 'Tambah Karyawan Baru',
            'jabatan'   => $this->jabatanModel->findAll()
        ];
        return view('admin/karyawan/new', $data);
    }

    public function create()
    {
        // Aturan validasi
        $rules = [
            'nama_lengkap' => 'required',
            'nik'          => 'required|is_unique[karyawan.nik]',
            'jabatan_id'   => 'required',
            'no_telepon'   => 'required',
            'username'     => 'required|is_unique[users.username]',
            'password'     => 'required|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Mulai transaksi database
        $this->db->transStart();

        // 1. Simpan ke tabel users
        $userId = $this->userModel->insert([
            'username' => $this->request->getPost('username'),
            'password' => $this->request->getPost('password'), // Akan di-hash otomatis oleh model
            'role'     => 'karyawan'
        ]);

        // 2. Simpan ke tabel karyawan
        $this->karyawanModel->insert([
            'user_id'      => $userId,
            'jabatan_id'   => $this->request->getPost('jabatan_id'),
            'nik'          => $this->request->getPost('nik'),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'no_telepon'   => $this->request->getPost('no_telepon'),
            'alamat'       => $this->request->getPost('alamat'),
        ]);

        // Selesaikan transaksi
        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            // Jika transaksi gagal, kembalikan dengan pesan error
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data karyawan.');
        }

        return redirect()->to('/admin/karyawan')->with('success', 'Data karyawan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = [
            'title'     => 'Edit Karyawan',
            'karyawan'  => $this->karyawanModel->getKaryawanDetail($id),
            'jabatan'   => $this->jabatanModel->findAll()
        ];

        if (empty($data['karyawan'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Karyawan tidak ditemukan.');
        }

        return view('admin/karyawan/edit', $data);
    }

    public function update($id)
    {
        $karyawan = $this->karyawanModel->find($id);
        // Aturan validasi
        $rules = [
            'nama_lengkap' => 'required',
            'nik'          => "required|is_unique[karyawan.nik,id,{$id}]",
            'jabatan_id'   => 'required',
            'no_telepon'   => 'required',
            'username'     => "required|is_unique[users.username,id,{$karyawan['user_id']}]",
        ];

        // Aturan validasi untuk password (jika diisi)
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $rules['password'] = 'min_length[6]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->db->transStart();

        // 1. Update tabel users
        $userData = [
            'username' => $this->request->getPost('username')
        ];
        if (!empty($password)) {
            $userData['password'] = password_hash($password, PASSWORD_DEFAULT);
        }
        $this->userModel->update($karyawan['user_id'], $userData);

        // 2. Update tabel karyawan
        $this->karyawanModel->update($id, [
            'jabatan_id'   => $this->request->getPost('jabatan_id'),
            'nik'          => $this->request->getPost('nik'),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'no_telepon'   => $this->request->getPost('no_telepon'),
            'alamat'       => $this->request->getPost('alamat'),
        ]);

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data karyawan.');
        }

        return redirect()->to('/admin/karyawan')->with('success', 'Data karyawan berhasil diperbarui.');
    }

   public function delete($id)
{
    // Cari data karyawan berdasarkan ID yang akan dihapus
    $karyawan = $this->karyawanModel->find($id);

    // Jika data karyawan ditemukan
    if ($karyawan) {

        // Mulai transaksi untuk memastikan kedua operasi (hapus karyawan & hapus user) berhasil
        $this->db->transStart();

        // 1. Hapus data dari tabel karyawan
        $this->karyawanModel->delete($id);

        // 2. Hapus data dari tabel users berdasarkan user_id yang ada di data karyawan
        $this->userModel->delete($karyawan['user_id']);

        // Selesaikan transaksi
        $this->db->transComplete();

        // Cek apakah transaksi berhasil
        if ($this->db->transStatus() === false) {
            // Jika gagal, kembalikan pesan error
            return redirect()->to('/admin/karyawan')->with('error', 'Gagal menghapus data karyawan dan user terkait.');
        }

        // Jika berhasil, kembalikan pesan sukses
        return redirect()->to('/admin/karyawan')->with('success', 'Data karyawan dan data login berhasil dihapus.');
    }

    // Jika data karyawan tidak ditemukan dari awal
    return redirect()->to('/admin/karyawan')->with('error', 'Gagal menghapus, data karyawan tidak ditemukan.');
}
public function updateJatahCuti($karyawanId)
    {
        $rules = [
            'jatah_cuti' => 'required|numeric|max_length[3]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', 'Input jatah cuti tidak valid.');
        }

        $karyawanModel = new KaryawanModel();
        $jatahCuti = $this->request->getPost('jatah_cuti');

        $karyawanModel->update($karyawanId, ['jatah_cuti' => $jatahCuti]);

        return redirect()->to('/admin/karyawan')->with('success', 'Jatah cuti karyawan berhasil diperbarui.');
    }
}