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
    $admin->generateRegisterToken();
    $admin->setOrganisation($repository->findFacultyByName('Racunarski fakultet'));

    $repository->create($admin);
});

Route::get('/addStudent', function (\StudentInfo\Repositories\UserRepositoryInterface $repository) {
    $student = new \StudentInfo\Models\Student();
    $student->setFirstName('Milan');
    $student->setLastName('Vucic');
    $student->setEmail(new \StudentInfo\ValueObjects\Email('mv@gmail1.com'));
    $student->setPassword(new \StudentInfo\ValueObjects\Password('blabla'));
    $student->setIndexNumber('1244221');
    $student->setRememberToken('bla');
    $student->generateRegisterToken();
    $student->setOrganisation($repository->findFacultyByName('Racunarski fakultet'));

    $repository->create($student);
});

Route::get('/addFaculty', function (\StudentInfo\Repositories\UserRepositoryInterface $repository) {
    $faculty = new \StudentInfo\Models\Faculty();
    $faculty->setName('Racunarski fakultet');

    $repository->create($faculty);
});
Route::get('addStudents', 'StudentController@addStudents');

Route::get('user/{id}', 'UserController@editProfile');

Route::put('user/{id}', 'UserController@updateProfile');

Route::get('students', 'StudentController@getStudents');

Route::post('auth', 'AuthController@login');

Route::delete('auth', 'AuthController@logout');

Route::post('register', 'RegisterController@issueRegisterTokens');

Route::get('register/{rememberToken}', 'RegisterController@registerStudent');

Route::post('register/{rememberToken}', 'RegisterController@createPassword');
