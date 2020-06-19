<?php

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../routes/web.php';



try {

    $request = \Jan\Component\Http\Request::fromGlobals();

    $dispatcher = new \Jan\Foundation\RouteDispatcher($request);
    $dispatcher->setBaseUrl('http://localhost:8080');
    $dispatcher->setControllerNamespace('App\\Controllers');
    $response = $dispatcher->callAction();

} catch (Exception $e) {

    exit('404 Page not found');
}


