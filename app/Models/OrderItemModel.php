<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderItemModel extends Model
{
    protected $table            = 'order_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'order_id',
        'product_id',
        'product_name',
        'product_image',
        'quantity',
        'price',
        'subtotal',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getOrderItems($orderId)
    {
        return $this->select('order_items.*, products.name as product_name, products.image as product_image')
            ->join('products', 'products.id = order_items.product_id', 'left')
            ->where('order_items.order_id', $orderId)
            ->findAll();
    }

    public function createOrderItems($orderId, $cartItems)
    {
        $items = [];

        foreach ($cartItems as $item) {
            $items[] = [
                'order_id'      => $orderId,
                'product_id'    => $item['id'],
                'product_name'  => $item['name'],
                'product_image' => $item['image'] ?? null,
                'quantity'      => $item['quantity'],
                'price'         => $item['price'],
                'subtotal'      => $item['price'] * $item['quantity'],
            ];
        }
        return $this->insertBatch($items);
    }
}