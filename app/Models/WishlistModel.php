<?php

namespace App\Models;

use CodeIgniter\Model;

class WishlistModel extends Model
{
    protected $table            = 'wishlist';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'product_id',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Get wishlist items for a user with product details
     */
    public function getUserWishlist($userId)
    {
        return $this->select('wishlist.*, products.name, products.slug, products.price, products.image, products.stock_quantity, products.is_active')
            ->join('products', 'products.id = wishlist.product_id')
            ->where('wishlist.user_id', $userId)
            ->orderBy('wishlist.created_at', 'DESC')
            ->findAll();
    }

    /**
     * Check if product is in user's wishlist
     */
    public function isInWishlist($userId, $productId)
    {
        return $this->where('user_id', $userId)
            ->where('product_id', $productId)
            ->first() !== null;
    }

    /**
     * Add product to wishlist
     */
    public function addToWishlist($userId, $productId)
    {
        // Check if already exists
        if ($this->isInWishlist($userId, $productId)) {
            return false;
        }

        return $this->insert([
            'user_id' => $userId,
            'product_id' => $productId
        ]);
    }

    /**
     * Remove product from wishlist
     */
    public function removeFromWishlist($userId, $productId)
    {
        return $this->where('user_id', $userId)
            ->where('product_id', $productId)
            ->delete();
    }

    /**
     * Clear all wishlist items for a user
     */
    public function clearWishlist($userId)
    {
        return $this->where('user_id', $userId)->delete();
    }

    /**
     * Get wishlist count for a user
     */
    public function getWishlistCount($userId)
    {
        return $this->where('user_id', $userId)->countAllResults();
    }
}