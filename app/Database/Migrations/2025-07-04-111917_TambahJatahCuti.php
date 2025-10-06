<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TambahJatahCuti extends Migration
{
    public function up()
    {
        // Menambah kolom baru ke tabel 'karyawan'
        $this->forge->addColumn('karyawan', [
            'jatah_cuti' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'default' => 12, // Jatah cuti default, misal 12 hari setahun
                'after' => 'alamat',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('karyawan', 'jatah_cuti');
    }
}
