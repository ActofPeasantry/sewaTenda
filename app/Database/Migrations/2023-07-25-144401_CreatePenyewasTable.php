<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePenyewasTable extends Migration
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
            'nik'   => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'nama'      => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'alamat'   => [
                'type'       => 'TEXT',
            ],
            'no_hp'      => [
                'type'       => 'VARCHAR',
                'constraint' => '14',
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
        $this->forge->createTable('penyewas');
    }

    public function down()
    {
        {
            $this->forge->dropTable('penyewas');
        }
    }
}
