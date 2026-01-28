<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<main>
    <!-- Breadcrumb Start -->
    <div class="breadcrumb-section">
        <div class="container-fluid custom-container">
            <div class="breadcrumb-wrapper text-center">
                <h2 class="breadcrumb-wrapper__title">
                    Cychez Beauty Boat
                </h2>
                <ul class="breadcrumb-wrapper__items justify-content-center">
                    <li><a href="<?= base_url() ?>">Home</a></li>
                    <li><span>Shop</span></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Shop Start -->
    <div class="shop-section section-padding-2">
        <div class="container-fluid custom-container">
            <!-- Shop Wrapper Start -->
            <div class="shop-wrapper">
                <div class="row">
                    <?php if (isset($keyword) && !empty($keyword)): ?>
                        <div class="col-12 mb-4">
                            <h4>Showing results for: "<?= esc($keyword) ?>"</h4>
                        </div>
                    <?php endif; ?>

                    <?php if (empty($products)): ?>
                        <div class="col-12">
                            <div class="text-center py-5">
                                <p>No products found.</p>
                            </div>
                        </div>
                    <?php else: ?>
                        <?php 
                        helper('cart');
                        foreach ($products as $product): 
                            $hasDiscount = isset($product['sale_price']) && $product['sale_price'] > 0 && $product['sale_price'] < $product['price'];
                            $isOutOfStock = isset($product['stock_quantity']) && $product['stock_quantity'] <= 0;
                        ?>
                            <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                                <!-- Single product Start -->
                                <div class="single-product js-scroll ShortFadeInUp">
                                    <div class="single-product__thumbnail">
                                        <div class="single-product__thumbnail--meta-3" style="font-size: 18px;">
                                            <a href="javascript:void(0)" onclick="addToWishlist(<?= $product['id'] ?>)" data-bs-tooltip="tooltip" data-bs-placement="top" data-bs-title="Add to wishlist" data-bs-custom-class="p-meta-tooltip" aria-label="Add to wishlist">
                                                <i class="lastudioicon-heart-2"></i>
                                            </a>
                                        </div>
                                        <?php if ($hasDiscount): ?>
                                            <div class="single-product__thumbnail--badge onsale">
                                                Sale
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($isOutOfStock): ?>
                                            <div class="single-product__thumbnail--badge out-of-stock">
                                                Out of stock
                                            </div>
                                        <?php endif; ?>
                                        <div class="single-product__thumbnail--holder">
                                            <a href="<?= base_url('product/' . $product['id']) ?>">
                                                <img src="<?= base_url('assets/uploads/products/' . ($product['image'] ?? 'default.png')) ?>" alt="<?= esc($product['name']) ?>" width="344" height="371" />
                                            </a>
                                        </div>
                                    </div>
                                    <div class="single-product__info text-start">
                                        <h3 class="single-product__info--title" style="font-size: 14px; margin-bottom: 8px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; line-height: 1.4;">
                                            <a href="<?= base_url('product/' . $product['id']) ?>">
                                                <?= esc($product['name']) ?>
                                            </a>
                                        </h3>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="single-product__info--price" style="margin: 0;">
                                                <?php if ($hasDiscount): ?>
                                                    <del style="font-size: 12px;"><?= format_currency($product['price']) ?></del>
                                                    <ins style="font-size: 16px; font-weight: 600;"><?= format_currency($product['sale_price']) ?></ins>
                                                <?php else: ?>
                                                    <ins style="font-size: 16px; font-weight: 600;"><?= format_currency($product['price']) ?></ins>
                                                <?php endif; ?>
                                            </div>
                                            <?php if (!$isOutOfStock): ?>
                                                <a href="#" onclick="addToCart(<?= $product['id'] ?>); return false;" class="btn btn-sm" style="background-color: #f5f5f5; border-radius: 50%; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; padding: 0;" data-bs-tooltip="tooltip" data-bs-placement="top" data-bs-title="Add to cart" aria-label="Add to cart">
                                                    <i class="lastudioicon-shopping-cart-3" style="font-size: 16px;"></i>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <!-- Single product End -->
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <!-- Shop Wrapper End -->

            <!-- Pagination Start -->
            <?php if (!empty($products) && isset($pager) && $pager->getPageCount() > 1): ?>
                <div class="pagination-wrapper mt-5">
                    <?php
                    $currentPage = $pager->getCurrentPage();
                    $pageCount = $pager->getPageCount();
                    $params = $_GET;
                    ?>
                    
                    <nav aria-label="Product pagination">
                        <ul class="pagination justify-content-center mb-0">
                            <!-- Previous Button -->
                            <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
                                <?php
                                $params['page'] = $currentPage - 1;
                                $prevUrl = base_url('shop') . '?' . http_build_query($params);
                                ?>
                                <a class="page-link" href="<?= $prevUrl ?>" aria-label="Previous">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </li>
                            
                            <?php
                            $startPage = max(1, $currentPage - 2);
                            $endPage = min($pageCount, $currentPage + 2);
                            
                            if ($startPage > 1): ?>
                                <?php $params['page'] = 1; ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?= base_url('shop') . '?' . http_build_query($params) ?>">1</a>
                                </li>
                                <?php if ($startPage > 2): ?>
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                <?php endif; ?>
                            <?php endif; ?>
                            
                            <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                                <?php $params['page'] = $i; ?>
                                <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                                    <a class="page-link" href="<?= base_url('shop') . '?' . http_build_query($params) ?>">
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                            
                            <?php if ($endPage < $pageCount): ?>
                                <?php if ($endPage < $pageCount - 1): ?>
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                <?php endif; ?>
                                <?php $params['page'] = $pageCount; ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?= base_url('shop') . '?' . http_build_query($params) ?>"><?= $pageCount ?></a>
                                </li>
                            <?php endif; ?>
                            
                            <!-- Next Button -->
                            <li class="page-item <?= $currentPage >= $pageCount ? 'disabled' : '' ?>">
                                <?php
                                $params['page'] = $currentPage + 1;
                                $nextUrl = base_url('shop') . '?' . http_build_query($params);
                                ?>
                                <a class="page-link" href="<?= $nextUrl ?>" aria-label="Next">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                    
                    <div class="pagination-info">
                        Showing page <?= $currentPage ?> of <?= $pageCount ?>
                    </div>
                </div>
            <?php endif; ?>
            <!-- Pagination End -->
        </div>
    </div>
    <!-- Shop End -->
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

// Add to Cart Function
function addToCart(productId) {
    const formData = new FormData();
    formData.append('product_id', productId);
    formData.append('quantity', 1);
    formData.append(csrfToken.name, csrfToken.hash);
    
    fetch('<?= base_url('cart/add') ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        // Update CSRF token for next request
        updateCsrfToken(data);
        
        if (data.success) {
            // Update cart count badges
            if (data.cart_count) {
                const badge = document.getElementById('cart-count-badge');
                if (badge) {
                    badge.textContent = String(data.cart_count).padStart(2, '0');
                    badge.style.display = 'inline-block';
                }
                
                const mobileBadge = document.getElementById('mobile-cart-count-badge');
                if (mobileBadge) {
                    mobileBadge.textContent = String(data.cart_count).padStart(2, '0');
                    mobileBadge.style.display = 'inline-block';
                }
            }
            
            // Trigger custom event
            document.dispatchEvent(new Event('cartUpdated'));
            
            // Show success message using Toast if available
            if (typeof Toast !== 'undefined') {
                Toast.success(data.message || 'Product added to cart!');
            } else {
                alert(data.message || 'Product added to cart!');
            }
        } else {
            // Show error message
            if (typeof Toast !== 'undefined') {
                Toast.error(data.message || 'Failed to add product to cart');
            } else {
                alert(data.message || 'Failed to add product to cart');
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
}

// Add to Wishlist Function
function addToWishlist(productId) {
    const formData = new FormData();
    formData.append('product_id', productId);
    formData.append(csrfToken.name, csrfToken.hash);
    
    fetch('<?= base_url('wishlist/add') ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        // Check if response is ok before parsing JSON
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        // Update CSRF token for next request
        updateCsrfToken(data);
        
        if (data.success) {
            // Update wishlist count badges IMMEDIATELY
            if (data.wishlist_count) {
                const badge = document.getElementById('wishlist-count-badge');
                if (badge) {
                    badge.textContent = String(data.wishlist_count).padStart(2, '0');
                    badge.style.display = 'inline-block';
                }
                
                const mobileBadge = document.getElementById('mobile-wishlist-count-badge');
                if (mobileBadge) {
                    mobileBadge.textContent = String(data.wishlist_count).padStart(2, '0');
                    mobileBadge.style.display = 'inline-block';
                }
            }
            
            // Trigger custom event to update header
            document.dispatchEvent(new Event('wishlistUpdated'));
            
            // Show success message
            if (typeof Toast !== 'undefined') {
                Toast.success(data.message || 'Product added to wishlist!');
            } else {
                alert(data.message || 'Product added to wishlist!');
            }
        } else {
            // Handle redirect for login - show message BEFORE redirecting
            if (data.redirect) {
                if (typeof Toast !== 'undefined') {
                    Toast.error(data.message || 'Please login to add items to wishlist');
                    // Add a small delay before redirect to ensure toast is visible
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 1500);
                } else {
                    alert(data.message || 'Please login to add items to wishlist');
                    window.location.href = data.redirect;
                }
                return;
            }
            
            // Show error message for other cases
            if (typeof Toast !== 'undefined') {
                Toast.error(data.message || 'Failed to add to wishlist');
            } else {
                alert(data.message || 'Failed to add to wishlist');
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // More specific error message - check if user might not be logged in
        if (typeof Toast !== 'undefined') {
            Toast.error('Unable to add to wishlist. Please try again or login.');
        } else {
            alert('Unable to add to wishlist. Please try again or login.');
        }
    });
}
</script>
<?= $this->endSection() ?>