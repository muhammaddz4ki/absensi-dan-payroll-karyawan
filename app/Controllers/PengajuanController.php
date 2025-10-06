<?php

namespace App\Controllers;

use App\Models\AbsensiModel;

class PengajuanController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Pengajuan Izin/Sakit',
        ];
        return view('karyawan/pengajuan_page', $data);
    }

    public function save()
    {
        $absensiModel = new AbsensiModel();

        // Aturan validasi
        $rules = [
            'tgl_pengajuan' => 'required|valid_date',
            'status'        => 'required|in_list[Sakit,Izin]',
            'keterangan'    => 'required',
            'dokumen'       => 'max_size[dokumen,2048]|ext_in[dokumen,pdf,jpg,jpeg,png]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $karyawanId = session()->get('karyawan_id');
        $tglAbsen = $this->request->getPost('tgl_pengajuan');
        $status = $this->request->getPost('status');
        $keterangan = $this->request->getPost('keterangan');

        // Proses upload file
        $fileDokumen = $this->request->getFile('dokumen');
        $namaDokumen = null;
        if ($fileDokumen->isValid() && !$fileDokumen->hasMoved()) {
            $namaDokumen = $fileDokumen->getRandomName();
            $fileDokumen->move(WRITEPATH . 'uploads/dokumen', $namaDokumen);
        }

        // Cek apakah sudah ada data absen di tanggal tersebut
        $existingAbsen = $absensiModel->where('karyawan_id', $karyawanId)
                                      ->where('tgl_absen', $tglAbsen)
                                      ->first();

        $dataToSave = [
            'karyawan_id' => $karyawanId,
            'tgl_absen'   => $tglAbsen,
            'status'      => $status,
            'keterangan'  => $keterangan,
            'dokumen'     => $namaDokumen,
        ];

        if ($existingAbsen) {
            // Jika karyawan sudah absen masuk, jangan timpa datanya, beri pesan error
            if (!empty($existingAbsen['jam_masuk'])) {
                return redirect()->to('/riwayat')->with('error', 'Anda sudah melakukan absensi di tanggal yang sama. Hubungi admin untuk perubahan.');
            }
            // Jika belum absen masuk, update statusnya
            $absensiModel->update($existingAbsen['id'], $dataToSave);
            $message = 'Pengajuan berhasil diperbarui.';
        } else {
            $absensiModel->insert($dataToSave);
            $message = 'Pengajuan berhasil dikirim.';
        }

        return redirect()->to('/riwayat')->with('success', $message);
    }
}