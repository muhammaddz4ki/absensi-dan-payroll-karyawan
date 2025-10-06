<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\JabatanModel;

class JabatanController extends BaseController
{
    protected $jabatanModel;

    public function __construct()
    {
        $this->jabatanModel = new JabatanModel();
    }

    public function index()
    {
        $data = [
            'title'   => 'Manajemen Jabatan',
            'jabatan' => $this->jabatanModel->findAll()
        ];
        return view('admin/jabatan/index', $data);
    }

    public function new()
    {
        $data = [
            'title' => 'Tambah Jabatan Baru'
        ];
        return view('admin/jabatan/new', $data);
    }

    public function create()
    {
        $rules = [
            'nama_jabatan' => 'required|is_unique[jabatan.nama_jabatan]',
            'gaji_pokok'   => 'required|numeric',
            'tunjangan_jabatan' => 'required|numeric' // Tambah validasi
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->jabatanModel->save([
            'nama_jabatan' => $this->request->getPost('nama_jabatan'),
            'gaji_pokok'   => $this->request->getPost('gaji_pokok'),
            'tunjangan_jabatan' => $this->request->getPost('tunjangan_jabatan'), // Tambah field
        ]);

        return redirect()->to('/admin/jabatan')->with('success', 'Data jabatan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = [
            'title'   => 'Edit Jabatan',
            'jabatan' => $this->jabatanModel->find($id)
        ];

        if (empty($data['jabatan'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Jabatan tidak ditemukan.');
        }

        return view('admin/jabatan/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'nama_jabatan' => "required|is_unique[jabatan.nama_jabatan,id,{$id}]",
            'gaji_pokok'   => 'required|numeric',
            'tunjangan_jabatan' => 'required|numeric' // Tambah validasi
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->jabatanModel->update($id, [
            'nama_jabatan' => $this->request->getPost('nama_jabatan'),
            'gaji_pokok'   => $this->request->getPost('gaji_pokok'),
            'tunjangan_jabatan' => $this->request->getPost('tunjangan_jabatan'), // Tambah field
        ]);

        return redirect()->to('/admin/jabatan')->with('success', 'Data jabatan berhasil diperbarui.');
    }

    public function delete($id)
    {
        if ($this->jabatanModel->find($id)) {
            $this->jabatanModel->delete($id);
            return redirect()->to('/admin/jabatan')->with('success', 'Data jabatan berhasil dihapus.');
        }

        return redirect()->to('/admin/jabatan')->with('error', 'Data jabatan tidak ditemukan.');
    }
}