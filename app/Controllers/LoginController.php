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

    public function forgotPasswordView()
    {

        $data = [
            'cardReload' => '',
            'headerTitle' => 'Forgot Password',
            'cardAlignment' => 'text-center',
            'breadcrumbLink' => '<a href="/catalog">Catalog</a>'
        ];
        return view('forgot-password', $data);
    }

    public function submitForgotPassword()
    {
        $data = [
            'cardReload' => '',
            'headerTitle' => 'Forgot Password',
            'cardAlignment' => 'text-center',
            'breadcrumbLink' => '<a href="/catalog">Catalog</a>'
        ];

        $email = $this->request->getPost('email');
        $userModel = new User();
        $userData = $userModel->verifyEmail($email);
        // var_dump(!empty($userData));
        if (!empty($userData)) {
            $to = $email;
            $subject = 'Reset Password';
            $token = $userData[0]['id'];
            $message = 'Hello ' . $userData[0]['username'] . ',<br><br> Click the link dibawah untuk me-reset password anda:<br> <a href="' . base_url() . '/reset-password/' . $token . '">Reset Password</a>';
            $email = \Config\Services::email();
            $email->setTo($to);
            $email->setFrom('sewatendawahyukhan@gmail.com', 'Admin');
            $email->setMessage($message);
            $email->setSubject($subject);
            if ($email->send()) {
                return redirect()->back()->with('success', 'Email reset password terkirim');
            } else {
                return redirect()->back()->with('error', 'Email reset password gagal dikirim');
            }
        } else {
            return redirect()->back()->with('error', 'Email tidak ditemukan');
        }
        return view('forgot-password', $data);
    }

    public function resetPasswordView($token)
    {
        $userModel = new User();

        if (!empty($token)) {
            $userData = $userModel->verrifyToken($token);
            if (!empty($userData)) {
                $data = [
                    'cardReload' => '',
                    'headerTitle' => 'Reset Password',
                    'cardAlignment' => 'text-center',
                    'breadcrumbLink' => '<a href="/catalog">Catalog</a>',
                ];
                return view('reset-password', $data);
            }
        }
        $data = [
            'cardReload' => '',
            'headerTitle' => 'Forgot Password',
            'cardAlignment' => 'text-center',
            'breadcrumbLink' => '<a href="/catalog">Catalog</a>',
            'error' => 'Unable to find user',
        ];
        return view('forgot-password', $data);
    }
}
