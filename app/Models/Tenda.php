<?php

namespace App\Models;

use CodeIgniter\Model;

class Tenda extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tendas';
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
        // Select the columns from 'tendas' and alias the 'name' column from 'kategoris' as 'kategori_name'
        $this->select('tendas.*, kategoris.nama AS nama_kategori, kategoris.kode AS kode_kategori');

        // Perform the join with the 'kategoris' table
        $this->join('kategoris', 'tendas.kategori_id = kategoris.id');

        // Filter the data where 'is_deleted' column is 0
        $this->where('tendas.is_deleted', 0);

        // Order the data by 'tendas.id' in ascending order
        $this->orderBy('tendas.id', 'asc');

        // Perform the query and return the result
        return $this;
    }

    public function kategoris()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }
    public function detailPembayarans()
    {
        return $this->belongsTo(detailPembayaran::class, 'tenda_id', 'id');
    }
}
