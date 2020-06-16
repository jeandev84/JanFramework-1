<?php

# MAP ROUTE VIA ROUTER
$router = new \Jan\Component\Routing\Router();
$router->map(['GET'], '/', 'HomeController@index', 'home');
$router->map(['GET'], '/contact', 'HomeController@contact', 'get.contact');
$router->map(['POST'], '/contact', 'HomeController@contact', 'post.contact');

dump($router->routeCollection());
$router->match($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);