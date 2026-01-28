<?php

/**
 * Shipping Notice Helper
 * 
 * Provides reusable shipping notice text for UI
 */

if (!function_exists('shipping_main_notice')) {
    /**
     * Main shipping notice for checkout page
     * 
     * @return string
     */
    function shipping_main_notice(): string
    {
        return '<div class="alert alert-info mb-3">
            <i class="fas fa-info-circle me-2"></i>
            <strong>Delivery Fee Notice:</strong> Shipping fees are calculated based on your delivery location. 
            For riverine or hard-to-reach areas, final delivery cost may be confirmed after order review.
        </div>';
    }
}

if (!function_exists('shipping_riverine_warning')) {
    /**
     * Warning for Rivers State riverine locations
     * 
     * @return string
     */
    function shipping_riverine_warning(): string
    {
        return '<div class="alert alert-warning mb-3">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Important:</strong> Deliveries to riverine areas may attract additional logistics costs. 
            Our team will contact you to confirm the final delivery fee before dispatch.
        </div>';
    }
}

if (!function_exists('shipping_inline_note')) {
    /**
     * Short inline shipping note for cart/checkout
     * 
     * @return string
     */
    function shipping_inline_note(): string
    {
        return '<small class="text-muted">
            <i class="fas fa-truck me-1"></i>
            Shipping fee is location-based and covers standard delivery only.
        </small>';
    }
}

if (!function_exists('format_shipping_fee')) {
    /**
     * Format shipping fee with currency
     * 
     * @param float $fee
     * @return string
     */
    function format_shipping_fee(float $fee): string
    {
        return '₦' . number_format($fee, 2);
    }
}

if (!function_exists('is_riverine_zone')) {
    /**
     * Check if a zone is riverine (requires special handling)
     * 
     * @param string $zoneName
     * @return bool
     */
    function is_riverine_zone(string $zoneName): bool
    {
        return stripos($zoneName, 'riverine') !== false;
    }
}

if (!function_exists('get_shipping_estimate_text')) {
    /**
     * Get shipping estimate text based on zone
     * 
     * @param array $zone
     * @return string
     */
    function get_shipping_estimate_text(array $zone): string
    {
        if (is_riverine_zone($zone['zone_name'])) {
            return 'Estimated fee (may be adjusted): ' . format_shipping_fee($zone['base_fee']);
        }
        
        return 'Shipping fee: ' . format_shipping_fee($zone['base_fee']);
    }
}

if (!function_exists('shipping_breakdown_html')) {
    /**
     * Generate HTML for shipping fee breakdown in checkout
     * 
     * @param float $cartTotal
     * @param float $shippingFee
     * @param array|null $zone
     * @return string
     */
    function shipping_breakdown_html(float $cartTotal, float $shippingFee, ?array $zone = null): string
    {
        $isRiverine = $zone && is_riverine_zone($zone['zone_name']);
        $asterisk = $isRiverine ? '<span class="text-warning">*</span>' : '';
        
        $html = '<div class="shipping-breakdown border-top pt-3 mt-3">';
        $html .= '<div class="d-flex justify-content-between mb-2">';
        $html .= '<span class="text-muted">Cart Subtotal:</span>';
        $html .= '<span>₦' . number_format($cartTotal, 2) . '</span>';
        $html .= '</div>';
        
        $html .= '<div class="d-flex justify-content-between mb-2">';
        $html .= '<span class="text-muted">Shipping Fee' . $asterisk . ':</span>';
        $html .= '<span class="text-primary fw-bold">₦' . number_format($shippingFee, 2) . '</span>';
        $html .= '</div>';
        
        if ($zone) {
            $html .= '<div class="mb-2">';
            $html .= '<small class="text-muted">Zone: ' . esc($zone['zone_name']) . '</small>';
            $html .= '</div>';
        }
        
        $html .= '<div class="d-flex justify-content-between border-top pt-2 mt-2">';
        $html .= '<span class="fw-bold">Total Amount' . $asterisk . ':</span>';
        $html .= '<span class="fw-bold fs-5 text-success">₦' . number_format($cartTotal + $shippingFee, 2) . '</span>';
        $html .= '</div>';
        
        if ($isRiverine) {
            $html .= '<div class="mt-2">';
            $html .= '<small class="text-warning"><span class="text-warning">*</span> Riverine area - Fee may be adjusted after review</small>';
            $html .= '</div>';
        }
        
        $html .= '</div>';
        
        return $html;
    }
}