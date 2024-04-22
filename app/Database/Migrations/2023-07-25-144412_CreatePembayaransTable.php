<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePembayaransTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'penyewa_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'tenda_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'tanggal_pembayaran'   => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'lama_sewa'      => [
                'type' => 'INT',
                'constraint' => 5,
            ],
            'jumlah_tenda'   => [
                'type' => 'INT',
                'constraint' => 5,
            ],
            'bukti_pembayaran'   => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'sudah_bayar'      => [
                'type' => 'TINYINT',
                'constraint' => 1,
            ],
            'catatan'   => [
                'type'       => 'TEXT',
            ],
            'alamat_kirim'   => [
                'type'       => 'TEXT',
            ],
            'tanggal_mulai_sewa' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'is_deleted' => [
                'type'       => 'BOOLEAN',
                'default'    => false,
            ],
            'created_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'updated_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'deleted_at' => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('penyewa_id', 'penyewas', 'id');
        $this->forge->addForeignKey('tenda_id', 'tendas', 'id');
        $this->forge->createTable('pembayarans');
    }

    public function down()
    {
        {
            $this->forge->dropTable('pembayarans');
        }
    }
}
