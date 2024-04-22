<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTendasTable extends Migration
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
            'kategori_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'kode'   => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'nama'   => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'ukuran'         => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'harga'         => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'sisa'         => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
            ],
            'gambar'   => [
                'type'       => 'TEXT',
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
        $this->forge->addForeignKey('kategori_id', 'kategoris', 'id');
        $this->forge->createTable('tendas');
    }

    public function down()
    {
        {
            $this->forge->dropTable('tendas');
        }
    }
}
