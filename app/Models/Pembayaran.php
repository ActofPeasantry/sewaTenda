<?php

namespace App\Models;

use CodeIgniter\Model;

class Pembayaran extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'transactions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'tanggal_pembayaran', 'is_deleted', 'jumlah_tenda', 'pakai_dp',
        'status_pembayaran', 'status_lunas', 'catatan',
        'alamat_kirim', 'tanggal_mulai_sewa', 'user_id', 'item_id'
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


    public function getUnpaidPembayaran($penyewaId)
    {
        $this->select('transactions.*')
            ->where([
                'transactions.is_deleted' => 0,
                'transactions.user_id' => $penyewaId,
                'transactions.tanggal_pembayaran' => NULL,
                'transactions.status_pembayaran' => 3,
            ])
            ->orderBy('transactions.id', 'asc');
        return $this;
    }

    // Tampered
    public function getPaidPembayaran($penyewaId)
    {
        $this->select('transactions.*, invoices.*')
            ->where('transactions.is_deleted', 0)
            ->join('invoices', 'transactions.id = invoices.transaction_id')
            ->where('transactions.user_id', $penyewaId)
            ->where('tanggal_pembayaran IS NOT NULL')
            ->groupStart()
            ->where('invoices.bukti_pembayaran IS NOT NULL')
            ->orWhere('invoices.bukti_pembayaran_dp IS NOT NULL')
            ->groupEnd()
            // ->where('status_pembayaran', 2)
            ->orderBy('transactions.id', 'asc');

        return $this;
    }

    public function getPembayaranCost($penyewaId, $arePaid)
    {
        if ($arePaid === true) {
            // Get unpaid pembayaran for the given penyewaId
            $getPembayarans = $this->getPaidPembayaran($penyewaId)->get()->getResultArray();
        } else {
            // Get unpaid pembayaran for the given penyewaId
            $getPembayarans = $this->getUnpaidPembayaran($penyewaId)->get()->getResultArray();
        }


        if (!empty($getPembayarans)) {
            $total_cost_data = [];
            foreach ($getPembayarans as $getPembayaran) {
                // Retrieve the first unpaid pembayaran ID
                $pembayaranId = $getPembayaran['id'];

                // Initialize DetailPembayaran model
                $getDetails = new DetailPembayaran();

                // Perform join with 'items' table
                $getCosts = $getDetails
                    ->select('transaction_details.*, items.harga') // Select desired columns
                    ->join('items', 'transaction_details.item_id = items.id') // Join 'items' table
                    ->where('transaction_details.transaction_id', $pembayaranId) // Filter by transaction_id
                    ->get()
                    ->getResultArray();

                // Calculate total cost based on retrieved data
                $total_cost = 0;
                foreach ($getCosts as $cost) {
                    $total_cost += $cost['lama_sewa'] * $cost['jumlah_tenda'] * $cost['harga'];
                }
                array_push($total_cost_data, $total_cost);
            }
            return $total_cost_data;
        }
        return 0; // Return 0 if no unpaid pembayaran found
    }

    public function getPembayaranBelumBayarWithTenda($penyewaId)
    {
        $this->select('transactions.*, invoices.*, items.kode, items.nama, items.ukuran, items.harga, items.sisa, items.gambar, items.kategori_id');
        $this->join('invoices', 'transactions.id = invoices.transaction_id');
        $this->join('items', 'transactions.item_id = items.id');

        $this->where('transactions.is_deleted', 0);
        $this->where('transactions.user_id', $penyewaId);

        $this->where('tanggal_pembayaran IS NULL');
        $this->where('bukti_pembayaran IS NULL');

        $this->orderBy('transactions.id', 'asc');

        return $this;
    }

    public function getPembayaranWithTendaByPenyewaAndStatus($penyewaId, $status)
    {
        $this->select('transactions.*, items.*')
            ->join('items', 'transaction_details.item_id = items.id')
            ->where([
                'transaction_details.is_deleted' => 0,
                'transactions.user_id' => $penyewaId,
                'transactions.status_pembayaran' => $status
            ])
            ->orderBy('transactions.bukti_pembayaran', 'asc')
            ->orderBy('transactions.id', 'asc');

        return $this;
    }

    // My TAMPERING
    public function getPembayaranByPenyewaAndStatus($penyewaId, $status)
    {
        $this->select('transactions.*, invoices.*')
            ->join('invoices', 'invoices.transaction_id = transactions.id')
            ->where([
                'transactions.is_deleted' => 0,
                'transactions.user_id' => $penyewaId,
                'transactions.status_pembayaran' => $status,
            ])
            ->orderBy('invoices.bukti_pembayaran', 'asc')
            ->orderBy('transactions.id', 'asc');
        return $this;
    }
    public function getPembayaranCostByPenyewaAndStatus($penyewaId, $status)
    {
        // Get paid pembayaran with status for the given penyewaId
        $getPembayarans = $this->getPembayaranByPenyewaAndStatus($penyewaId, $status)->get()->getResultArray();

        if (!empty($getPembayarans)) {
            $total_cost_data = [];
            foreach ($getPembayarans as $getPembayaran) {
                // Retrieve the first unpaid pembayaran ID
                $pembayaranId = $getPembayaran['id'];

                // Initialize DetailPembayaran model
                $getDetails = new DetailPembayaran();

                // Perform join with 'items' table
                $getCosts = $getDetails
                    ->select('transaction_details.*, items.harga') // Select desired columns
                    ->join('items', 'transaction_details.item_id = items.id') // Join 'items' table
                    ->where(['transaction_details.transaction_id' => $pembayaranId])
                    ->get()
                    ->getResultArray();

                // Calculate total cost based on retrieved data
                $total_cost = 0;
                foreach ($getCosts as $cost) {
                    $total_cost += $cost['lama_sewa'] * $cost['jumlah_tenda'] * $cost['harga'];
                }
                array_push($total_cost_data, $total_cost);
            }
            return $total_cost_data;
        }
        return 0; // Return 0 if no unpaid pembayaran found
    }
    // END OF MY TAMPERING
    public function getPembayaranByPembayaranIdList($pembayaranIdList)
    {
        // Initialize DetailPembayaran model
        $getDetails = new DetailPembayaran();

        $getDetails->select('transactions.*, invoices.*, transaction_details.*, 
        items.*')
            ->join('transactions', 'transaction_details.transaction_id = transactions.id')
            ->join('items', 'transaction_details.item_id = items.id')
            ->where('transaction_details.is_deleted', 0)
            ->whereIn('transactions.id', $pembayaranIdList)
            ->orderBy('invoices.bukti_pembayaran', 'asc')
            ->orderBy('transactions.id', 'asc');

        return $getDetails;
    }

    // Tampered
    public function getPembayaranByStatus($status)
    {
        // Initialize DetailPembayaran model
        $getDetails = new DetailPembayaran();

        $getDetails->select('
            transaction_details.*, transactions.*, items.nama AS nama_tenda, items.harga AS harga_tenda, users.nama AS nama_penyewa,
        ')
            ->join('transactions', 'transaction_details.transaction_id = transactions.id')
            ->join('items', 'transaction_details.item_id = items.id')
            ->join('users', 'transactions.user_id = users.id')
            ->where(['transactions.is_deleted' => 0, 'transactions.status_pembayaran' => $status])
            ->orderBy('transactions.id', 'desc');

        return $getDetails;
    }


    public function detailPembayarans()
    {
        return $this->hasMany(detailPembayaran::class, 'transaction_id', 'id');
    }

    public function users()
    {
        return $this->belongsTo(Penyewa::class, 'user_id', 'id');
    }
}
