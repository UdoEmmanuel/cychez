<?php

use App\Models\CartModel;

if (!function_exists('get_cart')) {
    function get_cart()
    {
        $userId = session()->get('user_id');
        
        if (!$userId) {
            return [];
        }

        $cartModel = new CartModel();
        $items = $cartModel->getCartItems($userId);
        
        // Format items to match the old structure (keyed by product_id)
        $cart = [];
        foreach ($items as $item) {
            $cart[$item['product_id']] = [
                'id'       => $item['product_id'],
                'name'     => $item['name'],
                'slug'     => $item['slug'],
                'price'    => $item['price'],
                'image'    => $item['image'] ?? null,
                'quantity' => $item['quantity'],
            ];
        }
        
        return $cart;
    }
}

if (!function_exists('add_to_cart')) {
    function add_to_cart($product, $quantity = 1)
    {
        $userId = session()->get('user_id');
        
        if (!$userId) {
            return false;
        }

        $cartModel = new CartModel();
        return $cartModel->addToCart($userId, $product['id'], $quantity);
    }
}

if (!function_exists('update_cart')) {
    function update_cart($productId, $quantity)
    {
        $userId = session()->get('user_id');
        
        if (!$userId) {
            return false;
        }

        $cartModel = new CartModel();
        return $cartModel->updateQuantity($userId, $productId, $quantity);
    }
}

if (!function_exists('remove_from_cart')) {
    function remove_from_cart($productId)
    {
        $userId = session()->get('user_id');
        
        if (!$userId) {
            return false;
        }

        $cartModel = new CartModel();
        return $cartModel->removeItem($userId, $productId);
    }
}

if (!function_exists('clear_cart')) {
    function clear_cart()
    {
        $userId = session()->get('user_id');
        
        if (!$userId) {
            return false;
        }

        $cartModel = new CartModel();
        return $cartModel->clearCart($userId);
    }
}

if (!function_exists('get_cart_total')) {
    function get_cart_total()
    {
        $userId = session()->get('user_id');
        
        if (!$userId) {
            return 0;
        }

        $cartModel = new CartModel();
        return $cartModel->getCartTotal($userId);
    }
}

if (!function_exists('get_cart_count')) {
    function get_cart_count()
    {
        $userId = session()->get('user_id');
        
        if (!$userId) {
            return 0;
        }

        $cartModel = new CartModel();
        return $cartModel->getCartCount($userId);
    }
}

if (!function_exists('is_in_cart')) {
    function is_in_cart($productId)
    {
        $userId = session()->get('user_id');
        
        if (!$userId) {
            return false;
        }

        $cartModel = new CartModel();
        return $cartModel->isInCart($userId, $productId);
    }
}

if (!function_exists('format_currency')) {
    function format_currency($amount)
    {
        $symbol = env('site.currencySymbol', '₦');
        return $symbol . number_format($amount, 2);
    }
}