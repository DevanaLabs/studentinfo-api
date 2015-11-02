<?php

use StudentInfo\Models\Admin;
use StudentInfo\ValueObjects\Email;
use StudentInfo\ValueObjects\Password;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/add', function(\StudentInfo\Repositories\UserRepositoryInterface $repository) {
    $admin = new Admin;
    $admin->setFirstName('Nebojsa');
    $admin->setLastName('Urosevic');
    $admin->setEmail(new Email('nu1@gmail.com'));
    $admin->setPassword(new Password('blabla'));

    $repository->create($admin);

});
Route::post('auth', 'AuthController@login');
Route::delete('auth', 'AuthController@logout');
Route::post('register', 'RegisterController@issueRegisterTokens');

