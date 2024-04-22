<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User;
use App\Models\Penyewa;
use App\Models\Role;

class UserController extends BaseController
{
    public function index()
    {
        $userModel = new User();
        $userList = $userModel->getUserRoleAdmin()->get()->getResultArray();

        $data = [
        'headerTitle' => 'User',
        'navUserActive' => 'active',
        'breadcrumbLink' => '<a href="/dashboard">Dashboard</a>',
        'userList' => $userList
       ];
        return view('user/index-user', $data);
    }
    public function registerUpdateAccountView()
    {
        $data = ['cardReload' => '',
        'headerTitle' => 'Pendaftaran',
        'cardAlignment' => 'text-center',
        'breadcrumbLink' => session()->get('user')?'<a href="/catalog">Catalog</a>':'<a href="/login">Login</a>'
       ];

       if(session()->get('user') && session()->get('role') && session()->get('penyewa') ){
        $data += ['nik' => session()->get('penyewa')['nik'],
        'nama' => session()->get('penyewa')['nama'],
        'noHp' => session()->get('penyewa')['no_hp'],
        'alamat' => session()->get('penyewa')['alamat'],
        'username' => session()->get('user')['username'],
        'email' => session()->get('user')['email'],
        'userId' => session()->get('user')['id'],
        'penyewaId' => session()->get('penyewa')['id'],
        'action' => 'edit',
        ];
       }else{
        $data += ['action' => 'add'];
       }
        return view('user/register-update-account', $data);
    }

    public function registerUpdateAccount()
    {
        $roleModel = new Role();
        $userModel = new User();
        $penyewaModel = new Penyewa();

        $role = $roleModel->where('kode', 'PNY')->first();
        $roleId = null;

        if(!$role){
            $roleModel->insert([
                'kode' => 'PNY', 
                'nama' => 'Penyewa', 
                'is_delete' => 0]);
            
            $roleId = $roleModel->insertID();
        }else{
            $roleId = $role['id'];
        }
        
        $userRequest = [
            'role_id' =>  $roleId,
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'is_delete' => 0
        ];
        $penyewaRequest = [
            'nik' => $this->request->getPost('nik'),
            'nama' => $this->request->getPost('nama'),
            'alamat' => $this->request->getPost('alamat'),
            'no_hp' => $this->request->getPost('noHp'),
            'is_delete' => 0
        ];

        if($this->request->getPost('action') == 'add'){

            $user = $userModel->where('email', $this->request->getPost('email'))->first();
            $penyewa = $penyewaModel->where('nik', $this->request->getPost('nik'))->first();

            if($user){
                return redirect()->back()->with('error', 'Email Sudah Ada');
            }

            if($penyewa){
                return redirect()->back()->with('error', 'NIK Sudah Ada');
            }

            $userModel->insert($userRequest);
            $penyewaRequest['user_id'] =  $userModel->insertID();
            $penyewaModel->insert($penyewaRequest);
        }

        if($this->request->getPost('action') == 'edit'){

            $penyewa = $penyewaModel->where('nik', $this->request->getPost('nik'))->first();
            
            if($penyewa && $penyewa['id']!=(int)$this->request->getPost('penyewaId')){
                return redirect()->back()->with('error', 'NIK Sudah Ada');
            }

            $user = $userModel->where('email', $this->request->getPost('email'))->first();

            if ($user && $user['id'] != $this->request->getPost('id')){
                return redirect()->back()->with('error', 'Email Sudah Ada');
            }
            
            $userModel->update((int)$this->request->getPost('userId'), $userRequest);
            $penyewaModel->update((int)$this->request->getPost('penyewaId'), $penyewaRequest);
        }


       return redirect()->to('/login')->with('success', 'Pendaftaran Berhasil');
    }

    public function addEditUserView()
    {
        $data = [
            'headerTitle' => 'User',
            'navUserActive' => 'active',
            'cardAlignment' => 'text-center',
            'breadcrumbLink' => '<a href="/user">Back</a>',
        ];

        if($this->request->getPost('action') == 'add'){
            $data+=[
                'action' => 'add'
            ];
        }else{
            $userModel = new User();
            $user = $userModel->find($this->request->getPost('userId'));
            $data+=[
                'action' => 'edit',
                'userId' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
            ];
        }

        return view('user/add-edit-user', $data);
    }

    public function addEditUser()
    {
        $userModel = new User();
        $roleModel = new Role();

        $role = $roleModel->where('kode', 'ADM')->first();

        $userRequest = [
            'role_id' =>  $role['id'],
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'is_delete' => 0
        ];

        if($this->request->getPost('action') == 'add'){

            $user = $userModel->where('email', $this->request->getPost('email'))->first();

            if($user){
                return redirect()->to('/user')->with('error', 'Email Sudah Ada');
            }

            $userModel->insert($userRequest);

        }else{

            $user = $userModel->where('email', $this->request->getPost('email'))->first();

            if ($user && $user['id'] != $this->request->getPost('id')){
                return redirect()->to('/user')->with('error', 'Email Sudah Ada');
            }

            $userModel->update((int)$this->request->getPost('userId'), $userRequest);
        }
        
        return redirect()->to('/user')->with('success', 'Perubahan Data User Berhasil');
    }

    public function delete($id)
    {
       $userModel = new User();

       $user = $userModel->find($id);
       $user['is_deleted'] = 1;

       $userModel->update($user['id'], $user);

       $userModel->delete($user['id']);
       return redirect()->to('/user')->with('success', 'Data User Berhasil Dihapus');
    }
}
