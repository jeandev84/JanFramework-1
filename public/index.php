<?php

require_once __DIR__.'/../vendor/autoload.php';
class_alias('Jan\\Component\\Routing\\Route', 'Route');


/*
Route::map('GET', '/', 'HomeController@index', 'home');
Route::map('GET|POST', '/contact', 'HomeController@contact');


$options = [
  'prefix' => 'admin'
];

Route::group($options, function () {
    Route::map('GET', '/posts', 'PostController@index', 'admin.posts');
    Route::map('GET', '/post/{id}/edit', 'PostController@edit', 'admin.post.edit');
});


Route::get('/foo', function () {
    return 'Foo';
});


dump(Route::collections());

$params = Route::router()->match($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
*/


Route::map('GET', '/', 'HomeController@index', 'home')
->middleware([
    'App\Middleware\Authenticated',
    'App\Middleware\Guarded'
]);

Route::map('GET|POST', '/contact', 'HomeController@contact')
->name('site.contact');


$options = [
    'prefix' => '/admin',
    'namespace' => 'Admin\\'
];

Route::group($options, function () {
    Route::get('/posts', 'PostController@index', 'admin.posts');
    Route::get('/post/{id}/edit', 'PostController@edit', 'admin.post.edit');
});


Route::get('/foo', function () {
    return 'Foo';
});


$route = Route::router()->match($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

dump($route);

dd(Route::router()->routeCollection());
