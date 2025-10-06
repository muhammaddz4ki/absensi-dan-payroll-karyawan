<?php

namespace App\Models;

use CodeIgniter\Model;

class KaryawanModel extends Model
{
    protected $table            = 'karyawan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    
    protected $allowedFields    = [
        'user_id', 
        'jabatan_id', 
        'nik', 
        'nama_lengkap', 
        'no_telepon', 
        'alamat',
        'jatah_cuti' 
    ];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Method untuk mengambil semua data karyawan dengan detail jabatan
    public function getKaryawanWithJabatan()
    {
        return $this->db->table('karyawan')
            // PERBAIKAN DI SINI: Tambahkan karyawan.jatah_cuti
            ->select('karyawan.id, karyawan.nik, karyawan.nama_lengkap, karyawan.jatah_cuti, jabatan.nama_jabatan, karyawan.no_telepon')
            ->join('jabatan', 'jabatan.id = karyawan.jabatan_id')
            ->get()->getResultArray();
    }
    
    // Method untuk mengambil satu data karyawan dengan detail jabatan & user
    public function getKaryawanDetail($id)
    {
        return $this->db->table('karyawan')
            ->select('karyawan.*, users.username, jabatan.nama_jabatan')
            ->join('users', 'users.id = karyawan.user_id')
            ->join('jabatan', 'jabatan.id = karyawan.jabatan_id')
            ->where('karyawan.id', $id)
            ->get()->getRowArray();
    }
}
