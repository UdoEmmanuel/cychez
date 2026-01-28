<div class="order-detail-header">
    <button onclick="backToOrders()" class="btn-back">
        <i class="fas fa-arrow-left"></i> Back to Orders
    </button>
    <h2><i class="fas fa-receipt"></i> Order Details</h2>
</div>

<div class="order-detail-container">
    <div class="order-header-info">
        <div class="order-header-left">
            <h3>Order #<?= esc($order['order_number']) ?></h3>
            <p class="text-muted">Placed on <?= date('F d, Y', strtotime($order['created_at'])) ?></p>
        </div>
        <div class="order-header-right">
            <span class="status-badge <?= esc($order['payment_status']) ?>">
                <?= $order['payment_status'] === 'paid' ? '<i class="fas fa-check-circle"></i>' : '<i class="fas fa-clock"></i>' ?>
                Payment: <?= ucfirst(esc($order['payment_status'])) ?>
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
                Delivery: <?= ucfirst(esc($order['delivery_status'])) ?>
            </span>
        </div>
    </div>

    <div class="order-detail-grid">
        <div class="order-items-section">
            <div class="section-card">
                <div class="section-card-header">
                    <h4><i class="fas fa-shopping-bag"></i> Order Items</h4>
                </div>
                <div class="section-card-body">
                    <?php if (!empty($order['items'])): ?>
                        <div class="items-list">
                            <?php foreach ($order['items'] as $item): ?>
                                <div class="item-row">
                                    <div class="item-info">
                                        <?php if (!empty($item['product_image'])): ?>
                                            <img src="<?= base_url('assets/uploads/products/' . $item['product_image']) ?>" 
                                                 alt="<?= esc($item['product_name']) ?>" 
                                                 class="item-image">
                                        <?php else: ?>
                                            <div class="item-image-placeholder">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div class="item-details">
                                            <h5><?= esc($item['product_name']) ?></h5>
                                            <p class="item-price"><?= format_currency($item['price']) ?> × <?= $item['quantity'] ?></p>
                                        </div>
                                    </div>
                                    <div class="item-subtotal">
                                        <?= format_currency($item['subtotal']) ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="order-summary">
                            <div class="summary-row">
                                <span>Subtotal:</span>
                                <span><?= format_currency($order['total_amount'] - ($order['shipping_fee'] ?? 0)) ?></span>
                            </div>
                            <?php if (!empty($order['shipping_fee'])): ?>
                                <div class="summary-row">
                                    <span>Shipping:</span>
                                    <span><?= format_currency($order['shipping_fee']) ?></span>
                                </div>
                            <?php endif; ?>
                            <div class="summary-row total">
                                <span><strong>Total:</strong></span>
                                <span><strong><?= format_currency($order['total_amount']) ?></strong></span>
                            </div>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">No items found for this order.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="order-info-section">
            <div class="section-card">
                <div class="section-card-header">
                    <h4><i class="fas fa-map-marker-alt"></i> Delivery Information</h4>
                </div>
                <div class="section-card-body">
                    <div class="info-group">
                        <p class="info-label">Recipient:</p>
                        <p class="info-value"><strong><?= esc($order['first_name']) ?> <?= esc($order['last_name']) ?></strong></p>
                    </div>
                    
                    <div class="info-group">
                        <p class="info-label">Address:</p>
                        <p class="info-value">
                            <?= esc($order['address']) ?><br>
                            <?= esc($order['city']) ?>, <?= esc($order['state']) ?><br>
                            <?= esc($order['country']) ?>
                            <?php if (!empty($order['postal_code'])): ?>
                                - <?= esc($order['postal_code']) ?>
                            <?php endif; ?>
                        </p>
                    </div>
                    
                    <div class="info-group">
                        <p class="info-label">Contact:</p>
                        <p class="info-value">
                            <i class="fas fa-phone"></i> <?= esc($order['phone']) ?><br>
                            <i class="fas fa-envelope"></i> <?= esc($order['email']) ?>
                        </p>
                    </div>
                    
                    <!-- <?php if (!empty($order['tracking_number'])): ?>
                        <div class="info-group highlight">
                            <p class="info-label"><i class="fas fa-shipping-fast"></i> Tracking Number:</p>
                            <p class="info-value tracking-number"><?= esc($order['tracking_number']) ?></p>
                        </div>
                    <?php endif; ?> -->
                    
                    <?php if (!empty($order['notes'])): ?>
                        <div class="info-group">
                            <p class="info-label">Order Notes:</p>
                            <p class="info-value"><?= nl2br(esc($order['notes'])) ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="section-card">
                <div class="section-card-header">
                    <h4><i class="fas fa-credit-card"></i> Payment Information</h4>
                </div>
                <div class="section-card-body">
                    <div class="info-group">
                        <p class="info-label">Payment Method:</p>
                        <p class="info-value"><?= isset($order['payment_method']) ? ucfirst(esc($order['payment_method'])) : 'N/A' ?></p>
                    </div>
                    
                    <?php if (!empty($order['payment_reference'])): ?>
                        <div class="info-group">
                            <p class="info-label">Reference:</p>
                            <p class="info-value"><?= esc($order['payment_reference']) ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function backToOrders() {
    // Click the orders tab to go back
    const ordersTab = document.querySelector('.nav-link[data-tab="orders"]');
    if (ordersTab) {
        ordersTab.click();
    }
}
</script>

<style>
.order-detail-header {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 30px;
}

.btn-back {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    padding: 10px 20px;
    border-radius: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    transition: all 0.3s ease;
}

.btn-back:hover {
    background: #e9ecef;
    border-color: #adb5bd;
}

.order-detail-container {
    display: flex;
    flex-direction: column;
    gap: 25px;
    max-width: 100%;
    overflow-x: hidden;
}

.order-header-info {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 12px;
    flex-wrap: wrap;
    gap: 15px;
    max-width: 100%;
}

.order-header-left h3 {
    margin: 0 0 5px 0;
    font-size: 24px;
    word-wrap: break-word;
}

.order-header-right {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.order-detail-grid {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 25px;
    max-width: 100%;
}

.section-card {
    background: white;
    border: 1px solid #e0e0e0;
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 20px;
    max-width: 100%;
}

.section-card-header {
    background: #f8f9fa;
    padding: 15px 20px;
    border-bottom: 1px solid #e0e0e0;
}

.section-card-header h4 {
    margin: 0;
    font-size: 18px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.section-card-body {
    padding: 20px;
    max-width: 100%;
    overflow-x: hidden;
}

.items-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
    max-width: 100%;
}

.item-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
    gap: 15px;
    max-width: 100%;
}

.item-info {
    display: flex;
    gap: 15px;
    align-items: center;
    flex: 1;
    min-width: 0;
    max-width: 100%;
}

.item-image {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
    flex-shrink: 0;
}

.item-image-placeholder {
    width: 60px;
    height: 60px;
    background: #e0e0e0;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #999;
    flex-shrink: 0;
}

.item-details {
    flex: 1;
    min-width: 0;
}

.item-details h5 {
    margin: 0 0 5px 0;
    font-size: 16px;
    word-wrap: break-word;
    overflow-wrap: break-word;
}

.item-price {
    margin: 0;
    color: #666;
    font-size: 14px;
}

.item-subtotal {
    font-weight: 600;
    font-size: 16px;
    white-space: nowrap;
    flex-shrink: 0;
}

.order-summary {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 2px solid #e0e0e0;
    max-width: 100%;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    font-size: 16px;
}

.summary-row.total {
    border-top: 2px solid #e0e0e0;
    margin-top: 10px;
    padding-top: 15px;
    font-size: 18px;
}

.info-group {
    margin-bottom: 20px;
}

.info-group:last-child {
    margin-bottom: 0;
}

.info-label {
    margin: 0 0 5px 0;
    color: #666;
    font-size: 14px;
    font-weight: 500;
}

.info-value {
    margin: 0;
    font-size: 15px;
    line-height: 1.6;
    word-wrap: break-word;
    overflow-wrap: break-word;
}

.info-group.highlight {
    background: #e3f2fd;
    padding: 15px;
    border-radius: 8px;
    border-left: 4px solid #2196f3;
}

.tracking-number {
    font-family: monospace;
    font-weight: 600;
    font-size: 16px;
    color: #2196f3;
}

/* Tablet and Mobile Responsive */
@media (max-width: 992px) {
    .order-detail-grid {
        grid-template-columns: 1fr;
    }
    
    .order-header-info {
        flex-direction: column;
    }
    
    .order-header-right {
        width: 100%;
    }
}

/* Mobile Specific */
@media (max-width: 768px) {
    .order-detail-header {
        flex-wrap: wrap;
        gap: 15px;
    }

    .btn-back {
        width: 100%;
        justify-content: center;
    }

    .order-detail-header h2 {
        font-size: 1.35rem;
        width: 100%;
    }

    .order-header-left h3 {
        font-size: 20px;
    }

    .section-card-body {
        padding: 15px;
    }

    .item-row {
        flex-wrap: wrap;
    }

    .item-subtotal {
        margin-left: auto;
    }
}

/* Small Mobile */
@media (max-width: 576px) {
    .order-detail-header {
        margin-bottom: 20px;
    }

    .order-detail-header h2 {
        font-size: 1.25rem;
    }

    .order-header-info {
        padding: 15px;
    }

    .order-header-left h3 {
        font-size: 18px;
    }

    .section-card-header {
        padding: 12px 15px;
    }

    .section-card-header h4 {
        font-size: 16px;
    }

    .section-card-body {
        padding: 12px;
    }

    .item-row {
        padding: 12px;
        flex-direction: column;
        align-items: flex-start;
    }

    .item-image,
    .item-image-placeholder {
        width: 50px;
        height: 50px;
    }

    .item-details h5 {
        font-size: 14px;
    }

    .item-price {
        font-size: 13px;
    }

    .item-subtotal {
        align-self: flex-end;
        margin-left: 0;
        font-size: 16px;
    }

    .info-label {
        font-size: 13px;
    }

    .info-value {
        font-size: 14px;
    }

    .order-summary {
        margin-top: 15px;
        padding-top: 15px;
    }

    .summary-row {
        font-size: 14px;
        padding: 8px 0;
    }

    .summary-row.total {
        font-size: 16px;
        padding-top: 12px;
    }

    .status-badge {
        flex: 1;
        justify-content: center;
        min-width: 0;
    }
}

/* Extra Small Mobile */
@media (max-width: 400px) {
    .order-header-right {
        flex-direction: column;
        gap: 8px;
    }

    .status-badge {
        width: 100%;
    }
}
</style>