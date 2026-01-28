<?php

namespace App\Services;

use App\Models\ShippingZoneModel;
use App\Models\ShippingLocationModel;
use Config\Services;

class ShippingService
{
    protected $zoneModel;
    protected $locationModel;

    public function __construct()
    {
        $this->zoneModel = new ShippingZoneModel();
        $this->locationModel = new ShippingLocationModel();
    }

    /**
     * Calculate shipping fee based on location
     * 
     * @param string $state
     * @param string|null $city
     * @param string|null $area
     * @return array ['fee' => float, 'zone' => array, 'is_riverine' => bool]
     */
    public function calculateShippingFee(string $state, ?string $city = null, ?string $area = null): array
    {
        // Find matching zone
        $zone = $this->locationModel->findZoneByLocation($state, $city, $area);

        if (!$zone) {
            // Fallback to default zone
            $zone = $this->zoneModel->getFallbackZone();
        }

        $isRiverine = $this->isRiverineZone($zone['zone_name'] ?? '');

        return [
            'fee' => (float) ($zone['base_fee'] ?? 5000.00),
            'zone' => $zone,
            'zone_id' => $zone['id'] ?? null,
            'zone_name' => $zone['zone_name'] ?? 'Default Zone',
            'is_riverine' => $isRiverine,
            'requires_confirmation' => $isRiverine,
        ];
    }

    /**
     * Get zone for location
     * 
     * @param string $state
     * @param string|null $city
     * @param string|null $area
     * @return array|null
     */
    public function getZoneForLocation(string $state, ?string $city = null, ?string $area = null): ?array
    {
        return $this->locationModel->findZoneByLocation($state, $city, $area);
    }

    /**
     * Get all active shipping zones
     * 
     * @return array
     */
    public function getActiveZones(): array
    {
        return $this->zoneModel->getActiveZones();
    }

    /**
     * Check if zone is riverine
     * 
     * @param string $zoneName
     * @return bool
     */
    public function isRiverineZone(string $zoneName): bool
    {
        return stripos($zoneName, 'riverine') !== false;
    }

    /**
     * Send riverine order notification to admin
     * 
     * @param array $order
     * @return bool
     */
    public function sendRiverineOrderNotification(array $order): bool
    {
        try {
            $email = Services::email();
            
            $adminEmail = env('site.adminEmail');
            if (!$adminEmail) {
                log_message('error', 'Admin email not configured for riverine notifications');
                return false;
            }

            $message = view('emails/riverine_order_notification', ['order' => $order]);

            $email->setTo($adminEmail);
            $email->setSubject('⚠️ Riverine Area Order - Requires Fee Confirmation - ' . $order['order_number']);
            $email->setMessage($message);
            
            $sent = $email->send();

            if (!$sent) {
                log_message('error', 'Failed to send riverine notification: ' . print_r($email->printDebugger(['headers']), true));
            }

            return $sent;

        } catch (\Exception $e) {
            log_message('error', 'Riverine notification error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get shipping breakdown for display
     * 
     * @param float $cartTotal
     * @param array $shippingData
     * @return array
     */
    public function getShippingBreakdown(float $cartTotal, array $shippingData): array
    {
        return [
            'cart_total' => $cartTotal,
            'shipping_fee' => $shippingData['fee'],
            'total_amount' => $cartTotal + $shippingData['fee'],
            'zone_name' => $shippingData['zone_name'],
            'is_riverine' => $shippingData['is_riverine'],
            'requires_confirmation' => $shippingData['requires_confirmation'],
        ];
    }

    /**
     * Validate shipping location data
     * 
     * @param array $data
     * @return array ['valid' => bool, 'errors' => array]
     */
    public function validateLocation(array $data): array
    {
        $errors = [];

        if (empty($data['state'])) {
            $errors['state'] = 'State is required';
        }

        // Rivers State must have city selected
        if (isset($data['state']) && $data['state'] === 'Rivers' && empty($data['city'])) {
            $errors['city'] = 'City is required for Rivers State deliveries';
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors,
        ];
    }

    /**
     * Get available cities for a state
     * 
     * @param string $state
     * @return array
     */
    public function getCitiesForState(string $state): array
    {
        // First check database for configured cities
        $dbCities = $this->locationModel->getCitiesByState($state);
        
        if (!empty($dbCities)) {
            return array_combine($dbCities, $dbCities);
        }

        // Fallback to config
        return \Config\NigerianStates::getCitiesByState($state);
    }

    /**
     * Get available areas for a city
     * 
     * @param string $state
     * @param string $city
     * @return array
     */
    public function getAreasForCity(string $state, string $city): array
    {
        // First check database
        $dbAreas = $this->locationModel->getAreasByCity($state, $city);
        
        if (!empty($dbAreas)) {
            return array_combine($dbAreas, $dbAreas);
        }

        // Fallback to config
        return \Config\NigerianStates::getAreasByCity($city);
    }

    /**
     * Format shipping fee for display
     * 
     * @param float $fee
     * @return string
     */
    public function formatFee(float $fee): string
    {
        return '₦' . number_format($fee, 2);
    }

    /**
     * Get shipping estimate text based on zone type
     * 
     * @param array $shippingData
     * @return string
     */
    public function getEstimateText(array $shippingData): string
    {
        if ($shippingData['is_riverine']) {
            return 'Estimated fee (may be adjusted after review): ' . $this->formatFee($shippingData['fee']);
        }

        return 'Shipping fee: ' . $this->formatFee($shippingData['fee']);
    }
}