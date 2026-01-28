<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ShippingSeeder extends Seeder
{
    public function run()
    {

        // Define all shipping zones with their locations
        $zonesData = [
            // ZONE 1 — Port Harcourt (Metro)
            [
                'zone' => [
                    'zone_name' => 'Port Harcourt (Metro)',
                    'base_fee' => 2000.00,
                    'is_active' => 1,
                    'priority' => 1,
                    'description' => 'Same day / Next day delivery',
                ],
                'locations' => [
                    ['state' => 'Rivers', 'city' => 'Port Harcourt', 'area' => 'PH Township'],
                    ['state' => 'Rivers', 'city' => 'Port Harcourt', 'area' => 'GRA Phase 1'],
                    ['state' => 'Rivers', 'city' => 'Port Harcourt', 'area' => 'GRA Phase 2'],
                    ['state' => 'Rivers', 'city' => 'Port Harcourt', 'area' => 'GRA Phase 3'],
                    ['state' => 'Rivers', 'city' => 'Port Harcourt', 'area' => 'GRA Phase 4'],
                    ['state' => 'Rivers', 'city' => 'Port Harcourt', 'area' => 'Rumuola'],
                    ['state' => 'Rivers', 'city' => 'Port Harcourt', 'area' => 'Rumuokoro'],
                    ['state' => 'Rivers', 'city' => 'Port Harcourt', 'area' => 'Rumuigbo'],
                    ['state' => 'Rivers', 'city' => 'Port Harcourt', 'area' => 'Rumuokwuta'],
                    ['state' => 'Rivers', 'city' => 'Port Harcourt', 'area' => 'Diobu'],
                    ['state' => 'Rivers', 'city' => 'Port Harcourt', 'area' => 'Woji'],
                    ['state' => 'Rivers', 'city' => 'Port Harcourt', 'area' => 'Elekahia'],
                    ['state' => 'Rivers', 'city' => 'Port Harcourt', 'area' => 'Mile 3'],
                    ['state' => 'Rivers', 'city' => 'Port Harcourt', 'area' => 'Mile 4'],
                ],
            ],

            // ZONE 2 — Rivers State (Mainland – Non-PH)
            [
                'zone' => [
                    'zone_name' => 'Rivers State (Mainland)',
                    'base_fee' => 3500.00,
                    'is_active' => 1,
                    'priority' => 2,
                    'description' => 'Rivers State mainland areas excluding Port Harcourt metro',
                ],
                'locations' => [
                    ['state' => 'Rivers', 'city' => 'Eleme', 'area' => null],
                    ['state' => 'Rivers', 'city' => 'Oyigbo', 'area' => null],
                    ['state' => 'Rivers', 'city' => 'Omoku', 'area' => null],
                    ['state' => 'Rivers', 'city' => 'Ahoada East', 'area' => null],
                    ['state' => 'Rivers', 'city' => 'Ahoada West', 'area' => null],
                    ['state' => 'Rivers', 'city' => 'Emohua', 'area' => null],
                    ['state' => 'Rivers', 'city' => 'Ikwerre', 'area' => null],
                    ['state' => 'Rivers', 'city' => 'Etche', 'area' => null],
                    ['state' => 'Rivers', 'city' => 'Bori', 'area' => null],
                    ['state' => 'Rivers', 'city' => 'Kpor', 'area' => null],
                    ['state' => 'Rivers', 'city' => 'Obio-Akpor', 'area' => null],
                ],
            ],

            // ZONE 3 — Rivers State (Riverine / Hard-to-Reach)
            [
                'zone' => [
                    'zone_name' => 'Rivers State (Riverine)',
                    'base_fee' => 8000.00,
                    'is_active' => 1,
                    'priority' => 3,
                    'description' => 'Riverine areas - Final delivery fee may be confirmed after order review',
                ],
                'locations' => [
                    ['state' => 'Rivers', 'city' => 'Bonny', 'area' => null],
                    ['state' => 'Rivers', 'city' => 'Opobo', 'area' => null],
                    ['state' => 'Rivers', 'city' => 'Andoni', 'area' => null],
                    ['state' => 'Rivers', 'city' => 'Degema', 'area' => null],
                    ['state' => 'Rivers', 'city' => 'Okrika', 'area' => null],
                    ['state' => 'Rivers', 'city' => 'Akuku-Toru', 'area' => null],
                    ['state' => 'Rivers', 'city' => 'Asari-Toru', 'area' => null],
                ],
            ],

            // ZONE 4 — South-South (Outside Rivers)
            [
                'zone' => [
                    'zone_name' => 'South-South',
                    'base_fee' => 4500.00,
                    'is_active' => 1,
                    'priority' => 4,
                    'description' => 'South-South states excluding Rivers',
                ],
                'locations' => [
                    // Akwa Ibom State
                    ['state' => 'Akwa Ibom', 'city' => 'Uyo', 'area' => 'Uyo Urban'],
                    ['state' => 'Akwa Ibom', 'city' => 'Uyo', 'area' => 'Ewet Housing'],
                    ['state' => 'Akwa Ibom', 'city' => 'Uyo', 'area' => 'Use Offot'],
                    ['state' => 'Akwa Ibom', 'city' => 'Uyo', 'area' => 'Itam'],
                    ['state' => 'Akwa Ibom', 'city' => 'Uyo', 'area' => 'Shelter Afrique'],
                    ['state' => 'Akwa Ibom', 'city' => 'Eket', 'area' => null],
                    ['state' => 'Akwa Ibom', 'city' => 'Ikot Ekpene', 'area' => null],
                    ['state' => 'Akwa Ibom', 'city' => 'Oron', 'area' => null],
                    ['state' => 'Akwa Ibom', 'city' => 'Abak', 'area' => null],

                    // Cross River State
                    ['state' => 'Cross River', 'city' => 'Calabar', 'area' => 'Calabar Municipal'],
                    ['state' => 'Cross River', 'city' => 'Calabar', 'area' => 'Calabar South'],
                    ['state' => 'Cross River', 'city' => 'Calabar', 'area' => 'Effio-Ette'],
                    ['state' => 'Cross River', 'city' => 'Calabar', 'area' => 'Marian Road'],
                    ['state' => 'Cross River', 'city' => 'Calabar', 'area' => 'Ekpo Abasi'],
                    ['state' => 'Cross River', 'city' => 'Ikom', 'area' => null],
                    ['state' => 'Cross River', 'city' => 'Ogoja', 'area' => null],
                    ['state' => 'Cross River', 'city' => 'Ugep', 'area' => null],
                    ['state' => 'Cross River', 'city' => 'Obudu', 'area' => null],

                    // Bayelsa State
                    ['state' => 'Bayelsa', 'city' => 'Yenagoa', 'area' => 'Yenagoa Town'],
                    ['state' => 'Bayelsa', 'city' => 'Yenagoa', 'area' => 'Amarata'],
                    ['state' => 'Bayelsa', 'city' => 'Yenagoa', 'area' => 'Kpansia'],
                    ['state' => 'Bayelsa', 'city' => 'Yenagoa', 'area' => 'Biogbolo'],
                    ['state' => 'Bayelsa', 'city' => 'Yenagoa', 'area' => 'Okaka'],
                    ['state' => 'Bayelsa', 'city' => 'Brass', 'area' => null],
                    ['state' => 'Bayelsa', 'city' => 'Ekeremor', 'area' => null],
                    ['state' => 'Bayelsa', 'city' => 'Nembe', 'area' => null],
                    ['state' => 'Bayelsa', 'city' => 'Ogbia', 'area' => null],

                    // Delta State
                    ['state' => 'Delta', 'city' => 'Asaba', 'area' => 'Asaba GRA'],
                    ['state' => 'Delta', 'city' => 'Asaba', 'area' => 'Cable Point'],
                    ['state' => 'Delta', 'city' => 'Asaba', 'area' => 'Okpanam'],
                    ['state' => 'Delta', 'city' => 'Asaba', 'area' => 'Ibusa'],
                    ['state' => 'Delta', 'city' => 'Asaba', 'area' => 'Oshimili'],
                    ['state' => 'Delta', 'city' => 'Warri', 'area' => 'Warri Central'],
                    ['state' => 'Delta', 'city' => 'Warri', 'area' => 'Effurun'],
                    ['state' => 'Delta', 'city' => 'Warri', 'area' => 'Ekpan'],
                    ['state' => 'Delta', 'city' => 'Warri', 'area' => 'PTI'],
                    ['state' => 'Delta', 'city' => 'Warri', 'area' => 'NPA'],
                    ['state' => 'Delta', 'city' => 'Ughelli', 'area' => null],
                    ['state' => 'Delta', 'city' => 'Sapele', 'area' => null],
                    ['state' => 'Delta', 'city' => 'Agbor', 'area' => null],

                    // Edo State
                    ['state' => 'Edo', 'city' => 'Benin City', 'area' => 'Benin GRA'],
                    ['state' => 'Edo', 'city' => 'Benin City', 'area' => 'Ugbowo'],
                    ['state' => 'Edo', 'city' => 'Benin City', 'area' => 'Ikpoba Hill'],
                    ['state' => 'Edo', 'city' => 'Benin City', 'area' => 'Uselu'],
                    ['state' => 'Edo', 'city' => 'Benin City', 'area' => 'Ring Road'],
                    ['state' => 'Edo', 'city' => 'Auchi', 'area' => null],
                    ['state' => 'Edo', 'city' => 'Ekpoma', 'area' => null],
                    ['state' => 'Edo', 'city' => 'Uromi', 'area' => null],
                    ['state' => 'Edo', 'city' => 'Igarra', 'area' => null],
                ],
            ],

            // ZONE 5 — South-West
            [
                'zone' => [
                    'zone_name' => 'South-West',
                    'base_fee' => 5500.00,
                    'is_active' => 1,
                    'priority' => 5,
                    'description' => 'South-West states',
                ],
                'locations' => [
                    // Lagos State
                    ['state' => 'Lagos', 'city' => 'Lagos Island', 'area' => 'Victoria Island'],
                    ['state' => 'Lagos', 'city' => 'Lagos Island', 'area' => 'Ikoyi'],
                    ['state' => 'Lagos', 'city' => 'Lagos Island', 'area' => 'Lekki Phase 1'],
                    ['state' => 'Lagos', 'city' => 'Lagos Island', 'area' => 'Ajah'],
                    ['state' => 'Lagos', 'city' => 'Lagos Island', 'area' => 'Marina'],
                    ['state' => 'Lagos', 'city' => 'Lagos Mainland', 'area' => 'Yaba'],
                    ['state' => 'Lagos', 'city' => 'Lagos Mainland', 'area' => 'Surulere'],
                    ['state' => 'Lagos', 'city' => 'Lagos Mainland', 'area' => 'Ikeja'],
                    ['state' => 'Lagos', 'city' => 'Lagos Mainland', 'area' => 'Maryland'],
                    ['state' => 'Lagos', 'city' => 'Lagos Mainland', 'area' => 'Anthony'],
                    ['state' => 'Lagos', 'city' => 'Badagry', 'area' => null],
                    ['state' => 'Lagos', 'city' => 'Epe', 'area' => null],
                    ['state' => 'Lagos', 'city' => 'Ikorodu', 'area' => null],

                    // Ogun State
                    ['state' => 'Ogun', 'city' => 'Abeokuta', 'area' => 'Oke-Mosan'],
                    ['state' => 'Ogun', 'city' => 'Abeokuta', 'area' => 'Ibara'],
                    ['state' => 'Ogun', 'city' => 'Abeokuta', 'area' => 'Kuto'],
                    ['state' => 'Ogun', 'city' => 'Abeokuta', 'area' => 'Olomore'],
                    ['state' => 'Ogun', 'city' => 'Abeokuta', 'area' => 'MKO Abiola Way'],
                    ['state' => 'Ogun', 'city' => 'Ijebu-Ode', 'area' => null],
                    ['state' => 'Ogun', 'city' => 'Sagamu', 'area' => null],
                    ['state' => 'Ogun', 'city' => 'Ota', 'area' => null],
                    ['state' => 'Ogun', 'city' => 'Ilaro', 'area' => null],

                    // Oyo State
                    ['state' => 'Oyo', 'city' => 'Ibadan', 'area' => 'Bodija'],
                    ['state' => 'Oyo', 'city' => 'Ibadan', 'area' => 'Agodi GRA'],
                    ['state' => 'Oyo', 'city' => 'Ibadan', 'area' => 'Ring Road'],
                    ['state' => 'Oyo', 'city' => 'Ibadan', 'area' => 'Mokola'],
                    ['state' => 'Oyo', 'city' => 'Ibadan', 'area' => 'UI'],
                    ['state' => 'Oyo', 'city' => 'Ogbomoso', 'area' => null],
                    ['state' => 'Oyo', 'city' => 'Oyo', 'area' => null],
                    ['state' => 'Oyo', 'city' => 'Iseyin', 'area' => null],
                    ['state' => 'Oyo', 'city' => 'Saki', 'area' => null],

                    // Osun State
                    ['state' => 'Osun', 'city' => 'Osogbo', 'area' => 'Oke Fia'],
                    ['state' => 'Osun', 'city' => 'Osogbo', 'area' => 'Okefia GRA'],
                    ['state' => 'Osun', 'city' => 'Osogbo', 'area' => 'Ota-Efun'],
                    ['state' => 'Osun', 'city' => 'Osogbo', 'area' => 'MDS'],
                    ['state' => 'Osun', 'city' => 'Osogbo', 'area' => 'Ayetoro'],
                    ['state' => 'Osun', 'city' => 'Ile-Ife', 'area' => null],
                    ['state' => 'Osun', 'city' => 'Ilesa', 'area' => null],
                    ['state' => 'Osun', 'city' => 'Ede', 'area' => null],
                    ['state' => 'Osun', 'city' => 'Iwo', 'area' => null],

                    // Ondo State
                    ['state' => 'Ondo', 'city' => 'Akure', 'area' => 'Alagbaka'],
                    ['state' => 'Ondo', 'city' => 'Akure', 'area' => 'Oba-Ile'],
                    ['state' => 'Ondo', 'city' => 'Akure', 'area' => 'Ijapo Estate'],
                    ['state' => 'Ondo', 'city' => 'Akure', 'area' => 'FUTA Area'],
                    ['state' => 'Ondo', 'city' => 'Akure', 'area' => 'Hospital Road'],
                    ['state' => 'Ondo', 'city' => 'Ondo', 'area' => null],
                    ['state' => 'Ondo', 'city' => 'Owo', 'area' => null],
                    ['state' => 'Ondo', 'city' => 'Ikare', 'area' => null],
                    ['state' => 'Ondo', 'city' => 'Ore', 'area' => null],

                    // Ekiti State
                    ['state' => 'Ekiti', 'city' => 'Ado-Ekiti', 'area' => 'Ajilosun'],
                    ['state' => 'Ekiti', 'city' => 'Ado-Ekiti', 'area' => 'Basiri'],
                    ['state' => 'Ekiti', 'city' => 'Ado-Ekiti', 'area' => 'Fajuyi'],
                    ['state' => 'Ekiti', 'city' => 'Ado-Ekiti', 'area' => 'Iworoko Road'],
                    ['state' => 'Ekiti', 'city' => 'Ado-Ekiti', 'area' => 'Bank Road'],
                    ['state' => 'Ekiti', 'city' => 'Ikere', 'area' => null],
                    ['state' => 'Ekiti', 'city' => 'Ijero', 'area' => null],
                    ['state' => 'Ekiti', 'city' => 'Ise', 'area' => null],
                    ['state' => 'Ekiti', 'city' => 'Emure', 'area' => null],
                ],
            ],

            // ZONE 6 — South-East
            [
                'zone' => [
                    'zone_name' => 'South-East',
                    'base_fee' => 5500.00,
                    'is_active' => 1,
                    'priority' => 6,
                    'description' => 'South-East states',
                ],
                'locations' => [
                    // Abia State
                    ['state' => 'Abia', 'city' => 'Umuahia', 'area' => 'Ubakala'],
                    ['state' => 'Abia', 'city' => 'Umuahia', 'area' => 'World Bank'],
                    ['state' => 'Abia', 'city' => 'Umuahia', 'area' => 'Ogurube Layout'],
                    ['state' => 'Abia', 'city' => 'Umuahia', 'area' => 'Aba Road'],
                    ['state' => 'Abia', 'city' => 'Umuahia', 'area' => 'Umuahia GRA'],
                    ['state' => 'Abia', 'city' => 'Aba', 'area' => 'Ariaria'],
                    ['state' => 'Abia', 'city' => 'Aba', 'area' => 'Cemetery'],
                    ['state' => 'Abia', 'city' => 'Aba', 'area' => 'Ogbor Hill'],
                    ['state' => 'Abia', 'city' => 'Aba', 'area' => 'Eziukwu'],
                    ['state' => 'Abia', 'city' => 'Aba', 'area' => 'Asa Road'],
                    ['state' => 'Abia', 'city' => 'Arochukwu', 'area' => null],
                    ['state' => 'Abia', 'city' => 'Ohafia', 'area' => null],
                    ['state' => 'Abia', 'city' => 'Bende', 'area' => null],

                    // Anambra State
                    ['state' => 'Anambra', 'city' => 'Awka', 'area' => 'Aroma Junction'],
                    ['state' => 'Anambra', 'city' => 'Awka', 'area' => 'Ifite'],
                    ['state' => 'Anambra', 'city' => 'Awka', 'area' => 'Amawbia'],
                    ['state' => 'Anambra', 'city' => 'Awka', 'area' => 'Ngozika Estate'],
                    ['state' => 'Anambra', 'city' => 'Awka', 'area' => 'Kwata'],
                    ['state' => 'Anambra', 'city' => 'Onitsha', 'area' => 'GRA'],
                    ['state' => 'Anambra', 'city' => 'Onitsha', 'area' => 'Main Market'],
                    ['state' => 'Anambra', 'city' => 'Onitsha', 'area' => 'Inland Town'],
                    ['state' => 'Anambra', 'city' => 'Onitsha', 'area' => 'Trans-Nkisi'],
                    ['state' => 'Anambra', 'city' => 'Onitsha', 'area' => 'Fegge'],
                    ['state' => 'Anambra', 'city' => 'Nnewi', 'area' => null],
                    ['state' => 'Anambra', 'city' => 'Ekwulobia', 'area' => null],
                    ['state' => 'Anambra', 'city' => 'Ihiala', 'area' => null],

                    // Enugu State
                    ['state' => 'Enugu', 'city' => 'Enugu', 'area' => 'Independence Layout'],
                    ['state' => 'Enugu', 'city' => 'Enugu', 'area' => 'GRA Enugu'],
                    ['state' => 'Enugu', 'city' => 'Enugu', 'area' => 'Trans-Ekulu'],
                    ['state' => 'Enugu', 'city' => 'Enugu', 'area' => 'New Haven'],
                    ['state' => 'Enugu', 'city' => 'Enugu', 'area' => 'Ogui'],
                    ['state' => 'Enugu', 'city' => 'Nsukka', 'area' => null],
                    ['state' => 'Enugu', 'city' => 'Agbani', 'area' => null],
                    ['state' => 'Enugu', 'city' => 'Udi', 'area' => null],
                    ['state' => 'Enugu', 'city' => 'Oji River', 'area' => null],

                    // Ebonyi State
                    ['state' => 'Ebonyi', 'city' => 'Abakaliki', 'area' => 'Kpirikpiri'],
                    ['state' => 'Ebonyi', 'city' => 'Abakaliki', 'area' => 'Waterworks'],
                    ['state' => 'Ebonyi', 'city' => 'Abakaliki', 'area' => 'Ogoja Road'],
                    ['state' => 'Ebonyi', 'city' => 'Abakaliki', 'area' => 'Mile 50'],
                    ['state' => 'Ebonyi', 'city' => 'Abakaliki', 'area' => 'Afikpo Road'],
                    ['state' => 'Ebonyi', 'city' => 'Afikpo', 'area' => null],
                    ['state' => 'Ebonyi', 'city' => 'Onueke', 'area' => null],
                    ['state' => 'Ebonyi', 'city' => 'Ishielu', 'area' => null],
                    ['state' => 'Ebonyi', 'city' => 'Ezza', 'area' => null],

                    // Imo State
                    ['state' => 'Imo', 'city' => 'Owerri', 'area' => 'New Owerri'],
                    ['state' => 'Imo', 'city' => 'Owerri', 'area' => 'World Bank'],
                    ['state' => 'Imo', 'city' => 'Owerri', 'area' => 'Ikenegbu'],
                    ['state' => 'Imo', 'city' => 'Owerri', 'area' => 'Orlu Road'],
                    ['state' => 'Imo', 'city' => 'Owerri', 'area' => 'GRA Owerri'],
                    ['state' => 'Imo', 'city' => 'Orlu', 'area' => null],
                    ['state' => 'Imo', 'city' => 'Okigwe', 'area' => null],
                    ['state' => 'Imo', 'city' => 'Mbaise', 'area' => null],
                    ['state' => 'Imo', 'city' => 'Oguta', 'area' => null],
                ],
            ],

            // ZONE 7 — North-Central
            [
                'zone' => [
                    'zone_name' => 'North-Central',
                    'base_fee' => 6500.00,
                    'is_active' => 1,
                    'priority' => 7,
                    'description' => 'North-Central states including FCT',
                ],
                'locations' => [
                    // FCT Abuja
                    ['state' => 'FCT', 'city' => 'Abuja', 'area' => 'Wuse'],
                    ['state' => 'FCT', 'city' => 'Abuja', 'area' => 'Maitama'],
                    ['state' => 'FCT', 'city' => 'Abuja', 'area' => 'Garki'],
                    ['state' => 'FCT', 'city' => 'Abuja', 'area' => 'Asokoro'],
                    ['state' => 'FCT', 'city' => 'Abuja', 'area' => 'Gwarimpa'],
                    ['state' => 'FCT', 'city' => 'Abuja', 'area' => 'Kubwa'],
                    ['state' => 'FCT', 'city' => 'Abuja', 'area' => 'Nyanya'],
                    ['state' => 'FCT', 'city' => 'Abuja', 'area' => 'Jabi'],
                    ['state' => 'FCT', 'city' => 'Abuja', 'area' => 'Lugbe'],
                    ['state' => 'FCT', 'city' => 'Abuja', 'area' => 'Kuje'],
                    ['state' => 'FCT', 'city' => 'Gwagwalada', 'area' => null],
                    ['state' => 'FCT', 'city' => 'Bwari', 'area' => null],

                    // Kogi State
                    ['state' => 'Kogi', 'city' => 'Lokoja', 'area' => 'Phase 1'],
                    ['state' => 'Kogi', 'city' => 'Lokoja', 'area' => 'Phase 2'],
                    ['state' => 'Kogi', 'city' => 'Lokoja', 'area' => 'Ganaja'],
                    ['state' => 'Kogi', 'city' => 'Lokoja', 'area' => 'Felele'],
                    ['state' => 'Kogi', 'city' => 'Lokoja', 'area' => 'Adankolo'],
                    ['state' => 'Kogi', 'city' => 'Okene', 'area' => null],
                    ['state' => 'Kogi', 'city' => 'Idah', 'area' => null],
                    ['state' => 'Kogi', 'city' => 'Kabba', 'area' => null],
                    ['state' => 'Kogi', 'city' => 'Anyigba', 'area' => null],

                    // Kwara State
                    ['state' => 'Kwara', 'city' => 'Ilorin', 'area' => 'GRA Ilorin'],
                    ['state' => 'Kwara', 'city' => 'Ilorin', 'area' => 'Tanke'],
                    ['state' => 'Kwara', 'city' => 'Ilorin', 'area' => 'Challenge'],
                    ['state' => 'Kwara', 'city' => 'Ilorin', 'area' => 'Fate Road'],
                    ['state' => 'Kwara', 'city' => 'Ilorin', 'area' => 'Unity Road'],
                    ['state' => 'Kwara', 'city' => 'Offa', 'area' => null],
                    ['state' => 'Kwara', 'city' => 'Omu-Aran', 'area' => null],
                    ['state' => 'Kwara', 'city' => 'Jebba', 'area' => null],
                    ['state' => 'Kwara', 'city' => 'Lafiagi', 'area' => null],

                    // Niger State
                    ['state' => 'Niger', 'city' => 'Minna', 'area' => 'Bosso'],
                    ['state' => 'Niger', 'city' => 'Minna', 'area' => 'Tunga'],
                    ['state' => 'Niger', 'city' => 'Minna', 'area' => 'Chanchaga'],
                    ['state' => 'Niger', 'city' => 'Minna', 'area' => 'Maitumbi'],
                    ['state' => 'Niger', 'city' => 'Minna', 'area' => 'Sauka Kahuta'],
                    ['state' => 'Niger', 'city' => 'Suleja', 'area' => null],
                    ['state' => 'Niger', 'city' => 'Bida', 'area' => null],
                    ['state' => 'Niger', 'city' => 'Kontagora', 'area' => null],
                    ['state' => 'Niger', 'city' => 'Lapai', 'area' => null],

                    // Nasarawa State
                    ['state' => 'Nasarawa', 'city' => 'Lafia', 'area' => 'Lafia GRA'],
                    ['state' => 'Nasarawa', 'city' => 'Lafia', 'area' => 'New Nyanya'],
                    ['state' => 'Nasarawa', 'city' => 'Lafia', 'area' => 'Shabu'],
                    ['state' => 'Nasarawa', 'city' => 'Lafia', 'area' => 'Makurdi Road'],
                    ['state' => 'Nasarawa', 'city' => 'Lafia', 'area' => 'Jos Road'],
                    ['state' => 'Nasarawa', 'city' => 'Keffi', 'area' => null],
                    ['state' => 'Nasarawa', 'city' => 'Akwanga', 'area' => null],
                    ['state' => 'Nasarawa', 'city' => 'Karu', 'area' => null],
                    ['state' => 'Nasarawa', 'city' => 'Doma', 'area' => null],

                    // Plateau State
                    ['state' => 'Plateau', 'city' => 'Jos', 'area' => 'Jos North'],
                    ['state' => 'Plateau', 'city' => 'Jos', 'area' => 'Rayfield'],
                    ['state' => 'Plateau', 'city' => 'Jos', 'area' => 'Bukuru'],
                    ['state' => 'Plateau', 'city' => 'Jos', 'area' => 'Lamingo'],
                    ['state' => 'Plateau', 'city' => 'Jos', 'area' => 'Tudun Wada'],
                    ['state' => 'Plateau', 'city' => 'Pankshin', 'area' => null],
                    ['state' => 'Plateau', 'city' => 'Shendam', 'area' => null],
                    ['state' => 'Plateau', 'city' => 'Langtang', 'area' => null],
                    ['state' => 'Plateau', 'city' => 'Vom', 'area' => null],

                    // Benue State
                    ['state' => 'Benue', 'city' => 'Makurdi', 'area' => 'High Level'],
                    ['state' => 'Benue', 'city' => 'Makurdi', 'area' => 'North Bank'],
                    ['state' => 'Benue', 'city' => 'Makurdi', 'area' => 'Wurukum'],
                    ['state' => 'Benue', 'city' => 'Makurdi', 'area' => 'Modern Market'],
                    ['state' => 'Benue', 'city' => 'Makurdi', 'area' => 'Railway Area'],
                    ['state' => 'Benue', 'city' => 'Gboko', 'area' => null],
                    ['state' => 'Benue', 'city' => 'Otukpo', 'area' => null],
                    ['state' => 'Benue', 'city' => 'Katsina-Ala', 'area' => null],
                    ['state' => 'Benue', 'city' => 'Vandeikya', 'area' => null],
                ],
            ],

            // ZONE 8 — Far North
            [
                'zone' => [
                    'zone_name' => 'Far North',
                    'base_fee' => 8000.00,
                    'is_active' => 1,
                    'priority' => 8,
                    'description' => 'Far Northern states',
                ],
                'locations' => [
                    // Kano State
                    ['state' => 'Kano', 'city' => 'Kano Municipal', 'area' => 'Sabon Gari'],
                    ['state' => 'Kano', 'city' => 'Kano Municipal', 'area' => 'Nassarawa GRA'],
                    ['state' => 'Kano', 'city' => 'Kano Municipal', 'area' => 'Fagge'],
                    ['state' => 'Kano', 'city' => 'Kano Municipal', 'area' => 'Bompai'],
                    ['state' => 'Kano', 'city' => 'Kano Municipal', 'area' => 'Hotoro'],
                    ['state' => 'Kano', 'city' => 'Kumbotso', 'area' => null],
                    ['state' => 'Kano', 'city' => 'Wudil', 'area' => null],
                    ['state' => 'Kano', 'city' => 'Gwarzo', 'area' => null],
                    ['state' => 'Kano', 'city' => 'Rano', 'area' => null],

                    // Kaduna State
                    ['state' => 'Kaduna', 'city' => 'Kaduna', 'area' => 'Kaduna North'],
                    ['state' => 'Kaduna', 'city' => 'Kaduna', 'area' => 'Kaduna South'],
                    ['state' => 'Kaduna', 'city' => 'Kaduna', 'area' => 'Barnawa'],
                    ['state' => 'Kaduna', 'city' => 'Kaduna', 'area' => 'Kakuri'],
                    ['state' => 'Kaduna', 'city' => 'Kaduna', 'area' => 'Malali'],
                    ['state' => 'Kaduna', 'city' => 'Zaria', 'area' => null],
                    ['state' => 'Kaduna', 'city' => 'Kafanchan', 'area' => null],
                    ['state' => 'Kaduna', 'city' => 'Kagoro', 'area' => null],
                    ['state' => 'Kaduna', 'city' => 'Zonkwa', 'area' => null],

                    // Katsina State
                    ['state' => 'Katsina', 'city' => 'Katsina', 'area' => 'Kofar Kwaya'],
                    ['state' => 'Katsina', 'city' => 'Katsina', 'area' => 'GRA Katsina'],
                    ['state' => 'Katsina', 'city' => 'Katsina', 'area' => 'Low Cost'],
                    ['state' => 'Katsina', 'city' => 'Katsina', 'area' => 'Kofar Sauri'],
                    ['state' => 'Katsina', 'city' => 'Katsina', 'area' => 'Dutsinma Road'],
                    ['state' => 'Katsina', 'city' => 'Daura', 'area' => null],
                    ['state' => 'Katsina', 'city' => 'Funtua', 'area' => null],
                    ['state' => 'Katsina', 'city' => 'Dutsinma', 'area' => null],
                    ['state' => 'Katsina', 'city' => 'Malumfashi', 'area' => null],

                    // Jigawa State
                    ['state' => 'Jigawa', 'city' => 'Dutse', 'area' => 'Dutse GRA'],
                    ['state' => 'Jigawa', 'city' => 'Dutse', 'area' => 'Takur'],
                    ['state' => 'Jigawa', 'city' => 'Dutse', 'area' => 'Kiyawa Road'],
                    ['state' => 'Jigawa', 'city' => 'Dutse', 'area' => 'Sabon Gari Dutse'],
                    ['state' => 'Jigawa', 'city' => 'Dutse', 'area' => 'Danladi Nasidi Road'],
                    ['state' => 'Jigawa', 'city' => 'Hadejia', 'area' => null],
                    ['state' => 'Jigawa', 'city' => 'Gumel', 'area' => null],
                    ['state' => 'Jigawa', 'city' => 'Kazaure', 'area' => null],
                    ['state' => 'Jigawa', 'city' => 'Ringim', 'area' => null],

                    // Sokoto State
                    ['state' => 'Sokoto', 'city' => 'Sokoto', 'area' => 'Sokoto North'],
                    ['state' => 'Sokoto', 'city' => 'Sokoto', 'area' => 'Runjin Sambo'],
                    ['state' => 'Sokoto', 'city' => 'Sokoto', 'area' => 'Arkilla'],
                    ['state' => 'Sokoto', 'city' => 'Sokoto', 'area' => 'Wamakko'],
                    ['state' => 'Sokoto', 'city' => 'Sokoto', 'area' => 'Mabera'],
                    ['state' => 'Sokoto', 'city' => 'Tambuwal', 'area' => null],
                    ['state' => 'Sokoto', 'city' => 'Gwadabawa', 'area' => null],
                    ['state' => 'Sokoto', 'city' => 'Illela', 'area' => null],
                    ['state' => 'Sokoto', 'city' => 'Wurno', 'area' => null],

                    // Zamfara State
                    ['state' => 'Zamfara', 'city' => 'Gusau', 'area' => 'Gusau Central'],
                    ['state' => 'Zamfara', 'city' => 'Gusau', 'area' => 'Tudun Wada Gusau'],
                    ['state' => 'Zamfara', 'city' => 'Gusau', 'area' => 'Sabon Gari Gusau'],
                    ['state' => 'Zamfara', 'city' => 'Gusau', 'area' => 'Saminaka'],
                    ['state' => 'Zamfara', 'city' => 'Gusau', 'area' => 'Rijiya'],
                    ['state' => 'Zamfara', 'city' => 'Kaura Namoda', 'area' => null],
                    ['state' => 'Zamfara', 'city' => 'Talata Mafara', 'area' => null],
                    ['state' => 'Zamfara', 'city' => 'Anka', 'area' => null],
                    ['state' => 'Zamfara', 'city' => 'Bungudu', 'area' => null],

                    // Kebbi State
                    ['state' => 'Kebbi', 'city' => 'Birnin Kebbi', 'area' => 'Gwadangaji'],
                    ['state' => 'Kebbi', 'city' => 'Birnin Kebbi', 'area' => 'Makera'],
                    ['state' => 'Kebbi', 'city' => 'Birnin Kebbi', 'area' => 'Ahmadu Bello Way'],
                    ['state' => 'Kebbi', 'city' => 'Birnin Kebbi', 'area' => 'GRA Birnin Kebbi'],
                    ['state' => 'Kebbi', 'city' => 'Birnin Kebbi', 'area' => 'Zauro'],
                    ['state' => 'Kebbi', 'city' => 'Argungu', 'area' => null],
                    ['state' => 'Kebbi', 'city' => 'Jega', 'area' => null],
                    ['state' => 'Kebbi', 'city' => 'Zuru', 'area' => null],
                    ['state' => 'Kebbi', 'city' => 'Yauri', 'area' => null],

                    // Bauchi State
                    ['state' => 'Bauchi', 'city' => 'Bauchi', 'area' => 'GRA Bauchi'],
                    ['state' => 'Bauchi', 'city' => 'Bauchi', 'area' => 'Wunti'],
                    ['state' => 'Bauchi', 'city' => 'Bauchi', 'area' => 'Yelwa'],
                    ['state' => 'Bauchi', 'city' => 'Bauchi', 'area' => 'Muda Lawal'],
                    ['state' => 'Bauchi', 'city' => 'Bauchi', 'area' => 'Dass Road'],
                    ['state' => 'Bauchi', 'city' => 'Azare', 'area' => null],
                    ['state' => 'Bauchi', 'city' => 'Misau', 'area' => null],
                    ['state' => 'Bauchi', 'city' => 'Tafawa Balewa', 'area' => null],
                    ['state' => 'Bauchi', 'city' => 'Ningi', 'area' => null],

                    // Gombe State
                    ['state' => 'Gombe', 'city' => 'Gombe', 'area' => 'Pantami'],
                    ['state' => 'Gombe', 'city' => 'Gombe', 'area' => 'Tudun Hatsi'],
                    ['state' => 'Gombe', 'city' => 'Gombe', 'area' => 'Bolari'],
                    ['state' => 'Gombe', 'city' => 'Gombe', 'area' => 'Nasarawo'],
                    ['state' => 'Gombe', 'city' => 'Gombe', 'area' => 'Jekadafari'],
                    ['state' => 'Gombe', 'city' => 'Dukku', 'area' => null],
                    ['state' => 'Gombe', 'city' => 'Kumo', 'area' => null],
                    ['state' => 'Gombe', 'city' => 'Billiri', 'area' => null],
                    ['state' => 'Gombe', 'city' => 'Kaltungo', 'area' => null],

                    // Adamawa State
                    ['state' => 'Adamawa', 'city' => 'Yola', 'area' => 'Jimeta'],
                    ['state' => 'Adamawa', 'city' => 'Yola', 'area' => 'Yola Town'],
                    ['state' => 'Adamawa', 'city' => 'Yola', 'area' => 'Karewa'],
                    ['state' => 'Adamawa', 'city' => 'Yola', 'area' => 'Rumde'],
                    ['state' => 'Adamawa', 'city' => 'Yola', 'area' => 'Bekaji'],
                    ['state' => 'Adamawa', 'city' => 'Mubi', 'area' => null],
                    ['state' => 'Adamawa', 'city' => 'Numan', 'area' => null],
                    ['state' => 'Adamawa', 'city' => 'Ganye', 'area' => null],
                    ['state' => 'Adamawa', 'city' => 'Gombi', 'area' => null],

                    // Taraba State
                    ['state' => 'Taraba', 'city' => 'Jalingo', 'area' => 'GRA Jalingo'],
                    ['state' => 'Taraba', 'city' => 'Jalingo', 'area' => 'Sabon Gari Jalingo'],
                    ['state' => 'Taraba', 'city' => 'Jalingo', 'area' => 'Kona'],
                    ['state' => 'Taraba', 'city' => 'Jalingo', 'area' => 'Turaki'],
                    ['state' => 'Taraba', 'city' => 'Jalingo', 'area' => 'Magami'],
                    ['state' => 'Taraba', 'city' => 'Wukari', 'area' => null],
                    ['state' => 'Taraba', 'city' => 'Takum', 'area' => null],
                    ['state' => 'Taraba', 'city' => 'Ibi', 'area' => null],
                    ['state' => 'Taraba', 'city' => 'Gembu', 'area' => null],

                    // Yobe State
                    ['state' => 'Yobe', 'city' => 'Damaturu', 'area' => 'GRA Damaturu'],
                    ['state' => 'Yobe', 'city' => 'Damaturu', 'area' => 'Nayinawa'],
                    ['state' => 'Yobe', 'city' => 'Damaturu', 'area' => 'Pompomari'],
                    ['state' => 'Yobe', 'city' => 'Damaturu', 'area' => 'Kukareta'],
                    ['state' => 'Yobe', 'city' => 'Damaturu', 'area' => 'Bindigari'],
                    ['state' => 'Yobe', 'city' => 'Potiskum', 'area' => null],
                    ['state' => 'Yobe', 'city' => 'Gashua', 'area' => null],
                    ['state' => 'Yobe', 'city' => 'Nguru', 'area' => null],
                    ['state' => 'Yobe', 'city' => 'Geidam', 'area' => null],

                    // Borno State
                    ['state' => 'Borno', 'city' => 'Maiduguri', 'area' => 'GRA Maiduguri'],
                    ['state' => 'Borno', 'city' => 'Maiduguri', 'area' => 'Gwange'],
                    ['state' => 'Borno', 'city' => 'Maiduguri', 'area' => 'Bulumkutu'],
                    ['state' => 'Borno', 'city' => 'Maiduguri', 'area' => 'Pompomari'],
                    ['state' => 'Borno', 'city' => 'Maiduguri', 'area' => 'Mairi'],
                    ['state' => 'Borno', 'city' => 'Biu', 'area' => null],
                    ['state' => 'Borno', 'city' => 'Bama', 'area' => null],
                    ['state' => 'Borno', 'city' => 'Monguno', 'area' => null],
                    ['state' => 'Borno', 'city' => 'Konduga', 'area' => null],
                ],
            ],

            // DEFAULT/FALLBACK ZONE
            [
                'zone' => [
                    'zone_name' => 'Default Zone (Fallback)',
                    'base_fee' => 5000.00,
                    'is_active' => 1,
                    'priority' => 999,
                    'description' => 'Fallback zone for unmatched locations',
                ],
                'locations' => [
                    // No specific locations - acts as catch-all
                ],
            ],
        ];

        // Insert zones and their locations
        foreach ($zonesData as $data) {
            // Insert zone
            $this->db->table('shipping_zones')->insert($data['zone']);
            $zoneId = $this->db->insertID();

            // Insert locations for this zone
            foreach ($data['locations'] as $location) {
                $location['zone_id'] = $zoneId;
                $this->db->table('shipping_locations')->insert($location);
            }
        }

        echo "✅ Shipping zones and locations seeded successfully!\n";
        echo "📦 Total zones created: " . count($zonesData) . "\n";
    }
}