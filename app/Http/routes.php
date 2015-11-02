<?php

use StudentInfo\Models\Student;
use StudentInfo\ValueObjects\Email;
use StudentInfo\ValueObjects\Password;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/add', function(\StudentInfo\Repositories\UserRepositoryInterface $repository) {
    $student = new Student();
    $student->setFirstName('Nebojsa');
    $student->setLastName('Urosevic');
    $student->setEmail(new Email('nu1@gmail.com'));
    $student->setPassword(new Password('blabla'));
    $student->setIndexNumber('13421');

    $repository->create($student);

});
Route::post('auth', 'AuthController@login');
Route::delete('auth', 'AuthController@logout');
