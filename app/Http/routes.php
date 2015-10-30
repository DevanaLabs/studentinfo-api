<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use StudentInfo\Repositories\DoctrineUserRepository;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/testmodels', function (DoctrineUserRepository $repository) {
    echo var_dump($repository->findByEmail('nn140110d@student.etf.rs'));
});
