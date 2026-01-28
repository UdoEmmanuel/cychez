<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\ProductModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $orderModel = new OrderModel();
        $productModel = new ProductModel();
        $userModel = new UserModel();

        $todayStart = date('Y-m-d 00:00:00');
        $todayEnd = date('Y-m-d 23:59:59');

        $data = [
            'title'             => 'Admin Dashboard - Cychez Store',
            'totalOrders'       => $orderModel->countAll(),
            'pendingOrders'     => $orderModel->getPendingOrdersCount(),
            'totalSales'        => $orderModel->getTotalSales(),
            'todaySales'        => $orderModel->getTotalSales($todayStart, $todayEnd),
            'totalProducts'     => $productModel->countAll(),
            'lowStockProducts'  => $productModel->getLowStockProducts(10),
            'recentOrders'      => $orderModel->getRecentOrders(10),
            'totalCustomers'    => $userModel->where('role', 'customer')->countAllResults(),
        ];

        return view('admin/dashboard', $data);
    }
}