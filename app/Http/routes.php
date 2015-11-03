<?php


Route::get('/', function () {
    return view('welcome');
});
Route::get('/add', function(\StudentInfo\Repositories\UserRepositoryInterface $repository){
    $admin = new \StudentInfo\Models\Admin();
    $admin->setFirstName("Nebojsa");
    $admin->setLastName("Urosevic");
    $admin->setEmail(new \StudentInfo\ValueObjects\Email("nu@gmail.com"));
    $admin->setPassword(new \StudentInfo\ValueObjects\Password("blabla"));
    $admin->setRememberToken("bla");

    $repository->create($admin);
});
Route::post('auth', 'AuthController@login');
Route::delete('auth', 'AuthController@logout');
Route::post('register', 'RegisterController@issueRegisterTokens');
Route::get('register/{rememberToken}', 'RegisterController@registerStudent');
Route::post('register/{rememberToken}', 'RegisterController@createPassword');