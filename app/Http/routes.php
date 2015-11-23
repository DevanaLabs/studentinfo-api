<?php

use StudentInfo\Repositories\FacultyRepositoryInterface;
use StudentInfo\Repositories\UserRepositoryInterface;

Route::get('/', function () {
    return view('welcome');
});

/* Test Routes */
Route::get('/addAdmin', function (FacultyRepositoryInterface $facultyRepository, UserRepositoryInterface $userRepository) {
    $admin = new \StudentInfo\Models\Admin();
    $admin->setFirstName("Nebojsa");
    $admin->setLastName("Urosevic");
    $admin->setEmail(new \StudentInfo\ValueObjects\Email("nu@gmail.com"));
    $admin->setPassword(new \StudentInfo\ValueObjects\Password("blabla"));
    $admin->setRememberToken("bla");
    $admin->generateRegisterToken();
    $admin->setOrganisation($facultyRepository->findFacultyByName('Racunarski fakultet'));

    $userRepository->create($admin);
});

Route::get('/addStudent', function (FacultyRepositoryInterface $facultyRepository, UserRepositoryInterface $userRepository) {
    $student = new \StudentInfo\Models\Student();
    $student->setFirstName('Milan');
    $student->setLastName('Vucic');
    $student->setEmail(new \StudentInfo\ValueObjects\Email('mv@gmail1.com'));
    $student->setPassword(new \StudentInfo\ValueObjects\Password('blabla'));
    $student->setIndexNumber('1244221');
    $student->setRememberToken('bla');
    $student->generateRegisterToken();
    $student->setYear(3);
    $student->setOrganisation($facultyRepository->findFacultyByName('Racunarski fakultet'));

    $userRepository->create($student);
});

Route::get('/addFaculty', function (UserRepositoryInterface $repository) {
    $faculty = new \StudentInfo\Models\Faculty();
    $faculty->setName('Racunarski fakultet');

    $repository->create($faculty);
});
Route::post('addStudents', 'StudentController@addStudents');

Route::get('user/{user_id}', 'UserController@getProfile');

Route::put('user/{user_id}', 'UserController@updateProfile');

Route::get('students', 'StudentController@getStudents');

Route::post('auth', 'AuthController@login');

Route::delete('auth', 'AuthController@logout');

Route::post('register', 'RegisterController@issueRegisterTokens');

Route::get('register/{rememberToken}', 'RegisterController@registerStudent');

Route::post('register/{rememberToken}', 'RegisterController@createPassword');

Route::post('addClassrooms', 'ClassroomController@addClassrooms');

Route::get('getClassrooms', 'ClassroomController@getClassrooms');

Route::post('addProfessors', 'ProfessorController@addProfessors');

Route::get('getProfessors', 'ProfessorController@getProfessors');

Route::post('addLecture', 'LectureController@addLecture');

Route::post('addCourses', 'CourseController@addCourses');

Route::post('chooseLectures', 'StudentController@chooseLectures');

Route::get('showMyLectures', 'StudentController@showMyLectures');

Route::get('editClassroom/{id}', 'ClassroomController@getEditClassroom');

Route::put('editClassroom/{id}', 'ClassroomController@putEditClassroom');

Route::get('editProfessor/{id}', 'ProfessorController@getEditProfessor');

Route::put('editProfessor/{id}', 'ProfessorController@putEditProfessor');

Route::get('editCourse/{id}', 'CourseController@getEditCourse');

Route::put('editCourse/{id}', 'CourseController@putEditCourse');

Route::get('editLecture/{id}', 'LectureController@getEditLecture');

Route::put('editLecture/{id}', 'LectureController@putEditLecture');

Route::delete('deleteLectures' , 'LectureController@deleteLectures');

Route::delete('deleteCourses' , 'CourseController@deleteCourses');

Route::delete('deleteClassrooms' , 'ClassroomController@deleteClassrooms');

Route::delete('deleteCourses' , 'CourseController@deleteCourses');

Route::delete('deleteProfessors' , 'ProfessorController@deleteProfessors');

Route::delete('deleteLectures' , 'LectureController@deleteLectures');



