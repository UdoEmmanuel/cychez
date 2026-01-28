<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;

class Orders extends BaseController
{
    public function index()
    {
        $orderModel = new OrderModel();

        $perPage = 20;
        $orders = $orderModel->select('orders.*, users.first_name as user_first_name, users.last_name as user_last_name')
            ->join('users', 'users.id = orders.user_id', 'left')
            ->orderBy('orders.created_at', 'DESC')
            ->paginate($perPage);

        $data = [
            'title'  => 'Orders - Admin',
            'orders' => $orders,
            'pager'  => $orderModel->pager,
        ];

        return view('admin/orders/index', $data);
    }

    public function view($id)
    {
        $orderModel = new OrderModel();
        $order = $orderModel->getOrderWithItems($id);

        if (!$order) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Order Details - ' . $order['order_number'],
            'order' => $order,
        ];

        return view('admin/orders/view', $data);
    }

    public function updateStatus()
    {
        // Get POST data
        $orderId = $this->request->getPost('order_id');
        $status = $this->request->getPost('delivery_status');

        // Validate inputs
        if (!$orderId || !$status) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Missing required fields',
                'csrf_token_name' => csrf_token(),
                'csrf_hash' => csrf_hash(),
            ]);
        }

        // Validate status value
        $validStatuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        if (!in_array($status, $validStatuses)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid status value',
                'csrf_token_name' => csrf_token(),
                'csrf_hash' => csrf_hash(),
            ]);
        }

        // Find the order
        $orderModel = new OrderModel();
        $order = $orderModel->find($orderId);

        if (!$order) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Order not found',
                'csrf_token_name' => csrf_token(),
                'csrf_hash' => csrf_hash(),
            ]);
        }

        // Prepare update data
        $updateData = ['delivery_status' => $status];

        // Auto-generate tracking number when status is changed to shipped
        if ($status === 'shipped' && empty($order['tracking_number'])) {
            $updateData['tracking_number'] = 'TRK-' . strtoupper(substr(uniqid(), -8));
        }

        // Update the order
        try {
            $result = $orderModel->update($orderId, $updateData);
            
            if ($result) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Order status updated successfully',
                    'csrf_token_name' => csrf_token(),
                    'csrf_hash' => csrf_hash(),
                    'data' => [
                        'new_status' => $status,
                        'tracking_number' => $updateData['tracking_number'] ?? null
                    ]
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Database update failed',
                    'csrf_token_name' => csrf_token(),
                    'csrf_hash' => csrf_hash(),
                ]);
            }

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'csrf_token_name' => csrf_token(),
                'csrf_hash' => csrf_hash(),
            ]);
        }
    }
}