<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Order Notification</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">

        <!-- LOGO HEADER -->
        <div style="text-align: center; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 2px solid #007bff;">
            <img src="<?= base_url('assets/images/Logo-modified.jpg') ?>" 
                 alt="Cychez Store" 
                 style="max-width: 200px; height: auto; display: block; margin: 0 auto;">
            <p style="margin: 10px 0 0 0; color: #666; font-size: 14px;">
                Premium Products, Delivered with Care
            </p>
        </div>
        
        <h2 style="color: #007bff;">New Order Received</h2>
        
        <p>A new order has been placed on your store.</p>
        
        <!-- Order Details with Shipping Breakdown -->
        <div style="background: #f8f9fa; padding: 15px; margin: 20px 0; border-radius: 5px;">
            <h3 style="margin-top: 0;">Order Details</h3>
            <p><strong>Order Number:</strong> <?= esc($order['order_number']) ?></p>
            <p><strong>Order Date:</strong> <?= date('F d, Y H:i', strtotime($order['created_at'])) ?></p>
            
            <!-- Shipping Breakdown -->
            <div style="border-top: 1px solid #dee2e6; margin-top: 15px; padding-top: 15px;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 5px 0;">Cart Subtotal:</td>
                        <td style="text-align: right; padding: 5px 0;">
                            ₦<?= number_format($order['total_amount'] - ($order['shipping_fee'] ?? 0), 2) ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 5px 0;">Shipping Fee:</td>
                        <td style="text-align: right; padding: 5px 0; color: #007bff;">
                            ₦<?= number_format($order['shipping_fee'] ?? 0, 2) ?>
                        </td>
                    </tr>
                    <?php if (!empty($order['shipping_zone_name'])): ?>
                    <tr>
                        <td colspan="2" style="padding: 5px 0; font-size: 12px; color: #666;">
                            Shipping Zone: <?= esc($order['shipping_zone_name']) ?>
                        </td>
                    </tr>
                    <?php endif; ?>
                    <tr style="border-top: 2px solid #007bff;">
                        <td style="padding: 10px 0; font-size: 16px;"><strong>Total Amount:</strong></td>
                        <td style="text-align: right; padding: 10px 0; font-size: 16px; font-weight: bold; color: #28a745;">
                            ₦<?= number_format($order['total_amount'], 2) ?>
                        </td>
                    </tr>
                </table>
            </div>
            
            <p style="margin-top: 15px;">
                <strong>Payment Status:</strong> 
                <span style="color: <?= $order['payment_status'] === 'paid' ? '#28a745' : '#ffc107' ?>;">
                    <?= ucfirst($order['payment_status']) ?>
                </span>
            </p>
        </div>
        
        <!-- Customer Information -->
        <h3>Customer Information</h3>
        <div style="background: #fff; border: 1px solid #dee2e6; padding: 15px; border-radius: 5px;">
            <p>
                <strong>Name:</strong> <?= esc($order['first_name']) ?> <?= esc($order['last_name']) ?><br>
                <strong>Email:</strong> <a href="mailto:<?= esc($order['email']) ?>"><?= esc($order['email']) ?></a><br>
                <strong>Phone:</strong> <a href="tel:<?= esc($order['phone']) ?>"><?= esc($order['phone']) ?></a>
            </p>
        </div>
        
        <!-- Delivery Address -->
        <h3>Delivery Address</h3>
        <div style="background: #fff; border: 1px solid #dee2e6; padding: 15px; border-radius: 5px;">
            <p>
                <strong><?= esc($order['address']) ?></strong><br>
                <?= esc($order['city']) ?>, <?= esc($order['state']) ?><br>
                <?= esc($order['country']) ?><br>
                <?php if (!empty($order['postal_code'])): ?>
                    Postal Code: <?= esc($order['postal_code']) ?><br>
                <?php endif; ?>
            </p>
            <?php if (!empty($order['notes'])): ?>
                <p><strong>Customer Notes:</strong><br><?= nl2br(esc($order['notes'])) ?></p>
            <?php endif; ?>
        </div>
        
        <!-- Admin Actions -->
        <p style="text-align: center; margin: 30px 0;">
            <a href="<?= base_url('admin/orders/view/' . $order['id']) ?>" 
               style="display: inline-block; padding: 12px 30px; background: #007bff; color: #fff; text-decoration: none; border-radius: 5px;">
                View Full Order Details
            </a>
        </p>
        
        <hr style="border: 1px solid #ddd; margin: 30px 0;">
        
        <p style="font-size: 12px; color: #666;">
            This is an automated notification from the Cychez Store order management system.
        </p>
    </div>
</body>
</html>