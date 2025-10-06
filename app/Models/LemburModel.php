<?php

namespace App\Models;

use CodeIgniter\Model;

class LemburModel extends Model
{
    protected $table            = 'lembur';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'karyawan_id',
        'tanggal_lembur',
        'jumlah_jam',
        'upah_per_jam_saat_pengajuan',
        'total_upah_lembur',
        'keterangan',
        'status'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
