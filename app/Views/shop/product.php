<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php helper('cart'); ?>

<style>
/* Mobile Responsive Text */
@media (max-width: 767px) {
    .single-breadcrumbs-list { font-size: 12px; }
    .product-single-content__title { font-size: 20px !important; line-height: 1.3; }
    .product-single-content__price ins { font-size: 22px !important; }
    .product-single-content__price del { font-size: 16px !important; }
    .stock-text { font-size: 13px !important; }
    .product-single-content__short-description { font-size: 14px; line-height: 1.6; }
    .product-single-content__meta { font-size: 13px; }
    .single-product__info--title { font-size: 14px !important; }
    .single-product__info--price { font-size: 14px !important; }
    .related-title__title { font-size: 22px !important; }
}

.rating-stars .star { font-size: 24px; color: #ddd; cursor: pointer; font-style: normal; }
.rating-stars .star:hover, .rating-stars .star.active { color: #ffc107; }
</style>

<main>
    <!-- Breadcrumbs Start -->
    <div class="single-breadcrumbs">
        <div class="container-fluid custom-container">
            <ul class="single-breadcrumbs-list">
                <li><a href="<?= base_url() ?>">Home</a></li>
                <li><a href="<?= base_url('shop') ?>">Shop</a></li>
                <li><a href="<?= base_url('shop/category/' . $product['category_id']) ?>"><?= esc($product['category_name']) ?></a></li>
                <li><span><?= esc($product['name']) ?></span></li>
            </ul>
        </div>
    </div>

    <!-- Product Single -->
    <div class="product-single-section section-padding-2">
        <div class="container-fluid custom-container">
            <div class="product-single-image">
                <?php if (!empty($product['images']) && is_array($product['images'])): ?>
                    <div class="product-single-carousel navigation-arrows-style-2">
                        <div class="swiper">
                            <div class="swiper-wrapper">
                                <?php foreach ($product['images'] as $image): ?>
                                    <div class="product-single-slide-item swiper-slide">
                                        <img src="<?= base_url('assets/uploads/products/' . $image) ?>" alt="<?= esc($product['name']) ?>" width="462" height="584" loading="lazy" />
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="swiper-button-next"><i class="lastudioicon-arrow-right"></i></div>
                            <div class="swiper-button-prev"><i class="lastudioicon-arrow-left"></i></div>
                        </div>
                    </div>
                <?php else: ?>
                    <img src="<?= base_url('assets/uploads/products/' . ($product['image'] ?? 'default.png')) ?>" alt="<?= esc($product['name']) ?>" class="img-fluid" width="462" height="584" />
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Product Details -->
    <div class="product-single-section section-padding-2">
        <div class="container-fluid custom-container">
            <div class="product-single-wrapper">
                <div class="product-single-col-1">
                    <div class="product-single-content">
                        <h2 class="product-single-content__title"><?= esc($product['name']) ?></h2>
                        
                        <div class="product-single-content__price-stock">
                            <div class="product-single-content__price">
                                <?php if ($product['compare_price'] && $product['compare_price'] > $product['price']): ?>
                                    <del><?= format_currency($product['compare_price']) ?></del>
                                <?php endif; ?>
                                <ins><?= format_currency($product['price']) ?></ins>
                            </div>
                            <div class="product-single-content__stock">
                                <?php if ($product['stock_quantity'] > 0): ?>
                                    <span class="stock-icon"><i class="dlicon ui-1_check-circle-08"></i></span>
                                    <span class="stock-text"><?= $product['stock_quantity'] ?> in stock</span>
                                <?php else: ?>
                                    <span class="stock-icon out-of-stock"><i class="dlicon ui-1_circle-remove"></i></span>
                                    <span class="stock-text out-of-stock">Out of Stock</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="product-single-content__short-description">
                            <p><?= nl2br(esc($product['description'])) ?></p>
                        </div>
                        
                        <?php if ($product['stock_quantity'] > 0): ?>
                            <div class="product-single-content__add-to-cart-wrapper">
                                <div class="product-single-content__quantity-add-to-cart">
                                    <div class="product-single-content__quantity product-quantity">
                                        <button type="button" class="decrease"><i class="lastudioicon-i-delete-2"></i></button>
                                        <input class="quantity-input" type="number" id="quantity" value="1" min="1" max="<?= $product['stock_quantity'] ?>" />
                                        <button type="button" class="increase"><i class="lastudioicon-i-add-2"></i></button>
                                    </div>
                                    <button class="product-single-content__add-to-cart btn" id="add-to-cart-btn" onclick="addToCartDetail(<?= $product['id'] ?>)">Add to cart</button>
                                </div>
                                <?php if (session()->get('logged_in')): ?>
                                    <a href="javascript:void(0)" class="product-add-wishlist" onclick="addToWishlist(<?= $product['id'] ?>)">
                                        <i class="lastudioicon-heart-2"></i> Add to Wishlist
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="product-single-content__meta">
                            <?php if (!empty($product['sku'])): ?>
                                <div class="product-single-content__meta--item">
                                    <div class="label">SKU:</div>
                                    <div class="content"><?= esc($product['sku']) ?></div>
                                </div>
                            <?php endif; ?>
                            <div class="product-single-content__meta--item">
                                <div class="label">Category:</div>
                                <div class="content">
                                    <a href="<?= base_url('shop/category/' . $product['category_id']) ?>"><?= esc($product['category_name']) ?></a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="product-single-content__social">
                            <div class="label">Share</div>
                            <ul class="socail-icon">
                                <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?= current_url() ?>" target="_blank"><i class="lastudioicon-b-facebook"></i></a></li>
                                <li><a href="https://twitter.com/intent/tweet?url=<?= current_url() ?>&text=<?= esc($product['name']) ?>" target="_blank"><i class="lastudioicon-b-twitter"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="product-single-col-2">
                    <div class="product-single-accordion">
                        <div class="accordion" id="productAccordion">
                            <div class="accordion-item">
                                <button type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">Description</button>
                                <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#productAccordion">
                                    <div class="product-single-tab-description">
                                        <div class="product-single-tab-description-item">
                                            <?= $product['long_description'] ?? nl2br(esc($product['description'])) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    <?php if (!empty($relatedProducts)): ?>
        <div class="related-product-section section-padding-2">
            <div class="container-fluid custom-container">
                <div class="related-title text-center">
                    <h2 class="related-title__title">Related Products</h2>
                </div>
                <div class="related-product-active swiper-dot-style-1">
                    <div class="swiper">
                        <div class="swiper-wrapper">
                            <?php foreach ($relatedProducts as $related): ?>
                                <?php if ($related['id'] != $product['id']): ?>
                                    <div class="swiper-slide">
                                        <div class="single-product">
                                            <div class="single-product__thumbnail">
                                                <div class="single-product__thumbnail--holder">
                                                    <a href="<?= base_url('product/' . $related['id']) ?>">
                                                        <img src="<?= base_url('assets/uploads/products/' . ($related['image'] ?? 'default.png')) ?>" alt="<?= esc($related['name']) ?>" width="344" height="371" loading="lazy" />
                                                    </a>
                                                </div>
                                                <?php if (($related['stock_quantity'] ?? 0) > 0): ?>
                                                    <div class="single-product__thumbnail--meta-2">
                                                        <a href="javascript:void(0)" onclick="addToCart(<?= $related['id'] ?>)"><i class="lastudioicon-shopping-cart-3"></i></a>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="single-product__info text-center">
                                                <h3 class="single-product__info--title">
                                                    <a href="<?= base_url('shop/product/' . $related['slug']) ?>"><?= esc($related['name']) ?></a>
                                                </h3>
                                                <div class="single-product__info--price">
                                                    <ins><?= format_currency($related['price']) ?></ins>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
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

// Add to cart from product detail page (with quantity)
function addToCartDetail(productId) {
    const quantity = parseInt(document.getElementById('quantity').value) || 1;
    const button = document.getElementById('add-to-cart-btn');
    
    button.disabled = true;
    button.textContent = 'Adding...';
    
    const formData = new FormData();
    formData.append('product_id', productId);
    formData.append('quantity', quantity);
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
            // Update cart badge
            const badge = document.getElementById('cart-count-badge');
            if (badge && data.cart_count) {
                badge.textContent = String(data.cart_count).padStart(2, '0');
            }
            // Show success toast
            Toast.success(data.message || 'Product added to cart!');
        } else {
            Toast.error(data.message || 'Failed to add product');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Toast.error('An error occurred while adding to cart');
    })
    .finally(() => {
        button.disabled = false;
        button.textContent = 'Add to cart';
    });
}

// Quick add to cart (quantity = 1) for related products
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
            // Update cart badge
            const badge = document.getElementById('cart-count-badge');
            if (badge && data.cart_count) {
                badge.textContent = String(data.cart_count).padStart(2, '0');
            }
            Toast.success(data.message || 'Product added to cart!');
        } else {
            Toast.error(data.message || 'Failed to add product');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Toast.error('An error occurred');
    });
}

// Add to wishlist
function addToWishlist(productId) {
    const formData = new FormData();
    formData.append('product_id', productId);
    formData.append(csrfToken.name, csrfToken.hash);
    
    fetch('<?= base_url('wishlist/add') ?>', { 
        method: 'POST', 
        body: formData 
    })
    .then(response => response.json())
    .then(data => {
        // Update CSRF token for next request
        updateCsrfToken(data);
        
        if (data.success) {
            Toast.success(data.message || 'Added to wishlist');
        } else {
            Toast.error(data.message || 'Failed to add to wishlist');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Toast.error('An error occurred');
    });
}
</script>
<?= $this->endSection() ?>