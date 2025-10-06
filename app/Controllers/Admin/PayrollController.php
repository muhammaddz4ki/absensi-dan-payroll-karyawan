<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KaryawanModel;
use App\Models\AbsensiModel;
use App\Models\PayrollModel;
use App\Models\PengaturanModel;
use App\Models\LemburModel;

class PayrollController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    
    public function index()
    {
        $data = [
            'title' => 'Generate Payroll',
        ];
        return view('admin/payroll/index', $data);
    }

    public function generate()
    {
        $rules = [
            'bulan' => 'required',
            'tahun' => 'required',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Bulan dan Tahun wajib diisi.');
        }

        $bulan = $this->request->getPost('bulan');
        $tahun = $this->request->getPost('tahun');

        $karyawanModel = new KaryawanModel();
        $absensiModel = new AbsensiModel();
        $payrollModel = new PayrollModel();
        $pengaturanModel = new PengaturanModel();
        $lemburModel = new LemburModel();

        // Ambil pengaturan dinamis
        $pengaturanDb = $pengaturanModel->findAll();
        $pengaturan = [];
        foreach($pengaturanDb as $p) {
            $pengaturan[$p['nama_pengaturan']] = $p['nilai_pengaturan'];
        }
        $potonganPerAlpha = $pengaturan['potongan_alpha_per_hari'] ?? 50000;

        // Ambil semua karyawan aktif beserta tunjangan jabatannya
        $karyawanList = $karyawanModel
                        ->select('karyawan.id, karyawan.nama_lengkap, jabatan.gaji_pokok, jabatan.tunjangan_jabatan')
                        ->join('jabatan', 'jabatan.id = karyawan.jabatan_id')
                        ->findAll();

        $jumlahHariDiBulan = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        $totalHariKerja = 0;
        for ($hari = 1; $hari <= $jumlahHariDiBulan; $hari++) {
            $posisiHari = date('N', strtotime("$tahun-$bulan-$hari"));
            if ($posisiHari < 6) { 
                $totalHariKerja++;
            }
        }
        
        $startDate = "$tahun-$bulan-01";
        $endDate = "$tahun-$bulan-$jumlahHariDiBulan";

        $jumlahDitambah = 0;
        $jumlahDiperbarui = 0;

        foreach ($karyawanList as $karyawan) {
            // Hitung rekap absensi
            $rekap = $absensiModel
                    ->select("
                        COUNT(CASE WHEN status = 'Hadir' THEN 1 END) as total_hadir,
                        COUNT(CASE WHEN status = 'Sakit' THEN 1 END) as total_sakit,
                        COUNT(CASE WHEN status = 'Izin' THEN 1 END) as total_izin,
                        COUNT(CASE WHEN status = 'Cuti' THEN 1 END) as total_cuti
                    ")
                    ->where('karyawan_id', $karyawan['id'])
                    ->where('tgl_absen >=', $startDate)
                    ->where('tgl_absen <=', $endDate)
                    ->first();
            
            $totalAlpha = $totalHariKerja - $rekap['total_hadir'] - $rekap['total_sakit'] - $rekap['total_izin'] - $rekap['total_cuti'];
            if ($totalAlpha < 0) $totalAlpha = 0;

            // Hitung total jam lembur dan upah lembur yang disetujui
            $resultLembur = $lemburModel
                                ->selectSum('jumlah_jam', 'total_jam')
                                ->selectSum('total_upah_lembur', 'total_upah')
                                ->where('karyawan_id', $karyawan['id'])
                                ->where('MONTH(tanggal_lembur)', $bulan)
                                ->where('YEAR(tanggal_lembur)', $tahun)
                                ->where('status', 'Approved')
                                ->first();
            $totalJamLembur   = $resultLembur && isset($resultLembur['total_jam']) ? $resultLembur['total_jam'] : 0;
            $totalUpahLembur  = $resultLembur && isset($resultLembur['total_upah']) ? $resultLembur['total_upah'] : 0;

            // Hitung gaji
            $tunjanganJabatan = $karyawan['tunjangan_jabatan'];
            $totalPotongan = $totalAlpha * $potonganPerAlpha;
            $gajiBersih = ($karyawan['gaji_pokok'] + $tunjanganJabatan + $totalUpahLembur) - $totalPotongan;

            $dataPayroll = [
                'karyawan_id'       => $karyawan['id'],
                'bulan'             => $bulan,
                'tahun'             => $tahun,
                'gaji_pokok'        => $karyawan['gaji_pokok'],
                'total_hadir'       => $rekap['total_hadir'],
                'total_sakit'       => $rekap['total_sakit'],
                'total_izin'        => $rekap['total_izin'],
                'total_alpha'       => $totalAlpha,
                'tunjangan'         => $tunjanganJabatan,
                'total_jam_lembur'  => $totalJamLembur,      // <- ini field barunya
                'total_upah_lembur' => $totalUpahLembur,
                'potongan'          => $totalPotongan,
                'gaji_bersih'       => $gajiBersih,
            ];

            // Logika "Update atau Insert"
            $existingPayroll = $payrollModel
                                ->where('karyawan_id', $karyawan['id'])
                                ->where('bulan', $bulan)
                                ->where('tahun', $tahun)
                                ->first();

            if ($existingPayroll) {
                $this->db->table('payroll')->where('id', $existingPayroll['id'])->update($dataPayroll);
                $jumlahDiperbarui++;
            } else {
                $this->db->table('payroll')->insert($dataPayroll);
                $jumlahDitambah++;
            }
        }

        $message = "Payroll berhasil diproses. Data Baru: $jumlahDitambah, Data Diperbarui: $jumlahDiperbarui.";
        return redirect()->to('/admin/payroll/laporan?bulan='.$bulan.'&tahun='.$tahun)->with('success', $message);
    }
    
    public function laporan()
    {
        $payrollModel = new PayrollModel();
        $bulan = $this->request->getGet('bulan') ?? date('m');
        $tahun = $this->request->getGet('tahun') ?? date('Y');
        $data = [
            'title'     => 'Laporan Penggajian',
            'laporan'   => $payrollModel->getLaporan($bulan, $tahun),
            'bulan'     => $bulan,
            'tahun'     => $tahun,
        ];
        return view('admin/payroll/laporan', $data);
    }

    public function detail($payrollId)
    {
        $payrollModel = new PayrollModel();
        $detail = $payrollModel->getDetailSlip($payrollId);
        if (empty($detail)) {
            return redirect()->to('/admin/payroll/laporan')->with('error', 'Data slip gaji tidak ditemukan.');
        }
        $data = [
            'title' => 'Detail Slip Gaji Karyawan',
            'slip' => $detail,
        ];
        return view('admin/payroll/detail', $data);
    }

    public function edit($payrollId)
    {
        $payrollModel = new PayrollModel();
        $detail = $payrollModel->getDetailSlip($payrollId);
        if (empty($detail)) {
            return redirect()->to('/admin/payroll/laporan')->with('error', 'Data slip gaji tidak ditemukan.');
        }
        $data = [
            'title' => 'Edit Data Gaji',
            'slip'  => $detail,
        ];
        return view('admin/payroll/edit', $data);
    }

    public function update($payrollId)
    {
        $rules = [
            'gaji_pokok' => 'required|numeric',
            'tunjangan'  => 'required|numeric',
            'potongan'   => 'required|numeric',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $payrollModel = new PayrollModel();
        
        $existingPayroll = $payrollModel->find($payrollId);
        if (!$existingPayroll) {
            return redirect()->to('/admin/payroll/laporan')->with('error', 'Data gaji tidak ditemukan.');
        }
        $upahLembur = $existingPayroll['total_upah_lembur'];

        $gajiPokok = $this->request->getPost('gaji_pokok');
        $tunjangan = $this->request->getPost('tunjangan');
        $potongan = $this->request->getPost('potongan');

        $gajiBersih = ($gajiPokok + $upahLembur + $tunjangan) - $potongan;

        $dataToUpdate = [
            'gaji_pokok' => $gajiPokok,
            'tunjangan'  => $tunjangan,
            'potongan'   => $potongan,
            'gaji_bersih'=> $gajiBersih,
        ];
        
        $payrollModel->update($payrollId, $dataToUpdate);

        return redirect()->to('/admin/payroll/laporan')->with('success', 'Data gaji berhasil diperbarui.');
    }
    
    public function delete($payrollId)
    {
        $payrollModel = new PayrollModel();
        if ($payrollModel->find($payrollId)) {
            $payrollModel->delete($payrollId);
            return redirect()->to('/admin/payroll/laporan')->with('success', 'Data gaji berhasil dihapus.');
        }
        return redirect()->to('/admin/payroll/laporan')->with('error', 'Data gaji tidak ditemukan.');
    }
}
