<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Cart extends BaseController
{
    public function index()
    {
        // Check if user is logged in
        if (!session()->get('logged_in')) {
            session()->setFlashdata('error', 'Please login to view your cart.');
            return redirect()->to('/login');
        }

        helper('cart');

        $cart = get_cart();

        $data = [
            'title' => 'Shopping Cart - Cychez Store',
            'cart'  => $cart,
            'shopHeader' => true,
        ];

        if (empty($cart)) {
            return view('cart/empty', $data);
        }

        return view('cart/index', $data);
    }

    public function add()
    {
        // Check if user is logged in
        if (!session()->get('logged_in')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please login to add items to cart',
                'redirect' => base_url('login'),
                'csrf_token_name' => csrf_token(),
                'csrf_token_hash' => csrf_hash(),
            ]);
        }

        helper('cart');

        $productId = $this->request->getPost('product_id');
        $quantity = $this->request->getPost('quantity', FILTER_VALIDATE_INT) ?: 1;

        $productModel = new ProductModel();
        $product = $productModel->find($productId);

        if (!$product || !$product['is_active']) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Product not found',
                'csrf_token_name' => csrf_token(),
                'csrf_token_hash' => csrf_hash(),
            ]);
        }

        if ($product['stock_quantity'] < $quantity) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Insufficient stock',
                'csrf_token_name' => csrf_token(),
                'csrf_token_hash' => csrf_hash(),
            ]);
        }

        if (add_to_cart($product, $quantity)) {
            return $this->response->setJSON([
                'success'    => true,
                'message'    => 'Product added to cart',
                'cart_count' => get_cart_count(),
                'csrf_token_name' => csrf_token(),
                'csrf_token_hash' => csrf_hash(),
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to add product to cart',
            'csrf_token_name' => csrf_token(),
            'csrf_token_hash' => csrf_hash(),
        ]);
    }

    public function update()
    {
        // Check if user is logged in
        if (!session()->get('logged_in')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please login first',
                'csrf_token_name' => csrf_token(),
                'csrf_token_hash' => csrf_hash(),
            ]);
        }

        // Enable CORS if needed
        $this->response->setHeader('Content-Type', 'application/json');
        
        helper('cart');

        $productId = $this->request->getPost('product_id');
        $quantity = $this->request->getPost('quantity', FILTER_VALIDATE_INT);

        // Debug logging
        log_message('info', 'Update Cart - Product ID: ' . $productId . ', Quantity: ' . $quantity);

        if (!$productId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Product ID is required',
                'csrf_token_name' => csrf_token(),
                'csrf_token_hash' => csrf_hash(),
            ]);
        }

        if ($quantity === false || $quantity === null) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Valid quantity is required',
                'csrf_token_name' => csrf_token(),
                'csrf_token_hash' => csrf_hash(),
            ]);
        }

        // Check product stock
        $productModel = new ProductModel();
        $product = $productModel->find($productId);
        
        if ($product && $product['stock_quantity'] < $quantity) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Only ' . $product['stock_quantity'] . ' items available in stock',
                'csrf_token_name' => csrf_token(),
                'csrf_token_hash' => csrf_hash(),
            ]);
        }

        if (update_cart($productId, $quantity)) {
            return $this->response->setJSON([
                'success'    => true,
                'message'    => 'Cart updated',
                'cart_total' => get_cart_total(),
                'cart_count' => get_cart_count(),
                'csrf_token_name' => csrf_token(),
                'csrf_token_hash' => csrf_hash(),
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to update cart',
            'csrf_token_name' => csrf_token(),
            'csrf_token_hash' => csrf_hash(),
        ]);
    }

    public function remove()
    {
        // Check if user is logged in
        if (!session()->get('logged_in')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please login first',
                'csrf_token_name' => csrf_token(),
                'csrf_token_hash' => csrf_hash(),
            ]);
        }

        // Enable CORS and set proper headers
        $this->response->setHeader('Content-Type', 'application/json');
        
        helper('cart');

        $productId = $this->request->getPost('product_id');

        // Debug logging
        log_message('info', 'Remove from Cart - Product ID: ' . $productId);
        log_message('info', 'POST data: ' . json_encode($this->request->getPost()));

        if (!$productId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Product ID is required',
                'csrf_token_name' => csrf_token(),
                'csrf_token_hash' => csrf_hash(),
            ]);
        }

        // Get current cart for debugging
        $cartBefore = get_cart();
        log_message('info', 'Cart before removal: ' . json_encode(array_keys($cartBefore)));

        if (remove_from_cart($productId)) {
            $cartAfter = get_cart();
            log_message('info', 'Cart after removal: ' . json_encode(array_keys($cartAfter)));
            
            return $this->response->setJSON([
                'success'    => true,
                'message'    => 'Product removed from cart',
                'cart_count' => get_cart_count(),
                'cart_total' => get_cart_total(),
                'csrf_token_name' => csrf_token(),
                'csrf_token_hash' => csrf_hash(),
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to remove product from cart. Product may not exist in cart.',
            'csrf_token_name' => csrf_token(),
            'csrf_token_hash' => csrf_hash(),
        ]);
    }

    public function clear()
    {
        // Check if user is logged in
        if (!session()->get('logged_in')) {
            session()->setFlashdata('error', 'Please login first');
            return redirect()->to('/login');
        }

        helper('cart');

        clear_cart();
        session()->setFlashdata('success', 'Cart cleared successfully');

        return redirect()->to('/cart');
    }

    public function getCount()
    {
        helper('cart');
        $this->response->setHeader('Content-Type', 'application/json');

        return $this->response->setJSON([
            'success' => true,
            'count' => get_cart_count(),
            'csrf_token_name' => csrf_token(),
            'csrf_token_hash' => csrf_hash(),
        ]);
    }
}