<?php

namespace App\Models;

use CodeIgniter\Model;

class PengaturanModel extends Model
{
    protected $table = 'pengaturan';
    protected $allowedFields = [
        'nama_pengaturan',
        'nilai_pengaturan',
        'potongan_alpha_per_hari',
        'upah_lembur_per_jam'
    ];
}
