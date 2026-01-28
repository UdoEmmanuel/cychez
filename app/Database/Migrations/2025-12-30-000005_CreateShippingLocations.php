<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateShippingLocations extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'zone_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],

            'state' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],

            'city' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],

            'area' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],

            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('zone_id');
        $this->forge->addKey(['state', 'city', 'area'], false, false, 'idx_location_lookup');

        $this->forge->addForeignKey(
            'zone_id',
            'shipping_zones',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('shipping_locations', true);
    }

    public function down()
    {
        $this->forge->dropTable('shipping_locations', true);
    }
}
