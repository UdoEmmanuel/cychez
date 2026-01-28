<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Riverine Order Requires Fee Confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <!-- Warning Header -->
        <div style="background: #fff3cd; border: 2px solid #ffc107; border-radius: 5px; padding: 15px; margin-bottom: 20px;">
            <h2 style="color: #856404; margin-top: 0;">
                ⚠️ Riverine Area Order - Fee Confirmation Required
            </h2>
            <p style="margin: 0; color: #856404;">
                This order is being delivered to a riverine/hard-to-reach area. 
                Please confirm the final delivery fee with the customer before dispatch.
            </p>
        </div>
        
        <h3 style="color: #dc3545;">Priority Action Required</h3>
        <p>
            A new order has been placed for delivery to a riverine location. 
            The customer has paid an estimated shipping fee, but the final logistics cost 
            needs to be confirmed before dispatch.
        </p>
        
        <!-- Order Details -->
        <div style="background: #f8f9fa; padding: 15px; margin: 20px 0; border-radius: 5px;">
            <h3 style="margin-top: 0;">Order Details</h3>
            <p><strong>Order Number:</strong> <?= esc($order['order_number']) ?></p>
            <p><strong>Order Date:</strong> <?= date('F d, Y H:i', strtotime($order['created_at'])) ?></p>
            <p><strong>Cart Subtotal:</strong> ₦<?= number_format($order['total_amount'] - ($order['shipping_fee'] ?? 0), 2) ?></p>
            <p><strong>Estimated Shipping Fee:</strong> 
                <span style="color: #ffc107;">₦<?= number_format($order['shipping_fee'] ?? 0, 2) ?></span>
            </p>
            <p><strong>Total Paid:</strong> <strong>₦<?= number_format($order['total_amount'], 2) ?></strong></p>
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
        <h3 style="color: #dc3545;">Delivery Address (Riverine Area)</h3>
        <div style="background: #fff3cd; border: 1px solid #ffc107; padding: 15px; border-radius: 5px;">
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
        
        <!-- Action Items -->
        <div style="background: #d1ecf1; border: 1px solid #bee5eb; padding: 15px; margin: 20px 0; border-radius: 5px;">
            <h3 style="margin-top: 0; color: #0c5460;">Next Steps:</h3>
            <ol style="margin: 0; padding-left: 20px;">
                <li>Contact the customer via phone (<strong><?= esc($order['phone']) ?></strong>) to confirm the exact delivery location</li>
                <li>Get a logistics quote for the riverine delivery</li>
                <li>If the actual fee exceeds the estimated fee of <strong>₦<?= number_format($order['shipping_fee'] ?? 0, 2) ?></strong>, 
                    inform the customer and offer options:
                    <ul>
                        <li>Pay the difference via bank transfer before dispatch</li>
                        <li>Cancel and refund the order</li>
                        <li>Arrange pickup from a mainland location instead</li>
                    </ul>
                </li>
                <li>Update the order status once confirmed</li>
            </ol>
        </div>
        
        <!-- Admin Action Buttons -->
        <p style="text-align: center; margin: 30px 0;">
            <a href="<?= base_url('admin/orders/view/' . $order['id']) ?>" 
               style="display: inline-block; padding: 12px 30px; background: #007bff; color: #fff; text-decoration: none; border-radius: 5px; margin: 5px;">
                View Full Order Details
            </a>
            <a href="tel:<?= esc($order['phone']) ?>" 
               style="display: inline-block; padding: 12px 30px; background: #28a745; color: #fff; text-decoration: none; border-radius: 5px; margin: 5px;">
                📞 Call Customer
            </a>
        </p>
        
        <!-- Important Reminder -->
        <div style="background: #f8d7da; border: 1px solid #f5c6cb; padding: 15px; border-radius: 5px; margin-top: 20px;">
            <p style="margin: 0; color: #721c24;">
                <strong>⚠️ Important:</strong> Do not dispatch this order until the final shipping fee is confirmed and 
                any additional payment (if required) is received. This protects both the business and ensures 
                customer satisfaction.
            </p>
        </div>
        
        <hr style="border: 1px solid #ddd; margin: 30px 0;">
        
        <p style="font-size: 12px; color: #666;">
            This is an automated notification from the Cychez Store shipping system. 
            Orders to riverine areas trigger this alert to prevent logistics disputes.
        </p>
    </div>
</body>
</html>