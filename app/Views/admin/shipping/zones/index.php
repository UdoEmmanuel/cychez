<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php helper('cart'); ?>

<div class="products-header">
    <h4>Shipping Zones</h4>
    <a href="<?= base_url('admin/shipping-zones/create') ?>" class="btn btn-primary">
        <i class="fas fa-plus"></i> <span class="btn-text">Add Zone</span>
    </a>
</div>

<p class="text-muted mb-4">Manage your shipping zones and delivery fees</p>

<!-- Statistics -->
<div class="row dashboard-stats">
    <div class="col-lg-3 col-md-6 col-6">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-map-marked-alt"></i>
            </div>
            <div class="stat-content">
                <h3><?= $stats['total_zones'] ?></h3>
                <p class="text-muted mb-0">Total Zones</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-6">
        <div class="stat-card">
            <div class="stat-icon text-success">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <h3><?= $stats['active_zones'] ?></h3>
                <p class="text-muted mb-0">Active Zones</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-6">
        <div class="stat-card">
            <div class="stat-icon text-secondary">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="stat-content">
                <h3><?= $stats['inactive_zones'] ?></h3>
                <p class="text-muted mb-0">Inactive Zones</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-6">
        <div class="stat-card">
            <div class="stat-icon text-warning">
                <i class="fas fa-water"></i>
            </div>
            <div class="stat-content">
                <h3><?= $stats['riverine_zones'] ?></h3>
                <p class="text-muted mb-0">Riverine Zones</p>
            </div>
        </div>
    </div>
</div>

<!-- Zones Table -->
<div class="card">
    <div class="card-body">
        <!-- Desktop Table View -->
        <div class="table-responsive desktop-table-view">
            <table class="table">
                <thead>
                    <tr>
                        <th>Priority</th>
                        <th>Zone Name</th>
                        <th>Base Fee</th>
                        <th>Locations</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($zones as $zone): ?>
                        <tr>
                            <td>
                                <span class="badge bg-secondary">#<?= $zone['priority'] ?></span>
                            </td>
                            <td>
                                <strong><?= esc($zone['zone_name']) ?></strong>
                                <?php if (stripos($zone['zone_name'], 'riverine') !== false): ?>
                                    <span class="badge bg-warning text-dark ms-2">
                                        <i class="fas fa-exclamation-triangle"></i> Riverine
                                    </span>
                                <?php endif; ?>
                                <?php if ($zone['priority'] == 999): ?>
                                    <span class="badge bg-info ms-2">Fallback</span>
                                <?php endif; ?>
                                <?php if (!empty($zone['description'])): ?>
                                    <br><small class="text-muted"><?= esc($zone['description']) ?></small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong class="text-primary"><?= format_currency($zone['base_fee']) ?></strong>
                                <button class="btn btn-sm btn-link p-0 ms-2" 
                                        onclick="quickEditFee(<?= $zone['id'] ?>, <?= $zone['base_fee'] ?>, '<?= esc($zone['zone_name']) ?>')"
                                        title="Quick edit fee">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/shipping-zones/' . $zone['id'] . '/locations') ?>" 
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-map-marker-alt"></i> Manage Locations
                                </a>
                            </td>
                            <td>
                                <span class="badge bg-<?= $zone['is_active'] ? 'success' : 'secondary' ?>">
                                    <?= $zone['is_active'] ? 'Active' : 'Inactive' ?>
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="<?= base_url('admin/shipping-zones/view/' . $zone['id']) ?>" 
                                       class="btn btn-sm btn-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?= base_url('admin/shipping-zones/edit/' . $zone['id']) ?>" 
                                       class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?= base_url('admin/shipping-zones/toggle-active/' . $zone['id']) ?>" 
                                       class="btn btn-sm btn-<?= $zone['is_active'] ? 'secondary' : 'success' ?>" 
                                       title="<?= $zone['is_active'] ? 'Deactivate' : 'Activate' ?>"
                                       onclick="return confirm('Toggle zone status?')">
                                        <i class="fas fa-power-off"></i>
                                    </a>
                                    <?php if ($zone['priority'] != 999): ?>
                                        <a href="<?= base_url('admin/shipping-zones/delete/' . $zone['id']) ?>" 
                                           class="btn btn-sm btn-danger" title="Delete"
                                           onclick="return confirm('Are you sure? This will delete all associated locations.')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Mobile Card View -->
        <div class="mobile-card-view">
            <?php foreach ($zones as $zone): ?>
                <div class="product-mobile-card">
                    <div class="mobile-card-content">
                        <div class="mobile-card-info">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h6 class="mobile-card-title">
                                        <?= esc($zone['zone_name']) ?>
                                        <?php if (stripos($zone['zone_name'], 'riverine') !== false): ?>
                                            <span class="badge bg-warning text-dark ms-1">
                                                <i class="fas fa-exclamation-triangle"></i>
                                            </span>
                                        <?php endif; ?>
                                        <?php if ($zone['priority'] == 999): ?>
                                            <span class="badge bg-info ms-1">Fallback</span>
                                        <?php endif; ?>
                                    </h6>
                                    <?php if (!empty($zone['description'])): ?>
                                        <small class="text-muted d-block mb-2"><?= esc($zone['description']) ?></small>
                                    <?php endif; ?>
                                    <div class="mobile-card-price">
                                        <?= format_currency($zone['base_fee']) ?>
                                        <button class="btn btn-sm btn-link p-0 ms-1" 
                                                onclick="quickEditFee(<?= $zone['id'] ?>, <?= $zone['base_fee'] ?>, '<?= esc($zone['zone_name']) ?>')"
                                                title="Quick edit fee">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="<?= base_url('admin/shipping-zones/' . $zone['id'] . '/locations') ?>">
                                                <i class="fas fa-map-marker-alt me-2 text-primary"></i>Manage Locations
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item" href="<?= base_url('admin/shipping-zones/view/' . $zone['id']) ?>">
                                                <i class="fas fa-eye me-2 text-info"></i>View
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="<?= base_url('admin/shipping-zones/edit/' . $zone['id']) ?>">
                                                <i class="fas fa-edit me-2 text-warning"></i>Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="<?= base_url('admin/shipping-zones/toggle-active/' . $zone['id']) ?>"
                                               onclick="return confirm('Toggle zone status?')">
                                                <i class="fas fa-power-off me-2 text-<?= $zone['is_active'] ? 'secondary' : 'success' ?>"></i>
                                                <?= $zone['is_active'] ? 'Deactivate' : 'Activate' ?>
                                            </a>
                                        </li>
                                        <?php if ($zone['priority'] != 999): ?>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a class="dropdown-item text-danger" 
                                                   href="<?= base_url('admin/shipping-zones/delete/' . $zone['id']) ?>"
                                                   onclick="return confirm('Delete this zone and all locations?')">
                                                    <i class="fas fa-trash me-2"></i>Delete
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Quick Edit Fee Modal -->
<div class="modal fade" id="quickEditFeeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalZoneName">Quick Edit Fee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="edit-zone-id">
                <div class="mb-3">
                    <label class="form-label">New Base Fee (₦)</label>
                    <input type="number" class="form-control" id="edit-fee" step="0.01" min="0" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveFeeBtn" onclick="saveQuickEdit()">
                    <span class="spinner-border spinner-border-sm d-none" id="saveSpinner"></span>
                    Save Changes
                </button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
let feeModal;

// Initialize modal
document.addEventListener('DOMContentLoaded', function() {
    const modalElement = document.getElementById('quickEditFeeModal');
    if (modalElement) {
        feeModal = new bootstrap.Modal(modalElement);
    }
});

function quickEditFee(zoneId, currentFee, zoneName) {
    document.getElementById('edit-zone-id').value = zoneId;
    document.getElementById('edit-fee').value = currentFee;
    document.getElementById('modalZoneName').textContent = 'Quick Edit Fee - ' + zoneName;
    
    if (feeModal) {
        feeModal.show();
    }
}

function saveQuickEdit() {
    const zoneId = document.getElementById('edit-zone-id').value;
    const newFee = document.getElementById('edit-fee').value;
    const saveBtn = document.getElementById('saveFeeBtn');
    const spinner = document.getElementById('saveSpinner');
    
    // Validate
    if (!newFee || parseFloat(newFee) < 0) {
        alert('Please enter a valid fee');
        return;
    }
    
    // Show loading
    saveBtn.disabled = true;
    spinner.classList.remove('d-none');
    
    // Using vanilla JavaScript fetch
    fetch('<?= base_url('admin/shipping-zones/update-fee') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: new URLSearchParams({
            'zone_id': zoneId,
            'new_fee': newFee,
            '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Success - reload page
            location.reload();
        } else {
            // Error
            alert(data.message || 'Failed to update fee');
            saveBtn.disabled = false;
            spinner.classList.add('d-none');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
        saveBtn.disabled = false;
        spinner.classList.add('d-none');
    });
}
</script>
<?= $this->endSection() ?>