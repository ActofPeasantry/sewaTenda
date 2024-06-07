<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
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
            'role_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'username'   => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'email'      => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'password'   => [
                'type'       => 'TEXT',
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
        $this->forge->addForeignKey('role_id', 'roles', 'id');
        $this->forge->createTable('users');
    }

    public function down()
    { {
            $this->forge->dropTable('users');
        }
    }
}
