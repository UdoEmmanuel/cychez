<div class="profile-header">
    <h2><i class="fas fa-user-edit"></i> Profile Information</h2>
    <p>Update your personal details and contact information</p>
</div>

<div class="profile-card">
    <form id="profileForm" onsubmit="return false;">
        <?= csrf_field() ?>
        
        <div class="profile-section">
            <h5 class="section-title">
                <i class="fas fa-id-card"></i>
                Personal Information
            </h5>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group-modern">
                        <label for="first_name" class="form-label-modern">
                            <i class="fas fa-user"></i> First Name
                        </label>
                        <input type="text" class="form-control-modern" id="first_name" name="first_name" 
                               value="<?= esc($user['first_name']) ?>" required placeholder="Enter your first name">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group-modern">
                        <label for="last_name" class="form-label-modern">
                            <i class="fas fa-user"></i> Last Name
                        </label>
                        <input type="text" class="form-control-modern" id="last_name" name="last_name" 
                               value="<?= esc($user['last_name']) ?>" required placeholder="Enter your last name">
                    </div>
                </div>
            </div>
        </div>

        <div class="profile-section">
            <h5 class="section-title">
                <i class="fas fa-address-book"></i>
                Contact Information
            </h5>
            
            <div class="form-group-modern">
                <label for="email" class="form-label-modern">
                    <i class="fas fa-envelope"></i> Email Address
                </label>
                <input type="email" class="form-control-modern disabled" id="email" 
                       value="<?= esc($user['email']) ?>" disabled>
                <small class="form-hint">
                    <i class="fas fa-info-circle"></i> Email cannot be changed for security reasons
                </small>
            </div>
            
            <div class="form-group-modern">
                <label for="phone" class="form-label-modern">
                    <i class="fas fa-phone"></i> Phone Number
                </label>
                <input type="tel" class="form-control-modern" id="phone" name="phone" 
                       value="<?= esc($user['phone']) ?>" required placeholder="Enter your phone number">
            </div>
        </div>

        <div class="profile-section">
            <h5 class="section-title">
                <i class="fas fa-map-marked-alt"></i>
                Shipping Address
            </h5>
            
            <div class="form-group-modern">
                <label for="address" class="form-label-modern">
                    <i class="fas fa-home"></i> Street Address
                </label>
                <input type="text" class="form-control-modern" id="address" name="address" 
                       value="<?= esc($user['address'] ?? '') ?>" placeholder="Enter your street address">
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group-modern">
                        <label for="city" class="form-label-modern">
                            <i class="fas fa-city"></i> City
                        </label>
                        <input type="text" class="form-control-modern" id="city" name="city" 
                               value="<?= esc($user['city'] ?? '') ?>" placeholder="Enter your city">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group-modern">
                        <label for="state" class="form-label-modern">
                            <i class="fas fa-flag"></i> State
                        </label>
                        <input type="text" class="form-control-modern" id="state" name="state" 
                               value="<?= esc($user['state'] ?? '') ?>" placeholder="Enter your state">
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group-modern">
                        <label for="country" class="form-label-modern">
                            <i class="fas fa-globe"></i> Country
                        </label>
                        <input type="text" class="form-control-modern" id="country" name="country" 
                               value="<?= esc($user['country'] ?? 'Nigeria') ?>" placeholder="Enter your country">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group-modern">
                        <label for="postal_code" class="form-label-modern">
                            <i class="fas fa-mail-bulk"></i> Postal Code
                        </label>
                        <input type="text" class="form-control-modern" id="postal_code" name="postal_code" 
                               value="<?= esc($user['postal_code'] ?? '') ?>" placeholder="Enter postal code">
                    </div>
                </div>
            </div>
        </div>

        <div class="profile-actions">
            <button type="button" class="btn-save-profile" id="saveBtn">
                <i class="fas fa-save"></i> Save Changes
            </button>
            <button type="button" class="btn-reset-profile" id="resetBtn">
                <i class="fas fa-undo"></i> Reset
            </button>
        </div>
    </form>
</div>

<div class="profile-info-card">
    <div class="info-item">
        <i class="fas fa-calendar-check"></i>
        <div>
            <span class="info-label">Member Since</span>
            <span class="info-value"><?= date('M d, Y', strtotime($user['created_at'] ?? 'now')) ?></span>
        </div>
    </div>
    <div class="info-item">
        <i class="fas fa-shield-alt"></i>
        <div>
            <span class="info-label">Account Status</span>
            <span class="info-value status-active">
                <i class="fas fa-check-circle"></i> Active
            </span>
        </div>
    </div>
</div>