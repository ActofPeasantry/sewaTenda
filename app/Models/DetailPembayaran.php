<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailPembayaran extends Model
{

  protected $DBGroup = 'default';
  protected $table = 'transaction_details';
  protected $primaryKey = 'id';
  protected $useAutoIncrement = true;
  protected $returnType       = 'array';
  protected $useSoftDeletes   = true;
  protected $protectFields    = true;
  protected $allowedFields = [
    'item_id',
    'transaction_id',
    'jumlah_tenda',
    'lama_sewa',
    'is_deleted',
  ];

  // Dates
  protected $useTimestamps = true;
  protected $dateFormat    = 'datetime';
  protected $createdField  = 'created_at';
  protected $updatedField  = 'updated_at';
  protected $deletedField  = 'deleted_at';

  // Validation
  protected $validationRules      = [];
  protected $validationMessages   = [];
  protected $skipValidation       = false;
  protected $cleanValidationRules = true;

  // Callbacks
  protected $allowCallbacks = true;
  protected $beforeInsert   = [];
  protected $afterInsert    = [];
  protected $beforeUpdate   = [];
  protected $afterUpdate    = [];
  protected $beforeFind     = [];
  protected $afterFind      = [];
  protected $beforeDelete   = [];
  protected $afterDelete    = [];

  // public function getPembayaranByPembayaranIdList($pembayaranIdList)
  // {
  //   $this->select('transaction_details.*, transactions.*, 
  //       items.kode, items.nama, items.ukuran, items.harga, items.sisa, items.gambar, items.kategori_id')
  //     ->join('transactions', 'transaction_details.transaction_id = transactions.id')
  //     ->join('items', 'transaction_details.item_id = items.id')
  //     ->where('transactions.is_deleted', 0)
  //     ->whereIn('transactions.id', $pembayaranIdList)
  //     ->orderBy('transactions.bukti_pembayaran', 'asc')
  //     ->orderBy('transactions.id', 'asc');

  //   return $this;
  // }

  public function getDetailByPembayaranId($pembayaranId)
  {
    $this->select('transaction_details.*, items.nama, items.ukuran, items.harga, items.kategori_id')
      ->join('items', 'transaction_details.item_id = items.id')
      ->where('transaction_id', $pembayaranId);
    return $this;
  }

  public function transactions()
  {
    return $this->belongsTo(Pembayaran::class, 'transaction_id', 'id');
  }

  public function items()
  {
    return $this->hasMany(Tenda::class, 'item_id', 'id');
  }
}
