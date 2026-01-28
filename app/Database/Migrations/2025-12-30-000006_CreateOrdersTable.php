<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrdersTable extends Migration
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

            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],

            'order_number' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'unique'     => true,
            ],

            'total_amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],

            'shipping_fee' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0,
            ],

            'shipping_zone_id' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true,
            ],

            'payment_method' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'default'    => 'paystack',
            ],

            'payment_status' => [
                'type'       => 'ENUM',
                'constraint' => ['pending', 'paid', 'failed', 'refunded'],
                'default'    => 'pending',
            ],

            'payment_reference' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],

            'delivery_status' => [
                'type'       => 'ENUM',
                'constraint' => ['pending', 'processing', 'shipped', 'delivered', 'cancelled'],
                'default'    => 'pending',
            ],

            'first_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],

            'last_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],

            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],

            'phone' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],

            'address' => [
                'type' => 'TEXT',
            ],

            'city' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],

            'state' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],

            'country' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'default'    => 'Nigeria',
            ],

            'postal_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],

            'notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            'tracking_number' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],

            'email_sent_at' => [
                'type' => 'DATETIME',
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
        $this->forge->addKey('shipping_zone_id');

        $this->forge->addForeignKey(
            'user_id',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'shipping_zone_id',
            'shipping_zones',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->forge->createTable('orders');
    }

    public function down()
    {
        $this->forge->dropTable('orders');
    }
}
