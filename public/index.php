<?php

require_once __DIR__.'/../vendor/autoload.php';
class_alias('Jan\\Component\\Routing\\Route', 'Route');




Route::get('/', 'HomeController@index', 'home');
Route::get('/contact', 'HomeController@contact', 'contact');

Route::get('/foo', function () {
    echo 'Foo!';
});

Route::get('/post/{id}/{slug}', 'PostController@show', 'post.show');



$route = Route::router()->match($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

if(! $route)
{
    exit('404 Page not found');
}

if(! $route['target'] instanceof Closure)
{
    $route['target'] = str_replace('@', '::', 'App\\Controllers\\'. $route['target']);
}

call_user_func_array($route['target'], $route['matches']);


echo '<h2>Generator Path</h2>';

$href = Route::router()->generate('post.show', ['id' => 5, 'slug' => 'article-4']);
echo '<a href="'. $href .'">show</a>';



echo '<h2>Route</h2>';
dump($route);


echo '<h2>Routes</h2>';
dump(Route::router()->routes());