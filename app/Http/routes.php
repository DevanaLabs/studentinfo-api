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

Route::get('user/{user_id}', 'UserController@getProfile');

Route::put('user/{user_id}', 'UserController@updateProfile');

Route::post('auth', 'AuthController@login');

Route::delete('auth', 'AuthController@logout');

Route::post('register', 'RegisterController@issueRegisterTokens');

Route::get('register/{rememberToken}', 'RegisterController@registerStudent');

Route::post('register/{rememberToken}', 'RegisterController@createPassword');

Route::post('chooseLectures', 'StudentController@chooseLectures');

Route::get('showMyLectures', 'StudentController@showMyLectures');

Route::post('addStudents', 'StudentController@addStudents');

Route::post('addClassrooms', 'ClassroomController@addClassrooms');

Route::post('addEvents', 'EventController@addEvents');

Route::post('addProfessors', 'ProfessorController@addProfessors');

Route::post('addEvents', 'EventController@addEvents');

Route::post('addLecture', 'LectureController@addLecture');

Route::post('addCourses', 'CourseController@addCourses');

Route::post('addGroups', 'GroupController@addGroups');

Route::get('student/{id}', ['middleware' => 'role:student.retrieve', 'uses' => 'StudentController@getStudent']);

Route::get('students/{start}/{count}', ['middleware' => 'role:student.retrieve', 'uses' => 'StudentController@getStudents']);

Route::get('classroom/{id}', ['middleware' => 'role:classroom.retrieve', 'uses' => 'ClassroomController@getClassroom']);

Route::get('classrooms/{start}/{count}', ['middleware' => 'role:classroom.retrieve', 'uses' => 'ClassroomController@getClassrooms']);

Route::get('professor/{id}', ['middleware' => 'role:professor.retrieve', 'uses' => 'ProfessorController@getProfessor']);

Route::get('professors/{start}/{count}', ['middleware' => 'role:professor.retrieve', 'uses' => 'ProfessorController@getProfessors']);

Route::get('event/{id}', ['middleware' => 'role:event.retrieve', 'uses' => 'EventController@getEvent']);

Route::get('events/{start}/{count}', ['middleware' => 'role:event.retrieve', 'uses' => 'EventController@getEvents']);

Route::get('lecture/{id}', ['middleware' => 'role:lecture.retrieve', 'uses' => 'LectureController@getLecture']);

Route::get('lectures/{start}/{count}', ['middleware' => 'role:lecture.retrieve', 'uses' => 'LectureController@getLectures']);

Route::get('course/{id}', ['middleware' => 'role:course.retrieve', 'uses' => 'CourseController@getCourse']);

Route::get('courses/{start}/{count}', ['middleware' => 'role:course.retrieve', 'uses' => 'CourseController@getCourses']);

Route::get('group/{id}', ['middleware' => 'role:group.retrieve', 'uses' => 'GroupController@getGroup']);

Route::get('groups/{start}/{count}', ['middleware' => 'role:group.retrieve', 'uses' => 'GroupController@getGroups']);

Route::put('classroom/{id}', ['middleware' => 'role:classroom.edit', 'uses' => 'ClassroomController@putEditClassroom']);

Route::put('professor/{id}', ['middleware' => 'role:professor.edit', 'uses' => 'ProfessorController@putEditProfessor']);

Route::put('course/{id}', ['middleware' => 'role:course.edit', 'uses' => 'CourseController@putEditCourse']);

Route::put('lecture/{id}', ['middleware' => 'role:lecture.edit', 'uses' => 'LectureController@putEditLecture']);

Route::put('group/{id}', ['middleware' => 'role:group.edit', 'uses' => 'GroupController@putEditGroup']);

Route::put('event/{id}', ['middleware' => 'role:event.edit', 'uses' => 'EventController@putEditEvent']);

Route::delete('classroom/{id}' , ['middleware' => 'role:classroom.delete', 'uses' => 'ClassroomController@deleteClassroom']);

Route::delete('course/{id}' , ['middleware' => 'role:course.delete', 'uses' => 'CourseController@deleteCourse']);

Route::delete('professor/{id}' , ['middleware' => 'role:professor.delete', 'uses' => 'ProfessorController@deleteProfessor']);

Route::delete('lecture/{id}' , ['middleware' => 'role:lecture.delete', 'uses' => 'LectureController@deleteLecture']);

Route::delete('group/{id}' , ['middleware' => 'role:group.delete', 'uses' => 'GroupController@deleteGroup']);

Route::delete('event/{id}' , ['middleware' => 'role:event.delete', 'uses' => 'EventController@deleteEvent']);



