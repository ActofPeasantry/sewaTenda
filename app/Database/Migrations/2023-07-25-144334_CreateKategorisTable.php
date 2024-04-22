<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKategorisTable extends Migration
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
            'kode'   => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'nama'   => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
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
        $this->forge->createTable('kategoris');
    }

    public function down()
    {
        {
            $this->forge->dropTable('kategoris');
        }
    }
}
