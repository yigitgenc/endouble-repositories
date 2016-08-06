<?php

namespace Config;

/**
 * Class Database
 * @package Config
 */
class Database
{
    /**
     * @var array $connections
     *
     * Define your connections here.
     */
    static private $connections = [
        'albert' => [
            'driver' => 'sqlite',
            'database' => __DIR__ . '/../data/albert.sqlite',
            'prefix' => ''
        ],
        'heijn' => [
            'driver' => 'sqlite',
            'database' => __DIR__ . '/../data/heijn.sqlite',
            'prefix' => ''
        ],
        'bol' => [
            'driver' => 'sqlite',
            'database' => __DIR__ . '/../data/bol.sqlite',
            'prefix' => ''
        ],
        'booking' => [
            'driver' => 'sqlite',
            'database' => __DIR__ . '/../data/booking.sqlite',
            'prefix' => ''
        ],
        'test' => [
            'driver' => 'sqlite',
            'database' => __DIR__ . '/../data/test.sqlite',
            'prefix' => ''
        ]
    ];

    /**
     * @param $connection
     * @return mixed
     */
    public static function getConfig($connection)
    {
        return self::$connections[$connection];
    }
}