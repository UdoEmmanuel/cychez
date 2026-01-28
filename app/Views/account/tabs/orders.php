<div class="orders-header">
    <h2><i class="fas fa-shopping-bag"></i> Order History</h2>
    <p>View and track all your orders</p>
</div>

<?php if (empty($orders)): ?>
    <div class="empty-state">
        <div class="empty-state-icon">
            <i class="fas fa-shopping-bag"></i>
        </div>
        <h4>No Orders Yet</h4>
        <p>You haven't placed any orders yet. Start shopping to see your orders here!</p>
        <a href="<?= base_url('shop') ?>" class="btn-shop">
            Browse Products
        </a>
    </div>
<?php else: ?>
    <div class="orders-stats">
        <div class="stat-mini">
            <i class="fas fa-box"></i>
            <div>
                <h4><?= count($orders) ?></h4>
                <p>Total Orders</p>
            </div>
        </div>
        <div class="stat-mini">
            <i class="fas fa-clock"></i>
            <div>
                <h4>
                    <?php
                    $pending = array_filter($orders, function($order) {
                        return in_array($order['delivery_status'], ['pending', 'processing']);
                    });
                    echo count($pending);
                    ?>
                </h4>
                <p>In Progress</p>
            </div>
        </div>
        <div class="stat-mini">
            <i class="fas fa-check-circle"></i>
            <div>
                <h4>
                    <?php
                    $delivered = array_filter($orders, function($order) {
                        return $order['delivery_status'] === 'delivered';
                    });
                    echo count($delivered);
                    ?>
                </h4>
                <p>Completed</p>
            </div>
        </div>
    </div>

    <!-- FILTER ORDER BY STATUS AND SEARCH BAR -->
    <!-- <div class="orders-filter">
        <div class="filter-group">
            <label><i class="fas fa-filter"></i> Filter by Status:</label>
            <select id="statusFilter" class="form-select">
                <option value="all">All Orders</option>
                <option value="pending">Pending</option>
                <option value="processing">Processing</option>
                <option value="shipped">Shipped</option>
                <option value="delivered">Delivered</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>
        <div class="filter-group">
            <label><i class="fas fa-search"></i> Search:</label>
            <input type="text" id="orderSearch" class="form-control" placeholder="Search by order number...">
        </div>
    </div> -->

    <div class="orders-list" id="ordersList">
        <?php foreach ($orders as $order): ?>
            <div class="order-card" data-status="<?= esc($order['delivery_status']) ?>" data-order-number="<?= esc($order['order_number']) ?>">
                <div class="order-card-header">
                    <div class="order-info">
                        <h5 class="order-number">
                            <i class="fas fa-receipt"></i>
                            Order <?= esc($order['order_number']) ?>
                        </h5>
                        <span class="order-date">
                            <i class="far fa-calendar"></i>
                            <?= date('M d, Y', strtotime($order['created_at'])) ?>
                        </span>
                    </div>
                    <div class="order-badges">
                        <span class="status-badge <?= esc($order['payment_status']) ?>">
                            <?= $order['payment_status'] === 'paid' ? '<i class="fas fa-check-circle"></i>' : '<i class="fas fa-clock"></i>' ?>
                            <?= ucfirst(esc($order['payment_status'])) ?>
                        </span>
                        <span class="status-badge <?= esc($order['delivery_status']) ?>">
                            <?php
                            $icons = [
                                'pending' => 'clock',
                                'processing' => 'cog',
                                'shipped' => 'truck',
                                'delivered' => 'check-circle',
                                'cancelled' => 'times-circle'
                            ];
                            $icon = $icons[$order['delivery_status']] ?? 'box';
                            ?>
                            <i class="fas fa-<?= $icon ?>"></i>
                            <?= ucfirst(esc($order['delivery_status'])) ?>
                        </span>
                    </div>
                </div>

                <div class="order-card-body">
                    <div class="order-details">
                        <div class="detail-item">
                            <span class="detail-label">Items:</span>
                            <span class="detail-value">
                                <?php
                                echo isset($order['items_count']) ? $order['items_count'] : '—';
                                ?> item(s)
                            </span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Total Amount:</span>
                            <span class="detail-value total-amount"><?= format_currency($order['total_amount']) ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Payment Method:</span>
                            <span class="detail-value">
                                <?= isset($order['payment_method']) ? ucfirst(esc($order['payment_method'])) : 'N/A' ?>
                            </span>
                        </div>
                    </div>

                    <div class="order-actions">
                        <a href="javascript:void(0)" onclick="window.viewOrderDetails(<?= $order['id'] ?>)" class="btn-view-order">
                            <i class="fas fa-eye"></i> View Details
                        </a>
                        <!-- <?php if ($order['delivery_status'] === 'delivered'): ?>
                            <button class="btn-reorder" onclick="window.reorderOrder(<?= $order['id'] ?>)">
                                <i class="fas fa-redo"></i> Reorder
                            </button>
                        <?php endif; ?> -->
                    </div>
                </div>

                <?php if (isset($order['tracking_number']) && !empty($order['tracking_number'])): ?>
                    <div class="order-card-footer">
                        <i class="fas fa-shipping-fast"></i>
                        <span>Tracking Number: <strong><?= esc($order['order_number']) ?></strong></span>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <div id="noResultsMessage" class="empty-state" style="display: none;">
        <div class="empty-state-icon">
            <i class="fas fa-search"></i>
        </div>
        <h4>No Orders Found</h4>
        <p>No orders match your search or filter criteria</p>
    </div>
<?php endif; ?>

<script>
// Initialize orders tab functionality immediately (no DOMContentLoaded needed)
(function() {
    const statusFilter = document.getElementById('statusFilter');
    const orderSearch = document.getElementById('orderSearch');
    const ordersList = document.getElementById('ordersList');
    const noResultsMessage = document.getElementById('noResultsMessage');

    if (statusFilter && orderSearch && ordersList) {
        function filterOrders() {
            const selectedStatus = statusFilter.value.toLowerCase();
            const searchTerm = orderSearch.value.toLowerCase();
            const orderCards = ordersList.querySelectorAll('.order-card');
            let visibleCount = 0;

            orderCards.forEach(card => {
                const cardStatus = card.dataset.status.toLowerCase();
                const orderNumber = card.dataset.orderNumber.toLowerCase();
                
                const statusMatch = selectedStatus === 'all' || cardStatus === selectedStatus;
                const searchMatch = orderNumber.includes(searchTerm);

                if (statusMatch && searchMatch) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Show/hide no results message
            if (noResultsMessage) {
                if (visibleCount === 0) {
                    ordersList.style.display = 'none';
                    noResultsMessage.style.display = 'block';
                } else {
                    ordersList.style.display = 'block';
                    noResultsMessage.style.display = 'none';
                }
            }
        }

        statusFilter.addEventListener('change', filterOrders);
        orderSearch.addEventListener('input', filterOrders);
    }
})();
</script>