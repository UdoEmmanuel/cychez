<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Run all seeders in order
        $this->call('CategorySeeder');
        $this->call('ShippingSeeder');
        $this->call('AdminSeeder');
        
        // Add more seeders here as needed
        // $this->call('UserSeeder');
        // $this->call('OrderSeeder');
        
        echo "All seeders executed successfully!\n";
    }
}