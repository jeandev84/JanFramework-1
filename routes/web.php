<?php

Route::get('/foo', function () {
    echo 'Foo!';
});

Route::get('/', 'HomeController@index', 'home');
Route::get('/contact', 'HomeController@contact', 'contact');

Route::get('/post/{id}/{slug}', 'PostController@show', 'post.show');
Route::get('/user/{token}/edit', 'UserController@edit', 'user.edit')
->where('token', '\w+');
