<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php helper('cart'); ?>

<main>

    <!-- Breadcrumb Start -->
    <div class="breadcrumb-section">
        <div class="container-fluid custom-container">
            <div class="breadcrumb-wrapper text-center">
                <h2 class="breadcrumb-wrapper__title">Cart</h2>
                <ul class="breadcrumb-wrapper__items justify-content-center">
                    <li><a href="<?= base_url('/') ?>">Home</a></li>
                    <li><span>Cart</span></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Cart Start -->
    <div class="cart-section section-padding-2">
        <div class="container-fluid custom-container">

            <div class="cart-wrapper">

                <!-- Cart Table - Desktop View -->
                <div class="cart-form d-none d-lg-block">
                    <div class="cart-table table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th>Product</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Subtotal</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($cart as $item): ?>
                                    <tr class="cart-item">

                                        <!-- Remove -->
                                        <td class="cart-product-remove">
                                            <button type="button" class="remove remove-from-cart"
                                                    data-product-id="<?= $item['id'] ?>"
                                                    aria-label="Remove item">×</button>
                                        </td>

                                        
                                        <!-- Image -->
                                        <td class="cart-product-thumbnail">
                                            <a href="<?= base_url('shop/product/' . $item['id']) ?>">
                                                <img src="<?= base_url('assets/uploads/products/' . ($item['image'] ?? 'default.png')) ?>"
                                                     width="70" height="89"
                                                     alt="<?= esc($item['name']) ?>">
                                            </a>
                                        </td>

                                        <!-- Name -->
                                        <td class="cart-product-name">
                                            <a href="<?= base_url('shop/product/' . $item['id']) ?>">
                                                <?= esc($item['name']) ?>
                                            </a>
                                        </td>

                                        <!-- Price -->
                                        <td class="cart-product-price text-center">
                                            ₦<?= number_format($item['price']) ?>
                                        </td>

                                        <!-- Quantity (Read-only Display) -->
                                        <td class="cart-product-quantity text-center">
                                            <span class="quantity-display"><?= $item['quantity'] ?></span>
                                        </td>

                                        <!-- Subtotal -->
                                        <td class="cart-product-subtotal text-center">
                                            ₦<?= number_format($item['price'] * $item['quantity']) ?>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Cart Cards - Mobile View -->
                <div class="cart-mobile d-lg-none">
                    <?php foreach ($cart as $item): ?>
                        <div class="cart-mobile-item mb-3 p-3 border rounded position-relative" data-product-id="<?= $item['id'] ?>">
                            
                            <!-- Remove Button -->
                            <button type="button" class="remove remove-from-cart position-absolute"
                                    data-product-id="<?= $item['id'] ?>"
                                    aria-label="Remove item"
                                    style="top: 10px; right: 10px; border: none; background: #dc3545; color: white; width: 30px; height: 30px; border-radius: 50%; font-size: 20px; line-height: 1; cursor: pointer;">×</button>
                            
                            <div class="row align-items-center">
                                <!-- Product Image -->
                                <div class="col-4">
                                    <a href="<?= base_url('shop/product/' . $item['id']) ?>">
                                        <img src="<?= base_url('assets/uploads/products/' . ($item['image'] ?? 'default.png')) ?>"
                                             class="img-fluid rounded"
                                             alt="<?= esc($item['name']) ?>">
                                    </a>
                                </div>
                                
                                <!-- Product Details -->
                                <div class="col-8">
                                    <h6 class="mb-2">
                                        <a href="<?= base_url('shop/product/' . $item['id']) ?>" class="text-dark text-decoration-none">
                                            <?= esc($item['name']) ?>
                                        </a>
                                    </h6>
                                    
                                    <p class="mb-1"><strong>Price:</strong> ₦<?= number_format($item['price']) ?></p>
                                    
                                    <!-- Quantity Display (Read-only) -->
                                    <div class="mb-2">
                                        <span><strong>Qty:</strong> <?= $item['quantity'] ?></span>
                                    </div>
                                    
                                    <p class="mb-0"><strong>Subtotal:</strong> <span class="text-primary">₦<?= number_format($item['price'] * $item['quantity']) ?></span></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Cart Totals -->
                <div class="cart-collaterals">
                    <div class="cart-totals">
                        <h3 class="cart-totals__title">Cart totals</h3>

                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Subtotal</th>
                                    <td>₦<?= number_format(get_cart_total()) ?></td>
                                </tr>
                                <tr class="order-total">
                                    <th>Total</th>
                                    <td><strong>₦<?= number_format(get_cart_total()) ?></strong></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="cart-totals__checkout">
                            <a href="<?= base_url('checkout') ?>">Proceed to checkout</a>
                        </div>

                        <div class="mt-3 text-center">
                            <a href="<?= base_url('shop') ?>">Continue Shopping</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Cart End -->

</main>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Remove item from cart
    document.querySelectorAll('.remove-from-cart').forEach(function(button) {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            
            console.log('Remove button clicked');
            
            // CONFIRMATION TO REMOVE PRODUCT
            // if (!confirm('Remove this item from cart?')) {
            //     return false;
            // }

            const productId = this.dataset.productId;
            
            console.log('Product ID:', productId);
            
            // Disable button to prevent double clicks
            this.disabled = true;

            fetch('<?= base_url('cart/remove') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    product_id: productId,
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Response:', data);
                if (data.success) {
                    // Show success notification
                    if (typeof Toast !== 'undefined') {
                        Toast.success('Item removed from cart');
                    } else {
                        alert('Item removed from cart');
                    }
                    location.reload();
                } else {
                    if (typeof Toast !== 'undefined') {
                        Toast.error('Failed to remove item from cart');
                    }
                    alert('Failed to remove item from cart');
                    this.disabled = false;
                }
            })
            .catch(error => {
                console.error('Remove error:', error);
                alert('An error occurred while removing the item');
                this.disabled = false;
            });
            
            return false;
        });
    });

});
</script>
<?= $this->endSection() ?>