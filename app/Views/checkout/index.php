<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php helper(['cart', 'shipping']); ?>
<?php use Config\NigerianStates; ?>

<main>
    <!-- Breadcrumb Start -->
    <div class="breadcrumb-section">
        <div class="container-fluid custom-container">
            <div class="breadcrumb-wrapper text-center">
                <h2 class="breadcrumb-wrapper__title">Checkout</h2>
                <ul class="breadcrumb-wrapper__items justify-content-center">
                    <li><a href="<?= base_url('/shop') ?>">shop</a></li>
                    <li><span>Checkout</span></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Checkout Start -->
    <div class="checkout-section section-padding-2">
        <div class="container-fluid custom-container">
            
            <!-- Main Shipping Notice -->
            <?= shipping_main_notice() ?>
            
            <!-- Riverine Warning (hidden by default, shown via JS) -->
            <div id="riverine-warning" style="display: none;">
                <?= shipping_riverine_warning() ?>
            </div>

            <!-- Checkout Start -->
            <div class="checkout-wrapper">
                <form id="checkout-form">
                    <?= csrf_field() ?>
                    
                    <div class="checkout-row">
                        <div class="checkout-col-1">
                            <!-- Checkout Details Start -->
                            <div class="checkout-details">
                                <h3 class="checkout-details__title">Billing & Delivery Details</h3>

                                <!-- Checkout Details Billing Start -->
                                <div class="checkout-details__billing">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="single-form">
                                                <label class="single-form__label">First name *</label>
                                                <input class="single-form__input" type="text" name="first_name" 
                                                       value="<?= old('first_name', $user['first_name'] ?? '') ?>" required />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="single-form">
                                                <label class="single-form__label">Last name *</label>
                                                <input class="single-form__input" type="text" name="last_name" 
                                                       value="<?= old('last_name', $user['last_name'] ?? '') ?>" required />
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Email -->
                                    <div class="single-form">
                                        <label class="single-form__label">Email address *</label>
                                        <input class="single-form__input" type="email" name="email" 
                                               value="<?= old('email', $user['email'] ?? '') ?>" required />
                                    </div>

                                    <!-- Phone -->
                                    <div class="single-form">
                                        <label class="single-form__label">Phone *</label>
                                        <input class="single-form__input" type="text" name="phone" 
                                               value="<?= old('phone', $user['phone'] ?? '') ?>" 
                                               placeholder="08012345678" required />
                                    </div>

                                    <!-- State -->
                                    <div class="single-form">
                                        <label class="single-form__label">State *</label>
                                        <select class="single-form__select" name="state" id="state" required>
                                            <option value="">Select State</option>
                                            <?php foreach ($states as $code => $name): ?>
                                                <option value="<?= esc($code) ?>" <?= old('state') === $code ? 'selected' : '' ?>>
                                                    <?= esc($name) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <!-- City (dynamically populated) -->
                                    <div class="single-form">
                                        <label class="single-form__label">City/LGA *</label>
                                        <select class="single-form__select" name="city" id="city" required>
                                            <option value="">Select State First</option>
                                        </select>
                                        <small class="text-muted">Select your state first to see available cities</small>
                                    </div>

                                    <!-- Area (optional, dynamically populated) -->
                                    <div class="single-form" id="area-wrapper" style="display: none;">
                                        <label class="single-form__label">Area/Landmark (Optional)</label>
                                        <select class="single-form__select" name="area" id="area">
                                            <option value="">Select City First</option>
                                        </select>
                                        <small class="text-muted">Select for more accurate shipping calculation</small>
                                    </div>

                                    <!-- Street Address -->
                                    <div class="single-form">
                                        <label class="single-form__label">Street address *</label>
                                        <input class="single-form__input" type="text" name="address" 
                                               placeholder="House number and street name" 
                                               value="<?= old('address') ?>" required />
                                    </div>

                                    <!-- Postal Code (optional) -->
                                    <div class="single-form">
                                        <label class="single-form__label">Postal Code (Optional)</label>
                                        <input class="single-form__input" type="text" name="postal_code" 
                                               value="<?= old('postal_code') ?>" />
                                    </div>

                                    <!-- Order Notes -->
                                    <div class="single-form">
                                        <label class="single-form__label">Order notes (optional)</label>
                                        <textarea class="single-form__input" name="notes" rows="4" 
                                                  placeholder="Notes about your order, e.g. special notes for delivery."><?= old('notes') ?></textarea>
                                    </div>
                                </div>
                                <!-- Checkout Details Billing End -->
                            </div>
                            <!-- Checkout Details End -->
                        </div>
                        
                        <div class="checkout-col-2">
                            <!-- Checkout Details Start -->
                            <div class="checkout-details">
                                <h3 class="checkout-details__title">Your order</h3>

                                <div class="checkout-details__order-review">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="product-name">Product</th>
                                                <th class="product-total">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($cart as $item): ?>
                                                <tr class="cart-item">
                                                    <td class="product-name">
                                                        <?= esc($item['name']) ?>&nbsp;
                                                        <strong>× <?= $item['quantity'] ?></strong>
                                                    </td>
                                                    <td class="product-total">
                                                        <span>₦<?= number_format($item['price'] * $item['quantity'], 2) ?></span>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr class="cart-subtotal">
                                                <th>Cart Subtotal</th>
                                                <td><span>₦<?= number_format(get_cart_total(), 2) ?></span></td>
                                            </tr>

                                            <!-- Shipping Fee Row (Updated via AJAX) -->
                                            <tr class="shipping" id="shipping-row">
                                                <th>Shipping Fee</th>
                                                <td>
                                                    <span id="shipping-fee-display" class="text-primary fw-bold">
                                                        Calculate below
                                                    </span>
                                                    <!-- <div id="shipping-zone-info" class="mt-1" style="display: none;">
                                                        <small class="text-muted">Zone: <span id="zone-name"></span></small>
                                                    </div> -->
                                                </td>
                                            </tr>

                                            <!-- Total Row -->
                                            <tr class="order-total">
                                                <th>Total</th>
                                                <td>
                                                    <strong>
                                                        <span id="total-amount">₦<?= number_format(get_cart_total(), 2) ?></span>
                                                    </strong>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>

                                    <!-- Shipping Inline Note -->
                                    <div class="mt-3">
                                        <?= shipping_inline_note() ?>
                                    </div>

                                    <!-- Payment Method -->
                                    <!-- <div class="checkout-details__payment-method mt-4">
                                        <div class="single-form">
                                            <input type="radio" name="payment-method" id="paystack" checked />
                                            <label for="paystack" class="single-form__label radio-label">
                                                <span></span> Pay with Paystack (Card, Bank Transfer, USSD)
                                            </label>
                                        </div>
                                        <div class="payment-method-body mt-2">
                                            <p class="text-muted">
                                                You will be redirected to Paystack to complete your payment securely.
                                            </p>
                                        </div>
                                    </div> -->

                                    <!-- Privacy Policy -->
                                    <div class="checkout-details__privacy-policy mt-3">
                                        <p>
                                            Your personal data will be used to process your order, support
                                            your experience throughout this website, and for other purposes
                                            described in our privacy policy.
                                        </p>
                                    </div>

                                    <!-- Place Order Button -->
                                    <div class="checkout-details__btn">
                                        <button type="submit" class="btn" id="place-order-btn">
                                            <span id="btn-text">Place Order</span>
                                            <span id="btn-loading" style="display: none;">
                                                <i class="fas fa-spinner fa-spin"></i> Processing...
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- Checkout Details End -->
                        </div>
                    </div>
                </form>
            </div>
            <!-- Checkout End -->
        </div>
    </div>
    <!-- Checkout End -->
</main>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://js.paystack.co/v1/inline.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        let currentShippingFee = 0;
        let isRiverineZone = false;
        const cartTotal = <?= get_cart_total() ?>;

        // Function to get fresh CSRF token from meta tags or page
        function getCsrfToken() {
            // Try to get from meta tag first
            let token = $('meta[name="csrf-token"]').attr('content');
            if (!token) {
                // Fallback: get from hidden input if exists
                token = $('input[name="<?= csrf_token() ?>"]').val();
            }
            if (!token) {
                // Last resort: use the one from page load
                token = '<?= csrf_hash() ?>';
            }
            return token;
        }

        // Set up AJAX to always include CSRF token
        $.ajaxSetup({
            data: {},
            beforeSend: function(xhr, settings) {
                // Add CSRF token to all POST requests
                if (settings.type === 'POST') {
                    if (typeof settings.data === 'string') {
                        settings.data += '&<?= csrf_token() ?>=' + getCsrfToken();
                    } else {
                        settings.data['<?= csrf_token() ?>'] = getCsrfToken();
                    }
                }
            }
        });

        // State change - load cities
        $('#state').on('change', function() {
            const state = $(this).val();
            
            console.log('State changed to:', state);
            
            if (!state) {
                $('#city').html('<option value="">Select State First</option>');
                $('#area-wrapper').hide();
                $('#area').html('<option value="">Select City First</option>');
                resetShippingDisplay();
                return;
            }

            // Show loading
            $('#city').html('<option value="">Loading cities...</option>').prop('disabled', true);

            // Load cities
            $.ajax({
                url: '<?= base_url('checkout/getCities') ?>',
                method: 'POST',
                dataType: 'json',
                data: {
                    state: state
                },
                success: function(response) {
                    console.log('Cities response:', response);
                    
                    $('#city').prop('disabled', false);
                    
                    if (response.success && response.cities) {
                        let options = '<option value="">Select City/LGA</option>';
                        
                        // Handle array response
                        if (Array.isArray(response.cities)) {
                            response.cities.forEach(function(city) {
                                options += `<option value="${city}">${city}</option>`;
                            });
                        } else {
                            // Handle object response
                            $.each(response.cities, function(value, label) {
                                options += `<option value="${value}">${label}</option>`;
                            });
                        }
                        
                        $('#city').html(options);
                        
                        // Show area dropdown for Rivers State
                        if (state === 'Rivers') {
                            $('#area-wrapper').show();
                        } else {
                            $('#area-wrapper').hide();
                        }
                    } else {
                        $('#city').html('<option value="">No cities available</option>');
                        Toast.info(response.message || 'No delivery locations available for this state.'); 
                    }
                    
                    resetShippingDisplay();
                },
                error: function(xhr, status, error) {
                    console.error('Cities error:', error);
                    console.error('Response:', xhr.responseText);
                    
                    $('#city').prop('disabled', false);
                    $('#city').html('<option value="">Error loading cities</option>');
                    
                    // Show user-friendly error
                    let errorMsg = 'Failed to load cities. ';
                    if (xhr.status === 403) {
                        errorMsg += 'Security error. Please refresh the page.';
                    } else if (xhr.status === 500) {
                        errorMsg += 'Server error. Please try again.';
                    } else {
                        errorMsg += 'Please try again.';
                    }
                    alert(errorMsg);
                }
            });
        });

        // City change - load areas and calculate shipping
        $('#city').on('change', function() {
            const state = $('#state').val();
            const city = $(this).val();
            
            console.log('City changed to:', city);
            
            if (!city) {
                $('#area').html('<option value="">Select City First</option>');
                resetShippingDisplay();
                return;
            }

            // Load areas if applicable
            $.ajax({
                url: '<?= base_url('checkout/getAreas') ?>',
                method: 'POST',
                dataType: 'json',
                data: {
                    state: state,
                    city: city
                },
                success: function(response) {
                    console.log('Areas response:', response);
                    
                    if (response.success && response.areas && response.areas.length > 0) {
                        let options = '<option value="">Select Area (Optional)</option>';
                        response.areas.forEach(function(area) {
                            options += `<option value="${area}">${area}</option>`;
                        });
                        $('#area').html(options);
                    } else {
                        $('#area').html('<option value="">No specific areas</option>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Areas error:', error);
                }
            });

            // Calculate shipping
            calculateShipping();
        });

        // Area change - recalculate shipping
        $('#area').on('change', function() {
            calculateShipping();
        });

        function calculateShipping() {
            const state = $('#state').val();
            const city = $('#city').val();
            const area = $('#area').val();

            if (!state || !city) {
                return;
            }

            console.log('Calculating shipping for:', {state, city, area});

            // Show loading
            $('#shipping-fee-display').html('<i class="fas fa-spinner fa-spin"></i> Calculating...');

            $.ajax({
                url: '<?= base_url('checkout/previewShipping') ?>',
                method: 'POST',
                dataType: 'json',
                data: {
                    state: state,
                    city: city,
                    area: area
                },
                success: function(response) {
                    console.log('Shipping response:', response);
                    
                    if (response.success) {
                        currentShippingFee = response.shipping_fee;
                        isRiverineZone = response.is_riverine;
                        
                        $('#shipping-fee-display').html(response.formatted_shipping);
                        $('#total-amount').html(response.formatted_total);
                        $('#zone-name').text(response.zone_name);
                        $('#shipping-zone-info').show();
                        
                        // Show/hide riverine warning
                        if (isRiverineZone) {
                            $('#riverine-warning').slideDown();
                        } else {
                            $('#riverine-warning').slideUp();
                        }
                    } else {
                        $('#shipping-fee-display').html('<span class="text-danger">Not available</span>');
                        alert(response.message || 'Shipping not available for this location');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Shipping calculation error:', error);
                    $('#shipping-fee-display').html('<span class="text-danger">Error</span>');
                    alert('Failed to calculate shipping. Please try again.');
                }
            });
        }

        function resetShippingDisplay() {
            currentShippingFee = 0;
            isRiverineZone = false;
            $('#shipping-fee-display').html('Calculate below');
            $('#total-amount').html('₦<?= number_format(get_cart_total(), 2) ?>');
            $('#shipping-zone-info').hide();
            $('#riverine-warning').slideUp();
        }

        // Form submission
        $('#checkout-form').on('submit', function(e) {
            e.preventDefault();
            
            console.log('Form submitted');
            
            // Validate shipping has been calculated
            if (currentShippingFee === 0) {
                alert('Please select your state and city to calculate shipping fee');
                return;
            }
            
            const formData = $(this).serialize();
            
            // Disable button and show loading
            $('#place-order-btn').prop('disabled', true);
            $('#btn-text').hide();
            $('#btn-loading').show();
            
            $.ajax({
                url: '<?= base_url('checkout/process') ?>',
                method: 'POST',
                dataType: 'json',
                data: formData,
                success: function(response) {
                    console.log('Checkout response:', response);
                    
                    if (response.success) {
                        // Initialize payment
                        initializePayment();
                    } else {
                        alert(response.message || 'Failed to process order');
                        $('#place-order-btn').prop('disabled', false);
                        $('#btn-text').show();
                        $('#btn-loading').hide();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Checkout error:', error);
                    alert('An error occurred. Please try again.');
                    $('#place-order-btn').prop('disabled', false);
                    $('#btn-text').show();
                    $('#btn-loading').hide();
                }
            });
        });
        
        function initializePayment() {
            $.ajax({
                url: '<?= base_url('payment/initialize') ?>',
                method: 'POST',
                dataType: 'json',
                success: function(response) {
                    console.log('Payment init response:', response);
                    
                    if (response.success && response.authorization_url) {
                        // Redirect to Paystack
                        window.location.href = response.authorization_url;
                    } else {
                        alert(response.message || 'Failed to initialize payment');
                        $('#place-order-btn').prop('disabled', false);
                        $('#btn-text').show();
                        $('#btn-loading').hide();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Payment init error:', error);
                    alert('Failed to initialize payment. Please try again.');
                    $('#place-order-btn').prop('disabled', false);
                    $('#btn-text').show();
                    $('#btn-loading').hide();
                }
            });
        }

        console.log('Checkout initialized successfully');
    });
</script>
<?= $this->endSection() ?>