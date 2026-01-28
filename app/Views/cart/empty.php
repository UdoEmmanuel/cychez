<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<main>
    <!-- Breadcrumb Start -->
    <div class="breadcrumb-section">
        <div class="container-fluid custom-container">
            <div class="breadcrumb-wrapper text-center">
                <h2 class="breadcrumb-wrapper__title">Cart Empty</h2>
                <ul class="breadcrumb-wrapper__items justify-content-center">
                    <li>
                        <a href="<?= base_url() ?>">Home</a>
                    </li>
                    <li>
                        <span>Cart Empty</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Cart Empty Start -->
    <div class="cart-section section-padding-2">
        <div class="container-fluid custom-container">
            <div class="cart-empty text-center">
                <img 
                    src="<?= base_url('assets/images/cart-empty.svg') ?>" 
                    alt="Cart Empty" 
                    width="230" 
                    height="230"
                />

                <p>Your cart is currently empty.</p>

                <a href="<?= base_url('shop') ?>" class="cart-empty__btn btn">
                    Return to shop
                </a>
            </div>
        </div>
    </div>
    <!-- Cart Empty End -->
</main>

<?= $this->endSection() ?>