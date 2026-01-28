<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="page-header mb-3">
    <div class="d-flex align-items-center gap-3">
        <a href="<?= base_url('admin/products') ?>" class="btn btn-outline-secondary btn-back" title="Back to Products">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h4 class="mb-0">Edit Product</h4>
    </div>
</div>

<div class="card form-card">
    <div class="card-body">
        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <form action="<?= base_url('admin/products/update/' . $product['id']) ?>" method="post" enctype="multipart/form-data" id="productForm">
            <?= csrf_field() ?>
            
            <!-- Basic Information Section -->
            <div class="form-section">
                <h5 class="section-title">
                    <i class="fas fa-info-circle me-2"></i>Basic Information
                </h5>
                
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="name" class="form-label">
                                Product Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="name" 
                                   name="name" 
                                   value="<?= old('name', $product['name']) ?>" 
                                   placeholder="Enter product name"
                                   required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" 
                                      id="description" 
                                      name="description" 
                                      rows="4" 
                                      placeholder="Enter product description"><?= old('description', $product['description']) ?></textarea>
                            <small class="text-muted">Provide a detailed description of the product</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="category_id" class="form-label">
                                Category <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                <option value="">Select Category</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>" 
                                            <?= old('category_id', $product['category_id']) == $category['id'] ? 'selected' : '' ?>>
                                        <?= esc($category['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Pricing Section -->
            <div class="form-section">
                <h5 class="section-title">
                    <i class="fas fa-tags me-2"></i>Pricing
                </h5>
                
                <div class="row">
                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label for="price" class="form-label">
                                Price <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">₦</span>
                                <input type="number" 
                                       class="form-control" 
                                       id="price" 
                                       name="price" 
                                       step="0.01" 
                                       min="0"
                                       value="<?= old('price', $product['price']) ?>" 
                                       placeholder="0.00"
                                       required>
                            </div>
                            <small class="text-muted">Selling price</small>
                        </div>
                    </div>
                    
                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label for="compare_price" class="form-label">Compare Price</label>
                            <div class="input-group">
                                <span class="input-group-text">₦</span>
                                <input type="number" 
                                       class="form-control" 
                                       id="compare_price" 
                                       name="compare_price" 
                                       step="0.01" 
                                       min="0"
                                       value="<?= old('compare_price', $product['compare_price']) ?>" 
                                       placeholder="0.00">
                            </div>
                            <small class="text-muted">Original price (optional)</small>
                        </div>
                    </div>
                    
                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <label for="cost_price" class="form-label">Cost Price</label>
                            <div class="input-group">
                                <span class="input-group-text">₦</span>
                                <input type="number" 
                                       class="form-control" 
                                       id="cost_price" 
                                       name="cost_price" 
                                       step="0.01" 
                                       min="0"
                                       value="<?= old('cost_price', $product['cost_price']) ?>" 
                                       placeholder="0.00">
                            </div>
                            <small class="text-muted">Your cost (optional)</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Inventory Section -->
            <div class="form-section">
                <h5 class="section-title">
                    <i class="fas fa-boxes me-2"></i>Inventory
                </h5>
                
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="mb-3">
                            <label for="sku" class="form-label">SKU</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="sku" 
                                   name="sku" 
                                   value="<?= old('sku', $product['sku']) ?>" 
                                   placeholder="Stock Keeping Unit">
                            <small class="text-muted">Unique product identifier (optional)</small>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-12">
                        <div class="mb-3">
                            <label for="stock_quantity" class="form-label">
                                Stock Quantity <span class="text-danger">*</span>
                            </label>
                            <input type="number" 
                                   class="form-control" 
                                   id="stock_quantity" 
                                   name="stock_quantity" 
                                   min="0"
                                   value="<?= old('stock_quantity', $product['stock_quantity']) ?>" 
                                   placeholder="0"
                                   required>
                            <small class="text-muted">Available quantity in stock</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Product Image Section -->
            <div class="form-section">
                <h5 class="section-title">
                    <i class="fas fa-image me-2"></i>Product Image
                </h5>
                
                <div class="row">
                    <div class="col-12">
                        <?php if ($product['image']): ?>
                            <div class="mb-3">
                                <label class="form-label">Current Image</label>
                                <div class="current-image-wrapper">
                                    <img src="<?= base_url('assets/uploads/products/' . $product['image']) ?>" 
                                         alt="<?= esc($product['name']) ?>" 
                                         class="current-product-image">
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <div class="mb-3">
                            <label for="image" class="form-label">Change Image</label>
                            <input type="file" 
                                   class="form-control" 
                                   id="image" 
                                   name="image" 
                                   accept="image/jpeg,image/png,image/jpg,image/webp" 
                                   onchange="previewImage(this)">
                            <small class="text-muted">Leave empty to keep current image. Accepted: JPG, PNG, WEBP (Max: 4MB)</small>
                        </div>
                        
                        <div id="imagePreview" class="image-preview" style="display: none;">
                            <img id="previewImg" src="" alt="Preview">
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Product Options Section -->
            <div class="form-section">
                <h5 class="section-title">
                    <i class="fas fa-cog me-2"></i>Product Options
                </h5>
                
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="is_featured" 
                                       name="is_featured" 
                                       value="1" 
                                       <?= old('is_featured', $product['is_featured']) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="is_featured">
                                    <strong>Featured Product</strong>
                                    <small class="d-block text-muted">Display on homepage</small>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-12">
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="is_active" 
                                       name="is_active" 
                                       value="1" 
                                       <?= old('is_active', $product['is_active']) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="is_active">
                                    <strong>Active Status</strong>
                                    <small class="d-block text-muted">Visible to customers</small>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- SEO Section -->
            <div class="form-section">
                <h5 class="section-title">
                    <i class="fas fa-search me-2"></i>SEO Information
                </h5>
                
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="mb-3">
                            <label for="meta_title" class="form-label">Meta Title</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="meta_title" 
                                   name="meta_title" 
                                   maxlength="60"
                                   value="<?= old('meta_title', $product['meta_title']) ?>" 
                                   placeholder="SEO title for search engines">
                            <small class="text-muted">Recommended: 50-60 characters</small>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-12">
                        <div class="mb-3">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea class="form-control" 
                                      id="meta_description" 
                                      name="meta_description" 
                                      rows="2" 
                                      maxlength="160"
                                      placeholder="Brief description for search results"><?= old('meta_description', $product['meta_description']) ?></textarea>
                            <small class="text-muted">Recommended: 150-160 characters</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Form Actions -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Update Product
                </button>
                <a href="<?= base_url('admin/products') ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        };
        
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.style.display = 'none';
    }
}
</script>

<?= $this->endSection() ?>