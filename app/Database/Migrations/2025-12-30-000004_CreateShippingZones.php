<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateShippingZones extends Migration
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

            'zone_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],

            'base_fee' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0.00,
            ],

            'is_active' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],

            'priority' => [
                'type'       => 'INT',
                'constraint' => 5,
                'default'    => 0,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
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
        $this->forge->addKey('priority');
        $this->forge->addKey('is_active');

        $this->forge->createTable('shipping_zones', true);
    }

    public function down()
    {
        $this->forge->dropTable('shipping_zones', true);
    }
}
