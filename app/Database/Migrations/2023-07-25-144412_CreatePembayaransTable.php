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
            'user_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'tanggal_pembayaran'   => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'bukti_pembayaran'   => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'pakai_dp'      => [
                'type' => 'BOOLEAN',
            ],
            'bukti_pembayaran_dp'   => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'status_pembayaran'      => [
                'type' => 'TINYINT',
                'constraint' => 1,
            ],
            'status_lunas'      => [
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
        $this->forge->addForeignKey('user_id', 'users', 'id');
        $this->forge->createTable('transactions');
    }

    public function down()
    { {
            $this->forge->dropTable('transactions');
        }
    }
}
