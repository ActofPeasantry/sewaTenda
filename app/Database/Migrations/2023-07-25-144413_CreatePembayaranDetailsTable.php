<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePembayaranDetailsTable extends Migration
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
            'tenda_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'pembayaran_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'jumlah_tenda'   => [
                'type' => 'INT',
                'constraint' => 5,
            ],
            'lama_sewa'      => [
                'type' => 'INT',
                'constraint' => 5,
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
        $this->forge->addForeignKey('pembayaran_id', 'pembayarans', 'id');
        $this->forge->addForeignKey('tenda_id', 'tendas', 'id');
        $this->forge->createTable('detail_pembayarans');
    }

    public function down()
    {
        //
    }
}
