<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User;
use App\Models\Penyewa;
use App\Models\Role;

class LoginController extends BaseController
{
    public function index()
    {
        $data = [
            'cardReload' => '',
            'headerTitle' => 'Login',
            'cardAlignment' => 'text-center',
            'breadcrumbLink' => '<a href="/catalog">Catalog</a>'
        ];

        if (session()->get('user')) {
            if (session()->get('role')['kode'] == 'PNY') {
                return redirect()->to('/catalog');
            }
            return redirect()->to('/dashboard');
        } else {
            return view('login', $data);
        }
    }

    public function login()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $roleModel = new Role();
        $userModel = new User();
        // $penyewaModel = new Penyewa();

        $user = $userModel->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {

            $role = $roleModel->find($user['role_id']);
            // $penyewa = $penyewaModel->where('user_id', $user['id'])->first();
            // User authenticated, store user info in session
            session()->set('user', $user);
            session()->set('role', $role);
            // session()->set('penyewa', $penyewa);

            if ($role['kode'] == 'PNY') {
                return redirect()->to('/catalog');
            }
            return redirect()->to('/dashboard');
        } else {
            // Invalid credentials, show error message
            return redirect()->back()->with('error', 'Invalid email or password');
        }
    }

    public function logout()
    {
        // Destroy the session and redirect to the login page
        session()->destroy();
        return redirect()->to('/login');
    }
}
