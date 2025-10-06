<?php

namespace App\Controllers;

use App\Models\CutiModel;
use App\Models\KaryawanModel;
use CodeIgniter\I18n\Time;

class CutiController extends BaseController
{
    public function index()
    {
        $cutiModel = new CutiModel();
        $karyawanId = session()->get('karyawan_id');

        $data = [
            'title' => 'Riwayat Pengajuan Cuti',
            'riwayat_cuti' => $cutiModel->where('karyawan_id', $karyawanId)->orderBy('tanggal_mulai', 'DESC')->findAll(),
        ];

        return view('karyawan/cuti/index', $data);
    }

    public function ajukan()
    {
        $karyawanModel = new KaryawanModel();
        $karyawanId = session()->get('karyawan_id');
        $karyawan = $karyawanModel->find($karyawanId);

        $data = [
            'title' => 'Form Pengajuan Cuti',
            'jatah_cuti' => $karyawan['jatah_cuti'] ?? 0,
        ];

        return view('karyawan/cuti/ajukan', $data);
    }

    public function save()
    {
        $rules = [
            'tanggal_mulai' => 'required|valid_date',
            'tanggal_selesai' => 'required|valid_date',
            'keterangan' => 'required|min_length[10]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $karyawanModel = new KaryawanModel();
        $cutiModel = new CutiModel();

        $karyawanId = session()->get('karyawan_id');
        $karyawan = $karyawanModel->find($karyawanId);
        $sisaCuti = $karyawan['jatah_cuti'];

        $tanggalMulai = new Time($this->request->getPost('tanggal_mulai'));
        $tanggalSelesai = new Time($this->request->getPost('tanggal_selesai'));

        // Validasi tanggal
        if ($tanggalSelesai->isBefore($tanggalMulai)) {
            return redirect()->back()->withInput()->with('error', 'Tanggal selesai tidak boleh sebelum tanggal mulai.');
        }

        // ========================================================
        // PERBAIKAN LOGIKA PERHITUNGAN HARI KERJA
        // ========================================================
        $jumlahHari = 0;
        $startTimestamp = $tanggalMulai->getTimestamp();
        $endTimestamp = $tanggalSelesai->getTimestamp();

        for ($t = $startTimestamp; $t <= $endTimestamp; $t += 86400) { // 86400 detik = 1 hari
            // 'N' memberikan hari dalam seminggu, 1 (Senin) s/d 7 (Minggu)
            if (date('N', $t) < 6) { // Hanya hitung hari Senin (1) sampai Jumat (5)
                $jumlahHari++;
            }
        }
        // ========================================================

        if ($jumlahHari <= 0) {
            return redirect()->back()->withInput()->with('error', 'Pengajuan cuti harus mencakup minimal satu hari kerja (Senin-Jumat).');
        }

        if ($jumlahHari > $sisaCuti) {
            return redirect()->back()->withInput()->with('error', "Jatah cuti Anda tidak mencukupi. Sisa cuti: {$sisaCuti} hari, Anda mengajukan: {$jumlahHari} hari.");
        }

        // Simpan pengajuan
        $cutiModel->save([
            'karyawan_id' => $karyawanId,
            'tanggal_mulai' => $this->request->getPost('tanggal_mulai'),
            'tanggal_selesai' => $this->request->getPost('tanggal_selesai'),
            'jumlah_hari' => $jumlahHari,
            'keterangan' => $this->request->getPost('keterangan'),
            'status' => 'Pending',
        ]);

        return redirect()->to('/cuti')->with('success', 'Pengajuan cuti berhasil dikirim dan sedang menunggu persetujuan.');
    }
}
