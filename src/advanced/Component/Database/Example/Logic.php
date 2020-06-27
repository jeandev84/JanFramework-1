<?php

use Jan\Component\Database\Database;

Database::connect([
    'driver'    => '',
    'database'  => '',
    'host'      => '',
    'port'      => '',
    'charset'   => '',
    'username'  => '',
    'password'  => '',
    'collation' => '',
    'options'   => '',
    'prefix'    => '',
    'engine'    => ''
]);


$sql = '';
$params = [];
Database::instance()->prepare($sql, $params);

