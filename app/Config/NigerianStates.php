<?php

namespace Config;

class NigerianStates
{
    /**
     * Get all Nigerian states
     * 
     * @return array
     */
    public static function all(): array
    {
        return [
            'Abia' => 'Abia',
            'Adamawa' => 'Adamawa',
            'Akwa Ibom' => 'Akwa Ibom',
            'Anambra' => 'Anambra',
            'Bauchi' => 'Bauchi',
            'Bayelsa' => 'Bayelsa',
            'Benue' => 'Benue',
            'Borno' => 'Borno',
            'Cross River' => 'Cross River',
            'Delta' => 'Delta',
            'Ebonyi' => 'Ebonyi',
            'Edo' => 'Edo',
            'Ekiti' => 'Ekiti',
            'Enugu' => 'Enugu',
            'FCT' => 'FCT (Abuja)',
            'Gombe' => 'Gombe',
            'Imo' => 'Imo',
            'Jigawa' => 'Jigawa',
            'Kaduna' => 'Kaduna',
            'Kano' => 'Kano',
            'Katsina' => 'Katsina',
            'Kebbi' => 'Kebbi',
            'Kogi' => 'Kogi',
            'Kwara' => 'Kwara',
            'Lagos' => 'Lagos',
            'Nasarawa' => 'Nasarawa',
            'Niger' => 'Niger',
            'Ogun' => 'Ogun',
            'Ondo' => 'Ondo',
            'Osun' => 'Osun',
            'Oyo' => 'Oyo',
            'Plateau' => 'Plateau',
            'Rivers' => 'Rivers',
            'Sokoto' => 'Sokoto',
            'Taraba' => 'Taraba',
            'Yobe' => 'Yobe',
            'Zamfara' => 'Zamfara',
        ];
    }

    /**
     * Get cities for Rivers State (for granular shipping)
     * 
     * @return array
     */
    public static function riversCities(): array
    {
        return [
            // Metro (Zone 1)
            'Port Harcourt' => 'Port Harcourt',
            
            // Mainland (Zone 2)
            'Eleme' => 'Eleme',
            'Oyigbo' => 'Oyigbo',
            'Omoku' => 'Omoku',
            'Ahoada East' => 'Ahoada East',
            'Ahoada West' => 'Ahoada West',
            'Emohua' => 'Emohua',
            'Ikwerre' => 'Ikwerre',
            'Etche' => 'Etche',
            'Bori' => 'Bori',
            'Kpor' => 'Kpor',
            'Obio-Akpor' => 'Obio-Akpor',
            
            // Riverine (Zone 3)
            'Bonny' => 'Bonny',
            'Opobo' => 'Opobo',
            'Andoni' => 'Andoni',
            'Degema' => 'Degema',
            'Okrika' => 'Okrika',
            'Akuku-Toru' => 'Akuku-Toru',
            'Asari-Toru' => 'Asari-Toru',
        ];
    }

    /**
     * Get areas within Port Harcourt (for Zone 1 granularity)
     * 
     * @return array
     */
    public static function portHarcourtAreas(): array
    {
        return [
            'PH Township' => 'PH Township',
            'GRA Phase 1' => 'GRA Phase 1',
            'GRA Phase 2' => 'GRA Phase 2',
            'GRA Phase 3' => 'GRA Phase 3',
            'GRA Phase 4' => 'GRA Phase 4',
            'Rumuola' => 'Rumuola',
            'Rumuokoro' => 'Rumuokoro',
            'Rumuigbo' => 'Rumuigbo',
            'Rumuokwuta' => 'Rumuokwuta',
            'Diobu' => 'Diobu',
            'Woji' => 'Woji',
            'Elekahia' => 'Elekahia',
            'Mile 3' => 'Mile 3',
            'Mile 4' => 'Mile 4',
            'Old GRA' => 'Old GRA',
            'New GRA' => 'New GRA',
            'Trans-Amadi' => 'Trans-Amadi',
            'D-Line' => 'D-Line',
            'Rumueme' => 'Rumueme',
            'Rumuomasi' => 'Rumuomasi',
            'Rukpokwu' => 'Rukpokwu',
            'Ada George' => 'Ada George',
            'Alakahia' => 'Alakahia',
            'Choba' => 'Choba',
        ];
    }

    /**
     * Get cities by state (add more as needed)
     * 
     * @param string $state
     * @return array
     */
    public static function getCitiesByState(string $state): array
    {
        $citiesMap = [
            'Rivers' => self::riversCities(),
            'Lagos' => [
                'Ikeja' => 'Ikeja',
                'Victoria Island' => 'Victoria Island',
                'Lekki' => 'Lekki',
                'Ikoyi' => 'Ikoyi',
                'Surulere' => 'Surulere',
                'Yaba' => 'Yaba',
                'Maryland' => 'Maryland',
                'Ajah' => 'Ajah',
                'Badagry' => 'Badagry',
                'Epe' => 'Epe',
            ],
            // Add more states as needed
        ];

        return $citiesMap[$state] ?? [];
    }

    /**
     * Get areas by city (for granular locations)
     * 
     * @param string $city
     * @return array
     */
    public static function getAreasByCity(string $city): array
    {
        $areasMap = [
            'Port Harcourt' => self::portHarcourtAreas(),
            // Add more cities as needed
        ];

        return $areasMap[$city] ?? [];
    }
}