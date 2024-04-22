<?php

namespace App\Models;

use CodeIgniter\Model;

class Penyewa extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'penyewas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['nik', 'nama', 'alamat', 'no_hp', 'user_id', 'is_deleted'];

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

    public function getPenyewa()
    {
        $this->select('penyewas.*');
        
        $this->where('penyewas.is_deleted', 0);

        $this->orderBy('penyewas.id', 'asc');

        return $this;
    }
   
    public function getPenyewaJumlahPembayaranProgress()
    {
        $this->select('penyewas.*, (SELECT COUNT(*) FROM pembayarans WHERE pembayarans.sudah_bayar = 2) AS jumlah_pesanan');
        
        $this->where('penyewas.is_deleted', 0);

        $this->where('penyewas.id IN (SELECT pembayarans.penyewa_id FROM pembayarans WHERE pembayarans.sudah_bayar = 2 GROUP BY pembayarans.penyewa_id)');

        $this->orderBy('penyewas.id', 'asc');

        return $this;
    }

    public function getPenyewaJumlahPembayaranApproved()
    {
        $this->select('penyewas.*, (SELECT COUNT(*) FROM pembayarans WHERE pembayarans.sudah_bayar = 1) AS jumlah_pesanan');
        
        $this->where('penyewas.is_deleted', 0);

        $this->where('penyewas.id IN (SELECT pembayarans.penyewa_id FROM pembayarans WHERE pembayarans.sudah_bayar = 1 GROUP BY pembayarans.penyewa_id)');

        $this->orderBy('penyewas.id', 'asc');

        return $this;
    }

    public function getPenyewaJumlahPembayaranRejected()
    {
        $this->select('penyewas.*, (SELECT COUNT(*) FROM pembayarans WHERE pembayarans.sudah_bayar = 0) AS jumlah_pesanan');
        
        $this->where('penyewas.is_deleted', 0);

        $this->where('penyewas.id IN (SELECT pembayarans.penyewa_id FROM pembayarans WHERE pembayarans.sudah_bayar = 0 GROUP BY pembayarans.penyewa_id)');

        $this->orderBy('penyewas.id', 'asc');

        return $this;
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class, 'penyewa_id', 'id');
    }
}
