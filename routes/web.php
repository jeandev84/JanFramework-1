<?php
use Jan\Component\Http\Response;


# Closure testing
Route::get('/hello', function () {
    return new Response('Привет друзья! как ваши дела?', 301);
});


Route::get('/foo', function () {
    return [
      'id' => 1,
      'name' => 'Jean-Claude',
      'age' => 36
    ];
});



# Home controllers
Route::get('/', 'HomeController@index', 'home');
Route::map('GET|POST', '/contact', 'HomeController@contact', 'contact');


# Post controllers
Route::get('/post/{id}/{slug}', 'PostController@show', 'post.show');



# User controllers
Route::get('/user', 'UserController@index', 'user.index');
Route::get('/user/{token}/edit', 'UserController@edit', 'user.edit')
->where('token', '\w+');


# Demo controllers
Route::get('/demo', 'DemoController@index')->name('demo.index');
Route::get('/send', 'DemoController@send')->name('demo.send');
Route::get('/cart', 'CartController@index')->name('cart.index');