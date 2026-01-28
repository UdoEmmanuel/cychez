<?php
helper(['cart', 'wishlist']); // Load both helpers
$cart_count = get_cart_count();
$wishlist_count = get_wishlist_count(); // Use helper instead of session
$current_uri = uri_string();
$request = \Config\Services::request();
$logged_in = session()->get('logged_in');
$user_name = session()->get('first_name');
$user_role = session()->get('role');
?>

<!-- Header Start -->
<header class="header bg-white header-height">
    <!-- Header Top Start -->
    <div class="header__top">
        <div class="container-fluid custom-container">
            <div class="header__top--wrapper">
                <div class="header__top--left d-none d-md-block">
                    <ul class="header__top--items">
                        <li>
                            <a href="mailto:cychezbeauty@gmail.com">
                                <i class="lastudioicon-mail-2"></i>
                                <span>cychezbeauty@gmail.com</span>
                            </a>
                        </li>
                        <li>
                            <a href="tel:+2348033095016">
                                <i class="lastudioicon-phone-call"></i>
                                <span>+234 803 309 5016</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)">
                                <i class="lastudioicon-pin-3-1"></i>
                                <span>Nigeria</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="header__top--right">
                    <ul class="header__top--items">
                        <?php if ($logged_in): ?>
                            <li>
                                <a href="<?= $user_role === 'admin' ? base_url('admin/dashboard') : base_url('account') ?>">
                                    <i class="lastudioicon-single-01-1"></i>
                                    <span>Welcome, <?= esc($user_name) ?></span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url('logout') ?>" onclick="return confirm('Are you sure you want to logout?')">
                                    <i class="lastudioicon-logout"></i>
                                    <span>Logout</span>
                                </a>
                            </li>
                        <?php else: ?>
                            <li>
                                <a href="<?= base_url('login') ?>">
                                    <i class="lastudioicon-single-01-1"></i>
                                    <span>Login / Sign Up</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Header Top End -->

    <!-- Header Main Start -->
    <div class="header__main header-shadow d-flex align-items-center">
        <div class="container-fluid custom-container">
            <div class="row align-items-center position-relative">
                <div class="col-md-4 col-3 d-xl-none">
                    <button class="header__main--toggle header__main--toggle-dark" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-label="menu">
                        <i class="lastudioicon-menu-8-1"></i>
                    </button>
                </div>
                <div class="col-xl-3 col-md-4 col-6">
                    <div class="header__main--logo text-center text-xl-start">
                        <a href="<?= base_url() ?>">
                            <img src="<?= base_url('assets/images/Logo-modified.jpg') ?>" alt="Logo" width="150" height="35" />
                        </a>
                    </div>
                </div>
                <div class="col-xl-6 d-none d-xl-block">
                    <div class="header__main--menu">
                        <nav class="navbar-menu">
                            <ul class="menu-items-list menu-items-list--dark d-flex justify-content-center">
                                <li>
                                    <a class="<?= ($current_uri === '' || $current_uri === '/') ? 'active' : '' ?>" href="<?= base_url() ?>">
                                        <span>Home</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="<?= (strpos($current_uri, 'shop') !== false) ? 'active' : '' ?>" href="<?= base_url('shop') ?>">
                                        <span>Shop</span>
                                    </a>
                                </li>
                                <?php if ($logged_in): ?>
                                    <li>
                                        <a class="<?= (strpos($current_uri, 'account') !== false && strpos($current_uri, 'orders') === false) ? 'active' : '' ?>" href="<?= base_url('account') ?>">
                                            <span>My Account</span>
                                        </a>
                                    </li>
                                    <!-- <li>
                                        <a class="<?= (strpos($current_uri, 'orders') !== false || strpos($current_uri, 'tracking') !== false) ? 'active' : '' ?>" href="<?= base_url('account/orders') ?>">
                                            <span>My Orders</span>
                                        </a>
                                    </li> -->
                                <?php else: ?>
                                    <li>
                                        <a class="<?= (strpos($current_uri, 'about') !== false) ? 'active' : '' ?>" href="<?= base_url('about') ?>">
                                            <span>About Us</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="<?= (strpos($current_uri, 'contact') !== false) ? 'active' : '' ?>" href="<?= base_url('contact') ?>">
                                            <span>Contact</span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-xl-3 col-md-4 col-3">
                    <div class="header__main--meta header__main--dark d-flex justify-content-end align-items-center">
                        <ul class="meta-items-list meta-items-list--dark d-flex justify-content-end align-items-center">
                            <li class="search d-none d-lg-block">
                                <form action="<?= base_url('search') ?>" method="get">
                                    <div class="meta-search meta-search--dark">
                                        <input type="text" name="q" placeholder="Search products…" value="<?= esc($request->getGet('q') ?? '') ?>" />
                                        <button type="submit" aria-label="search">
                                            <i class="lastudioicon-zoom-1"></i>
                                        </button>
                                    </div>
                                </form>
                            </li>
                            <li class="wishlist">
                                <a href="<?= base_url('wishlist') ?>">
                                    <i class="lastudioicon lastudioicon-heart-1"></i>
                                    <span class="badge" id="wishlist-count-badge" style="<?= $wishlist_count > 0 ? '' : 'display:none;' ?>">
                                        <?= sprintf('%02d', $wishlist_count) ?>
                                    </span>
                                </a>
                            </li>
                            <li class="cart">
                                <a href="<?= base_url('cart') ?>">
                                    <i class="lastudioicon-shopping-cart-1"></i>
                                    <span class="badge" id="cart-count-badge" style="<?= $cart_count > 0 ? '' : 'display:none;' ?>">
                                        <?= sprintf('%02d', $cart_count) ?>
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header Main End -->
</header>
<!-- Header End -->

<!-- Search Modal Start -->
<div class="search-modal modal fade" id="SearchModal">
    <button class="search-modal__close" data-bs-dismiss="modal">
        <i class="lastudioicon-e-remove"></i>
    </button>

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="search-modal__form">
                <form action="<?= base_url('search') ?>" method="get">
                    <input type="text" name="q" placeholder="Search product…" value="<?= esc($request->getGet('q') ?? '') ?>" />
                    <button type="submit" aria-label="search">
                        <i class="lastudioicon-zoom-1"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Search End -->

<!-- Offcanvas Menu Start -->
<div class="offcanvas offcanvas-end offcanvas-sidebar" tabindex="-1" id="offcanvasSidebar">
    <button type="button" class="offcanvas-sidebar__close" data-bs-dismiss="offcanvas" aria-label="close">
        <i class="lastudioicon-e-remove"></i>
    </button>
    <div class="offcanvas-body">
        <div class="offcanvas-sidebar__menu">
            <ul class="offcanvas-menu-list">
                <?php if ($logged_in): ?>
                    <li><a href="<?= base_url('account') ?>">My Dashboard</a></li>
                    <li><a href="<?= base_url('account/orders') ?>">My Orders</a></li>
                    <li><a href="<?= base_url('account/profile') ?>">Profile Settings</a></li>
                    <li><a href="<?= base_url('wishlist') ?>">My Wishlist</a></li>
                    <?php if ($user_role === 'admin'): ?>
                        <li><a href="<?= base_url('admin/dashboard') ?>">Admin Dashboard</a></li>
                    <?php endif; ?>
                    <li><a href="<?= base_url('logout') ?>" onclick="return confirm('Are you sure you want to logout?')">Logout</a></li>
                <?php else: ?>
                    <li><a href="<?= base_url('login') ?>">Login / Sign Up</a></li>
                    <li><a href="<?= base_url('about') ?>">About Us</a></li>
                    <li><a href="<?= base_url('contact') ?>">Contact Us</a></li>
                <?php endif; ?>
                <li><a href="<?= base_url('faqs') ?>">FAQs</a></li>
            </ul>
        </div>

        <div class="offcanvas-sidebar__banner" style="background-image: url(<?= base_url('assets/images/shop-sidebar-banner.jpg') ?>);">
            <h3 class="banner-title">NEW NOW</h3>
            <h4 class="banner-sub-title">WARM WOOL PREMIUM COAT</h4>
            <a href="<?= base_url('shop') ?>" class="banner-btn">Discover</a>
        </div>

        <div class="offcanvas-sidebar__info">
            <ul class="offcanvas-info-list">
                <li><a href="tel:+2348033095016">+234 803 309 5016</a></li>
                <li><a href="mailto:cychezbeauty@gmail.com">cychezbeauty@gmail.com</a></li>
                <li><span>Port Harcourt, Rivers State, Nigeria</span></li>
            </ul>
        </div>

        <div class="offcanvas-sidebar__social">
            <ul class="offcanvas-social">
                <li><a href="#" aria-label="facebook"><i class="lastudioicon-b-facebook"></i></a></li>
                <li><a href="#" aria-label="twitter"><i class="lastudioicon-b-twitter"></i></a></li>
                <li><a href="#" aria-label="instagram"><i class="lastudioicon-b-instagram"></i></a></li>
            </ul>
        </div>

        <div class="offcanvas-sidebar__copyright">
            <p>&copy; <span class="current-year"><?= date('Y') ?></span> <span>Cychez Beauty</span></p>
        </div>
    </div>
</div>
<!-- Offcanvas Menu End -->

<!-- Mobile Menu Start -->
<div class="mobile-menu offcanvas offcanvas-start" tabindex="-1" id="mobileMenu">
    <div class="offcanvas-header">
        <button type="button" class="mobile-menu__close" data-bs-dismiss="offcanvas" aria-label="Close">
            <i class="lastudioicon-e-remove"></i>
        </button>
    </div>

    <div class="offcanvas-body">
        <nav class="navbar-mobile-menu">
            <ul class="mobile-menu-items">
                <li><a href="<?= base_url() ?>">Home</a></li>
                <li><a href="<?= base_url('shop') ?>">Shop</a></li>
                <?php if ($logged_in): ?>
                    <li><a href="<?= base_url('account') ?>">My Dashboard</a></li>
                    <li><a href="<?= base_url('account/orders') ?>">My Orders</a></li>
                    <li><a href="<?= base_url('account/profile') ?>">Profile Settings</a></li>
                    <li><a href="<?= base_url('wishlist') ?>">My Wishlist</a></li>
                    <?php if ($user_role === 'admin'): ?>
                        <li><a href="<?= base_url('admin/dashboard') ?>">Admin Dashboard</a></li>
                    <?php endif; ?>
                    <li><a href="<?= base_url('logout') ?>" onclick="return confirm('Are you sure you want to logout?')">Logout</a></li>
                <?php else: ?>
                    <li><a href="<?= base_url('login') ?>">Login / Sign Up</a></li>
                    <li><a href="<?= base_url('about') ?>">About Us</a></li>
                    <li><a href="<?= base_url('contact') ?>">Contact Us</a></li>
                <?php endif; ?>
                <li><a href="<?= base_url('faqs') ?>">FAQs</a></li>
            </ul>
        </nav>
    </div>
</div>
<!-- Mobile Menu End -->

<!-- Mobile Meta Start -->
<div class="mobile-meta d-md-none">
    <ul class="mobile-meta-items">
        <li>
            <button data-bs-toggle="modal" data-bs-target="#SearchModal" aria-label="search">
                <i class="lastudioicon-zoom-1"></i>
            </button>
        </li>
        <li>
            <a href="<?= base_url('wishlist') ?>">
                <i class="lastudioicon-heart-1"></i>
                <span class="badge" id="mobile-wishlist-count-badge" style="<?= $wishlist_count > 0 ? '' : 'display:none;' ?>">
                    <?= sprintf('%02d', $wishlist_count) ?>
                </span>
            </a>
        </li>
        <li>
            <a href="<?= base_url('cart') ?>">
                <i class="lastudioicon-shopping-cart-1"></i>
                <span class="badge" id="mobile-cart-count-badge" style="<?= $cart_count > 0 ? '' : 'display:none;' ?>">
                    <?= sprintf('%02d', $cart_count) ?>
                </span>
            </a>
        </li>
    </ul>
</div>
<!-- Mobile Meta End -->

<script>
// Wishlist Count Update Function
function updateWishlistCount() {
    fetch('<?= base_url('wishlist/get-count') ?>')
        .then(response => response.json())
        .then(data => {
            const count = data.count || 0;
            const badge = document.getElementById('wishlist-count-badge');
            const mobileBadge = document.getElementById('mobile-wishlist-count-badge');
            
            if (badge) {
                badge.textContent = String(count).padStart(2, '0');
                badge.style.display = count > 0 ? 'inline-block' : 'none';
            }
            
            if (mobileBadge) {
                mobileBadge.textContent = String(count).padStart(2, '0');
                mobileBadge.style.display = count > 0 ? 'inline-block' : 'none';
            }
            
            // Update session storage
            sessionStorage.setItem('wishlist_count', count);
        })
        .catch(error => console.error('Error updating wishlist count:', error));
}

// Cart Count Update Function
function updateCartCount() {
    fetch('<?= base_url('cart/get-count') ?>')
        .then(response => response.json())
        .then(data => {
            const count = data.count || 0;
            const badge = document.getElementById('cart-count-badge');
            const mobileBadge = document.getElementById('mobile-cart-count-badge');
            
            if (badge) {
                badge.textContent = String(count).padStart(2, '0');
                badge.style.display = count > 0 ? 'inline-block' : 'none';
            }
            
            if (mobileBadge) {
                mobileBadge.textContent = String(count).padStart(2, '0');
                mobileBadge.style.display = count > 0 ? 'inline-block' : 'none';
            }
        })
        .catch(error => console.error('Error updating cart count:', error));
}

// Listen for custom events from product pages
document.addEventListener('wishlistUpdated', updateWishlistCount);
document.addEventListener('cartUpdated', updateCartCount);

// Update counts on page load
document.addEventListener('DOMContentLoaded', function() {
    updateWishlistCount();
    updateCartCount();
});
</script>