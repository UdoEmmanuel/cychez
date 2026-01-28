<div class="welcome-section">
    <h2>Welcome back, <?= esc(session()->get('first_name')) ?>! 👋</h2>
    <p>Here's what's happening with your account today</p>
</div>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-shopping-bag"></i>
        </div>
        <h3><?= count($recentOrders) ?></h3>
        <p>Total Orders</p>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-clock"></i>
        </div>
        <h3>
            <?php
            $pending = array_filter($recentOrders, function($order) {
                return $order['delivery_status'] === 'pending';
            });
            echo count($pending);
            ?>
        </h3>
        <p>Pending Orders</p>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <h3>
            <?php
            $delivered = array_filter($recentOrders, function($order) {
                return $order['delivery_status'] === 'delivered';
            });
            echo count($delivered);
            ?>
        </h3>
        <p>Completed Orders</p>
    </div>
</div>

<!-- Recent Orders -->
<?php if (!empty($recentOrders)): ?>
    <div class="recent-orders-section">
        <div class="section-header">
            <h3>Recent Orders</h3>
        </div>
        
        <div class="table-wrapper">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>Order Number</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentOrders as $order): ?>
                        <tr>
                            <td class="order-number">#<?= esc($order['order_number']) ?></td>
                            <td><?= date('M d, Y', strtotime($order['created_at'])) ?></td>
                            <td><strong><?= format_currency($order['total_amount']) ?></strong></td>
                            <td>
                                <span class="status-badge <?= esc($order['delivery_status']) ?>">
                                    <?= ucfirst(esc($order['delivery_status'])) ?>
                                </span>
                            </td>
                            <td>
                                <!-- <a href="javascript:void(0)" onclick="window.viewOrderDetails(<?= $order['id'] ?>)" class="btn-view-order">
                                    View Details
                                </a> -->
                                <div class="order-actions">
                                    <a href="javascript:void(0)" onclick="window.viewOrderDetails(<?= $order['id'] ?>)" class="btn-view-order">
                                        <i class="fas fa-eye"></i> View Details
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <a href="javascript:void(0)" onclick="document.querySelector('.nav-link[data-tab=\'orders\']')?.click()" class="btn-view-all">
            View All Orders →
        </a>
    </div>
<?php else: ?>
    <div class="empty-state">
        <div class="empty-state-icon">
            <i class="fas fa-shopping-bag"></i>
        </div>
        <h4>No Orders Yet</h4>
        <p>Start shopping and your orders will appear here</p>
        <a href="<?= base_url('shop') ?>" class="btn-shop">
            Start Shopping
        </a>
    </div>
<?php endif; ?>