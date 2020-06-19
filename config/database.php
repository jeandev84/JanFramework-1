<?php

return [

    /*
    |------------------------------------------------------------------
    |     CONNECTION TO DATABASE
    |     [ avalaibles drivers mysql, sqlite ]
    |------------------------------------------------------------------
    */

    'connection' => 'mysql', //env('DB_CONNECTION', 'mysql'),
    'sqlite' => [
        'driver'   => 'sqlite',
        'database' => '../example.sqlite',
        'options'  => [],
        'prefix'   => ''
    ],
    'mysql' => [
        'driver'    => 'mysql',
        'database'  => 'jframework',
        'host'      => '127.0.0.1',
        'port'      => '3306',
        'charset'   => 'utf8',
        'username'  => 'root',
        'password'  => '',
        'collation' => 'utf8_unicode_ci',
        'options'   => [],
        'prefix'    => '',
        'engine'    => 'innoDB',
        'somekey'   => 'ddd'
    ]
];

/*
'mysql' => [
    'driver'    => 'pdo_mysql',
    'type'      => 'mysql',
    'database'  => 'example',
    'host'      => 'localhost',
    'port'      => '3306',
    'charset'   => 'utf8',
    'username'  => 'root',
    'password'  => '', // secret
    'collation' => 'utf8_unicode_ci',
    'options'   => [],
    'prefix'    => '',
    'engine'    => 'innoDB'
]
*/