<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BuatTabelCuti extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'karyawan_id' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true],
            'tanggal_mulai' => ['type' => 'DATE'],
            'tanggal_selesai' => ['type' => 'DATE'],
            'jumlah_hari' => ['type' => 'INT', 'constraint' => 3],
            'keterangan' => ['type' => 'TEXT'],
            'status' => ['type' => 'ENUM', 'constraint' => ['Pending', 'Approved', 'Rejected'], 'default' => 'Pending'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('karyawan_id', 'karyawan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('cuti', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('cuti');
    }
}
