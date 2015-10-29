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

use StudentInfo\Models\Student;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/testmodels', function () {
    $student = new Student();
    $student->setFirstName("Nikola");
    $student->setLastName("Ninkovic");
    $student->setIndexNumber("0110/14");
    $student->setEmail("nn140110d@student.etf.rs");
    $student->setPassword(new \StudentInfo\ValueObjects\Password("nikola"));

    EntityManager::persist($student);
    EntityManager::flush();
});
