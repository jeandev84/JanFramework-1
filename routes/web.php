<?php

use Jan\Component\Http\Response;

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



Route::get('/', 'HomeController@index', 'home');
Route::map('GET|POST', '/contact', 'HomeController@contact', 'contact');


Route::get('/post/{id}/{slug}', 'PostController@show', 'post.show');
Route::get('/user/{token}/edit', 'UserController@edit', 'user.edit')
->where('token', '\w+');

Route::get('/demo', 'DemoController@index')->name('demo.index');
Route::get('/send', 'DemoController@send')->name('demo.send');