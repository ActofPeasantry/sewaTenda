<?php

namespace App\Models;

use CodeIgniter\Model;

class Tenda extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['kode', 'nama', 'ukuran', 'harga', 'sisa', 'gambar', 'kategori_id', 'is_deleted'];

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


    public function getTendasWithKategoris()
    {
        // Select the columns from 'items' and alias the 'name' column from 'kategoris' as 'nama_kategori'
        $this->select('items.*, kategoris.nama AS nama_kategori, kategoris.kode AS kode_kategori');

        // Perform the join with the 'kategoris' table
        $this->join('kategoris', 'items.kategori_id = kategoris.id');

        // Filter the data where 'is_deleted' column is 0
        $this->where('items.is_deleted', 0);

        // Order the data by 'items.id' in ascending order
        $this->orderBy('items.id', 'asc');

        // Return the query builder object
        return $this;
    }

    public function kategoris()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }
    public function detailPembayarans()
    {
        return $this->belongsTo(detailPembayaran::class, 'item_id', 'id');
    }
}
