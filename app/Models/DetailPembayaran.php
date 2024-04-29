<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailPembayaran extends Model
{

  protected $DBGroup = 'default';
  protected $table = 'detail_pembayarans';
  protected $primaryKey = 'id';
  protected $useAutoIncrement = true;
  protected $returnType       = 'array';
  protected $useSoftDeletes   = true;
  protected $protectFields    = true;
  protected $allowedFields = [
    'tenda_id',
    'pembayaran_id',
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
  //   $this->select('detail_pembayarans.*, pembayarans.*, 
  //       tendas.kode, tendas.nama, tendas.ukuran, tendas.harga, tendas.sisa, tendas.gambar, tendas.kategori_id')
  //     ->join('pembayarans', 'detail_pembayarans.pembayaran_id = pembayarans.id')
  //     ->join('tendas', 'detail_pembayarans.tenda_id = tendas.id')
  //     ->where('pembayarans.is_deleted', 0)
  //     ->whereIn('pembayarans.id', $pembayaranIdList)
  //     ->orderBy('pembayarans.bukti_pembayaran', 'asc')
  //     ->orderBy('pembayarans.id', 'asc');

  //   return $this;
  // }

  public function getDetailByPembayaranId($pembayaranId)
  {
    $this->select('detail_pembayarans.*, tendas.nama, tendas.ukuran, tendas.harga, tendas.kategori_id')
      ->join('tendas', 'detail_pembayarans.tenda_id = tendas.id')
      ->where('pembayaran_id', $pembayaranId);
    return $this;
  }

  public function pembayarans()
  {
    return $this->belongsTo(Pembayaran::class, 'pembayaran_id', 'id');
  }

  public function tendas()
  {
    return $this->hasMany(Tenda::class, 'tenda_id', 'id');
  }
}
