<?php helper('cart'); ?>

<!-- Header Start -->
<header class="header bg-white header-height">
    <div class="header__main d-flex align-items-center">
        <div class="container-fluid custom-container">
            <div class="row align-items-center position-relative gx-0">

                <!-- Mobile Menu Toggle (LEFT) -->
                <div class="col-3 d-xl-none text-start px-1">
                    <button class="header__main--toggle header__main--toggle-dark"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#mobileMenu"
                            aria-label="menu"
                            style="opacity: 1 !important; color: #363636 !important;">
                        <i class="lastudioicon-menu-8-1"></i>
                    </button>
                </div>

                <!-- Logo -->

                <div class="col-xl-3 col-md-4 col-6">
                    <!-- Header Main Logo Start -->
                    <div class="header__main--logo text-center text-xl-start" height="150">
                        <a href="<?= base_url('/') ?>">
                            <img src="<?= base_url('assets/images/Logo-modified.jpg')?>" alt="Logo" width="300" height="300" />
                            <!-- <h3 style="color: black;">CYCHEZ</h3> -->
                        </a>
                    </div>
                    <!-- Header Main Logo End -->
                </div>

                <!-- Right Side -->
                <div class="col-3 col-xl-9 text-end px-1">
                    <div class="header__main--menu d-flex justify-content-end align-items-center">

                        <!-- Desktop Menu -->
                        <nav class="navbar-menu d-none d-xl-block">
                            <ul class="menu-items-list menu-items-list--2 menu-items-list--dark d-flex">
                                <li><a href="<?= base_url('/') ?>"><span>Home</span></a></li>
                                <li><a href="<?= base_url('about') ?>"><span>About</span></a></li>
                                <li><a href="<?= base_url('service') ?>"><span>Services</span></a></li>
                                <li><a href="<?= base_url('contact') ?>"><span>Contact</span></a></li>
                                <li><a href="<?= base_url('faqs') ?>"><span>FAQs</span></a></li>
                                <li><a href="<?= base_url('shop') ?>"><span>Shop</span></a></li>
                            </ul>
                        </nav>

                        <!-- Desktop Auth Buttons -->
                        <div class="header-auth-buttons d-none d-xl-flex align-items-center ms-4">
                            <a href="<?= base_url('login') ?>" class="btn btn-outline-dark me-2">
                                Login
                            </a>
                            <a href="<?= base_url('register') ?>" class="btn btn-dark">
                                Sign Up
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</header>
<!-- Header End -->

 <!-- Mobile Menu Start -->
    <div class="mobile-menu offcanvas offcanvas-start" tabindex="-1" id="mobileMenu">
        <!-- offcanvas-header Start -->
        <div class="offcanvas-header">
            <button type="button" class="mobile-menu__close" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="lastudioicon-e-remove"></i>
            </button>
        </div>
        <!-- offcanvas-header End -->

        <!-- offcanvas-body Start -->
        <div class="offcanvas-body">
            <nav class="navbar-mobile-menu">
                <ul class="mobile-menu-items">
                    <li>
                        <a href="<?= base_url('/') ?>">
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('about') ?>">
                            About
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('service') ?>">
                            Services
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('contact') ?>">
                            Contact
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('faqs') ?>">
                            FAQs
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('shop') ?>">
                            Shop
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('register') ?>">
                            Sign Up
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('login') ?>">
                            Login
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        <!-- offcanvas-body end -->
    </div>

<!-- Mobile Menu End -->
 