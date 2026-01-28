<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= esc($title ?? 'Admin Panel - Cychez Store') ?></title>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('assets/images/favicon.jpg') ?>" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Admin Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/admin.css') ?>">
    
    <?= $this->renderSection('styles') ?>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar Overlay (for mobile) -->
        <div class="sidebar-overlay"></div>
        
        <!-- Sidebar -->
        <div class="admin-sidebar">
            <div class="p-3 text-center border-bottom">
                <h4>Admin Panel</h4>
            </div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?= uri_string() === 'admin' || uri_string() === 'admin/dashboard' ? 'active' : '' ?>" 
                    href="<?= base_url('admin/dashboard') ?>">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= strpos(uri_string(), 'admin/products') !== false ? 'active' : '' ?>" 
                    href="<?= base_url('admin/products') ?>">
                        <i class="fas fa-box"></i> Products
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= strpos(uri_string(), 'admin/orders') !== false ? 'active' : '' ?>" 
                    href="<?= base_url('admin/orders') ?>">
                        <i class="fas fa-shopping-bag"></i> Orders
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= strpos(uri_string(), 'admin/shipping-zones') !== false ? 'active' : '' ?>" 
                    href="<?= base_url('admin/shipping-zones') ?>">
                        <i class="fas fa-map-marker-alt"></i> Shipping Zones
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/') ?>" target="_blank">
                        <i class="fas fa-globe"></i> View Site
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('logout') ?>">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
        
        <!-- Main Content -->
        <div class="flex-fill admin-content">
            <div class="admin-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <button class="btn btn-link sidebar-toggle me-3" id="sidebarToggle">
                            <i class="fas fa-bars"></i>
                        </button>
                        <h5 class="mb-0"><?= esc($title ?? 'Dashboard') ?></h5>
                    </div>
                    <div class="admin-user-info">
                        <span class="text-muted">Welcome, <?= esc(session()->get('first_name')) ?></span>
                    </div>
                </div>
            </div>
            
            <div class="p-4">
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </div>
    
    <!-- Toast Notification System (Load first) -->
    <script src="<?= base_url('assets/js/toast.js') ?>"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
    
    <!-- Sidebar Toggle Script -->
    <script>
        $(document).ready(function() {
            // Toggle sidebar
            $('#sidebarToggle').on('click', function() {
                $('.admin-sidebar').toggleClass('active');
                $('.sidebar-overlay').toggleClass('active');
            });
            
            // Close sidebar when clicking overlay
            $(document).on('click', '.sidebar-overlay', function() {
                $('.admin-sidebar').removeClass('active');
                $('.sidebar-overlay').removeClass('active');
            });
            
            // Close sidebar when clicking a link on mobile
            if ($(window).width() <= 768) {
                $('.admin-sidebar .nav-link').on('click', function() {
                    $('.admin-sidebar').removeClass('active');
                    $('.sidebar-overlay').removeClass('active');
                });
            }
        });
    </script>

    <?php if (session()->getFlashdata('toast')): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toast = <?= json_encode(session()->getFlashdata('toast')) ?>;

            if (window.Toast && typeof Toast[toast.type] === 'function') {
                Toast[toast.type](toast.message);
            } else {
                console.error('Invalid toast type:', toast.type);
            }
        });
    </script>
    <?php endif; ?>
    
    <?= $this->renderSection('scripts') ?>
</body>
</html>