<?php

use StudentInfo\Repositories\DoctrineUserRepository;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', 'AuthController@authorize');