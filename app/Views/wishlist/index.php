<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php helper(['cart', 'wishlist']); ?>

<main>
    <!-- Breadcrumb Start -->
    <div class="breadcrumb-section">
        <div class="container-fluid custom-container">
            <div class="breadcrumb-wrapper text-center">
                <h2 class="breadcrumb-wrapper__title">Wishlist</h2>
                <ul class="breadcrumb-wrapper__items justify-content-center">
                    <li><a href="<?= base_url('shop') ?>">Back</a></li>
                    <li><span>Wishlist</span></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Wishlist Start -->
    <div class="wishlist-section section-padding-2">
        <div class="container-fluid custom-container">

            <?php if (empty($wishlist)): ?>
                <!-- Empty Wishlist -->
                <div class="text-center py-5">
                    <i class="fas fa-heart" style="font-size:80px;color:#ddd;"></i>
                    <h3 class="mt-4">Your wishlist is empty</h3>
                    <p class="text-muted">Add products to your wishlist to save them for later.</p>
                    <a href="<?= base_url('shop') ?>" class="btn btn-primary mt-3">
                        Start Shopping
                    </a>
                </div>
            <?php else: ?>

                <!-- Wishlist Table Start -->
                <div class="wishlist-table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="product-remove">&nbsp;</th>
                                <th class="product-thumbnail">&nbsp;</th>
                                <th class="product-name">Product</th>
                                <th class="product-price text-md-center">Price</th>
                                <th class="product-stock text-md-center">Stock status</th>
                                <th class="product-action text-md-end"></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($wishlist as $item): ?>
                                <tr class="wishlist-item" data-product-id="<?= $item['product_id'] ?>">
                                    <!-- Remove -->
                                    <td class="product-remove">
                                        <a href="javascript:void(0)"
                                           class="remove remove-from-wishlist"
                                           data-product-id="<?= $item['product_id'] ?>">
                                            ×
                                        </a>
                                    </td>

                                    <!-- Image -->
                                    <td class="product-thumbnail">
                                        <a href="<?= base_url('product/' . $item['product_id']) ?>">
                                            <img
                                                src="<?= base_url('assets/uploads/products/' . ($item['image'] ?? 'default.png')) ?>"
                                                alt="<?= esc($item['name']) ?>"
                                                width="90"
                                                height="114"
                                            />
                                        </a>
                                    </td>

                                    <!-- Name -->
                                    <td class="product-name">
                                        <a href="<?= base_url('product/' . $item['product_id']) ?>">
                                            <?= esc($item['name']) ?>
                                        </a>
                                    </td>

                                    <!-- Price -->
                                    <td class="product-price text-md-center" data-title="Price">
                                        <span>
                                            <?= format_currency($item['price']) ?>
                                        </span>
                                    </td>

                                    <!-- Stock -->
                                    <td class="product-stock text-md-center" data-title="Stock status">
                                        <?php if ($item['stock_quantity'] > 0): ?>
                                            <span class="stock in-stock">In stock</span>
                                        <?php else: ?>
                                            <span class="stock out-of-stock">Out of stock</span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Action -->
                                    <td class="product-action text-md-end">
                                        <?php if ($item['stock_quantity'] > 0): ?>
                                            <button
                                                class="wishlist-table__btn btn move-to-cart"
                                                data-product-id="<?= $item['product_id'] ?>">
                                                Add to cart
                                            </button>
                                        <?php else: ?>
                                            <button class="wishlist-table__btn btn" disabled>
                                                Out of stock
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
                <!-- Wishlist Table End -->

            <?php endif; ?>
        </div>
    </div>
    <!-- Wishlist End -->
</main>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Store CSRF token name and value
let csrfToken = {
    name: '<?= csrf_token() ?>',
    hash: '<?= csrf_hash() ?>'
};

// Function to update CSRF token from response
function updateCsrfToken(data) {
    if (data.csrf_token_name && data.csrf_token_hash) {
        csrfToken.name = data.csrf_token_name;
        csrfToken.hash = data.csrf_token_hash;
    }
}

// Track products already added to cart (to prevent duplicate notifications)
const addedToCart = new Set();

document.addEventListener('DOMContentLoaded', function() {

    // Move to Cart (Add to cart from wishlist)
    document.querySelectorAll('.move-to-cart').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            const row = this.closest('tr');
            const originalText = this.textContent;
            
            // Check if already added
            if (addedToCart.has(productId)) {
                if (typeof Toast !== 'undefined') {
                    Toast.info('This item is already in your cart');
                } else {
                    alert('This item is already in your cart');
                }
                return;
            }
            
            // Disable button while processing
            this.disabled = true;
            this.textContent = 'Adding...';
            
            const formData = new FormData();
            formData.append('product_id', productId);
            formData.append(csrfToken.name, csrfToken.hash);
            
            // FIXED: Changed URL to match your route
            fetch('<?= base_url('wishlist/move-to-cart') ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Update CSRF token for next request
                updateCsrfToken(data);
                
                if (data.success) {
                    // Mark as added to cart
                    addedToCart.add(productId);
                    
                    // Update button to show success
                    this.textContent = '✓ Added to Cart';
                    this.classList.add('btn-success');
                    
                    // Update cart count badge
                    const badge = document.getElementById('cart-count-badge');
                    if (badge && data.cart_count) {
                        badge.textContent = String(data.cart_count).padStart(2, '0');
                        badge.style.display = 'inline-block';
                    }
                    
                    const mobileBadge = document.getElementById('mobile-cart-count-badge');
                    if (mobileBadge && data.cart_count) {
                        mobileBadge.textContent = String(data.cart_count).padStart(2, '0');
                        mobileBadge.style.display = 'inline-block';
                    }
                    
                    // Update wishlist count
                    if (data.wishlist_count > 0) {
                        const wishlistBadge = document.getElementById('wishlist-count-badge');
                        if (wishlistBadge) {
                            wishlistBadge.textContent = String(data.wishlist_count).padStart(2, '0');
                            wishlistBadge.style.display = 'inline-block';
                        }
                        
                        const mobileWishlistBadge = document.getElementById('mobile-wishlist-count-badge');
                        if (mobileWishlistBadge) {
                            mobileWishlistBadge.textContent = String(data.wishlist_count).padStart(2, '0');
                            mobileWishlistBadge.style.display = 'inline-block';
                        }
                    } else {
                        const wishlistBadge = document.getElementById('wishlist-count-badge');
                        if (wishlistBadge) wishlistBadge.style.display = 'none';
                        
                        const mobileWishlistBadge = document.getElementById('mobile-wishlist-count-badge');
                        if (mobileWishlistBadge) mobileWishlistBadge.style.display = 'none';
                    }
                    
                    // Show success notification
                    if (typeof Toast !== 'undefined') {
                        Toast.success('Product moved to cart successfully!');
                    }
                    
                    // Trigger custom events
                    document.dispatchEvent(new Event('cartUpdated'));
                    document.dispatchEvent(new Event('wishlistUpdated'));
                    
                    // Remove row from table with animation after delay
                    setTimeout(() => {
                        row.style.opacity = '0';
                        row.style.transition = 'opacity 0.3s ease';
                        
                        setTimeout(() => {
                            row.remove();
                            
                            // Check if wishlist is now empty
                            const remainingItems = document.querySelectorAll('.wishlist-item');
                            if (remainingItems.length === 0) {
                                location.reload();
                            }
                        }, 300);
                    }, 800);
                    
                } else {
                    // Show error message
                    if (typeof Toast !== 'undefined') {
                        Toast.error(data.message || 'Failed to add product to cart');
                    } else {
                        alert(data.message || 'Failed to add product to cart');
                    }
                    
                    // Reset button
                    this.disabled = false;
                    this.textContent = originalText;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                
                if (typeof Toast !== 'undefined') {
                    Toast.error('An error occurred. Please try again.');
                } else {
                    alert('An error occurred. Please try again.');
                }
                
                // Reset button
                this.disabled = false;
                this.textContent = originalText;
            });
        });
    });

    // Remove from Wishlist - Works on both mobile and desktop
    document.querySelectorAll('.remove-from-wishlist').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // if (!confirm('Remove this item from wishlist?')) return;
            
            const productId = this.getAttribute('data-product-id');
            const row = this.closest('tr');
            
            const formData = new FormData();
            formData.append('product_id', productId);
            formData.append(csrfToken.name, csrfToken.hash);
            
            fetch('<?= base_url('wishlist/remove') ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Update CSRF token for next request
                updateCsrfToken(data);
                
                if (data.success) {
                    // Update wishlist count
                    if (data.wishlist_count > 0) {
                        const wishlistBadge = document.getElementById('wishlist-count-badge');
                        if (wishlistBadge) {
                            wishlistBadge.textContent = String(data.wishlist_count).padStart(2, '0');
                            wishlistBadge.style.display = 'inline-block';
                        }
                        
                        const mobileWishlistBadge = document.getElementById('mobile-wishlist-count-badge');
                        if (mobileWishlistBadge) {
                            mobileWishlistBadge.textContent = String(data.wishlist_count).padStart(2, '0');
                            mobileWishlistBadge.style.display = 'inline-block';
                        }
                    } else {
                        const wishlistBadge = document.getElementById('wishlist-count-badge');
                        if (wishlistBadge) wishlistBadge.style.display = 'none';
                        
                        const mobileWishlistBadge = document.getElementById('mobile-wishlist-count-badge');
                        if (mobileWishlistBadge) mobileWishlistBadge.style.display = 'none';
                    }
                    
                    // Show success notification
                    if (typeof Toast !== 'undefined') {
                        Toast.success('Item removed from wishlist');
                    }
                    
                    // Trigger custom event
                    document.dispatchEvent(new Event('wishlistUpdated'));
                    
                    // Remove row with animation
                    row.style.opacity = '0';
                    row.style.transition = 'opacity 0.3s ease';
                    
                    setTimeout(() => {
                        row.remove();
                        
                        // Check if wishlist is now empty
                        const remainingItems = document.querySelectorAll('.wishlist-item');
                        if (remainingItems.length === 0) {
                            location.reload();
                        }
                    }, 300);
                    
                } else {
                    if (typeof Toast !== 'undefined') {
                        Toast.error(data.message || 'Failed to remove item from wishlist');
                    } else {
                        alert(data.message || 'Failed to remove item from wishlist');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                
                if (typeof Toast !== 'undefined') {
                    Toast.error('An error occurred. Please try again.');
                } else {
                    alert('An error occurred. Please try again.');
                }
            });
        });
    });

});
</script>
<?= $this->endSection() ?>