<?php

namespace App\Models;

use CodeIgniter\Model;

class PayrollModel extends Model
{
    protected $table = 'payroll';
    protected $allowedFields = [
        'karyawan_id',
        'bulan',
        'tahun',
        'gaji_pokok',
        'total_hadir',
        'total_sakit',
        'total_izin',
        'total_alpha',
        'potongan',
        'tunjangan',
        'gaji_bersih',
        'total_jam_lembur',
        'total_upah_lembur'

    ];

    protected $useTimestamps = false; // Set menjadi false

    protected $createdField  = 'created_at';
    protected $updatedField  = null;

    /**
     * Mengambil laporan payroll.
     * Bisa difilter per periode (bulan & tahun) ATAU per ID payroll spesifik.
     *
     * @param int|null $bulan
     * @param int|null $tahun
     * @param int|null $payrollId
     * @return array
     */
    public function getLaporan($bulan = null, $tahun = null, $payrollId = null)
    {
        $builder = $this->select('payroll.*, karyawan.nama_lengkap, karyawan.nik, jabatan.nama_jabatan')
                    ->join('karyawan', 'karyawan.id = payroll.karyawan_id')
                    ->join('jabatan', 'jabatan.id = karyawan.jabatan_id');

        if ($payrollId !== null) {
            // Jika mencari satu detail slip gaji spesifik
            $builder->where('payroll.id', $payrollId);
        } else {
            // Jika mencari laporan bulanan
            $builder->where('payroll.bulan', $bulan)
                    ->where('payroll.tahun', $tahun);
        }

        return $builder->orderBy('karyawan.nama_lengkap', 'ASC')->findAll();
    }

    /**
     * Mengambil detail slip gaji berdasarkan ID payroll.
     *
     * @param int $payrollId
     * @return array|null
     */
    public function getDetailSlip($payrollId)
    {
        return $this->select('payroll.*, karyawan.nama_lengkap, karyawan.nik, jabatan.nama_jabatan')
            ->join('karyawan', 'karyawan.id = payroll.karyawan_id')
            ->join('jabatan', 'jabatan.id = karyawan.jabatan_id')
            ->where('payroll.id', $payrollId)
            ->first();
    }
}
