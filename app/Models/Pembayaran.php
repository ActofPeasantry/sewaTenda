<?php

namespace App\Models;

use CodeIgniter\Model;

class Pembayaran extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'pembayarans';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['tanggal_pembayaran', 'is_deleted', 'lama_sewa', 'jumlah_tenda', 'bukti_pembayaran', 'sudah_bayar', 'catatan', 'alamat_kirim', 'tanggal_mulai_sewa', 'penyewa_id', 'tenda_id'];

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

    public function getPembayaranBelumBayarWithTenda($penyewaId)
    {
        $this->select('pembayarans.*, tendas.kode, tendas.nama, tendas.ukuran, tendas.harga, tendas.sisa, tendas.gambar, tendas.kategori_id');

        $this->join('tendas', 'pembayarans.tenda_id = tendas.id');
        
        $this->where('pembayarans.is_deleted', 0);
        $this->where('pembayarans.penyewa_id', $penyewaId);

        $this->where('tanggal_pembayaran IS NULL');
        $this->where('bukti_pembayaran IS NULL');

        $this->orderBy('pembayarans.id', 'asc');

        return $this;
    }

    public function getPembayaranSudahBayarWithTenda($penyewaId)
    {
        $this->select('pembayarans.*, tendas.kode, tendas.nama, tendas.ukuran, tendas.harga, tendas.sisa, tendas.gambar, tendas.kategori_id');

        $this->join('tendas', 'pembayarans.tenda_id = tendas.id');
        
        $this->where('pembayarans.is_deleted', 0);
        $this->where('pembayarans.penyewa_id', $penyewaId);

        $this->where('tanggal_pembayaran IS NOT NULL');
        $this->where('bukti_pembayaran IS NOT NULL');

        $this->orderBy('pembayarans.id', 'asc');

        return $this;
    }

    public function getPembayaranWithTendaByPenyewaAndStatus($penyewaId, $status)
    {
        $this->select('pembayarans.*, tendas.kode, tendas.nama, tendas.ukuran, tendas.harga, tendas.sisa, tendas.gambar, tendas.kategori_id');

        $this->join('tendas', 'pembayarans.tenda_id = tendas.id');
        
        $this->where('pembayarans.is_deleted', 0);
        
        $this->where('pembayarans.penyewa_id', $penyewaId);

        $this->where('pembayarans.sudah_bayar', $status);

        $this->orderBy('pembayarans.bukti_pembayaran', 'asc');
        $this->orderBy('pembayarans.id', 'asc');

        return $this;
    }

    public function getPembayaranByPembayaranIdList($pembayaranIdList)
    {
        $this->select('pembayarans.*, tendas.kode, tendas.nama, tendas.ukuran, tendas.harga, tendas.sisa, tendas.gambar, tendas.kategori_id');

        $this->join('tendas', 'pembayarans.tenda_id = tendas.id');
        
        $this->where('pembayarans.is_deleted', 0);

        $this->whereIn('pembayarans.id', $pembayaranIdList);

        $this->orderBy('pembayarans.bukti_pembayaran', 'asc');
        $this->orderBy('pembayarans.id', 'asc');

        return $this;
    }

    public function getPembayaranByStatus($status)
    {
        $this->select('pembayarans.*, tendas.nama AS nama_tenda, tendas.harga AS harga_tenda, penyewas.nama AS nama_penyewa, ');

        $this->join('tendas', 'pembayarans.tenda_id = tendas.id');
        $this->join('penyewas', 'pembayarans.penyewa_id = penyewas.id');
        
        $this->where('pembayarans.is_deleted', 0);
        $this->where('pembayarans.sudah_bayar', $status);

        $this->orderBy('pembayarans.bukti_pembayaran', 'asc');
        $this->orderBy('pembayarans.id', 'asc');

        return $this;
    }

    public function penyewas()
    {
        return $this->belongsTo(Penyewa::class, 'penyewa_id', 'id');
    }
    public function tendas()
    {
        return $this->belongsTo(Tenda::class, 'tenda_id', 'id');
    }
}
