<?php

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../routes/web.php';


# Container


$container = \Jan\Component\DI\Container::getInstance();

$container->bind(Jan\Bar::class, function () {
    return new \Jan\Bar();
});

$instance = $container->make(\Jan\Foo::class, [1, 'article-1']);

dd($instance);




# Route Dispatcher
try {

    $request = \Jan\Component\Http\Request::fromGlobals();

    $dispatcher = new \Jan\Foundation\RouteDispatcher($request);
    $dispatcher->setBaseUrl('http://localhost:8080');
    $dispatcher->setControllerNamespace('App\\Controllers');
    $response = $dispatcher->callAction();

} catch (Exception $e) {

    exit('404 Page not found');
}


