<?php

namespace App\Models;

use CodeIgniter\Model;

class Penyewa extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'username', 'email', 'password',
        'role_id', 'nik', 'nama',
        'alamat', 'no_hp', 'is_deleted'
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

    public function getPenyewa()
    {
        $this->select('users.*')->where(['users.role_id' => 2, 'users.is_deleted' => 0])->orderBy('users.id', 'asc');
        return $this;
    }

    // public function getPenyewaJumlahPembayaranProgress()
    // {
    //     $this->select('penyewas.*, (SELECT COUNT(*) FROM pembayarans WHERE pembayarans.sudah_bayar = 2) AS jumlah_pesanan')
    //         ->where('penyewas.is_deleted', 0)
    //         ->where('penyewas.id IN (SELECT pembayarans.penyewa_id FROM pembayarans WHERE pembayarans.sudah_bayar = 2 GROUP BY pembayarans.penyewa_id)')
    //         ->orderBy('penyewas.id', 'asc');

    //     return $this;
    // }

    public function getPenyewaJumlahPembayaranProgress()
    {
        // Start with the base query defined in getPenyewa()
        $this->getPenyewa();

        // Add the additional select for jumlah_pesanan
        $this->select('(SELECT COUNT(*) FROM pembayarans WHERE pembayarans.status_pembayaran = 2) AS jumlah_pesanan')
            ->where('users.id IN (SELECT pembayarans.user_id FROM pembayarans WHERE pembayarans.status_pembayaran = 2 GROUP BY pembayarans.user_id)');

        return $this;
    }

    // public function getPenyewaJumlahPembayaranApproved()
    // {
    //     $this->select('penyewas.*, (SELECT COUNT(*) FROM pembayarans WHERE pembayarans.sudah_bayar = 1) AS jumlah_pesanan');

    //     $this->where('penyewas.is_deleted', 0);

    //     $this->where('penyewas.id IN (SELECT pembayarans.penyewa_id FROM pembayarans WHERE pembayarans.sudah_bayar = 1 GROUP BY pembayarans.penyewa_id)');

    //     $this->orderBy('penyewas.id', 'asc');

    //     return $this;
    // }

    public function getPenyewaJumlahPembayaranApproved()
    {
        $this->getPenyewa();

        $this->select('(SELECT COUNT(*) FROM pembayarans WHERE pembayarans.status_pembayaran = 1) AS jumlah_pesanan')
            ->where('users.id IN (SELECT pembayarans.user_id FROM pembayarans WHERE pembayarans.status_pembayaran = 1 GROUP BY pembayarans.user_id)');

        return $this;
    }

    // public function getPenyewaJumlahPembayaranRejected()
    // {
    //     $this->getPenyewa();

    //     $this->select('penyewas.*, (SELECT COUNT(*) FROM pembayarans WHERE pembayarans.sudah_bayar = 0) AS jumlah_pesanan');

    //     $this->where('penyewas.is_deleted', 0);

    //     $this->where('penyewas.id IN (SELECT pembayarans.user_id FROM pembayarans WHERE pembayarans.sudah_bayar = 0 GROUP BY pembayarans.user_id)');

    //     $this->orderBy('penyewas.id', 'asc');

    //     return $this;
    // }

    public function getPenyewaJumlahPembayaranRejected()
    {
        // Start with the base query defined in getPenyewa()
        $this->getPenyewa();

        // Add the additional select for jumlah_pesanan
        $this->select('(SELECT COUNT(*) FROM pembayarans WHERE pembayarans.status_pembayaran = 0) AS jumlah_pesanan')
            ->where('users.id IN (SELECT pembayarans.user_id FROM pembayarans WHERE pembayarans.status_pembayaran = 2 GROUP BY pembayarans.user_id)');

        return $this;
    }

    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class, 'user_id', 'id');
    }
}
