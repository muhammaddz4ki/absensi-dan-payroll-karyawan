<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BuatTabelPayroll extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'karyawan_id' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true],
            'bulan' => ['type' => 'INT', 'constraint' => 2],
            'tahun' => ['type' => 'INT', 'constraint' => 4],
            'gaji_pokok' => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'total_hadir' => ['type' => 'INT', 'constraint' => 2],
            'total_sakit' => ['type' => 'INT', 'constraint' => 2],
            'total_izin' => ['type' => 'INT', 'constraint' => 2],
            'total_alpha' => ['type' => 'INT', 'constraint' => 2],
            'total_menit_lembur' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'total_upah_lembur' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00],
            'potongan' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00],
            'tunjangan' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00],
            'gaji_bersih' => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('karyawan_id', 'karyawan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addUniqueKey(['karyawan_id', 'bulan', 'tahun']);
        $this->forge->createTable('payroll', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('payroll');
    }
}
