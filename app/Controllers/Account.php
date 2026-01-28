<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\UserModel;
use App\Models\WishlistModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Account extends BaseController
{
    protected $helpers = ['cart'];
    public function dashboard()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $orderModel = new OrderModel();
        $userId = session()->get('user_id');

        try {
            $recentOrders = $orderModel->getUserOrders($userId);
        } catch (\Exception $e) {
            log_message('error', 'Dashboard error: ' . $e->getMessage());
            $recentOrders = [];
        }

        $data = [
            'title' => 'My Account - Cychez Store',
            'recentOrders' => array_slice($recentOrders, 0, 5),
            'shopHeader' => true,
            'hideHeader' => true,
            'hideFooter' => false,
            'accountPage' => true,
        ];

        return view('account/index', $data);
    }

    public function tab(string $tab)
    {
        // Load helpers
        helper(['cart']);
        
        // Set JSON response type at the very beginning
        $this->response->setContentType('application/json');
        
        if (!session()->get('logged_in')) {
            return $this->response->setStatusCode(401)->setJSON([
                'success' => false,
                'error' => 'Unauthorized',
                'csrf_token' => csrf_hash()
            ]);
        }

        // Check if it's an AJAX request
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'error' => 'Bad Request - AJAX required',
                'csrf_token' => csrf_hash()
            ]);
        }

        $userId = session()->get('user_id');

        try {
            $content = '';
            
            switch ($tab) {
                case 'dashboard':
                    $orderModel = new OrderModel();
                    $recentOrders = $orderModel->getUserOrders($userId);
                    
                    $content = view('account/tabs/dashboard', [
                        'recentOrders' => array_slice($recentOrders, 0, 5)
                    ]);
                    break;

                case 'orders':
                    $orderModel = new OrderModel();
                    $orders = $orderModel->getUserOrders($userId);
                    
                    $content = view('account/tabs/orders', [
                        'orders' => $orders
                    ]);
                    break;

                case 'profile':
                    $userModel = new UserModel();
                    $user = $userModel->find($userId);
                    
                    if (!$user) {
                        throw new \Exception('User not found');
                    }
                    
                    $content = view('account/tabs/profile', [
                        'user' => $user
                    ]);
                    break;

                case 'wishlist':
                    $wishlistModel = new WishlistModel();
                    $wishlist = $wishlistModel->getUserWishlist($userId);
                    
                    $content = view('account/tabs/wishlist', [
                        'wishlist' => $wishlist
                    ]);
                    break;

                case 'tracking':
                    $content = view('account/tabs/tracking');
                    break;

                default:
                    return $this->response->setStatusCode(404)->setJSON([
                        'success' => false,
                        'error' => 'Tab not found',
                        'csrf_token' => csrf_hash()
                    ]);
            }
            
            return $this->response
                ->setHeader('X-CSRF-TOKEN', csrf_hash())
                ->setJSON([
                    'success' => true,
                    'content' => $content,
                    'csrf_token' => csrf_hash()
                ]);
                
        } catch (\Exception $e) {
            log_message('error', 'Tab loading error (' . $tab . '): ' . $e->getMessage());
            log_message('error', 'Stack trace: ' . $e->getTraceAsString());
            
            return $this->response
                ->setStatusCode(500)
                ->setJSON([
                    'success' => false,
                    'error' => 'Failed to load content. Please try again.',
                    'message' => ENVIRONMENT === 'development' ? $e->getMessage() : 'Internal server error',
                    'csrf_token' => csrf_hash()
                ]);
        }
    }

    // Add this new method for viewing order details
    public function viewOrder($orderId)
    {
        // Load helpers
        helper(['currency', 'form']);
        
        // Set JSON response type
        $this->response->setContentType('application/json');
        
        if (!session()->get('logged_in')) {
            return $this->response->setStatusCode(401)->setJSON([
                'success' => false,
                'error' => 'Unauthorized',
                'csrf_token' => csrf_hash()
            ]);
        }

        // Check if it's an AJAX request
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'error' => 'Bad Request - AJAX required',
                'csrf_token' => csrf_hash()
            ]);
        }

        $userId = session()->get('user_id');

        try {
            $orderModel = new OrderModel();
            $order = $orderModel->getOrderWithItems($orderId);

            if (!$order) {
                throw new \Exception('Order not found');
            }

            if ($order['user_id'] != $userId) {
                throw new \Exception('Unauthorized access to order');
            }

            $content = view('account/tabs/order_detail', ['order' => $order]);
            
            return $this->response
                ->setHeader('X-CSRF-TOKEN', csrf_hash())
                ->setJSON([
                    'success' => true,
                    'content' => $content,
                    'csrf_token' => csrf_hash()
                ]);
                
        } catch (\Exception $e) {
            log_message('error', 'View order error: ' . $e->getMessage());
            
            return $this->response
                ->setStatusCode(500)
                ->setJSON([
                    'success' => false,
                    'error' => 'Failed to load order details.',
                    'message' => ENVIRONMENT === 'development' ? $e->getMessage() : 'Internal server error',
                    'csrf_token' => csrf_hash()
                ]);
        }
    }

    public function orderDetail($orderId)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        try {
            $orderModel = new OrderModel();
            $order = $orderModel->getOrderWithItems($orderId);

            if (!$order) {
                throw new \Exception('Order not found');
            }

            if ($order['user_id'] != session()->get('user_id')) {
                throw new \Exception('Unauthorized access to order');
            }

            $data = [
                'title' => 'Order Details - ' . $order['order_number'],
                'order' => $order,
                'shopHeader' => true,
            ];

            return view('account/order_detail', $data);
            
        } catch (\Exception $e) {
            log_message('error', 'Order detail error: ' . $e->getMessage());
            session()->setFlashdata('error', 'Order not found or you do not have permission to view it.');
            return redirect()->to('/account');
        }
    }

    public function updateProfile()
    {
        log_message('info', 'Profile update request received');
        log_message('info', 'Is AJAX: ' . ($this->request->isAJAX() ? 'yes' : 'no'));
        
        if (!session()->get('logged_in')) {
            if ($this->request->isAJAX()) {
                return $this->response
                    ->setStatusCode(200)
                    ->setContentType('application/json')
                    ->setJSON([
                        'success' => false,
                        'message' => 'Please login to update profile',
                        'csrf_token' => csrf_hash()
                    ]);
            }
            return redirect()->to('/login');
        }

        $validation = \Config\Services::validation();

        $rules = [
            'first_name' => 'required|min_length[2]',
            'last_name' => 'required|min_length[2]',
            'phone' => 'required|min_length[10]',
        ];

        if (!$this->validate($rules)) {
            log_message('error', 'Validation failed: ' . json_encode($validation->getErrors()));
            
            if ($this->request->isAJAX()) {
                return $this->response
                    ->setStatusCode(200)
                    ->setContentType('application/json')
                    ->setJSON([
                        'success' => false,
                        'errors' => $validation->getErrors(),
                        'message' => 'Validation failed',
                        'csrf_token' => csrf_hash()
                    ]);
            }
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $userModel = new UserModel();
        $userId = session()->get('user_id');

        $updateData = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'city' => $this->request->getPost('city'),
            'state' => $this->request->getPost('state'),
            'country' => $this->request->getPost('country'),
            'postal_code' => $this->request->getPost('postal_code'),
        ];

        log_message('info', 'Attempting to update user: ' . $userId);
        log_message('info', 'Update data: ' . json_encode($updateData));

        try {
            $result = $userModel->update($userId, $updateData);
            log_message('info', 'Update result: ' . ($result ? 'success' : 'failed'));
            
            if ($result) {
                // Update session data
                session()->set([
                    'first_name' => $updateData['first_name'],
                    'last_name' => $updateData['last_name'],
                ]);

                if ($this->request->isAJAX()) {
                    return $this->response
                        ->setStatusCode(200)
                        ->setContentType('application/json')
                        ->setJSON([
                            'success' => true,
                            'message' => 'Profile updated successfully!',
                            'user' => [
                                'first_name' => $updateData['first_name'],
                                'last_name' => $updateData['last_name']
                            ],
                            'csrf_token' => csrf_hash()
                        ]);
                }

                session()->setFlashdata('success', 'Profile updated successfully');
                return redirect()->to('/account/profile');
            } else {
                log_message('error', 'Database update failed');
                
                if ($this->request->isAJAX()) {
                    return $this->response
                        ->setStatusCode(200)
                        ->setContentType('application/json')
                        ->setJSON([
                            'success' => false,
                            'message' => 'Failed to update profile. Please try again.',
                            'csrf_token' => csrf_hash()
                        ]);
                }

                session()->setFlashdata('error', 'Failed to update profile');
                return redirect()->to('/account/profile');
            }
        } catch (\Exception $e) {
            log_message('error', 'Exception during profile update: ' . $e->getMessage());
            
            if ($this->request->isAJAX()) {
                return $this->response
                    ->setStatusCode(200)
                    ->setContentType('application/json')
                    ->setJSON([
                        'success' => false,
                        'message' => 'An error occurred: ' . $e->getMessage(),
                        'csrf_token' => csrf_hash()
                    ]);
            }

            session()->setFlashdata('error', 'An error occurred');
            return redirect()->to('/account/profile');
        }
    }

    public function trackOrder()
    {
        // Check if request is AJAX
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'message' => 'Invalid request',
                'csrf_token' => csrf_hash()
            ]);
        }

        $orderNumber = $this->request->getPost('order_number');
        $email = $this->request->getPost('email');

        // Validate inputs
        if (!$orderNumber || !$email) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Order number and email are required',
                'csrf_token' => csrf_hash()
            ]);
        }

        $orderModel = new OrderModel();
        
        // Find order with order number and email
        $order = $orderModel->where('order_number', $orderNumber)
            ->where('email', $email)
            ->first();

        if (!$order) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Order not found. Please check your order number and email address.',
                'csrf_token' => csrf_hash()
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'order' => $order,
            'message' => 'Order found successfully',
            'csrf_token' => csrf_hash()
        ]);
    }

    public function addToWishlist()
    {
        if (!session()->get('logged_in')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please login to add items to wishlist',
                'csrf_token' => csrf_hash()
            ]);
        }

        $productId = $this->request->getPost('product_id');
        $userId = session()->get('user_id');

        if (!$productId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Product ID is required',
                'csrf_token' => csrf_hash()
            ]);
        }

        $wishlistModel = new WishlistModel();

        if ($wishlistModel->isInWishlist($userId, $productId)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Product already in wishlist',
                'csrf_token' => csrf_hash()
            ]);
        }

        if ($wishlistModel->insert(['user_id' => $userId, 'product_id' => $productId])) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Product added to wishlist',
                'csrf_token' => csrf_hash()
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to add product to wishlist',
            'csrf_token' => csrf_hash()
        ]);
    }

    public function removeFromWishlist()
    {
        if (!session()->get('logged_in')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please login to manage wishlist',
                'csrf_token' => csrf_hash()
            ]);
        }

        $productId = $this->request->getPost('product_id');
        $userId = session()->get('user_id');

        if (!$productId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Product ID is required',
                'csrf_token' => csrf_hash()
            ]);
        }

        $wishlistModel = new WishlistModel();

        if ($wishlistModel->removeFromWishlist($userId, $productId)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Product removed from wishlist',
                'csrf_token' => csrf_hash()
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to remove product from wishlist',
            'csrf_token' => csrf_hash()
        ]);
    }
}