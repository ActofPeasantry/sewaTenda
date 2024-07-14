<?php

namespace App\Models;

use CodeIgniter\Model;

class User extends Model
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

    public function getUserRoleAdmin()
    {
        $this->select('users.*');

        $this->join('roles', 'users.role_id = roles.id');

        $this->where('users.is_deleted', 0);

        $this->where('roles.kode', 'ADM');

        $this->orderBy('users.id', 'asc');

        return $this;
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function penyewas()
    {
        return $this->hasMany(Penyewa::class, 'user_id', 'id');
    }

    public function verifyEmail($email)
    {
        $result = $this->select('users.*')->where('email', $email)->where('is_deleted', 0)->get();
        return $result->getResultArray();
    }

    public function verrifyToken($id)
    {
        $result = $this->select('users.*')->where('id', $id)->where('is_deleted', 0)->get();
        return $result->getResultArray();
    }
}
