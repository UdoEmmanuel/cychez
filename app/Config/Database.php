<?php

namespace Config;

use CodeIgniter\Database\Config;

/**
 * Database Configuration
 */
class Database extends Config
{
    /**
     * The directory that holds the Migrations and Seeds directories.
     */
    public string $filesPath = APPPATH . 'Database' . DIRECTORY_SEPARATOR;

    /**
     * Lets you choose which connection group to use if no other is specified.
     */
    public string $defaultGroup = 'default';

    /**
     * The default database connection (your MySQL setup).
     *
     * @var array<string, mixed>
     */
    public array $default = [
        'DSN'       => '',
        'hostname'  => 'localhost',
        'username'  => 'root',
        'password'  => '',
        'database'  => 'cychez_ecommerce',
        'DBDriver'  => 'MySQLi',
        'DBPrefix'  => '',
        'pConnect'  => false,
        'DBDebug'   => true,
        'charset'   => 'utf8',
        'DBCollat'  => 'utf8_general_ci',
        'swapPre'   => '',
        'encrypt'   => false,
        'compress'  => false,
        'strictOn'  => false,
        'failover'  => [],
        'port'      => 3306,
        'numberNative' => false,
        'foundRows' => false,
        'dateFormat' => [
            'date'     => 'Y-m-d',
            'datetime' => 'Y-m-d H:i:s',
            'time'     => 'H:i:s',
        ],
    ];

    /**
     * This database connection is used when running PHPUnit database tests.
     *
     * @var array<string, mixed>
     */
    public array $tests = [
        'DSN'         => '',
        'hostname'    => '127.0.0.1',
        'username'    => '',
        'password'    => '',
        'database'    => ':memory:',
        'DBDriver'    => 'SQLite3',
        'DBPrefix'    => 'db_',  // Needed for CI4 tests
        'pConnect'    => false,
        'DBDebug'     => true,
        'charset'     => 'utf8',
        'DBCollat'    => '',
        'swapPre'     => '',
        'encrypt'     => false,
        'compress'    => false,
        'strictOn'    => false,
        'failover'    => [],
        'port'        => 3306,
        'foreignKeys' => true,
        'busyTimeout' => 1000,
        'dateFormat'  => [
            'date'     => 'Y-m-d',
            'datetime' => 'Y-m-d H:i:s',
            'time'     => 'H:i:s',
        ],
    ];

    public function __construct()
    {
        parent::__construct();

        // Override defaults with environment variables if set
        $this->default['hostname'] = env('database.default.hostname', $this->default['hostname']);
        $this->default['database'] = env('database.default.database', $this->default['database']);
        $this->default['username'] = env('database.default.username', $this->default['username']);
        $this->default['password'] = env('database.default.password', $this->default['password']);
        $this->default['DBDriver'] = env('database.default.DBDriver', $this->default['DBDriver']);
        $this->default['port']     = env('database.default.port', $this->default['port']);

        // If not in production, enable debugging
        if (ENVIRONMENT !== 'production') {
            $this->default['DBDebug'] = true;
        }

        // Use the 'tests' group automatically in testing environment
        if (ENVIRONMENT === 'testing') {
            $this->defaultGroup = 'tests';
        }
    }
}