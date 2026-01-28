<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<?php helper('cart'); ?>

<!-- Page Header -->
<div class="page-header">
    <div class="d-flex align-items-center gap-2 mb-3">
        <a href="<?= base_url('admin/shipping-zones/view/' . $zone['id']) ?>" class="btn btn-outline-secondary btn-back" title="Back">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h4 class="mb-1">Manage Locations - <?= esc($zone['zone_name']) ?></h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('admin/shipping-zones') ?>">Zones</a></li>
                    <li class="breadcrumb-item active">Locations</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<!-- Zone Info Card -->
<div class="card mb-3">
    <div class="card-body bg-light">
        <div class="row align-items-center">
            <div class="col-md-8 col-12 mb-3 mb-md-0">
                <h5 class="mb-1"><?= esc($zone['zone_name']) ?></h5>
                <p class="mb-0 text-muted">Base Fee: <strong class="text-primary"><?= format_currency($zone['base_fee']) ?></strong></p>
            </div>
            <div class="col-md-4 col-12">
                <div class="d-flex gap-2 justify-content-md-end form-actions">
                    <a href="<?= base_url('admin/shipping-zones/' . $zone['id'] . '/locations/create') ?>" 
                       class="btn btn-primary flex-fill flex-md-grow-0">
                        <i class="fas fa-plus"></i> <span class="btn-text">Add Location</span>
                    </a>
                    <!-- <a href="<?= base_url('admin/shipping-zones/' . $zone['id'] . '/locations/bulk-create') ?>" 
                       class="btn btn-success flex-fill flex-md-grow-0">
                        <i class="fas fa-plus-circle"></i> <span class="btn-text">Bulk Add</span>
                    </a> -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Locations Table/Cards -->
<div class="card">
    <div class="card-body">
        <?php if (empty($locations)): ?>
            <div class="empty-state">
                <i class="fas fa-map-marker-alt text-muted"></i>
                <p class="text-muted mb-0">No locations mapped yet. Add locations to define this zone's coverage.</p>
            </div>
        <?php else: ?>
            <!-- Desktop Table View -->
            <div class="table-responsive desktop-table-view">
                <table class="table">
                    <thead>
                        <tr>
                            <th>State</th>
                            <th>City/LGA</th>
                            <th>Area/Landmark</th>
                            <th>Added</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($locations as $location): ?>
                            <tr>
                                <td><strong><?= esc($location['state']) ?></strong></td>
                                <td><?= $location['city'] ? esc($location['city']) : '<span class="text-muted">All cities</span>' ?></td>
                                <td><?= $location['area'] ? esc($location['area']) : '<span class="text-muted">All areas</span>' ?></td>
                                <td><?= date('M d, Y', strtotime($location['created_at'])) ?></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item text-danger" 
                                                   href="<?= base_url('admin/shipping-zones/' . $zone['id'] . '/locations/' . $location['id'] . '/delete') ?>"
                                                   onclick="return confirm('Delete this location?')">
                                                    <i class="fas fa-trash me-2"></i>Delete
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="mobile-card-view">
                <?php foreach ($locations as $location): ?>
                    <div class="product-mobile-card">
                        <div class="mobile-card-content">
                            <div class="mobile-card-info">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <h6 class="mobile-card-title">
                                            <i class="fas fa-map-marker-alt text-primary me-1"></i>
                                            <?= esc($location['state']) ?>
                                        </h6>
                                        <div class="mb-2">
                                            <?php if ($location['city']): ?>
                                                <div class="text-muted small">
                                                    <i class="fas fa-city me-1"></i><?= esc($location['city']) ?>
                                                </div>
                                            <?php else: ?>
                                                <div class="text-muted small fst-italic">All cities</div>
                                            <?php endif; ?>
                                            
                                            <?php if ($location['area']): ?>
                                                <div class="text-muted small">
                                                    <i class="fas fa-location-dot me-1"></i><?= esc($location['area']) ?>
                                                </div>
                                            <?php else: ?>
                                                <div class="text-muted small fst-italic">All areas</div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="mobile-card-badges">
                                            <span class="badge bg-light text-dark border">
                                                <i class="fas fa-calendar me-1"></i>
                                                <?= date('M d, Y', strtotime($location['created_at'])) ?>
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item text-danger" 
                                                   href="<?= base_url('admin/shipping-zones/' . $zone['id'] . '/locations/' . $location['id'] . '/delete') ?>"
                                                   onclick="return confirm('Delete this location?')">
                                                    <i class="fas fa-trash me-2"></i>Delete
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>