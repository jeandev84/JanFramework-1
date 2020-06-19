<?php

require_once __DIR__ . '/../vendor/autoload.php';

$kernel = new \Jan\Kernel(__DIR__ . '/JanFramework/');
$kernel->handle();