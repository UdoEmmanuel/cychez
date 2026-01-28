<?php

namespace App\Models;

use CodeIgniter\Model;

class ShippingZoneModel extends Model
{
    protected $table            = 'shipping_zones';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'zone_name',
        'base_fee',
        'is_active',
        'priority',
        'description',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [
        'base_fee' => 'float',
        'is_active' => 'boolean',
        'priority' => 'integer',
    ];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'zone_name' => 'required|min_length[3]|max_length[100]',
        'base_fee' => 'required|decimal|greater_than_equal_to[0]',
        'priority' => 'required|integer|greater_than_equal_to[1]',
    ];

    protected $validationMessages = [
        'zone_name' => [
            'required' => 'Zone name is required',
            'min_length' => 'Zone name must be at least 3 characters',
        ],
        'base_fee' => [
            'required' => 'Base fee is required',
            'decimal' => 'Base fee must be a valid amount',
        ],
        'priority' => [
            'required' => 'Priority is required',
            'integer' => 'Priority must be a number',
        ],
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Get all active zones ordered by priority
     * 
     * @return array
     */
    public function getActiveZones(): array
    {
        return $this->where('is_active', 1)
            ->orderBy('priority', 'ASC')
            ->findAll();
    }

    /**
     * Get zone with its locations
     * 
     * @param int $zoneId
     * @return array|null
     */
    public function getZoneWithLocations(int $zoneId): ?array
    {
        $zone = $this->find($zoneId);
        
        if (!$zone) {
            return null;
        }

        $locationModel = new ShippingLocationModel();
        $zone['locations'] = $locationModel->where('zone_id', $zoneId)->findAll();

        return $zone;
    }

    /**
     * Get fallback/default zone
     * 
     * @return array|null
     */
    public function getFallbackZone(): ?array
    {
        return $this->where('zone_name', 'Default Zone (Fallback)')
            ->orWhere('priority', 999)
            ->first();
    }

    /**
     * Check if zone is riverine
     * 
     * @param int $zoneId
     * @return bool
     */
    public function isRiverineZone(int $zoneId): bool
    {
        $zone = $this->find($zoneId);
        return $zone && stripos($zone['zone_name'], 'riverine') !== false;
    }

    /**
     * Get zones statistics for admin dashboard
     * 
     * @return array
     */
    public function getStatistics(): array
    {
        return [
            'total_zones' => $this->countAll(),
            'active_zones' => $this->where('is_active', 1)->countAllResults(),
            'inactive_zones' => $this->where('is_active', 0)->countAllResults(),
            'riverine_zones' => $this->like('zone_name', 'riverine', 'both')->countAllResults(),
        ];
    }

    /**
     * Toggle zone active status
     * 
     * @param int $zoneId
     * @return bool
     */
    public function toggleActive(int $zoneId): bool
    {
        $zone = $this->find($zoneId);
        if (!$zone) {
            return false;
        }

        return $this->update($zoneId, [
            'is_active' => !$zone['is_active']
        ]);
    }

    /**
     * Update zone fee
     * 
     * @param int $zoneId
     * @param float $newFee
     * @return bool
     */
    public function updateFee(int $zoneId, float $newFee): bool
    {
        if ($newFee < 0) {
            return false;
        }

        return $this->update($zoneId, ['base_fee' => $newFee]);
    }
}