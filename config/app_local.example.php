<?php
return [
    'debug' => filter_var(env('DEBUG', true), FILTER_VALIDATE_BOOLEAN),
    'Security' => [
        'salt' => env('SECURITY_SALT', '__LOCAL_DEV_SALT_REPLACE_ME_IN_PROD__'),
    ],
    'Datasources' => [
        'default' => [
            'host' => 'db',
            'username' => 'kanban',
            'password' => 'kanban',
            'database' => 'kanban',
            'port' => 5432,
            'driver' => 'Cake\Database\Driver\Postgres',
            'persistent' => false,
            'encoding' => 'utf8',
            'timezone' => 'UTC',
            'flags' => [],
            'cacheMetadata' => true,
            'log' => false,
            'quoteIdentifiers' => false,
            'url' => env('DATABASE_URL', null),
        ],
        'test' => [
            'host' => 'db',
            'username' => 'kanban',
            'password' => 'kanban',
            'database' => 'test_kanban',
            'port' => 5432,
            'driver' => 'Cake\Database\Driver\Postgres',
            'persistent' => false,
            'encoding' => 'utf8',
            'timezone' => 'UTC',
            'flags' => [],
            'cacheMetadata' => true,
            'quoteIdentifiers' => false,
            'log' => false,
            'url' => env('DATABASE_TEST_URL', null),
        ],
    ],
    'EmailTransport' => [
        'default' => [
            'className' => 'Debug',
        ],
    ],
];
