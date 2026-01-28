<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\WishlistModel;

class Wishlist extends BaseController
{
    protected $wishlistModel;

    public function __construct()
    {
        $this->wishlistModel = new WishlistModel();
    }

    public function index()
    {
        // Check if user is logged in
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Please login to view your wishlist');
        }

        helper(['cart', 'wishlist']);

        $userId = session()->get('user_id');
        $wishlist = $this->wishlistModel->getUserWishlist($userId);

        $data = [
            'title' => 'My Wishlist - Cychez Store',
            'wishlist' => $wishlist,
            'shopHeader' => true,
        ];

        return view('wishlist/index', $data);
    }

    public function add()
    {
        // Enable CORS and set proper headers
        $this->response->setHeader('Content-Type', 'application/json');

        // Check if user is logged in
        if (!session()->get('logged_in')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please login to add items to wishlist',
                'redirect' => base_url('login'),
                'csrf_token_name' => csrf_token(),
                'csrf_token_hash' => csrf_hash(),
            ]);
        }

        $productId = $this->request->getPost('product_id');
        $userId = session()->get('user_id');

        // Debug logging
        log_message('info', 'Add to Wishlist - User ID: ' . $userId . ', Product ID: ' . $productId);

        if (!$productId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Product ID is required',
                'csrf_token_name' => csrf_token(),
                'csrf_token_hash' => csrf_hash(),
            ]);
        }

        // Verify product exists and is active
        $productModel = new ProductModel();
        $product = $productModel->find($productId);

        if (!$product || !$product['is_active']) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Product not found or is not available',
                'csrf_token_name' => csrf_token(),
                'csrf_token_hash' => csrf_hash(),
            ]);
        }

        // Check if product already in wishlist
        if ($this->wishlistModel->isInWishlist($userId, $productId)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Product already in wishlist',
                'csrf_token_name' => csrf_token(),
                'csrf_token_hash' => csrf_hash(),
            ]);
        }

        // Add to wishlist
        if ($this->wishlistModel->addToWishlist($userId, $productId)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Product added to wishlist',
                'wishlist_count' => $this->wishlistModel->getWishlistCount($userId),
                'csrf_token_name' => csrf_token(),
                'csrf_token_hash' => csrf_hash(),
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to add product to wishlist',
            'csrf_token_name' => csrf_token(),
            'csrf_token_hash' => csrf_hash(),
        ]);
    }

    public function remove()
    {
        // Enable CORS and set proper headers
        $this->response->setHeader('Content-Type', 'application/json');

        // Check if user is logged in
        if (!session()->get('logged_in')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please login to manage your wishlist',
                'csrf_token_name' => csrf_token(),
                'csrf_token_hash' => csrf_hash(),
            ]);
        }

        $productId = $this->request->getPost('product_id');
        $userId = session()->get('user_id');

        // Debug logging
        log_message('info', 'Remove from Wishlist - User ID: ' . $userId . ', Product ID: ' . $productId);

        if (!$productId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Product ID is required',
                'csrf_token_name' => csrf_token(),
                'csrf_token_hash' => csrf_hash(),
            ]);
        }

        // Check if product exists in wishlist
        if (!$this->wishlistModel->isInWishlist($userId, $productId)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Product not found in wishlist',
                'csrf_token_name' => csrf_token(),
                'csrf_token_hash' => csrf_hash(),
            ]);
        }

        // Remove from wishlist
        if ($this->wishlistModel->removeFromWishlist($userId, $productId)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Product removed from wishlist',
                'wishlist_count' => $this->wishlistModel->getWishlistCount($userId),
                'csrf_token_name' => csrf_token(),
                'csrf_token_hash' => csrf_hash(),
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to remove product from wishlist',
            'csrf_token_name' => csrf_token(),
            'csrf_token_hash' => csrf_hash(),
        ]);
    }

    public function clear()
    {
        // Check if user is logged in
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Please login to manage your wishlist');
        }

        $userId = session()->get('user_id');
        
        if ($this->wishlistModel->clearWishlist($userId)) {
            session()->setFlashdata('success', 'Wishlist cleared successfully');
        } else {
            session()->setFlashdata('error', 'Failed to clear wishlist');
        }

        return redirect()->to('/wishlist');
    }

    public function getCount()
    {
        helper('wishlist');
        $this->response->setHeader('Content-Type', 'application/json');

        return $this->response->setJSON([
            'success' => true,
            'count' => get_wishlist_count(),
            'csrf_token_name' => csrf_token(),
            'csrf_token_hash' => csrf_hash(),
        ]);
    }

    public function moveToCart()
    {
        $this->response->setHeader('Content-Type', 'application/json');

        // Check if user is logged in
        if (!session()->get('logged_in')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please login to add items to cart',
                'csrf_token_name' => csrf_token(),
                'csrf_token_hash' => csrf_hash(),
            ]);
        }

        helper('cart');

        $productId = $this->request->getPost('product_id');
        $userId = session()->get('user_id');

        if (!$productId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Product ID is required',
                'csrf_token_name' => csrf_token(),
                'csrf_token_hash' => csrf_hash(),
            ]);
        }

        // Check if product is in wishlist
        if (!$this->wishlistModel->isInWishlist($userId, $productId)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Product not found in wishlist',
                'csrf_token_name' => csrf_token(),
                'csrf_token_hash' => csrf_hash(),
            ]);
        }

        // Get fresh product data
        $productModel = new ProductModel();
        $product = $productModel->find($productId);

        if (!$product || !$product['is_active']) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Product not available',
                'csrf_token_name' => csrf_token(),
                'csrf_token_hash' => csrf_hash(),
            ]);
        }

        // Check stock
        if ($product['stock_quantity'] < 1) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Product is out of stock',
                'csrf_token_name' => csrf_token(),
                'csrf_token_hash' => csrf_hash(),
            ]);
        }

        // Add to cart
        if (add_to_cart($product, 1)) {
            // Remove from wishlist
            $this->wishlistModel->removeFromWishlist($userId, $productId);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Product moved to cart',
                'cart_count' => get_cart_count(),
                'wishlist_count' => $this->wishlistModel->getWishlistCount($userId),
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
}