<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php helper('cart'); ?>

<div class="mb-4">
    <a href="<?= base_url('admin/orders') ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Orders
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5>Order <?= esc($order['order_number']) ?></h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($order['items'] as $item): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php if ($item['product_image']): ?>
                                                <img src="<?= base_url('assets/uploads/products/' . $item['product_image']) ?>" 
                                                    alt="<?= esc($item['product_name']) ?>" 
                                                    width="50" class="me-3">
                                            <?php endif; ?>
                                            <span><?= esc($item['product_name']) ?></span>
                                        </div>
                                    </td>
                                    <td><?= format_currency($item['price']) ?></td>
                                    <td><?= $item['quantity'] ?></td>
                                    <td><?= format_currency($item['subtotal']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                <td><strong><?= format_currency($order['total_amount']) ?></strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5>Order Details</h5>
            </div>
            <div class="card-body">
                <p><strong>Order Date:</strong><br><?= date('F d, Y H:i', strtotime($order['created_at'])) ?></p>
                <p><strong>Payment Status:</strong><br>
                    <span class="badge bg-<?= $order['payment_status'] === 'paid' ? 'success' : 'warning' ?>">
                        <?= ucfirst($order['payment_status']) ?>
                    </span>
                </p>
                <p><strong>Delivery Status:</strong><br>
                    <span class="badge bg-<?= $order['delivery_status'] === 'delivered' ? 'success' : 'info' ?>">
                        <?= ucfirst($order['delivery_status']) ?>
                    </span>
                </p>
                <?php if ($order['payment_reference']): ?>
                    <p><strong>Payment Reference:</strong><br><?= esc($order['payment_reference']) ?></p>
                <?php endif; ?>
                <?php if ($order['tracking_number']): ?>
                    <p><strong>Tracking Number:</strong><br><?= esc($order['tracking_number']) ?></p>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h5>Customer Information</h5>
            </div>
            <div class="card-body">
                <p><strong>Name:</strong><br><?= esc($order['first_name']) ?> <?= esc($order['last_name']) ?></p>
                <p><strong>Email:</strong><br><?= esc($order['email']) ?></p>
                <p><strong>Phone:</strong><br><?= esc($order['phone']) ?></p>
                <hr>
                <p><strong>Delivery Address:</strong><br>
                    <?= esc($order['address']) ?><br>
                    <?= esc($order['city']) ?>, <?= esc($order['state']) ?><br>
                    <?= esc($order['country']) ?>
                    <?php if ($order['postal_code']): ?>
                        - <?= esc($order['postal_code']) ?>
                    <?php endif; ?>
                </p>
                <?php if ($order['notes']): ?>
                    <hr>
                    <p><strong>Order Notes:</strong><br><?= nl2br(esc($order['notes'])) ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>