<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php helper('cart'); ?>

<div class="dashboard-wrapper">
    <div class="container">
        <div class="dashboard-header d-none d-xl-block">
            <h1>My Account</h1>
            <p>Manage your orders, wishlist, and account settings</p>
        </div>
        
        <div class="dashboard-content">
            <div class="row">
                <!-- Sidebar Navigation -->
                <div class="col-lg-3 mb-4">
                    <button class="mobile-menu-toggle" id="mobileMenuToggle">
                        <i class="fas fa-bars"></i> Menu
                    </button>
                    
                    <?= $this->include('account/_sidebar') ?>
                </div>
                
                <!-- Main Content -->
                <div class="col-lg-9">
                    <div class="main-content-card">
                        <div class="loading-spinner" id="loadingSpinner">
                            <i class="fas fa-spinner"></i>
                            <p>Loading...</p>
                        </div>
                        
                        <div id="account-content">
                            <?= view('account/tabs/dashboard', ['recentOrders' => $recentOrders]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Store original form values globally
window.profileOriginalValues = {};

// CSRF Token Management
function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
           document.querySelector('input[name="<?= csrf_token() ?>"]')?.value || '';
}

function getCsrfTokenName() {
    return '<?= csrf_token() ?>';
}

function updateCsrfToken(newToken) {
    // Update meta tag
    const metaTag = document.querySelector('meta[name="csrf-token"]');
    if (metaTag) {
        metaTag.setAttribute('content', newToken);
    }
    
    // Update all CSRF input fields
    document.querySelectorAll(`input[name="${getCsrfTokenName()}"]`).forEach(input => {
        input.value = newToken;
    });
}

// Click event delegation for buttons
document.addEventListener('click', function(e) {
    // Handle Profile Save button
    if (e.target && e.target.id === 'saveBtn') {
        e.preventDefault();
        handleProfileSave();
    }
    
    // Handle Profile Reset button
    if (e.target && e.target.id === 'resetBtn') {
        e.preventDefault();
        handleProfileReset();
    }
    
    // Handle Close Tracking Result button
    if (e.target && e.target.id === 'closeResultBtn') {
        e.preventDefault();
        handleCloseTrackingResult();
    }
});

// Form submission event delegation
document.addEventListener('submit', function(e) {
    // Handle Tracking Form
    if (e.target && e.target.id === 'trackingForm') {
        e.preventDefault();
        handleTrackingSubmit(e.target);
    }
    
    // Prevent profile form from submitting normally
    if (e.target && e.target.id === 'profileForm') {
        e.preventDefault();
    }
});

// ===================================
// PROFILE FUNCTIONS
// ===================================

function handleProfileSave() {
    const form = document.getElementById('profileForm');
    if (!form) return;
    
    const requiredFields = form.querySelectorAll('[required]');
    let isValid = true;
    
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            isValid = false;
            field.classList.add('error');
        } else {
            field.classList.remove('error');
        }
    });
    
    if (!isValid) {
        if (typeof Toast !== 'undefined') {
            Toast.error('Please fill in all required fields');
        }
        return;
    }

    const saveBtn = document.getElementById('saveBtn');
    const originalBtnContent = saveBtn.innerHTML;
    saveBtn.disabled = true;
    saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';

    const formData = new FormData(form);
    
    // Ensure CSRF token is included
    if (!formData.has(getCsrfTokenName())) {
        formData.append(getCsrfTokenName(), getCsrfToken());
    }

    fetch('<?= base_url('account/profile/update') ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        // Extract new CSRF token from response headers if available
        const newToken = response.headers.get('X-CSRF-TOKEN');
        if (newToken) {
            updateCsrfToken(newToken);
        }
        return response.json();
    })
    .then(data => {
        // Update CSRF token if provided in response
        if (data.csrf_token) {
            updateCsrfToken(data.csrf_token);
        }
        
        if (data.success) {
            if (typeof Toast !== 'undefined') {
                Toast.success(data.message || 'Profile updated successfully!');
            }
            
            // Update original values
            const inputs = form.querySelectorAll('input:not([disabled])');
            inputs.forEach(input => {
                window.profileOriginalValues[input.name] = input.value;
            });
            
            // Update sidebar
            if (data.user) {
                const fullName = `${data.user.first_name} ${data.user.last_name}`;
                
                const sidebarNameElement = document.querySelector('.account-nav-header h5');
                if (sidebarNameElement) {
                    sidebarNameElement.textContent = fullName;
                }
                
                const avatarElement = document.querySelector('.user-avatar');
                if (avatarElement) {
                    avatarElement.textContent = data.user.first_name.charAt(0).toUpperCase();
                }
            }
        } else {
            let errorMessage = data.message || 'Failed to update profile';
            
            if (data.errors) {
                if (Array.isArray(data.errors)) {
                    errorMessage = data.errors.join(', ');
                } else {
                    errorMessage = Object.values(data.errors).join(', ');
                }
            }
            
            if (typeof Toast !== 'undefined') {
                Toast.error(errorMessage);
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (typeof Toast !== 'undefined') {
            Toast.error('An error occurred. Please try again.');
        }
    })
    .finally(() => {
        saveBtn.disabled = false;
        saveBtn.innerHTML = originalBtnContent;
    });
}

function handleProfileReset() {
    if (confirm('Are you sure you want to reset all changes?')) {
        const form = document.getElementById('profileForm');
        if (!form) return;
        
        const inputs = form.querySelectorAll('input:not([disabled])');
        inputs.forEach(input => {
            if (window.profileOriginalValues[input.name] !== undefined) {
                input.value = window.profileOriginalValues[input.name];
            }
        });
        
        if (typeof Toast !== 'undefined') {
            Toast.success('Form reset to original values');
        }
    }
}

function storeProfileOriginalValues() {
    const form = document.getElementById('profileForm');
    if (!form) return;
    
    window.profileOriginalValues = {};
    const inputs = form.querySelectorAll('input:not([disabled])');
    inputs.forEach(input => {
        window.profileOriginalValues[input.name] = input.value;
    });
}



// ===================================
// TRACKING FUNCTIONS
// ===================================

function handleTrackingSubmit(form) {
    const trackBtn = document.getElementById('trackBtn');
    const trackingResult = document.getElementById('trackingResult');
    
    if (!trackBtn || !trackingResult) return;
    
    // Validate form
    const orderNumber = form.querySelector('#order_number');
    const email = form.querySelector('#email');
    
    if (!orderNumber.value.trim() || !email.value.trim()) {
        if (typeof Toast !== 'undefined') {
            Toast.error('Please fill in all fields');
        }
        return;
    }
    
    // Disable button and show loading state
    const originalBtnContent = trackBtn.innerHTML;
    trackBtn.disabled = true;
    trackBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Tracking...';
    
    const formData = new FormData(form);
    
    // Ensure CSRF token is included
    if (!formData.has(getCsrfTokenName())) {
        formData.append(getCsrfTokenName(), getCsrfToken());
    }
    
    // Make AJAX request
    fetch('<?= base_url('account/tracking/track') ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        // Extract new CSRF token from response headers if available
        const newToken = response.headers.get('X-CSRF-TOKEN');
        if (newToken) {
            updateCsrfToken(newToken);
        }
        return response.json();
    })
    .then(data => {
        // Update CSRF token if provided in response
        if (data.csrf_token) {
            updateCsrfToken(data.csrf_token);
        }
        
        if (data.success && data.order) {
            renderOrderDetails(data.order);
            renderTrackingTimeline(data.order);
            trackingResult.style.display = 'block';

            if (typeof Toast !== 'undefined') {
                Toast.success(data.message || 'Order found successfully!');
            }
                        
            // Smooth scroll to results
            setTimeout(() => {
                trackingResult.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 100);
        } else {
            if (typeof Toast !== 'undefined') {
                Toast.error(data.message || 'Order not found. Please check your details.');
            }
            trackingResult.style.display = 'none';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (typeof Toast !== 'undefined') {
            Toast.error('An error occurred. Please try again.');
        }
        trackingResult.style.display = 'none';
    })
    .finally(() => {
        trackBtn.disabled = false;
        trackBtn.innerHTML = originalBtnContent;
    });
}

function renderOrderDetails(order) {
    const orderInfo = document.getElementById('orderInfo');
    if (!orderInfo) return;
    
    const paymentStatusClass = order.payment_status === 'paid' ? 'paid' : 'pending';
    const deliveryStatusClass = order.delivery_status || 'pending';
    
    const html = `
        <div class="info-grid">
            <div class="info-item-track">
                <i class="fas fa-receipt"></i>
                <div>
                    <span class="info-label">Order Number</span>
                    <span class="info-value">#${escapeHtml(order.order_number)}</span>
                </div>
            </div>
            
            <div class="info-item-track">
                <i class="fas fa-calendar-alt"></i>
                <div>
                    <span class="info-label">Order Date</span>
                    <span class="info-value">${formatDate(order.created_at)}</span>
                </div>
            </div>
            
            <div class="info-item-track">
                <i class="fas fa-money-bill-wave"></i>
                <div>
                    <span class="info-label">Total Amount</span>
                    <span class="info-value total-amount">${formatCurrency(order.total_amount)}</span>
                </div>
            </div>
            
            <div class="info-item-track">
                <i class="fas fa-credit-card"></i>
                <div>
                    <span class="info-label">Payment Status</span>
                    <span class="status-badge ${paymentStatusClass}">
                        ${order.payment_status === 'paid' ? '<i class="fas fa-check-circle"></i>' : '<i class="fas fa-clock"></i>'}
                        ${capitalizeFirst(order.payment_status)}
                    </span>
                </div>
            </div>
            
            <div class="info-item-track">
                <i class="fas fa-truck"></i>
                <div>
                    <span class="info-label">Delivery Status</span>
                    <span class="status-badge ${deliveryStatusClass}">
                        ${getStatusIcon(order.delivery_status)}
                        ${capitalizeFirst(order.delivery_status)}
                    </span>
                </div>
            </div>
            
            ${order.tracking_number ? `
                <div class="info-item-track tracking-number-highlight">
                    <i class="fas fa-shipping-fast"></i>
                    <div>
                        <span class="info-label">Tracking Number</span>
                        <span class="info-value">${escapeHtml(order.tracking_number)}</span>
                    </div>
                </div>
            ` : ''}
        </div>
    `;
    
    orderInfo.innerHTML = html;
}

function renderTrackingTimeline(order) {
    const timeline = document.getElementById('trackingTimeline');
    if (!timeline) return;
    
    const status = order.delivery_status;
    
    const steps = [
        { key: 'pending', label: 'Order Placed', icon: 'check-circle', description: 'Your order has been received' },
        { key: 'processing', label: 'Processing', icon: 'cog', description: 'Order is being prepared' },
        { key: 'shipped', label: 'Shipped', icon: 'truck', description: 'Order is on the way' },
        { key: 'delivered', label: 'Delivered', icon: 'home', description: 'Order has been delivered' }
    ];
    
    const statusOrder = ['pending', 'processing', 'shipped', 'delivered'];
    const currentIndex = statusOrder.indexOf(status);
    
    let timelineHtml = '<div class="timeline-container">';
    
    steps.forEach((step, index) => {
        const isCompleted = index <= currentIndex;
        const isCurrent = index === currentIndex;
        const statusClass = isCompleted ? 'completed' : (isCurrent ? 'current' : 'pending');
        
        timelineHtml += `
            <div class="timeline-step ${statusClass}">
                <div class="timeline-marker">
                    <i class="fas fa-${step.icon}"></i>
                </div>
                <div class="timeline-content">
                    <h5>${step.label}</h5>
                    <p>${step.description}</p>
                </div>
            </div>
        `;
        
        if (index < steps.length - 1) {
            timelineHtml += `<div class="timeline-connector ${isCompleted ? 'completed' : ''}"></div>`;
        }
    });
    
    timelineHtml += '</div>';
    timeline.innerHTML = timelineHtml;
}

function handleCloseTrackingResult() {
    const trackingResult = document.getElementById('trackingResult');
    if (!trackingResult) return;
    
    trackingResult.style.display = 'none';
    
    // Scroll back to form
    const trackingForm = document.getElementById('trackingForm');
    if (trackingForm) {
        trackingForm.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}

// ===================================
// HELPER FUNCTIONS
// ===================================

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
}

function formatCurrency(amount) {
    return new Intl.NumberFormat('en-NG', {
        style: 'currency',
        currency: 'NGN'
    }).format(amount);
}

function capitalizeFirst(str) {
    if (!str) return '';
    return str.charAt(0).toUpperCase() + str.slice(1);
}

function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function getStatusIcon(status) {
    const icons = {
        'pending': '<i class="fas fa-clock"></i>',
        'processing': '<i class="fas fa-cog"></i>',
        'shipped': '<i class="fas fa-truck"></i>',
        'delivered': '<i class="fas fa-check-circle"></i>',
        'cancelled': '<i class="fas fa-times-circle"></i>'
    };
    return icons[status] || '<i class="fas fa-box"></i>';
}

// ===================================
// ORDER FUNCTIONS
// ===================================

window.viewOrderDetails = function(orderId) {
    const accountContent = document.getElementById('account-content');
    const loadingSpinner = document.getElementById('loadingSpinner');
    
    if (!accountContent || !loadingSpinner) {
        console.error('Required elements not found');
        return;
    }
    
    // Show loading
    accountContent.style.display = 'none';
    loadingSpinner.classList.add('active');
    
    fetch(`<?= base_url('account/view-order/') ?>${orderId}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': getCsrfToken()
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        // Extract new CSRF token from response headers if available
        const newToken = response.headers.get('X-CSRF-TOKEN');
        if (newToken) {
            updateCsrfToken(newToken);
        }
        
        return response.json();
    })
    .then(data => {
        if (data.success && data.content) {
            accountContent.innerHTML = data.content;
            accountContent.style.display = 'block';
            loadingSpinner.classList.remove('active');
            
            // Update CSRF token
            if (data.csrf_token) {
                updateCsrfToken(data.csrf_token);
            }
            
            // Scroll to top
            if (window.innerWidth < 992) {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        } else {
            throw new Error(data.error || 'Failed to load order details');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        accountContent.innerHTML = `
            <div class="error-state">
                <i class="fas fa-exclamation-triangle"></i>
                <h4>Failed to load order details</h4>
                <p>${error.message}</p>
                <button onclick="document.querySelector('.nav-link[data-tab=\\'orders\\']')?.click()" class="btn-primary">
                    Back to Orders
                </button>
            </div>
        `;
        accountContent.style.display = 'block';
        loadingSpinner.classList.remove('active');
    });
};

    window.reorderOrder = function(orderId) {
        if (confirm('Add all items from this order to your cart?')) {
            fetch(`<?= base_url('account/order/reorder/') ?>${orderId}`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken()
                }
            })
            .then(response => response.json())
            .then(data => {
                // Update CSRF token
                if (data.csrf_token) {
                    updateCsrfToken(data.csrf_token);
                }
                
                if (data.success) {
                    if (typeof Toast !== 'undefined') {
                        Toast.success('Items added to cart successfully');
                    } else {
                        alert('Items added to cart successfully');
                    }
                    setTimeout(() => {
                        window.location.href = '<?= base_url('cart') ?>';
                    }, 1000);
                } else {
                    if (typeof Toast !== 'undefined') {
                        Toast.error(data.message || 'Failed to add items to cart');
                    } else {
                        alert(data.message || 'Failed to add items to cart');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (typeof Toast !== 'undefined') {
                    Toast.error('An error occurred while processing your request');
                } else {
                    alert('An error occurred while processing your request');
                }
            });
        }
    };

    window.backToOrders = function() {
        const ordersTab = document.querySelector('.nav-link[data-tab="orders"]');
        if (ordersTab) {
            ordersTab.click();
        }
    };

// ===================================
// TAB NAVIGATION
// ===================================

document.addEventListener('DOMContentLoaded', function() {
    const accountContent = document.getElementById('account-content');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const accountNav = document.getElementById('accountNav');
    
    // Mobile menu toggle
    if (mobileMenuToggle && accountNav) {
        mobileMenuToggle.addEventListener('click', function() {
            accountNav.classList.toggle('show');
        });
    }
    
    // Tab navigation
    document.querySelectorAll('.nav-link:not(.logout)').forEach(link => {
        link.addEventListener('click', function(e) {
            const tab = this.dataset.tab;
            
            // Only prevent default for tab navigation links
            if (!tab) return;
            
            e.preventDefault();
            e.stopPropagation();
            
            // Update active state
            document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
            this.classList.add('active');
            
            // Hide mobile menu after selection
            if (window.innerWidth < 992 && accountNav) {
                accountNav.classList.remove('show');
            }
            
            // Show loading state
            accountContent.style.display = 'none';
            loadingSpinner.classList.add('active');
            
            // Fetch tab content
            fetch(`<?= base_url('account/tab/') ?>${tab}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken()
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                // Extract new CSRF token from response headers if available
                const newToken = response.headers.get('X-CSRF-TOKEN');
                if (newToken) {
                    updateCsrfToken(newToken);
                }
                
                return response.json();
            })
            .then(data => {
                if (data.success && data.content) {
                    accountContent.innerHTML = data.content;
                    accountContent.style.display = 'block';
                    loadingSpinner.classList.remove('active');
                    
                    // Update CSRF token if provided
                    if (data.csrf_token) {
                        updateCsrfToken(data.csrf_token);
                    }
                    
                    // Store original values if profile tab
                    if (tab === 'profile') {
                        setTimeout(storeProfileOriginalValues, 100);
                    }
                    
                    // Scroll to top on mobile
                    if (window.innerWidth < 992) {
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                } else {
                    throw new Error(data.error || 'Failed to load content');
                }
            })
            .catch(error => {
                console.error('Error loading tab:', error);
                accountContent.innerHTML = `
                    <div class="error-state">
                        <i class="fas fa-exclamation-triangle"></i>
                        <h4>Failed to load content. Please try again.</h4>
                        <p>${error.message}</p>
                        <button onclick="location.reload()" class="btn-primary">Reload Page</button>
                    </div>
                `;
                accountContent.style.display = 'block';
                loadingSpinner.classList.remove('active');
            });
        });
    });

    // Handle shop link on mobile - close menu and allow navigation
    document.querySelector('.nav-link[href*="shop"]')?.addEventListener('click', function(e) {
        // Close mobile menu if open
        if (window.innerWidth < 992 && accountNav) {
            accountNav.classList.remove('show');
        }
        // Don't prevent default - let it navigate to shop
    });

    // Close mobile menu when clicking outside
    document.addEventListener('click', function(e) {
        if (window.innerWidth < 992 && accountNav) {
            if (!accountNav.contains(e.target) && !mobileMenuToggle.contains(e.target)) {
                accountNav.classList.remove('show');
            }
        }
    });
});
</script>

<?= $this->endSection() ?>