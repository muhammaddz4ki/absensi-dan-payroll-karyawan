<?php

namespace App\Models;

use CodeIgniter\Model;

class AbsensiModel extends Model
{
    protected $table = 'absensi';
    protected $allowedFields = [
        'karyawan_id',
        'tgl_absen',
        'jam_masuk',
        'jam_pulang',
        'foto_masuk',
        'foto_pulang',
        'lokasi_masuk',
        'lokasi_pulang',
        'status',
        'keterangan',
        'dokumen'
    ];

    /**
     * Ambil riwayat absensi untuk karyawan tertentu.
     *
     * @param int $karyawanId
     * @return array
     */
    public function getRiwayatAbsen($karyawanId)
    {
        return $this->where('karyawan_id', $karyawanId)
                    ->orderBy('tgl_absen', 'DESC')
                    ->findAll();
    }

    /**
     * Menghitung jumlah karyawan yang hadir hari ini.
     *
     * @return int
     */
    public function getHadirHariIni()
    {
        return $this->where('tgl_absen', date('Y-m-d'))
                    ->where('status', 'Hadir')
                    ->countAllResults();
    }

    /**
     * Mengambil rekap kehadiran harian untuk 7 hari terakhir.
     * Digunakan untuk data chart di dashboard.
     *
     * @return array
     */
    public function getRekapHarian()
    {
        return $this->select('tgl_absen, COUNT(id) as jumlah_hadir')
                    ->where('status', 'Hadir')
                    ->where('tgl_absen >=', date('Y-m-d', strtotime('-6 days')))
                    ->groupBy('tgl_absen')
                    ->orderBy('tgl_absen', 'ASC')
                    ->get()->getResultArray();
    }

    /**
     * Mengambil laporan absensi dengan filter.
     *
     * @param array $filters
     * @return array
     */
    public function getLaporanAbsensi($filters = [])
    {
        $builder = $this->db->table('absensi');
        $builder->select('absensi.*, karyawan.nama_lengkap, karyawan.nik');
        $builder->join('karyawan', 'karyawan.id = absensi.karyawan_id');

        if (!empty($filters['karyawan_id'])) {
            $builder->where('absensi.karyawan_id', $filters['karyawan_id']);
        }
        if (!empty($filters['start_date'])) {
            $builder->where('absensi.tgl_absen >=', $filters['start_date']);
        }
        if (!empty($filters['end_date'])) {
            $builder->where('absensi.tgl_absen <=', $filters['end_date']);
        }

        $builder->orderBy('absensi.tgl_absen', 'DESC');
        $builder->orderBy('absensi.jam_masuk', 'DESC');

        return $builder->get()->getResultArray();
    }

    public function getRekapBulanIni($karyawanId)
{
    $bulan = date('m');
    $tahun = date('Y');

    return $this->select("
                    COUNT(CASE WHEN status = 'Hadir' THEN 1 END) as total_hadir,
                    COUNT(CASE WHEN status = 'Sakit' THEN 1 END) as total_sakit,
                    COUNT(CASE WHEN status = 'Izin' THEN 1 END) as total_izin
                ")
                ->where('karyawan_id', $karyawanId)
                ->where('MONTH(tgl_absen)', $bulan)
                ->where('YEAR(tgl_absen)', $tahun)
                ->first();
}

}
