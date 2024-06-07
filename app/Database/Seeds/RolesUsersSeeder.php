<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RolesUsersSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'kode' => 'ADM',
                'nama' => 'admin',
                'is_deleted' => 0,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode' => 'PNY',
                'nama' => 'penyewa',
                'is_deleted' => 0,
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Insert roles and fetch role IDs
        $roleIds = [];
        foreach ($roles as $role) {
            $this->db->table('roles')->insert($role);
            $roleIds[$role['kode']] = $this->db->insertID();
        }

        // Insert user data with role foreign keys
        $users = [
            [
                'username' => 'admin',
                'email' => 'admin@example.com',
                'role_id' => $roleIds['ADM'],
                'password' => password_hash(12345, PASSWORD_BCRYPT),
                'nik' => '123456789012346',
                'nama' => 'Admin Testing',
                'alamat' => 'Alamat Dari Admin Testing',
                'no_hp' => '08223456789012',
                'is_deleted' => 0,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'penyewa',
                'email' => 'penyewa@example.com',
                'role_id' => $roleIds['PNY'],
                'password' => password_hash(12345, PASSWORD_BCRYPT),
                'nik' => '123456789012345',
                'nama' => 'Penyewa Testing',
                'alamat' => 'Alamat Dari Penyewa Testing',
                'no_hp' => '08223456789012',
                'is_deleted' => 0,
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $userIds = [];
        foreach ($users as $user) {
            $this->db->table('users')->insert($user);
            $userIds[$user['email']] = $this->db->insertID();
        }

        // $penyewa = [
        //     [
        //         'user_id' => $userIds['penyewa@example.com'],
        //         'nik' => '123456789012345',
        //         'nama' => 'Penyewa Testing',
        //         'alamat' => 'Alamat Dari Penyewa Testing',
        //         'no_hp' => '08223456789012',
        //         'is_deleted' => 0,
        //         'created_at' => date('Y-m-d H:i:s'),
        //     ]
        // ];
        // $this->db->table('penyewas')->insertBatch($penyewa);
    }
}
