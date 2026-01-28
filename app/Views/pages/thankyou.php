<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php helper('text'); ?>
<style>
    .thank-you-order-overview {
        list-style: none;
        padding: 0;
        margin: 0 0 30px 0;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        background: #f8f9fa;
    }
    .thank-you-order-overview li {
        display: flex;
        justify-content: space-between;
        padding: 10px 15px;
        border-bottom: 1px solid #dee2e6;
    }
    .thank-you-order-overview li:last-child {
        border-bottom: none;
    }
    .thank-you-order-overview li strong {
        font-weight: 600;
    }
    .thank-you-order-details table {
        width: 100%;
        border-collapse: collapse;
    }
    .thank-you-order-details th,
    .thank-you-order-details td {
        padding: 10px;
        border: 1px solid #dee2e6;
    }
    .thank-you-order-details tfoot th {
        font-size: 16px;
    }
    .thank-you-order-details tfoot .amount {
        font-size: 16px;
        font-weight: bold;
        color: #28a745;
    }
    .thank-you-customer-details address {
        font-style: normal;
        line-height: 1.6;
    }
    .order-status-info p {
        margin-bottom: 10px;
    }
</style>
<main>
    <!-- Breadcrumb Start -->
    <div class="breadcrumb-section">
        <div class="container-fluid custom-container">
            <div class="breadcrumb-wrapper text-center">
                <h2 class="breadcrumb-wrapper__title">Thank you</h2>
                <ul class="breadcrumb-wrapper__items justify-content-center">
                    <li><a href="<?= base_url('/') ?>">Home</a></li>
                    <li><span>Thank you</span></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Thank You Start -->
    <div class="thank-you-section section-padding-2">
        <div class="container-fluid custom-container">
            <!-- Thank You Table Start -->
            <div class="thank-you">
                <!-- Success Icon -->
                <div class="text-center mb-4">
                    <i class="fas fa-check-circle text-success" style="font-size: 64px;"></i>
                </div>

                <p class="thank-you-notice">
                    Thank you. Your order has been received and is being processed.
                </p>

                <!-- Thank You Order Overview Start -->
                <ul class="thank-you-order-overview">
                    <li>
                        <span>Order number:</span>
                        <strong><?= esc($order['order_number']) ?></strong>
                    </li>
                    <li>
                        <span>Date:</span>
                        <strong><?= date('M d, Y', strtotime($order['created_at'])) ?></strong>
                    </li>
                    <!-- <li>
                        <span>Email:</span>
                        <strong><?= esc($order['email']) ?></strong>
                    </li> -->
                    <li>
                        <span>Total:</span>
                        <strong>₦<?= number_format($order['total_amount'], 2) ?></strong>
                    </li>
                    <!-- <li>
                        <span>Payment method:</span>
                        <strong><?= ucfirst(esc($order['payment_method'])) ?></strong>
                    </li> -->
                </ul>
                <!-- Thank You Order Overview End -->

                <!-- Thank You Order Details Start -->
                <div class="thank-you-order-details">
                    <h3 class="thank-you-title">Order details</h3>

                    <table class="table">
                        <thead>
                            <tr>
                                <th class="product-name">Product</th>
                                <th class="product-total">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($order['items'])): ?>
                                <?php foreach ($order['items'] as $item): ?>
                                    <tr class="order-item">
                                        <td class="product-name">
                                            <a href="<?= base_url('product/' . $item['product_id']) ?>">
                                                <?= esc($item['product_name']) ?>
                                            </a>
                                            <strong>×&nbsp;<?= $item['quantity'] ?></strong>
                                        </td>
                                        <td class="product-total">
                                            <span class="amount">₦<?= number_format($item['price'] * $item['quantity'], 2) ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="2" class="text-center">No items found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Subtotal:</th>
                                <td>
                                    <span class="amount">₦<?= number_format($order['total_amount'] - $order['shipping_fee'], 2) ?></span>
                                </td>
                            </tr>
                            <tr>
                                <th>Shipping:</th>
                                <td>
                                    <span class="amount">
                                        ₦<?= number_format($order['shipping_fee'], 2) ?>
                                        <?php if (!empty($order['shipping_zone_id'])): ?>
                                            <small class="text-muted d-block">
                                                Delivery to: <?= esc($order['city']) ?>, <?= esc($order['state']) ?>
                                            </small>
                                        <?php endif; ?>
                                    </span>
                                </td>
                            </tr>
                            <!-- <tr>
                                <th>Payment method:</th>
                                <td><?= ucfirst(esc($order['payment_method'])) ?></td>
                            </tr> -->
                            <tr>
                                <th>Payment Status:</th>
                                <td>
                                    <?php if ($order['payment_status'] === 'paid'): ?>
                                        <span class="badge bg-success">Paid</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning">Pending</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr class="order-total">
                                <th>Total:</th>
                                <td>
                                    <span class="amount"><strong>₦<?= number_format($order['total_amount'], 2) ?></strong></span>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- Thank You Order Details End -->

                <!-- Thank You Customer Details Start -->
                <div class="row">
                    <div class="col-md-6">
                        <!-- Thank You Customer Billing Start -->
                        <div class="thank-you-customer-details">
                            <h3 class="thank-you-title">Billing & Delivery Address</h3>

                            <address>
                                <?= esc($order['first_name']) ?> <?= esc($order['last_name']) ?><br />
                                <?= esc($order['address']) ?><br />
                                <?= esc($order['city']) ?><br />
                                <?= esc($order['state']) ?><br />
                                <?php if (!empty($order['postal_code'])): ?>
                                    <?= esc($order['postal_code']) ?><br />
                                <?php endif; ?>
                                Nigeria<br />
                                <?= esc($order['phone']) ?><br />
                                <br />
                                <?= esc($order['email']) ?>
                            </address>
                        </div>
                        <!-- Thank You Customer Billing End -->
                    </div>
                    <div class="col-md-6">
                        <!-- Order Status & Tracking -->
                        <div class="thank-you-customer-details">
                            <h3 class="thank-you-title">Order Status</h3>

                            <div class="order-status-info">
                                <p>
                                    <strong>Delivery Status:</strong>
                                    <span class="badge bg-info">
                                        <?= ucfirst(esc($order['delivery_status'])) ?>
                                    </span>
                                </p>

                                <?php if (!empty($order['tracking_number'])): ?>
                                    <p>
                                        <strong>Tracking Number:</strong><br />
                                        <code><?= esc($order['tracking_number']) ?></code>
                                    </p>
                                <?php endif; ?>

                                <?php if (!empty($order['notes'])): ?>
                                    <p>
                                        <strong>Order Notes:</strong><br />
                                        <em class="text-muted"><?= esc($order['notes']) ?></em>
                                    </p>
                                <?php endif; ?>

                                <div class="mt-4">
                                    <p class="text-muted">
                                        <i class="fas fa-info-circle"></i>
                                        You will receive email updates about your order status.
                                    </p>
                                    <p class="text-muted">
                                        <i class="fas fa-headset"></i>
                                        Need help? Contact us at 
                                        <a href="mailto:<?= env('site.adminEmail') ?>">
                                            <?= env('site.adminEmail') ?>
                                        </a>
                                    </p>
                                </div>

                                <div class="mt-3">
                                    <a href="<?= base_url('account') ?>" class="btn bg-primary text-white me-2">
                                        <i class="fas fa-user"></i> View My Orders
                                    </a>
                                    <a href="<?= base_url('shop') ?>" class="btn btn-outline-secondary lg-mt-0 mt-2">
                                        <i class="fas fa-shopping-bag"></i> Continue Shopping
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Thank You Customer Details End -->

                <!-- Additional Info Alert -->
                <?php if ($order['delivery_status'] === 'processing'): ?>
                    <div class="alert alert-info mt-4">
                        <i class="fas fa-box"></i>
                        <strong>What's Next?</strong> 
                        Your order is being prepared for shipment. You'll receive a tracking number once it's dispatched.
                    </div>
                <?php endif; ?>
            </div>
            <!-- Thank You Table End -->
        </div>
    </div>
    <!-- Thank You End -->
</main>

<?= $this->endSection() ?>