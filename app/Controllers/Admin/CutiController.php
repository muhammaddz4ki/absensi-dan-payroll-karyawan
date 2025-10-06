<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CutiModel;
use App\Models\KaryawanModel;
use App\Models\AbsensiModel;
use CodeIgniter\I18n\Time;

class CutiController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $cutiModel = new CutiModel();

        $data = [
            'title' => 'Manajemen Pengajuan Cuti',
            'pending_cuti' => $cutiModel->select('cuti.*, karyawan.nama_lengkap')
                                        ->join('karyawan', 'karyawan.id = cuti.karyawan_id')
                                        ->where('status', 'Pending')->findAll(),
            'processed_cuti' => $cutiModel->select('cuti.*, karyawan.nama_lengkap')
                                        ->join('karyawan', 'karyawan.id = cuti.karyawan_id')
                                        ->whereIn('status', ['Approved', 'Rejected'])
                                        ->orderBy('updated_at', 'DESC')->findAll(),
        ];

        return view('admin/cuti/index', $data);
    }

public function process($cutiId)
{
    $status = $this->request->getPost('status');
    if (!in_array($status, ['Approved', 'Rejected'])) {
        return redirect()->back()->with('error', 'Status tidak valid.');
    }

    $cutiModel = new CutiModel();
    $karyawanModel = new KaryawanModel();
    $absensiModel = new AbsensiModel();

    $pengajuanCuti = $cutiModel->find($cutiId);
    if (!$pengajuanCuti) {
        return redirect()->back()->with('error', 'Pengajuan cuti tidak ditemukan.');
    }

    // Mulai transaksi database
    $this->db->transStart();

    // Update status pengajuan cuti
    $cutiModel->update($cutiId, ['status' => $status]);

    // Jika disetujui, kurangi jatah cuti dan catat di absensi
    if ($status === 'Approved') {
        $karyawan = $karyawanModel->find($pengajuanCuti['karyawan_id']);
        
        // Pastikan karyawan ditemukan
        if ($karyawan) {
            $sisaCutiBaru = $karyawan['jatah_cuti'] - $pengajuanCuti['jumlah_hari'];
            
            // Update jatah cuti karyawan
            $karyawanModel->update($pengajuanCuti['karyawan_id'], ['jatah_cuti' => $sisaCutiBaru]);

            // Proses absensi cuti
            $tanggalMulai = new \CodeIgniter\I18n\Time($pengajuanCuti['tanggal_mulai']);
            $tanggalSelesai = new \CodeIgniter\I18n\Time($pengajuanCuti['tanggal_selesai']);

            // Validasi tanggal
            if ($tanggalMulai->getTimestamp() > $tanggalSelesai->getTimestamp()) {
                $this->db->transComplete();
                return redirect()->back()->with('error', 'Tanggal mulai lebih besar dari tanggal selesai!');
            }

            // Inisialisasi currentDate
            $currentDate = clone $tanggalMulai;
            $counter = 0;
            $maxCounter = 40; // Batas hari cuti maksimum (supaya anti infinite)

            while (
                $currentDate->getTimestamp() <= $tanggalSelesai->getTimestamp()
                && $counter < $maxCounter
            ) {
                // Hanya hari Senin-Jumat (1-5)
                if ($currentDate->getDayOfWeek() >= 2 && $currentDate->getDayOfWeek() <= 6) {
                    // Cek apakah sudah ada data absensi di tanggal ini
                    $existingAbsen = $absensiModel
                        ->where('karyawan_id', $pengajuanCuti['karyawan_id'])
                        ->where('tgl_absen', $currentDate->toDateString())
                        ->first();

                    $dataAbsen = [
                        'karyawan_id' => $pengajuanCuti['karyawan_id'],
                        'tgl_absen'   => $currentDate->toDateString(),
                        'status'      => 'Cuti',
                        'keterangan'  => 'Cuti Disetujui: ' . $pengajuanCuti['keterangan']
                    ];

                    if ($existingAbsen) {
                        // Jika sudah ada, update
                        $absensiModel->update($existingAbsen['id'], $dataAbsen);
                    } else {
                        // Jika belum ada, insert
                        $absensiModel->insert($dataAbsen);
                    }
                }

                // Tambah satu hari, WAJIB pakai assignment!
                $currentDate = $currentDate->addDays(1);
                $counter++;
            }

            // Jika counter mentok, warning log (opsional)
            if ($counter >= $maxCounter) {
                log_message('error', 'Proses cuti: kemungkinan infinite loop dicegah pada pengajuan cuti ID ' . $cutiId);
            }
        }
    }

    // Selesaikan transaksi
    $this->db->transComplete();

    if ($this->db->transStatus() === false) {
        return redirect()->back()->with('error', 'Gagal memproses pengajuan cuti.');
    }

    return redirect()->to('/admin/cuti')->with('success', 'Pengajuan cuti berhasil diproses.');
}


}
