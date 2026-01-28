<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php helper('cart'); ?>

<div class="mb-4">
    <h4>Orders</h4>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Order Number</th>
                        <th>Customer</th>
                        <th>Email</th>
                        <th>Total</th>
                        <th>Payment</th>
                        <th>Delivery Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?= esc($order['order_number']) ?></td>
                            <td><?= esc($order['user_first_name'] ?? $order['first_name']) ?> <?= esc($order['user_last_name'] ?? $order['last_name']) ?></td>
                            <td><?= esc($order['email']) ?></td>
                            <td><?= format_currency($order['total_amount']) ?></td>
                            <td>
                                <span class="badge bg-<?= $order['payment_status'] === 'paid' ? 'success' : 'warning' ?>">
                                    <?= ucfirst($order['payment_status']) ?>
                                </span>
                            </td>
                            <td>
                                <select class="form-select form-select-sm order-status-select" 
                                        data-order-id="<?= $order['id'] ?>"
                                        data-order-number="<?= esc($order['order_number']) ?>"
                                        data-original-status="<?= $order['delivery_status'] ?>">
                                    <option value="pending" <?= $order['delivery_status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="processing" <?= $order['delivery_status'] === 'processing' ? 'selected' : '' ?>>Processing</option>
                                    <option value="shipped" <?= $order['delivery_status'] === 'shipped' ? 'selected' : '' ?>>Shipped</option>
                                    <option value="delivered" <?= $order['delivery_status'] === 'delivered' ? 'selected' : '' ?>>Delivered</option>
                                    <!-- <option value="cancelled" <?= $order['delivery_status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option> -->
                                </select>
                                <small class="status-message text-muted" style="display:none;"></small>
                            </td>
                            <td><?= date('M d, Y', strtotime($order['created_at'])) ?></td>
                            <td>
                                <a href="<?= base_url('admin/orders/view/' . $order['id']) ?>" 
                                   class="btn btn-sm btn-primary"> View
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <?php if (isset($pager)): ?>
            <div class="mt-3">
                <?= $pager->links() ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Store CSRF token globally and update it after each request
window.csrfTokenName = '<?= csrf_token() ?>';
window.csrfHash = '<?= csrf_hash() ?>';

document.addEventListener('DOMContentLoaded', function() {
    const selects = document.querySelectorAll('.order-status-select');
    
    selects.forEach(function(select) {
        select.addEventListener('change', function() {
            const orderId = this.dataset.orderId;
            const orderNumber = this.dataset.orderNumber;
            const newStatus = this.value;
            const originalStatus = this.dataset.originalStatus;
            const statusMessage = this.nextElementSibling;
            const selectElement = this;
            
            // Disable dropdown and show loading
            selectElement.disabled = true;
            statusMessage.textContent = 'Updating...';
            statusMessage.style.color = '#0d6efd';
            statusMessage.style.display = 'block';
            
            // Prepare form data with current CSRF token
            const formData = new FormData();
            formData.append('order_id', orderId);
            formData.append('delivery_status', newStatus);
            formData.append(window.csrfTokenName, window.csrfHash);
            
            // Send request
            fetch('<?= base_url("admin/orders/update-status") ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('HTTP ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                selectElement.disabled = false;
                
                if (data.success) {
                    // Update CSRF token for next request
                    if (data.csrf_token_name && data.csrf_hash) {
                        window.csrfTokenName = data.csrf_token_name;
                        window.csrfHash = data.csrf_hash;
                    }
                    
                    statusMessage.textContent = '✓ Updated';
                    statusMessage.style.color = '#198754';
                    setTimeout(() => {
                        statusMessage.style.display = 'none';
                    }, 3000);
                    
                    // Update original status
                    selectElement.dataset.originalStatus = newStatus;
                    
                    if (typeof Toast !== 'undefined') {
                        Toast.success('Order status updated successfully!');
                    }
                } else {
                    statusMessage.textContent = '✗ Failed';
                    statusMessage.style.color = '#dc3545';
                    setTimeout(() => {
                        statusMessage.style.display = 'none';
                    }, 5000);
                    
                    selectElement.value = originalStatus;
                    if (typeof Toast !== 'undefined') {
                        Toast.error('Error: ' + (data.message || 'Failed to update'));
                    }
                }
            })
            .catch(error => {
                selectElement.disabled = false;
                statusMessage.textContent = '✗ Error';
                statusMessage.style.color = '#dc3545';
                setTimeout(() => {
                    statusMessage.style.display = 'none';
                }, 5000);
                
                selectElement.value = originalStatus;
                
                if (typeof Toast !== 'undefined') {
                    Toast.error('Failed to update order status');
                }
            });
        });
    });
});
</script>

<style>
.order-status-select {
    min-width: 130px;
}
.order-status-select:disabled {
    opacity: 0.5;
    cursor: wait;
}
.status-message {
    display: block;
    font-size: 0.75rem;
    margin-top: 2px;
}
</style>

<?= $this->endSection() ?>