<?php

namespace App\Models;

use CodeIgniter\Model;

class Invoice extends Model
{
  protected $DBGroup = 'default';
  protected $table = 'invoices';
  protected $primaryKey = 'id';
  protected $useAutoIncrement = true;
  protected $returnType       = 'array';
  protected $useSoftDeletes   = true;
  protected $protectFields    = true;
  protected $allowedFields    = [
    'bukti_pembayaran', 'bukti_pembayaran_dp', 'transaction_id'
  ];
}
