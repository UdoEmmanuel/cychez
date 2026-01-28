<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<?php helper('cart'); ?>

<!-- Page Header -->
<div class="page-header">
    <div class="d-flex align-items-center gap-2 mb-3">
        <a href="<?= base_url('admin/shipping-zones') ?>" class="btn btn-outline-secondary btn-back" title="Back">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h4 class="mb-1"><?= esc($zone['zone_name']) ?></h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('admin/shipping-zones') ?>">Zones</a></li>
                    <li class="breadcrumb-item active"><?= esc($zone['zone_name']) ?></li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<div class="row dashboard-stats">
    <div class="col-lg-3 col-md-6 col-6">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="stat-content">
                <h3><?= format_currency($zone['base_fee']) ?></h3>
                <p class="text-muted mb-0">Base Fee</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-6">
        <div class="stat-card">
            <div class="stat-icon text-primary">
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <div class="stat-content">
                <h3><?= count($zone['locations']) ?></h3>
                <p class="text-muted mb-0">Locations</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-6">
        <div class="stat-card">
            <div class="stat-icon text-secondary">
                <i class="fas fa-sort-amount-up"></i>
            </div>
            <div class="stat-content">
                <h3>#<?= $zone['priority'] ?></h3>
                <p class="text-muted mb-0">Priority</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-6">
        <div class="stat-card">
            <div class="stat-icon text-<?= $zone['is_active'] ? 'success' : 'secondary' ?>">
                <i class="fas fa-<?= $zone['is_active'] ? 'check-circle' : 'times-circle' ?>"></i>
            </div>
            <div class="stat-content">
                <h3><?= $zone['is_active'] ? 'Active' : 'Inactive' ?></h3>
                <p class="text-muted mb-0">Status</p>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="row">
    <!-- Zone Information Card -->
    <div class="col-md-6 col-12 mb-3">
        <div class="card dashboard-card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>Zone Information
                    <?php if (stripos($zone['zone_name'], 'riverine') !== false): ?>
                        <span class="badge bg-warning text-dark ms-2">
                            <i class="fas fa-exclamation-triangle"></i> Riverine
                        </span>
                    <?php endif; ?>
                    <?php if ($zone['priority'] == 999): ?>
                        <span class="badge bg-info ms-2">Fallback</span>
                    <?php endif; ?>
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <th width="40%">
                            <i class="fas fa-tag text-primary me-2"></i>Zone Name:
                        </th>
                        <td><?= esc($zone['zone_name']) ?></td>
                    </tr>
                    <tr>
                        <th>
                            <i class="fas fa-money-bill-wave text-success me-2"></i>Base Fee:
                        </th>
                        <td class="text-primary fw-bold"><?= format_currency($zone['base_fee']) ?></td>
                    </tr>
                    <tr>
                        <th>
                            <i class="fas fa-sort-amount-up text-secondary me-2"></i>Priority:
                        </th>
                        <td><span class="badge bg-secondary">#<?= $zone['priority'] ?></span></td>
                    </tr>
                    <tr>
                        <th>
                            <i class="fas fa-toggle-<?= $zone['is_active'] ? 'on' : 'off' ?> text-<?= $zone['is_active'] ? 'success' : 'secondary' ?> me-2"></i>Status:
                        </th>
                        <td>
                            <span class="badge bg-<?= $zone['is_active'] ? 'success' : 'secondary' ?>">
                                <?= $zone['is_active'] ? 'Active' : 'Inactive' ?>
                            </span>
                        </td>
                    </tr>
                    <?php if (!empty($zone['description'])): ?>
                    <tr>
                        <th>
                            <i class="fas fa-align-left text-info me-2"></i>Description:
                        </th>
                        <td><?= esc($zone['description']) ?></td>
                    </tr>
                    <?php endif; ?>
                </table>

                <div class="form-actions">
                    <a href="<?= base_url('admin/shipping-zones/edit/' . $zone['id']) ?>" 
                       class="btn btn-warning">
                        <i class="fas fa-edit"></i> <span class="btn-text">Edit Zone</span>
                    </a>
                    <a href="<?= base_url('admin/shipping-zones/' . $zone['id'] . '/locations') ?>" 
                       class="btn btn-primary">
                        <i class="fas fa-map-marker-alt"></i> <span class="btn-text">Manage Locations</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Mapped Locations Card -->
    <div class="col-md-6 col-12 mb-3">
        <div class="card dashboard-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-map-marked-alt me-2"></i>Mapped Locations
                    <span class="badge bg-primary ms-2"><?= count($zone['locations']) ?></span>
                </h5>
            </div>
            <div class="card-body">
                <?php if (empty($zone['locations'])): ?>
                    <div class="empty-state-small">
                        <i class="fas fa-map-marker-alt text-muted"></i>
                        <p class="text-muted mb-3">No locations mapped to this zone yet.</p>
                        <a href="<?= base_url('admin/shipping-zones/' . $zone['id'] . '/locations/create') ?>" 
                           class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Location
                        </a>
                    </div>
                <?php else: ?>
                    <div class="list-group">
                        <?php foreach (array_slice($zone['locations'], 0, 10) as $location): ?>
                            <div class="list-group-item">
                                <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                <strong><?= esc($location['state']) ?></strong>
                                <?php if ($location['city']): ?>
                                    <i class="fas fa-angle-right mx-1 text-muted"></i>
                                    <span class="text-muted"><?= esc($location['city']) ?></span>
                                <?php endif; ?>
                                <?php if ($location['area']): ?>
                                    <i class="fas fa-angle-right mx-1 text-muted"></i>
                                    <span class="text-muted"><?= esc($location['area']) ?></span>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <?php if (count($zone['locations']) > 10): ?>
                        <div class="mt-3 text-center">
                            <a href="<?= base_url('admin/shipping-zones/' . $zone['id'] . '/locations') ?>" 
                               class="btn btn-outline-primary btn-sm">
                                View all <?= count($zone['locations']) ?> locations <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>