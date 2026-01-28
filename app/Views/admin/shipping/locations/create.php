<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="mb-4">
    <h4>Add Location to <?= esc($zone['zone_name']) ?></h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url('admin/dashboard') ?>">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?= base_url('admin/shipping-zones') ?>">Shipping Zones</a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?= base_url('admin/shipping-zones/' . $zone['id'] . '/locations') ?>">
                    <?= esc($zone['zone_name']) ?>
                </a>
            </li>
            <li class="breadcrumb-item active">Add Location</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="<?= base_url('admin/shipping-zones/' . $zone['id'] . '/locations/store') ?>" method="POST">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label">State *</label>
                        <select class="form-select" name="state" id="state" required>
                            <option value="">Select State</option>
                            <?php foreach ($states as $state): ?>
                                <option value="<?= esc($state) ?>" <?= old('state') == $state ? 'selected' : '' ?>>
                                    <?= esc($state) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($errors['state'])): ?>
                            <div class="text-danger"><?= $errors['state'] ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">City/LGA (Optional)</label>
                        <input
                            type="text"
                            class="form-control"
                            name="city"
                            value="<?= old('city') ?>"
                            placeholder="e.g., Port Harcourt, Obio/Akpor"
                        >
                        <small class="text-muted">Leave empty to cover all cities in the state</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Area/Landmark (Optional)</label>
                        <input
                            type="text"
                            class="form-control"
                            name="area"
                            value="<?= old('area') ?>"
                            placeholder="e.g., Rumuola, GRA Phase 2"
                        >
                        <small class="text-muted">Leave empty to cover all areas in the city</small>
                    </div>

                    <div class="alert alert-info">
                        <strong>How location matching works:</strong>
                        <ul class="mb-0 small">
                            <li><strong>State only:</strong> Covers entire state</li>
                            <li><strong>State + City:</strong> Covers all areas in that city</li>
                            <li><strong>State + City + Area:</strong> Covers specific area only</li>
                        </ul>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Location
                        </button>
                        <a href="<?= base_url('admin/shipping-zones/' . $zone['id'] . '/locations') ?>" 
                           class="btn btn-secondary">
                            Cancel
                        </a>
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
                    <li>Be as specific as possible for accurate matching</li>
                    <li>More specific locations override general ones</li>
                    <li>City names should match what customers will enter</li>
                    <li>You can use "Bulk Add" for multiple locations</li>
                </ul>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <h5>Examples</h5>
                <div class="small">
                    <p class="mb-2"><strong>Entire state:</strong></p>
                    <ul>
                        <li>State: Rivers</li>
                        <li>City: (empty)</li>
                        <li>Area: (empty)</li>
                    </ul>
                    
                    <p class="mb-2 mt-3"><strong>Specific city:</strong></p>
                    <ul>
                        <li>State: Rivers</li>
                        <li>City: Port Harcourt</li>
                        <li>Area: (empty)</li>
                    </ul>
                    
                    <p class="mb-2 mt-3"><strong>Specific area:</strong></p>
                    <ul>
                        <li>State: Rivers</li>
                        <li>City: Port Harcourt</li>
                        <li>Area: Rumuola</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>