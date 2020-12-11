<?php

Route::get('/', function () {
    // return view('welcome');
    return Str::random(100);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/get_users', 'HomeController@getUsers');
Route::get('/get_chats/{id}', 'HomeController@getMesseges');
Route::post('send', 'HomeController@storeChat');
