<?php

use StudentInfo\Repositories\FacultyRepositoryInterface;
use StudentInfo\Repositories\SuperUserRepositoryInterface;
use StudentInfo\Repositories\UserRepositoryInterface;

Route::get('/', function () {
    return view('welcome');
});

/* Test Routes */

Route::post('importCSV', 'StudentController@addStudentsFromCSV');

Route::post('wallpaper', 'SettingsController@setWallpaper');

Route::post('language', 'SettingsController@setLanguage');

Route::get('/addSuperUser', function (SuperUserRepositoryInterface $superUserRepository, FacultyRepositoryInterface $facultyRepository) {
    $superUser = new \StudentInfo\Models\SuperUser();
    $superUser->setFirstName("Nebojsa");
    $superUser->setLastName("Urosevic");
    $superUser->setEmail(new \StudentInfo\ValueObjects\Email("nu1@gmail.com"));
    $superUser->setPassword(new \StudentInfo\ValueObjects\Password("blabla"));
    $superUser->setOrganisation($facultyRepository->findFacultyByName('Racunarski fakultet'));
    $superUser->setRememberToken("bla");

    $superUserRepository->create($superUser);
});

Route::get('/addAdmin', function (FacultyRepositoryInterface $facultyRepository, UserRepositoryInterface $userRepository) {
    $admin = new \StudentInfo\Models\Admin();
    $admin->setFirstName("Nebojsa");
    $admin->setLastName("Urosevic");
    $admin->setEmail(new \StudentInfo\ValueObjects\Email("nu@gmail.com"));
    $admin->setPassword(new \StudentInfo\ValueObjects\Password("blabla"));
    $admin->setRememberToken("bla");
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

Route::get('/addFaculty', function (FacultyRepositoryInterface $repository) {
    $faculty = new \StudentInfo\Models\Faculty();
    $faculty->setName('Racunarski fakultet');
    $faculty->setUniversity('Union');
    $settings = new \StudentInfo\ValueObjects\Settings();
    $settings->setLanguage('english');
    $settings->setWallpaperPath('/settings/default/wallpaper/wallpaper.png');
    $faculty->setSettings($settings);

    $repository->create($faculty);
});

Route::get('user/{user_id}', 'UserController@getProfile');

Route::put('user/{user_id}', 'UserController@updateProfile');

Route::post('auth', 'AuthController@login');

Route::delete('auth', 'AuthController@logout');

Route::post('register', 'RegisterController@issueRegisterTokens');

Route::get('register/{registerToken}', 'RegisterController@registerStudent');

Route::post('register/{registerToken}', 'RegisterController@createPassword');

Route::post('chooseLectures', 'StudentController@chooseLectures');

Route::get('showMyLectures', 'StudentController@showMyLectures');

Route::post('addClassroom/{eventId}', 'EventController@AddClassroom');

Route::get('getClassrooms/{eventId}', 'EventController@getClassrooms');

Route::delete('deleteClassroom/{eventId}', 'EventController@deleteClassroom');

Route::post('student', 'StudentController@addStudent');

Route::post('classroom', 'ClassroomController@addClassroom');

Route::post('courseEvent', 'CourseEventController@addEvent');

Route::post('groupEvent', 'GroupEventController@addEvent');

Route::post('globalEvent', 'GlobalEventController@addEvent');

Route::post('professor', 'ProfessorController@addProfessor');

Route::post('lecture', 'LectureController@addLecture');

Route::post('course', 'CourseController@addCourse');

Route::post('group', 'GroupController@addGroup');

Route::post('admin', 'AdminController@addAdmin');

Route::post('notification', 'NotificationController@addNotification');

Route::post('faculty', 'FacultyController@addFaculty');

Route::get('student/{id}', ['middleware' => 'role:student.retrieve', 'uses' => 'StudentController@getStudent']);

Route::get('students/{start?}/{count?}', ['middleware' => 'role:student.retrieve', 'uses' => 'StudentController@getStudents']);

Route::get('classroom/{id}', ['middleware' => 'role:classroom.retrieve', 'uses' => 'ClassroomController@getClassroom']);

Route::get('classrooms/{start?}/{count?}', ['middleware' => 'role:classroom.retrieve', 'uses' => 'ClassroomController@getClassrooms']);

Route::get('professor/{id}', ['middleware' => 'role:professor.retrieve', 'uses' => 'ProfessorController@getProfessor']);

Route::get('professors/{start?}/{count?}', ['middleware' => 'role:professor.retrieve', 'uses' => 'ProfessorController@getProfessors']);

Route::get('event/{id}', ['middleware' => 'role:event.retrieve', 'uses' => 'EventController@getEvent']);

Route::get('events/{start?}/{count?}', ['middleware' => 'role:event.retrieve', 'uses' => 'EventController@getEvents']);

Route::get('lecture/{id}', ['middleware' => 'role:lecture.retrieve', 'uses' => 'LectureController@getLecture']);

Route::get('lectures/{start?}/{count?}', ['middleware' => 'role:lecture.retrieve', 'uses' => 'LectureController@getLectures']);

Route::get('course/{id}', ['middleware' => 'role:course.retrieve', 'uses' => 'CourseController@getCourse']);

Route::get('notification/{id}', ['middleware' => 'role:notification.retrieve', 'uses' => 'NotificationController@getNotification']);

Route::get('notifications/{start?}/{count?}', ['middleware' => 'role:notification.retrieve', 'uses' => 'NotificationController@getNotifications']);

Route::get('courses/{start?}/{count?}', ['middleware' => 'role:course.retrieve', 'uses' => 'CourseController@getCourses']);

Route::get('group/{id}', ['middleware' => 'role:group.retrieve', 'uses' => 'GroupController@getGroup']);

Route::get('groups/{start?}/{count?}', ['middleware' => 'role:group.retrieve', 'uses' => 'GroupController@getGroups']);

Route::get('admin/{id}', ['middleware' => 'role:admin.retrieve', 'uses' => 'AdminController@getAdmin']);

Route::get('admins/{start?}/{count?}', ['middleware' => 'role:admin.retrieve', 'uses' => 'AdminController@getAdmins']);

Route::get('faculty/{id}', ['middleware' => 'role:faculty.retrieve', 'uses' => 'FacultyController@getFaculty']);

Route::get('faculties/{start?}/{count?}', ['middleware' => 'role:faculty.retrieve', 'uses' => 'FacultyController@getFaculties']);

Route::put('student/{id}', ['middleware' => 'role:student.edit', 'uses' => 'StudentController@putEditStudent']);

Route::put('classroom/{id}', ['middleware' => 'role:classroom.edit', 'uses' => 'ClassroomController@putEditClassroom']);

Route::put('professor/{id}', ['middleware' => 'role:professor.edit', 'uses' => 'ProfessorController@putEditProfessor']);

Route::put('course/{id}', ['middleware' => 'role:course.edit', 'uses' => 'CourseController@putEditCourse']);

Route::put('lecture/{id}', ['middleware' => 'role:lecture.edit', 'uses' => 'LectureController@putEditLecture']);

Route::put('group/{id}', ['middleware' => 'role:group.edit', 'uses' => 'GroupController@putEditGroup']);

Route::put('courseEvent/{id}', ['middleware' => 'role:event.edit', 'uses' => 'CourseEventController@putEditEvent']);

Route::put('groupEvent/{id}', ['middleware' => 'role:event.edit', 'uses' => 'GroupEventController@putEditEvent']);

Route::put('globalEvent/{id}', ['middleware' => 'role:event.edit', 'uses' => 'GlobalEventController@putEditEvent']);

Route::put('admin/{id}', ['middleware' => 'role:admin.edit', 'uses' => 'AdminController@putEditAdmin']);

Route::put('faculty/{id}', ['middleware' => 'role:faculty.edit', 'uses' => 'FacultyController@putEditFaculty']);

Route::put('notification/{id}', ['middleware' => 'role:notification.edit', 'uses' => 'NotificationController@putEditNotification']);

Route::delete('classroom/{id}' , ['middleware' => 'role:classroom.delete', 'uses' => 'ClassroomController@deleteClassroom']);

Route::delete('course/{id}' , ['middleware' => 'role:course.delete', 'uses' => 'CourseController@deleteCourse']);

Route::delete('professor/{id}' , ['middleware' => 'role:professor.delete', 'uses' => 'ProfessorController@deleteProfessor']);

Route::delete('lecture/{id}' , ['middleware' => 'role:lecture.delete', 'uses' => 'LectureController@deleteLecture']);

Route::delete('group/{id}' , ['middleware' => 'role:group.delete', 'uses' => 'GroupController@deleteGroup']);

Route::delete('event/{id}', ['middleware' => 'role:event.delete', 'uses' => 'EventController@deleteEvent']);

Route::delete('student/{id}' , ['middleware' => 'role:student.delete', 'uses' => 'StudentController@deleteStudent']);

Route::delete('admin/{id}' , ['middleware' => 'role:admin.delete', 'uses' => 'AdminController@deleteAdmin']);

Route::delete('faculty/{id}' , ['middleware' => 'role:faculty.delete', 'uses' => 'FacultyController@deleteFaculty']);

Route::delete('notification/{id}' , ['middleware' => 'role:notification.delete', 'uses' => 'NotificationController@deleteNotification']);

Route::get('notifications/between/{start}/{end}', ['middleware' => 'role:notification.retrieve', 'uses' => 'NotificationController@getNotificationsInInterval']);

