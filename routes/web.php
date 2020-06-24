<?php

Route::get('/hello', function () {
//    return 'Привет!';
    return [
        'id' => 1,
        'name' => 'Jean',
        'age' => 36
    ];
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

Route::get('/demo', 'DemoController@index')->name('demo');