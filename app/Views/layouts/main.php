<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <title><?= esc($title ?? 'Cychez Store') ?></title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="<?= esc($description ?? 'Cychez - Cosmetic Shop') ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('assets/images/favicon.jpg') ?>" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@200;300;400;500;600;700&display=swap" rel="stylesheet" />

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/lastudioicon.css') ?>" />

    <!-- Plugins CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/swiper-bundle.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/glightbox.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/nice-select2.css') ?>" />

    <!-- Main Style CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Account Page Styles -->
    <?php if (isset($accountPage) && $accountPage === true): ?>
        <link rel="stylesheet" href="<?= base_url('assets/css/account.css') ?>" />
    <?php endif; ?>

    <?= $this->renderSection('styles') ?>
</head>
<body>
    <?php
        // Only render header if not explicitly set to hide
        if (!isset($hideHeader) || $hideHeader !== true) {
            // Load shop header on ecommerce pages
            if (isset($shopHeader) && $shopHeader === true) {
                echo $this->include('partials/shop_header');
            } else {
                echo $this->include('partials/header');
            }
        }
    ?>

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

    <?php
        // Only render footer if not explicitly set to hide
        if (!isset($hideFooter) || $hideFooter !== true) {
            echo view('partials/footer');
        }
    ?>


    <!-- Toast Notification System (Load first) -->
    <script src="<?= base_url('assets/js/toast.js') ?>"></script>
    <!-- Vendor JS -->
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>

    <!-- Plugins JS -->
    <script src="<?= base_url('assets/js/swiper-bundle.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/masonry.pkgd.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/glightbox.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/nice-select2.js') ?>"></script>

    <!-- Main JS -->
    <script src="<?= base_url('assets/js/main.js') ?>"></script>

    <?= $this->renderSection('scripts') ?>
</body>
</html>