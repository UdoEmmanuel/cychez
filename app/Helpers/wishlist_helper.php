<?php

use App\Models\WishlistModel;

if (!function_exists('get_wishlist')) {
    /**
     * Get all wishlist items for the logged-in user
     */
    function get_wishlist()
    {
        $userId = session()->get('user_id');
        
        if (!$userId) {
            return [];
        }

        $wishlistModel = new WishlistModel();
        return $wishlistModel->getUserWishlist($userId);
    }
}

if (!function_exists('add_to_wishlist')) {
    /**
     * Add product to wishlist
     */
    function add_to_wishlist($productId)
    {
        $userId = session()->get('user_id');
        
        if (!$userId) {
            return false;
        }

        $wishlistModel = new WishlistModel();
        return $wishlistModel->addToWishlist($userId, $productId);
    }
}

if (!function_exists('remove_from_wishlist')) {
    /**
     * Remove product from wishlist
     */
    function remove_from_wishlist($productId)
    {
        $userId = session()->get('user_id');
        
        if (!$userId) {
            return false;
        }

        $wishlistModel = new WishlistModel();
        return $wishlistModel->removeFromWishlist($userId, $productId);
    }
}

if (!function_exists('clear_wishlist')) {
    /**
     * Clear all wishlist items
     */
    function clear_wishlist()
    {
        $userId = session()->get('user_id');
        
        if (!$userId) {
            return false;
        }

        $wishlistModel = new WishlistModel();
        return $wishlistModel->clearWishlist($userId);
    }
}

if (!function_exists('is_in_wishlist')) {
    /**
     * Check if product is in wishlist
     */
    function is_in_wishlist($productId)
    {
        $userId = session()->get('user_id');
        
        if (!$userId) {
            return false;
        }

        $wishlistModel = new WishlistModel();
        return $wishlistModel->isInWishlist($userId, $productId);
    }
}

if (!function_exists('get_wishlist_count')) {
    /**
     * Get wishlist item count
     */
    function get_wishlist_count()
    {
        $userId = session()->get('user_id');
        
        if (!$userId) {
            return 0;
        }

        $wishlistModel = new WishlistModel();
        return $wishlistModel->getWishlistCount($userId);
    }
}