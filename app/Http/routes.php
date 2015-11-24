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

Route::get('students', ['middleware' => 'role:student.retrieve', 'uses' => 'StudentController@getStudents']);

Route::post('auth', 'AuthController@login');

Route::delete('auth', 'AuthController@logout');

Route::post('register', 'RegisterController@issueRegisterTokens');

Route::get('register/{rememberToken}', 'RegisterController@registerStudent');

Route::post('register/{rememberToken}', 'RegisterController@createPassword');

Route::post('addClassrooms', 'ClassroomController@addClassrooms');

Route::get('getClassrooms', ['middleware' => 'role:classroom.retrieve', 'uses' => 'ClassroomController@getClassrooms']);

Route::post('addProfessors', 'ProfessorController@addProfessors');

Route::get('getProfessors', ['middleware' => 'role:professor.retrieve', 'uses' => 'ProfessorController@getProfessors']);

Route::post('addLecture', 'LectureController@addLecture');

Route::get('getLectures', ['middleware' => 'role:lecture.retrieve', 'uses' => 'LectureController@getLectures']);

Route::post('addCourses', 'CourseController@addCourses');

Route::get('getCourses', ['middleware' => 'role:course.retrieve', 'uses' => 'CourseController@getCourses']);

Route::post('addGroups', 'GroupController@addGroups');

Route::get('getGroups', ['middleware' => 'role:group.retrieve', 'uses' => 'GroupController@getGroups']);

Route::post('chooseLectures', 'StudentController@chooseLectures');

Route::get('showMyLectures', 'StudentController@showMyLectures');

Route::get('editClassroom/{id}', ['middleware' => 'role:classroom.edit', 'uses' => 'ClassroomController@getEditClassroom']);

Route::put('editClassroom/{id}', ['middleware' => 'role:classroom.edit', 'uses' => 'ClassroomController@putEditClassroom']);

Route::get('editProfessor/{id}', ['middleware' => 'role:professor.edit', 'uses' => 'ProfessorController@getEditProfessor']);

Route::put('editProfessor/{id}', ['middleware' => 'role:professor.edit', 'uses' => 'ProfessorController@putEditProfessor']);

Route::get('editCourse/{id}', ['middleware' => 'role:course.edit', 'uses' => 'CourseController@getEditCourse']);

Route::put('editCourse/{id}', ['middleware' => 'role:course.edit', 'uses' => 'CourseController@putEditCourse']);

Route::get('editLecture/{id}', ['middleware' => 'role:lecture.edit', 'uses' => 'LectureController@getEditLecture']);

Route::put('editLecture/{id}', ['middleware' => 'role:lecture.edit', 'uses' => 'LectureController@putEditLecture']);

Route::get('editGroup/{id}', ['middleware' => 'role:group.edit', 'uses' => 'GroupController@getEditGroup']);

Route::put('editGroup/{id}', ['middleware' => 'role:group.edit', 'uses' => 'GroupController@putEditGroup']);

Route::delete('deleteClassrooms' , ['middleware' => 'role:classroom.delete', 'uses' => 'ClassroomController@deleteClassrooms']);

Route::delete('deleteCourses' , ['middleware' => 'role:course.delete', 'uses' => 'CourseController@deleteCourses']);

Route::delete('deleteProfessors' , ['middleware' => 'role:professor.delete', 'uses' => 'ProfessorController@deleteProfessors']);

Route::delete('deleteLectures' , ['middleware' => 'role:lecture.delete', 'uses' => 'LectureController@deleteLectures']);

Route::delete('deleteGroups' , ['middleware' => 'role:group.delete', 'uses' => 'GroupController@deleteGroup']);



