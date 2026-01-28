<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="mb-4">
    <h4>Create Shipping Zone</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('admin/shipping-zones') ?>">Shipping Zones</a></li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="<?= base_url('admin/shipping-zones/store') ?>" method="POST">
                    <?= csrf_field() ?>
                    
                    <div class="mb-3">
                        <label class="form-label">Zone Name *</label>
                        <input type="text" class="form-control" name="zone_name" 
                               value="<?= old('zone_name') ?>" required>
                        <?php if (isset($errors['zone_name'])): ?>
                            <div class="text-danger"><?= $errors['zone_name'] ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Base Fee (₦) *</label>
                        <input type="number" class="form-control" name="base_fee" 
                               value="<?= old('base_fee', '0.00') ?>" step="0.01" min="0" required>
                        <?php if (isset($errors['base_fee'])): ?>
                            <div class="text-danger"><?= $errors['base_fee'] ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Priority *</label>
                        <input type="number" class="form-control" name="priority" 
                               value="<?= old('priority', '10') ?>" min="1" required>
                        <small class="text-muted">Lower number = Higher priority (1 = checked first)</small>
                        <?php if (isset($errors['priority'])): ?>
                            <div class="text-danger"><?= $errors['priority'] ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description (Optional)</label>
                        <textarea class="form-control" name="description" rows="3"><?= old('description') ?></textarea>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" 
                                   id="is_active" value="1" <?= old('is_active', '1') ? 'checked' : '' ?>>
                            <label class="form-check-label" for="is_active">
                                Active
                            </label>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Create Zone</button>
                        <a href="<?= base_url('admin/shipping-zones') ?>" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5>Tips</h5>
                <ul class="small">
                    <li>Zone names should be descriptive (e.g., "Port Harcourt Metro")</li>
                    <li>Base fee is the default shipping cost for this zone</li>
                    <li>Priority determines matching order (1 = highest)</li>
                    <li>Use priority 999 for fallback zones</li>
                    <li>Add locations after creating the zone</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>