<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BuatTabelPengaturan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'auto_increment' => true],
            'nama_pengaturan' => ['type' => 'VARCHAR', 'constraint' => '100', 'unique' => true],
            'nilai_pengaturan' => ['type' => 'TEXT', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pengaturan');
    }

    public function down()
    {
        $this->forge->dropTable('pengaturan');
    }
}