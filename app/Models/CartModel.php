<?php

namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model
{
    protected $table            = 'cart';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'product_id', 'quantity'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    /**
     * Get cart items for a user with product details
     */
    public function getCartItems($userId)
    {
        return $this->select('cart.*, products.name, products.slug, products.price, products.image, products.stock_quantity, products.is_active')
                    ->join('products', 'products.id = cart.product_id')
                    ->where('cart.user_id', $userId)
                    ->findAll();
    }

    /**
     * Add item to cart or update quantity if exists
     */
    public function addToCart($userId, $productId, $quantity = 1)
    {
        $existing = $this->where([
            'user_id' => $userId,
            'product_id' => $productId
        ])->first();

        if ($existing) {
            // Update quantity
            return $this->update($existing['id'], [
                'quantity' => $existing['quantity'] + $quantity
            ]);
        } else {
            // Insert new item
            return $this->insert([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity
            ]);
        }
    }

    /**
     * Update cart item quantity
     */
    public function updateQuantity($userId, $productId, $quantity)
    {
        if ($quantity <= 0) {
            return $this->removeItem($userId, $productId);
        }

        return $this->where([
            'user_id' => $userId,
            'product_id' => $productId
        ])->set(['quantity' => $quantity])->update();
    }

    /**
     * Remove item from cart
     */
    public function removeItem($userId, $productId)
    {
        return $this->where([
            'user_id' => $userId,
            'product_id' => $productId
        ])->delete();
    }

    /**
     * Clear all cart items for a user
     */
    public function clearCart($userId)
    {
        return $this->where('user_id', $userId)->delete();
    }

    /**
     * Get cart count for a user
     */
    public function getCartCount($userId)
    {
        $result = $this->selectSum('quantity')
                       ->where('user_id', $userId)
                       ->first();
        
        return $result['quantity'] ?? 0;
    }

    /**
     * Get cart total for a user
     */
    public function getCartTotal($userId)
    {
        $items = $this->getCartItems($userId);
        $total = 0;

        foreach ($items as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return $total;
    }

    /**
     * Check if product is in cart
     */
    public function isInCart($userId, $productId)
    {
        return $this->where([
            'user_id' => $userId,
            'product_id' => $productId
        ])->first() !== null;
    }
}