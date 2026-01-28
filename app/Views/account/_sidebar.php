<div class="account-nav-card" id="accountNav">
    <div class="account-nav-header">
        <div class="user-avatar">
            <?= strtoupper(substr(session()->get('first_name'), 0, 1)) ?>
        </div>
        <h5><?= esc(session()->get('first_name') . ' ' . session()->get('last_name')) ?></h5>
        <p><?= esc(session()->get('email')) ?></p>
    </div>
    
    <ul class="nav-list">
        <li>
            <a href="javascript:void(0)" data-tab="dashboard" class="nav-link active">
                <i class="fas fa-home"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="<?= base_url('shop') ?>" class="nav-link">
                <i class="fas fa-shop"></i> Shop
            </a>
        </li>
        <li>
            <a href="javascript:void(0)" data-tab="orders" class="nav-link">
                <i class="fas fa-shopping-bag"></i> My Orders
            </a>
        </li>
        <!-- <li>
            <a href="javascript:void(0)" data-tab="wishlist" class="nav-link">
                <i class="fas fa-heart"></i> Wishlist
            </a>
        </li> -->
        <li>
            <a href="javascript:void(0)" data-tab="profile" class="nav-link">
                <i class="fas fa-user"></i> Profile Settings
            </a>
        </li>
        <li>
            <a href="javascript:void(0)" data-tab="tracking" class="nav-link">
                <i class="fas fa-map-marker-alt"></i> Track Order
            </a>
        </li>
        <li>
            <a href="<?= base_url('logout') ?>" class="nav-link logout" onclick="">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </li>
    </ul>
</div>