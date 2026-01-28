<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php helper('cart'); ?>

<div class="products-header">
    <h4>Products</h4>
    <a href="<?= base_url('admin/products/create') ?>" class="btn btn-primary">
        <i class="fas fa-plus"></i> <span class="btn-text">Add Product</span>
    </a>
</div>

<!-- Search and Filter Section -->
<div class="card mb-3">
    <div class="card-body">
        <form method="get" action="<?= base_url('admin/products') ?>" id="filterForm">
            <div class="row g-3">
                <!-- Search - Always Visible -->
                <div class="col-md-4 col-12">
                    <div class="input-group">
                        <input type="text" 
                               name="search" 
                               class="form-control" 
                               placeholder="Search products..." 
                               value="<?= esc($filters['search'] ?? '') ?>">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

                <!-- Filter Toggle Button (Mobile Only) -->
                <div class="col-12 d-md-none">
                    <button class="btn btn-outline-primary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse">
                        <i class="fas fa-filter me-2"></i>Filters
                        <i class="fas fa-chevron-down ms-2"></i>
                    </button>
                </div>

                <!-- Collapsible Filters (Mobile) / Always Visible (Desktop) -->
                <div class="col-md-8 col-12">
                    <div class="collapse d-md-block" id="filterCollapse">
                        <div class="row g-3">
                            <!-- Category Filter -->
                            <div class="col-md-3 col-6">
                                <select name="category" class="form-select filter-select" onchange="document.getElementById('filterForm').submit()">
                                    <option value="">All Categories</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category['id'] ?>" 
                                                <?= (isset($filters['category']) && $filters['category'] == $category['id']) ? 'selected' : '' ?>>
                                            <?= esc($category['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Status Filter -->
                            <div class="col-md-3 col-6">
                                <select name="status" class="form-select filter-select" onchange="document.getElementById('filterForm').submit()">
                                    <option value="">All Status</option>
                                    <option value="1" <?= (isset($filters['status']) && $filters['status'] === '1') ? 'selected' : '' ?>>Active</option>
                                    <option value="0" <?= (isset($filters['status']) && $filters['status'] === '0') ? 'selected' : '' ?>>Inactive</option>
                                </select>
                            </div>

                            <!-- Stock Filter -->
                            <div class="col-md-3 col-6">
                                <select name="stock" class="form-select filter-select" onchange="document.getElementById('filterForm').submit()">
                                    <option value="">All Stock</option>
                                    <option value="in" <?= (isset($filters['stock']) && $filters['stock'] === 'in') ? 'selected' : '' ?>>In Stock</option>
                                    <option value="low" <?= (isset($filters['stock']) && $filters['stock'] === 'low') ? 'selected' : '' ?>>Low Stock</option>
                                    <option value="out" <?= (isset($filters['stock']) && $filters['stock'] === 'out') ? 'selected' : '' ?>>Out of Stock</option>
                                </select>
                            </div>

                            <!-- Clear Filters -->
                            <div class="col-md-3 col-6">
                                <a href="<?= base_url('admin/products') ?>" class="btn btn-outline-secondary w-100 btn-filter-clear">
                                    <i class="fas fa-times"></i> <span class="btn-text">Clear</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Products Table -->
<div class="card">
    <div class="card-body">
        <!-- Desktop Table View -->
        <div class="table-responsive desktop-table-view">
            <table class="table products-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($products)): ?>
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No products found</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?= $product['id'] ?></td>
                                <td>
                                    <img src="<?= base_url('assets/uploads/products/' . ($product['image'] ?? 'default.jpg')) ?>" 
                                         alt="<?= esc($product['name']) ?>" 
                                         class="product-thumbnail"
                                         loading="lazy">
                                </td>
                                <td>
                                    <div class="product-name"><?= esc($product['name']) ?></div>
                                </td>
                                <td><?= esc($product['category_name']) ?></td>
                                <td class="price-cell"><?= format_currency($product['price']) ?></td>
                                <td>
                                    <span class="badge bg-<?= $product['stock_quantity'] > 10 ? 'success' : ($product['stock_quantity'] > 0 ? 'warning' : 'danger') ?>">
                                        <?= $product['stock_quantity'] ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-<?= $product['is_active'] ? 'success' : 'secondary' ?>">
                                        <?= $product['is_active'] ? 'Active' : 'Inactive' ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item" href="<?= base_url('admin/products/edit/' . $product['id']) ?>">
                                                    <i class="fas fa-edit me-2 text-warning"></i>Edit
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a class="dropdown-item text-danger" 
                                                   href="<?= base_url('admin/products/delete/' . $product['id']) ?>"
                                                   onclick="return confirm('Are you sure you want to delete this product?')">
                                                    <i class="fas fa-trash me-2"></i>Delete
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Mobile Card View -->
        <div class="mobile-card-view">
            <?php if (empty($products)): ?>
                <div class="text-center py-4">
                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                    <p class="text-muted">No products found</p>
                </div>
            <?php else: ?>
                <?php foreach ($products as $product): ?>
                    <div class="product-mobile-card">
                        <div class="mobile-card-content">
                            <img src="<?= base_url('assets/uploads/products/' . ($product['image'] ?? 'default.jpg')) ?>" 
                                 alt="<?= esc($product['name']) ?>" 
                                 class="mobile-card-image"
                                 loading="lazy">
                            
                            <div class="mobile-card-info">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <h6 class="mobile-card-title"><?= esc($product['name']) ?></h6>
                                        <div class="mobile-card-price"><?= format_currency($product['price']) ?></div>
                                    </div>
                                    
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item" href="<?= base_url('admin/products/edit/' . $product['id']) ?>">
                                                    <i class="fas fa-edit me-2 text-warning"></i>Edit
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a class="dropdown-item text-danger" 
                                                   href="<?= base_url('admin/products/delete/' . $product['id']) ?>"
                                                   onclick="return confirm('Delete this product?')">
                                                    <i class="fas fa-trash me-2"></i>Delete
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                
                                <div class="mobile-card-badges">
                                    <span class="badge bg-light text-dark border"><?= esc($product['category_name']) ?></span>
                                    <span class="badge bg-<?= $product['is_active'] ? 'success' : 'secondary' ?>">
                                        <?= $product['is_active'] ? 'Active' : 'Inactive' ?>
                                    </span>
                                    <span class="badge bg-<?= $product['stock_quantity'] > 10 ? 'success' : ($product['stock_quantity'] > 0 ? 'warning' : 'danger') ?>">
                                        Stock: <?= $product['stock_quantity'] ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <!-- Pagination -->
        <?php if (isset($pager) && $pager->getPageCount() > 1): ?>
            <div class="pagination-wrapper">
                <?php
                $currentPage = $pager->getCurrentPage();
                $pageCount = $pager->getPageCount();
                $params = $_GET;
                ?>
                
                <nav aria-label="Product pagination">
                    <ul class="pagination justify-content-center mb-0">
                        <!-- Previous Button -->
                        <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
                            <?php
                            $params['page'] = $currentPage - 1;
                            $prevUrl = base_url('admin/products') . '?' . http_build_query($params);
                            ?>
                            <a class="page-link" href="<?= $prevUrl ?>" aria-label="Previous">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        </li>
                        
                        <?php
                        $startPage = max(1, $currentPage - 2);
                        $endPage = min($pageCount, $currentPage + 2);
                        
                        if ($startPage > 1): ?>
                            <?php $params['page'] = 1; ?>
                            <li class="page-item">
                                <a class="page-link" href="<?= base_url('admin/products') . '?' . http_build_query($params) ?>">1</a>
                            </li>
                            <?php if ($startPage > 2): ?>
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            <?php endif; ?>
                        <?php endif; ?>
                        
                        <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                            <?php $params['page'] = $i; ?>
                            <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                                <a class="page-link" href="<?= base_url('admin/products') . '?' . http_build_query($params) ?>">
                                    <?= $i ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                        
                        <?php if ($endPage < $pageCount): ?>
                            <?php if ($endPage < $pageCount - 1): ?>
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            <?php endif; ?>
                            <?php $params['page'] = $pageCount; ?>
                            <li class="page-item">
                                <a class="page-link" href="<?= base_url('admin/products') . '?' . http_build_query($params) ?>"><?= $pageCount ?></a>
                            </li>
                        <?php endif; ?>
                        
                        <!-- Next Button -->
                        <li class="page-item <?= $currentPage >= $pageCount ? 'disabled' : '' ?>">
                            <?php
                            $params['page'] = $currentPage + 1;
                            $nextUrl = base_url('admin/products') . '?' . http_build_query($params);
                            ?>
                            <a class="page-link" href="<?= $nextUrl ?>" aria-label="Next">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
                
                <div class="pagination-info">
                    Showing page <?= $currentPage ?> of <?= $pageCount ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>