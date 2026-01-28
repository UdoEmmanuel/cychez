<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table            = 'orders';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'order_number',
        'total_amount',
        'shipping_fee',
        'shipping_zone_id',
        'payment_method',
        'payment_status',
        'payment_reference',
        'delivery_status',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'notes',
        'tracking_number',
        'email_sent_at',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function generateOrderNumber()
    {
        return 'ORD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
    }

    public function getUserOrders($userId)
    {
        try {
            $orders = $this->where('user_id', $userId)
                ->orderBy('created_at', 'DESC')
                ->findAll();

            // Get order items count for each order
            $orderItemsModel = new OrderItemModel();
            
            foreach ($orders as &$order) {
                $items = $orderItemsModel->where('order_id', $order['id'])->findAll();
                $order['items_count'] = count($items);
            }

            return $orders;
        } catch (\Exception $e) {
            log_message('error', 'Error fetching user orders: ' . $e->getMessage());
            return [];
        }
    }

    public function getOrderWithItems($orderId)
    {
        try {
            $order = $this->find($orderId);
            
            if (!$order) {
                return null;
            }

            // Get order items with product details
            $orderItemModel = new OrderItemModel();
            $items = $orderItemModel->select('order_items.*, products.name as product_name, products.image as product_image')
                ->join('products', 'products.id = order_items.product_id', 'left')
                ->where('order_items.order_id', $orderId)
                ->findAll();

            $order['items'] = $items;
            
            return $order;
        } catch (\Exception $e) {
            log_message('error', 'Error fetching order with items: ' . $e->getMessage());
            return null;
        }
    }

    public function getRecentOrders($limit = 10)
    {
        return $this->select('orders.*, users.first_name as user_first_name, users.last_name as user_last_name')
            ->join('users', 'users.id = orders.user_id', 'left')
            ->orderBy('orders.created_at', 'DESC')
            ->limit($limit)
            ->findAll();
    }

    public function getPendingOrdersCount()
    {
        return $this->where('delivery_status', 'pending')->countAllResults();
    }

    public function getTotalSales($startDate = null, $endDate = null)
    {
        $builder = $this->where('payment_status', 'paid');

        if ($startDate) {
            $builder->where('created_at >=', $startDate);
        }

        if ($endDate) {
            $builder->where('created_at <=', $endDate);
        }

        $result = $builder->select('SUM(total_amount - shipping_fee) as net_sales')->first();
        return $result['net_sales'] ?? 0;
    }

    public function getSalesCount($startDate = null, $endDate = null)
    {
        $builder = $this->where('payment_status', 'paid');

        if ($startDate) {
            $builder->where('created_at >=', $startDate);
        }

        if ($endDate) {
            $builder->where('created_at <=', $endDate);
        }

        return $builder->countAllResults();
    }

    public function findByOrderNumber($orderNumber)
    {
        return $this->where('order_number', $orderNumber)->first();
    }

    public function findByPaymentReference($reference)
    {
        return $this->where('payment_reference', $reference)->first();
    }

    public function markEmailSent(int $orderId)
    {
        return $this->update($orderId, [
            'email_sent_at' => date('Y-m-d H:i:s'),
        ]);
    }

}