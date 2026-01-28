<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/account');
        }

        $data = [
            'title' => 'Login - Cychez Store',
        ];

        return view('account/login', $data);
    }

    public function loginPost()
    {
        $validation = \Config\Services::validation();
        $validation->setRules(config('Validation')->login);

        if (!$this->validate($validation->getRules())) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $userModel = new UserModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        if ($userModel->verifyPassword($email, $password)) {
            $user = $userModel->findByEmail($email);

            if (!$user['is_active']) {
                session()->setFlashdata('error', 'Your account has been deactivated.');
                return redirect()->back();
            }

            $sessionData = [
                'user_id'    => $user['id'],
                'email'      => $user['email'],
                'first_name' => $user['first_name'],
                'last_name'  => $user['last_name'],
                'role'       => $user['role'],
                'logged_in'  => true,
            ];

            session()->set($sessionData);

            // After: session()->set($sessionData);

            // Migrate session cart to database
            helper('cart');
            $sessionCart = session()->get('cart');
            if ($sessionCart && !empty($sessionCart)) {
                $cartModel = new \App\Models\CartModel();
                foreach ($sessionCart as $item) {
                    $cartModel->addToCart($user['id'], $item['id'], $item['quantity']);
                }
                session()->remove('cart'); // Clear session cart
            }

            if ($user['role'] === 'admin') {
                return redirect()->to('/admin/dashboard');
            }

            return redirect()->to('/account');
        }

        session()->setFlashdata('error', 'Invalid email or password.');
        return redirect()->back()->withInput();
    }

    public function register()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/account');
        }

        $data = [
            'title' => 'Register - Cychez Store',
        ];

        return view('account/register', $data);
    }

    public function registerPost()
    {
        $validation = \Config\Services::validation();
        $validation->setRules(config('Validation')->signup);

        if (!$this->validate($validation->getRules())) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $userModel = new UserModel();

        $userData = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name'  => $this->request->getPost('last_name'),
            'email'      => $this->request->getPost('email'),
            'phone'      => $this->request->getPost('phone'),
            'password'   => $this->request->getPost('password'),
            'role'       => 'customer',
            'is_active'  => 1,
        ];

        if ($userModel->insert($userData)) {
            session()->setFlashdata('success', 'Registration successful! Please login.');
            return redirect()->to('/login');
        }

        session()->setFlashdata('error', 'Registration failed. Please try again.');
        return redirect()->back()->withInput();
    }

    public function logout()
    {
        session()->destroy();
        session()->setFlashdata('success', 'You have been logged out successfully.');
        return redirect()->to('/');
    }
}