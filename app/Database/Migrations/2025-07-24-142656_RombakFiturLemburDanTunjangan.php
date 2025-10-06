<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RombakFiturLemburDanTunjangan extends Migration
{
    public function up()
    {
        // 1. Menambah kolom tunjangan_jabatan ke tabel 'jabatan'
        if (!$this->db->fieldExists('tunjangan_jabatan', 'jabatan')) {
            $this->forge->addColumn('jabatan', [
                'tunjangan_jabatan' => [
                    'type' => 'DECIMAL',
                    'constraint' => '10,2',
                    'default' => 0.00,
                    'after' => 'gaji_pokok',
                ],
            ]);
        }

        // 2. Menghapus kolom lembur per menit dari tabel 'payroll'
        if ($this->db->fieldExists('total_menit_lembur', 'payroll')) {
            $this->forge->dropColumn('payroll', 'total_menit_lembur');
        }

        // 3. Membuat tabel baru untuk pengajuan lembur
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'karyawan_id' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true],
            'tanggal_lembur' => ['type' => 'DATE'],
            'jumlah_jam' => ['type' => 'INT', 'constraint' => 3],
            'upah_per_jam_saat_pengajuan' => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'total_upah_lembur' => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'keterangan' => ['type' => 'TEXT'],
            'status' => ['type' => 'ENUM', 'constraint' => ['Pending', 'Approved', 'Rejected'], 'default' => 'Pending'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('karyawan_id', 'karyawan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('lembur', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropColumn('jabatan', 'tunjangan_jabatan');
        $this->forge->dropTable('lembur');
        // (Opsional) Mengembalikan kolom lama jika diperlukan
        $this->forge->addColumn('payroll', [
            'total_menit_lembur' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
        ]);
    }
}
