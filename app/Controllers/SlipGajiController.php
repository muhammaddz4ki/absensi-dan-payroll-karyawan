<?php

    namespace App\Controllers;

    use App\Models\PayrollModel;

    class SlipGajiController extends BaseController
    {
        public function index()
        {
            $payrollModel = new PayrollModel();
            $karyawanId = session()->get('karyawan_id');

            $data = [
                'title' => 'Daftar Slip Gaji',
                'slip_gaji' => $payrollModel->where('karyawan_id', $karyawanId)
                                            ->orderBy('tahun', 'DESC')
                                            ->orderBy('bulan', 'DESC')
                                            ->findAll(),
            ];
            return view('karyawan/slip_gaji/index', $data);
        }

        public function detail($payrollId)
        {
            $payrollModel = new PayrollModel();
            $karyawanId = session()->get('karyawan_id');

            $detail = $payrollModel
                    ->select('payroll.*, karyawan.nama_lengkap, karyawan.nik, jabatan.nama_jabatan')
                    ->join('karyawan', 'karyawan.id = payroll.karyawan_id')
                    ->join('jabatan', 'jabatan.id = karyawan.jabatan_id')
                    ->where('payroll.id', $payrollId)
                    ->where('payroll.karyawan_id', $karyawanId) // Security check
                    ->first();

            if (!$detail) {
                return redirect()->to('/slip-gaji')->with('error', 'Slip gaji tidak ditemukan.');
            }

            $data = [
                'title' => 'Detail Slip Gaji',
                'slip' => $detail,
            ];
            return view('karyawan/slip_gaji/detail', $data);
        }
    }
    