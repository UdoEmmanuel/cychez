<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation</title>
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
        
        <h2 style="color: #007bff;">Order Confirmation</h2>
        
        <p>Dear <?= esc($order['first_name']) ?>,</p>
        
        <p>Thank you for your order! Your order has been successfully placed and payment confirmed.</p>
        
        <!-- Order Details with Shipping Breakdown -->
        <div style="background: #f8f9fa; padding: 15px; margin: 20px 0; border-radius: 5px;">
            <h3 style="margin-top: 0;">Order Details</h3>
            <p><strong>Order Number:</strong> <?= esc($order['order_number']) ?></p>
            <p><strong>Order Date:</strong> <?= date('F d, Y', strtotime($order['created_at'])) ?></p>
            
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
                        <td style="padding: 5px 0;">
                            Shipping Fee<?php if (isset($order['is_riverine']) && $order['is_riverine']): ?>
                                <span style="color: #ffc107;">*</span>
                            <?php endif; ?>:
                        </td>
                        <td style="text-align: right; padding: 5px 0; color: #007bff; font-weight: bold;">
                            ₦<?= number_format($order['shipping_fee'] ?? 0, 2) ?>
                        </td>
                    </tr>
                    <tr style="border-top: 2px solid #007bff;">
                        <td style="padding: 10px 0; font-size: 16px;"><strong>Total Amount Paid:</strong></td>
                        <td style="text-align: right; padding: 10px 0; font-size: 16px; font-weight: bold; color: #28a745;">
                            ₦<?= number_format($order['total_amount'], 2) ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        
        <!-- Riverine Area Notice -->
        <?php if (isset($order['is_riverine']) && $order['is_riverine']): ?>
            <div style="background: #fff3cd; border: 1px solid #ffc107; padding: 15px; margin: 20px 0; border-radius: 5px;">
                <p style="margin: 0; color: #856404;">
                    <strong>⚠️ Riverine Area Delivery Notice:</strong><br>
                    Your delivery location requires special logistics. Our team will contact you within 24 hours 
                    to confirm the final delivery fee and estimated delivery time. If there's any adjustment needed, 
                    we'll inform you before dispatch.
                </p>
            </div>
        <?php endif; ?>
        
        <!-- Delivery Information -->
        <h3>Delivery Information</h3>
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
                <p><strong>Your Notes:</strong><br><?= nl2br(esc($order['notes'])) ?></p>
            <?php endif; ?>
        </div>
        
        <!-- Order Status -->
        <div style="background: #d1ecf1; border: 1px solid #bee5eb; padding: 15px; margin: 20px 0; border-radius: 5px;">
            <h3 style="margin-top: 0; color: #0c5460;">What Happens Next?</h3>
            <ol style="margin: 0; padding-left: 20px;">
                <li>Your order is now being prepared for shipment</li>
                <li>You'll receive a shipping confirmation email with tracking information</li>
                <li>Estimated delivery: 3-7 business days (depending on your location)</li>
                <li>Our customer service team is available if you have any questions</li>
            </ol>
        </div>
        
        <!-- Contact Info -->
        <p>If you have any questions about your order, please contact us:</p>
        <p>
            Email: <a href="mailto:<?= env('site.adminEmail') ?>"><?= env('site.adminEmail') ?></a><br>
            Phone: <?= env('site.phone', '+234 803 309 5016') ?>
        </p>
        
        <p>Thank you for shopping with us!</p>
        
        <!-- <p style="text-align: center; margin: 30px 0;">
            <a href="<?= base_url('orders/' . $order['id']) ?>" 
               style="display: inline-block; padding: 12px 30px; background: #007bff; color: #fff; text-decoration: none; border-radius: 5px;">
                Track Your Order
            </a>
        </p> -->
        
        <hr style="border: 1px solid #ddd; margin: 30px 0;">
        
        <p style="font-size: 12px; color: #666;">
            This is an automated email. Please do not reply to this message.<br>
            If you need assistance, please contact us using the details above.
        </p>
    </div>
</body>
</html>