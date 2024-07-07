<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInvoicesTable extends Migration
{
  public function up()
  {
    $this->forge->addField([
      'id' => [
        'type' => 'INT',
        'constraint' => 5,
        'unsigned' => true,
        'auto_increment' => true,
      ],
      'transaction_id' => [
        'type' => 'INT',
        'constraint' => 5,
        'unsigned' => true,
      ],
      'bukti_pembayaran'   => [
        'type'       => 'TEXT',
        'null'       => true,
      ],
      'bukti_pembayaran_dp'   => [
        'type'       => 'TEXT',
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
    $this->forge->addForeignKey('transaction_id', 'transactions', 'id');
    $this->forge->createTable('invoices');
  }

  public function down()
  {
    $this->forge->dropTable('invoices');
  }
}
