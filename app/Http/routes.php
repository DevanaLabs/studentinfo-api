<?php


Route::get('/', function () {
    return view('welcome');
});
Route::get('/add', "authController@testDatabase");
Route::post('auth', 'AuthController@login');
Route::delete('auth', 'AuthController@logout');
Route::post('register', 'RegisterController@issueRegisterTokens');

