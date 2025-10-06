<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BuatTabelAbsensi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'karyawan_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true
            ],
            'tgl_absen' => [
                'type' => 'DATE'
            ],
            'jam_masuk' => [
                'type' => 'TIME',
                'null' => true
            ],
            'jam_pulang' => [
                'type' => 'TIME',
                'null' => true
            ],
            'foto_masuk' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true
            ],
            'foto_pulang' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true
            ],
            'lokasi_masuk' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true
            ],
            'lokasi_pulang' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['Hadir', 'Sakit', 'Izin', 'Cuti', 'Alpha'],
                'default' => 'Alpha'
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'dokumen' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('karyawan_id', 'karyawan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('absensi', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('absensi');
    }
}
