<div class="tracking-header">
    <h2><i class="fas fa-map-marker-alt"></i> Track Your Order</h2>
    <p>Enter your order details to track your shipment</p>
</div>

<div class="tracking-form-card">
    <div class="tracking-instructions">
        <i class="fas fa-info-circle"></i>
        <p>To track your order, please enter your Order ID and billing email address. This information can be found in your order confirmation email.</p>
    </div>

    <form id="trackingForm">
        <?= csrf_field() ?>
        
        <div class="form-group-modern">
            <label for="order_number" class="form-label-modern">
                <i class="fas fa-hashtag"></i> Order ID
            </label>
            <input 
                type="text" 
                class="form-control-modern" 
                id="order_number" 
                name="order_number" 
                placeholder="e.g. ORD-20250110-ABC123" 
                required
            >
            <small class="form-hint">
                <i class="fas fa-lightbulb"></i> Find this in your order confirmation email
            </small>
        </div>

        <div class="form-group-modern">
            <label for="email" class="form-label-modern">
                <i class="fas fa-envelope"></i> Billing Email
            </label>
            <input 
                type="email" 
                class="form-control-modern" 
                id="email" 
                name="email" 
                placeholder="email@example.com" 
                required
            >
            <small class="form-hint">
                <i class="fas fa-lightbulb"></i> Email address used during checkout
            </small>
        </div>

        <div class="tracking-actions">
            <button type="submit" class="btn-track-order" id="trackBtn">
                <i class="fas fa-search"></i> Track Order
            </button>
        </div>
    </form>
</div>

<!-- Tracking Result Container -->
<div id="trackingResult" class="tracking-result-card" style="display: none;">
    <div class="result-header">
        <h4><i class="fas fa-box"></i> Order Details</h4>
        <button type="button" class="btn-close-result" id="closeResultBtn">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <div id="orderInfo" class="order-tracking-info">
        <!-- Order details will be populated here -->
    </div>

    <div class="tracking-timeline" id="trackingTimeline">
        <!-- Timeline will be populated here -->
    </div>
</div>