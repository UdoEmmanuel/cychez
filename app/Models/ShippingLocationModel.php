<?php

namespace App\Models;

use CodeIgniter\Model;

class ShippingLocationModel extends Model
{
    protected $table            = 'shipping_locations';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'zone_id',
        'state',
        'city',
        'area',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [
        'zone_id' => 'integer',
    ];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'zone_id' => 'required|integer',
        'state' => 'required|min_length[3]|max_length[50]',
    ];

    protected $validationMessages = [
        'zone_id' => [
            'required' => 'Zone ID is required',
        ],
        'state' => [
            'required' => 'State is required',
            'min_length' => 'State must be at least 3 characters',
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
     * Get locations by zone ID
     * 
     * @param int $zoneId
     * @return array
     */
    public function getByZone(int $zoneId): array
    {
        return $this->where('zone_id', $zoneId)
            ->orderBy('state', 'ASC')
            ->orderBy('city', 'ASC')
            ->orderBy('area', 'ASC')
            ->findAll();
    }

    /**
     * Find zone by location (most specific match)
     * Matching priority: State+City+Area > State+City > State
     * 
     * @param string $state
     * @param string|null $city
     * @param string|null $area
     * @return array|null
     */
    public function findZoneByLocation(string $state, ?string $city = null, ?string $area = null): ?array
    {
        $zoneModel = new ShippingZoneModel();
        
        // Try Level 1: State + City + Area (most specific)
        if ($state && $city && $area) {
            $location = $this->select('shipping_locations.*, shipping_zones.*')
                ->join('shipping_zones', 'shipping_zones.id = shipping_locations.zone_id')
                ->where('shipping_zones.is_active', 1)
                ->where('shipping_locations.state', $state)
                ->where('shipping_locations.city', $city)
                ->where('shipping_locations.area', $area)
                ->orderBy('shipping_zones.priority', 'ASC')
                ->first();
            
            if ($location) {
                return $location;
            }
        }

        // Try Level 2: State + City
        if ($state && $city) {
            $location = $this->select('shipping_locations.*, shipping_zones.*')
                ->join('shipping_zones', 'shipping_zones.id = shipping_locations.zone_id')
                ->where('shipping_zones.is_active', 1)
                ->where('shipping_locations.state', $state)
                ->where('shipping_locations.city', $city)
                ->where('shipping_locations.area IS NULL')
                ->orderBy('shipping_zones.priority', 'ASC')
                ->first();
            
            if ($location) {
                return $location;
            }
        }

        // Try Level 3: State only
        if ($state) {
            $location = $this->select('shipping_locations.*, shipping_zones.*')
                ->join('shipping_zones', 'shipping_zones.id = shipping_locations.zone_id')
                ->where('shipping_zones.is_active', 1)
                ->where('shipping_locations.state', $state)
                ->where('shipping_locations.city IS NULL')
                ->where('shipping_locations.area IS NULL')
                ->orderBy('shipping_zones.priority', 'ASC')
                ->first();
            
            if ($location) {
                return $location;
            }
        }

        // Fallback: Return default zone
        return $zoneModel->getFallbackZone();
    }

    /**
     * Get all unique states with locations
     * 
     * @return array
     */
    public function getStatesWithZones(): array
    {
        return $this->select('DISTINCT state')
            ->orderBy('state', 'ASC')
            ->findColumn('state');
    }

    /**
     * Get cities for a specific state
     * 
     * @param string $state
     * @return array
     */
    public function getCitiesByState(string $state): array
    {
        return $this->select('DISTINCT city')
            ->where('state', $state)
            ->whereNotNull('city')
            ->orderBy('city', 'ASC')
            ->findColumn('city');
    }

    /**
     * Get areas for a specific city
     * 
     * @param string $state
     * @param string $city
     * @return array
     */
    public function getAreasByCity(string $state, string $city): array
    {
        return $this->select('DISTINCT area')
            ->where('state', $state)
            ->where('city', $city)
            ->whereNotNull('area')
            ->orderBy('area', 'ASC')
            ->findColumn('area');
    }

    /**
     * Add multiple locations to a zone (bulk insert)
     * 
     * @param int $zoneId
     * @param array $locations
     * @return bool
     */
    public function addBulkLocations(int $zoneId, array $locations): bool
    {
        $data = [];
        foreach ($locations as $location) {
            $data[] = [
                'zone_id' => $zoneId,
                'state' => $location['state'],
                'city' => $location['city'] ?? null,
                'area' => $location['area'] ?? null,
            ];
        }

        return $this->insertBatch($data);
    }

    /**
     * Check if location exists for a zone
     * 
     * @param int $zoneId
     * @param string $state
     * @param string|null $city
     * @param string|null $area
     * @return bool
     */
    public function locationExists(int $zoneId, string $state, ?string $city = null, ?string $area = null): bool
    {
        $builder = $this->where('zone_id', $zoneId)
            ->where('state', $state);

        if ($city) {
            $builder->where('city', $city);
        } else {
            $builder->where('city IS NULL');
        }

        if ($area) {
            $builder->where('area', $area);
        } else {
            $builder->where('area IS NULL');
        }

        return $builder->countAllResults() > 0;
    }

    /**
     * Delete all locations for a zone
     * 
     * @param int $zoneId
     * @return bool
     */
    public function deleteByZone(int $zoneId): bool
    {
        return $this->where('zone_id', $zoneId)->delete();
    }
}