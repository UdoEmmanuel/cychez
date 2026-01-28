<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php helper('cart'); ?>

<!-- Stats Cards -->
<div class="row dashboard-stats">
    <div class="col-lg-3 col-md-6 col-6">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-shopping-bag"></i>
            </div>
            <div class="stat-content">
                <h3><?= $totalOrders ?></h3>
                <p class="text-muted mb-0">Total Orders</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-6">
        <div class="stat-card">
            <div class="stat-icon text-warning">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <h3><?= $pendingOrders ?></h3>
                <p class="text-muted mb-0">Pending Orders</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-6">
        <div class="stat-card">
            <div class="stat-icon text-success">
                <i class="fas fa-box"></i>
            </div>
            <div class="stat-content">
                <h3><?= $totalProducts ?></h3>
                <p class="text-muted mb-0">Total Products</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-6">
        <div class="stat-card">
            <div class="stat-icon text-info">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <h3><?= $totalCustomers ?></h3>
                <p class="text-muted mb-0">Customers</p>
            </div>
        </div>
    </div>
</div>

<!-- Sales Overview & Low Stock -->
<div class="row mt-4">
    <div class="col-lg-6 col-12 mb-3">
        <div class="card dashboard-card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Sales Overview</h5>
            </div>
            <div class="card-body">
                <div class="sales-item">
                    <div class="sales-label">
                        <i class="fas fa-dollar-sign text-success"></i>
                        <strong>Total Sales:</strong>
                    </div>
                    <div class="sales-value"><?= format_currency($totalSales) ?></div>
                </div>
                <div class="sales-item">
                    <div class="sales-label">
                        <i class="fas fa-calendar-day text-primary"></i>
                        <strong>Today's Sales:</strong>
                    </div>
                    <div class="sales-value"><?= format_currency($todaySales) ?></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6 col-12 mb-3">
        <div class="card dashboard-card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Low Stock Alert</h5>
            </div>
            <div class="card-body">
                <?php if (empty($lowStockProducts)): ?>
                    <div class="empty-state-small">
                        <i class="fas fa-check-circle text-success"></i>
                        <p class="text-muted mb-0">All products are well stocked.</p>
                    </div>
                <?php else: ?>
                    <ul class="list-unstyled low-stock-list mb-0">
                        <?php foreach ($lowStockProducts as $product): ?>
                            <li class="low-stock-item">
                                <span class="badge bg-danger stock-badge"><?= $product['stock_quantity'] ?></span>
                                <span class="product-name-text"><?= esc($product['name']) ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card dashboard-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-list me-2"></i>Recent Orders</h5>
                <a href="<?= base_url('admin/orders') ?>" class="btn btn-sm btn-outline-primary">
                    View All
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table dashboard-table">
                        <thead>
                            <tr>
                                <th class="mobile-hide">Order Number</th>
                                <th>Customer</th>
                                <th class="mobile-hide">Total</th>
                                <th class="mobile-hide">Payment</th>
                                <th>Status</th>
                                <th class="mobile-hide">Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($recentOrders)): ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
                                        <p class="text-muted mb-0">No recent orders</p>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($recentOrders as $order): ?>
                                    <tr>
                                        <td class="mobile-hide">
                                            <strong><?= esc($order['order_number']) ?></strong>
                                        </td>
                                        <td>
                                            <div class="customer-info">
                                                <div class="customer-name">
                                                    <?= esc($order['user_first_name'] ?? $order['first_name']) ?> 
                                                    <?= esc($order['user_last_name'] ?? $order['last_name']) ?>
                                                </div>
                                                <!-- <div class="order-meta">
                                                    <small class="text-muted">#<?= esc($order['order_number']) ?></small>
                                                </div> -->
                                                <div class="order-meta">
                                                    <small class="text-muted"><?= format_currency($order['total_amount']) ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="mobile-hide">
                                            <strong><?= format_currency($order['total_amount']) ?></strong>
                                        </td>
                                        <td class="mobile-hide">
                                            <span class="badge bg-<?= $order['payment_status'] === 'paid' ? 'success' : 'warning' ?>">
                                                <?= ucfirst($order['payment_status']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-<?= $order['delivery_status'] === 'delivered' ? 'success' : ($order['delivery_status'] === 'pending' ? 'warning' : 'info') ?>">
                                                <?= ucfirst($order['delivery_status']) ?>
                                            </span>
                                        </td>
                                        <td class="mobile-hide">
                                            <?= date('M d, Y', strtotime($order['created_at'])) ?>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('admin/orders/view/' . $order['id']) ?>" 
                                               class="btn btn-sm btn-primary recent-order-view-btn">
                                                <i class="fas fa-eye"></i>
                                                <span class="btn-text">View</span>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>