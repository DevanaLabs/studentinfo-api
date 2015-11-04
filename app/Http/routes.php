<?php

Route::get('/', function () {
    return view('welcome');
});

/* Test Routes */
Route::get('/addAdmin', function (\StudentInfo\Repositories\UserRepositoryInterface $repository) {
    $admin = new \StudentInfo\Models\Admin();
    $admin->setFirstName("Nebojsa");
    $admin->setLastName("Urosevic");
    $admin->setEmail(new \StudentInfo\ValueObjects\Email("nu@gmail.com"));
    $admin->setPassword(new \StudentInfo\ValueObjects\Password("blabla"));
    $admin->setRememberToken("bla");
    $admin->setRegisterToken();
    $admin->setRegisterTokenCreatedAt();

    $repository->create($admin);
});

Route::get('/addStudent', function (\StudentInfo\Repositories\UserRepositoryInterface $repository) {
    $student = new \StudentInfo\Models\Student();
    $student->setFirstName('Milan');
    $student->setLastName('Vucic');
    $student->setEmail(new \StudentInfo\ValueObjects\Email('mv@gmail.com'));
    $student->setPassword(new \StudentInfo\ValueObjects\Password('blabla'));
    $student->setIndexNumber('124421');
    $student->setRememberToken('bla');
    $student->setRegisterToken();
    $student->setRegisterTokenCreatedAt();

    $repository->create($student);
});

Route::post('auth', 'AuthController@login');

Route::delete('auth', 'AuthController@logout');

Route::post('register', 'RegisterController@issueRegisterTokens');

Route::get('register/{rememberToken}', 'RegisterController@registerStudent');

Route::post('register/{rememberToken}', 'RegisterController@createPassword');
