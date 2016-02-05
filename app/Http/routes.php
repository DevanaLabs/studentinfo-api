<?php

Route::get('/', function () {
    return view('welcome');
});

Route::post('oauth/access_token', 'AuthController@getAccessToken');

Route::get('pushNotification', 'PushNotificationController@pushNotification');

Route::get('user/{user_id}', 'UserController@getProfile');

Route::post('user/{user_id}', 'UserController@updateProfile');

Route::post('auth', 'AuthController@login');

Route::delete('auth', 'AuthController@logout');

Route::post('register', 'RegisterController@issueRegisterTokens');

Route::get('register/{registerToken}', 'RegisterController@registerStudent');

Route::post('register/{registerToken}', 'RegisterController@createPassword');

Route::post('faculty', 'FacultyController@createFaculty');

Route::get('faculty/{id}', ['middleware' => ['oauth', 'role:faculty.retrieve'], 'uses' => 'FacultyController@retrieveFaculty']);

Route::get('faculties/{start?}/{count?}', ['middleware' => ['oauth', 'role:faculty.retrieve'], 'uses' => 'FacultyController@retrieveFaculties']);

Route::put('faculty/{id}', ['middleware' => ['oauth', 'role:faculty.update'], 'uses' => 'FacultyController@updateFaculty']);

Route::delete('faculty/{id}', ['middleware' => ['oauth', 'role:faculty.delete'], 'uses' => 'FacultyController@deleteFaculty']);

Route::post('deviceToken', 'DeviceTokenController@createDeviceToken');

Route::get('deviceToken/{id}', ['middleware' => ['oauth', 'role:token.retrieve'], 'uses' => 'DeviceTokenController@retrieveDeviceToken']);

Route::get('deviceTokens/{start?}/{count?}', ['middleware' => ['oauth', 'role:token.retrieve'], 'uses' => 'DeviceTokenController@retrieveDeviceTokens']);

Route::put('deviceToken/{id}', ['middleware' => ['oauth', 'role:token.update'], 'uses' => 'DeviceTokenController@updateDeviceToken']);

Route::delete('deviceToken/{id}', ['middleware' => ['oauth', 'role:token.delete'], 'uses' => 'DeviceTokenController@deleteDeviceToken']);

Route::post('admin', 'AdminController@createAdmin');

Route::get('admin/{id}', ['middleware' => ['oauth', 'role:admin.retrieve'], 'uses' => 'AdminController@retrieveAdmin']);

Route::get('admins/{start?}/{count?}', ['middleware' => ['oauth', 'role:admin.retrieve'], 'uses' => 'AdminController@retrieveAdmins']);

Route::put('admin/{id}', ['middleware' => ['oauth', 'role:admin.update'], 'uses' => 'AdminController@updateAdmin']);

Route::delete('admin/{id}', ['middleware' => ['oauth', 'role:admin.delete'], 'uses' => 'AdminController@deleteAdmin']);

Route::group(['prefix' => '{faculty}', 'middleware' => ['oauth', 'StudentInfo\Http\Middleware\FacultyCheck:{faculty}']], function () {

    Route::post('importStudents', 'StudentController@addStudentsFromCSV');

    Route::post('importClassrooms', 'ClassroomController@addClassroomsFromCSV');

    Route::post('importCourses', 'CourseController@addCoursesFromCSV');

    Route::post('importProfessors', 'ProfessorController@addProfessorsFromCSV');

    Route::post('importAssistants', 'AssistantController@addAssistantFromCSV');

    Route::post('importLecture', 'LectureController@AddLecturesFromCSV');

    Route::post('wallpaper', 'SettingsController@setWallpaper');

    Route::post('language', 'SettingsController@setLanguage');

    Route::get('updateRegisterToken/{id}', ['middleware' => ['oauth', 'role:token.update'], 'uses' => 'RegisterController@updateRegisterToken']);

    Route::post('student', 'StudentController@createStudent');

    Route::post('classroom', ['middleware' => 'oauth', 'uses' => 'ClassroomController@createClassroom']);

    Route::post('courseEvent', 'CourseEventController@createEvent');

    Route::post('groupEvent', 'GroupEventController@createEvent');

    Route::post('globalEvent', 'GlobalEventController@createEvent');

    Route::post('professor', 'ProfessorController@createProfessor');

    Route::post('assistant', 'AssistantController@createAssistant');

    Route::post('lecture', 'LectureController@createLecture');

    Route::post('course', 'CourseController@createCourse');

    Route::post('group', 'GroupController@createGroup');

    Route::post('lectureNotification', 'LectureNotificationController@createNotification');

    Route::post('eventNotification', 'EventNotificationController@createNotification');

    Route::post('feedback', 'FeedbackController@createFeedback');

    Route::get('data', 'DataController@getData');

    Route::get('student/{id}', ['middleware' => ['oauth', 'role:student.retrieve'], 'uses' => 'StudentController@retrieveStudent']);

    Route::get('students/{start?}/{count?}', ['middleware' => ['oauth', 'role:student.retrieve'], 'uses' => 'StudentController@retrieveStudents']);

    Route::get('classroom/{id}', 'ClassroomController@retrieveClassroom');

    Route::get('classrooms/{start?}/{count?}', 'ClassroomController@retrieveClassrooms');

    Route::get('teacher/{id}', 'TeacherController@retrieveTeacher');

    Route::get('teachers/{start?}/{count?}', 'TeacherController@retrieveTeachers');

    Route::get('professor/{id}', 'ProfessorController@retrieveProfessor');

    Route::get('professors/{start?}/{count?}', 'ProfessorController@retrieveProfessors');

    Route::get('assistant/{id}', 'AssistantController@retrieveAssistant');

    Route::get('assistants/{start?}/{count?}', 'AssistantController@retrieveAssistants');

    Route::get('event/{id}', ['middleware' => ['oauth', 'role:event.retrieve'], 'uses' => 'EventController@retrieveEvent']);

    Route::get('events/{start?}/{count?}', ['middleware' => ['oauth', 'role:event.retrieve'], 'uses' => 'EventController@retrieveEvents']);

    Route::get('courseEvent/{id}', 'CourseEventController@retrieveEvent');

    Route::get('courseEvents/{start?}/{count?}', 'CourseEventController@retrieveEvents');

    Route::get('groupEvent/{id}', 'GroupEventController@retrieveEvent');

    Route::get('groupEvents/{start?}/{count?}', 'GroupEventController@retrieveEvents');

    Route::get('globalEvent/{id}', 'GlobalEventController@retrieveEvent');

    Route::get('globalEvents/{start?}/{count?}', 'GlobalEventController@retrieveEvents');

    Route::get('lecture/{id}', 'LectureController@retrieveLecture');

    Route::get('lectures/{start?}/{count?}', 'LectureController@retrieveLectures');

    Route::get('notification/{id}', 'NotificationController@retrieveNotification');

    Route::get('notifications/{start?}/{count?}', 'NotificationController@retrieveNotifications');

    Route::get('eventNotification/{id}', 'EventNotificationController@retrieveNotification');

    Route::get('notificationsForEvent/{id}', 'EventNotificationController@retrieveNotificationsForEvent');

    Route::get('eventNotifications/{start?}/{count?}', 'EventNotificationController@retrieveNotifications');

    Route::get('lectureNotification/{id}', 'LectureNotificationController@retrieveNotification');

    Route::get('notificationsForLecture/{id}', 'LectureNotificationController@retrieveNotificationsForLecture');

    Route::get('lectureNotifications/{start?}/{count?}', 'LectureNotificationController@retrieveNotifications');

    Route::get('course/{id}', ['middleware' => ['oauth', 'role:course.retrieve'], 'uses' => 'CourseController@retrieveCourse']);

    Route::get('courses/{start?}/{count?}', ['middleware' => ['oauth', 'role:course.retrieve'], 'uses' => 'CourseController@retrieveCourses']);

    Route::get('group/{id}', 'GroupController@retrieveGroup');

    Route::get('groups/{start?}/{count?}', 'GroupController@retrieveGroups');

    Route::get('feedback/{id}', ['middleware' => ['oauth', 'role:feedback.retrieve'], 'uses' => 'FeedbackController@retrieveFeedback']);

    Route::get('feedbacks/{start?}/{count?}', ['middleware' => ['oauth', 'role:feedback.retrieve'], 'uses' => 'FeedbackController@retrieveFeedbacks']);

    Route::get('notifications/between/{start}/{end}', ['middleware' => ['oauth', 'role:notification.retrieve'], 'uses' => 'NotificationController@getNotificationsInInterval']);

    Route::put('student/{id}', ['middleware' => ['oauth', 'role:student.update'], 'uses' => 'StudentController@updateStudent']);

    Route::put('classroom/{id}', ['middleware' => ['oauth', 'role:classroom.update'], 'uses' => 'ClassroomController@updateClassroom']);

    Route::put('professor/{id}', ['middleware' => ['oauth', 'role:teacher.update'], 'uses' => 'ProfessorController@updateProfessor']);

    Route::put('assistant/{id}', ['middleware' => ['oauth', 'role:teacher.update'], 'uses' => 'AssistantController@updateAssistant']);

    Route::put('course/{id}', ['middleware' => ['oauth', 'role:course.update'], 'uses' => 'CourseController@updateCourse']);

    Route::put('lecture/{id}', ['middleware' => ['oauth', 'role:lecture.update'], 'uses' => 'LectureController@updateLecture']);

    Route::put('group/{id}', ['middleware' => ['oauth', 'role:group.update'], 'uses' => 'GroupController@updateGroup']);

    Route::put('courseEvent/{id}', ['middleware' => ['oauth', 'role:event.update'], 'uses' => 'CourseEventController@updateEvent']);

    Route::put('groupEvent/{id}', ['middleware' => ['oauth', 'role:event.update'], 'uses' => 'GroupEventController@updateEvent']);

    Route::put('globalEvent/{id}', ['middleware' => ['oauth', 'role:event.update'], 'uses' => 'GlobalEventController@updateEvent']);

    Route::put('feedback/{id}', ['middleware' => ['oauth', 'role:feedback.update'], 'uses' => 'FeedbackController@updateFeedback']);

    Route::put('eventNotification/{id}', ['middleware' => ['oauth', 'role:notification.edit'], 'uses' => 'EventNotificationController@updateNotification']);

    Route::put('lectureNotification/{id}', ['middleware' => ['oauth', 'role:notification.edit'], 'uses' => 'LectureNotificationController@updateNotification']);

    Route::delete('classroom/{id}', ['middleware' => ['oauth', 'role:classroom.delete'], 'uses' => 'ClassroomController@deleteClassroom']);

    Route::delete('course/{id}', ['middleware' => ['oauth', 'role:course.delete'], 'uses' => 'CourseController@deleteCourse']);

    Route::delete('professor/{id}', ['middleware' => ['oauth', 'role:teacher.delete'], 'uses' => 'ProfessorController@deleteProfessor']);

    Route::delete('assistant/{id}', ['middleware' => ['oauth', 'role:teacher.delete'], 'uses' => 'AssistantController@deleteAssistant']);

    Route::delete('lecture/{id}', ['middleware' => ['oauth', 'role:lecture.delete'], 'uses' => 'LectureController@deleteLecture']);

    Route::delete('group/{id}', ['middleware' => ['oauth', 'role:group.delete'], 'uses' => 'GroupController@deleteGroup']);

    Route::delete('event/{id}', ['middleware' => ['oauth', 'role:event.delete'], 'uses' => 'EventController@deleteEvent']);

    Route::delete('student/{id}', ['middleware' => ['oauth', 'role:student.delete'], 'uses' => 'StudentController@deleteStudent']);

    Route::delete('feedback/{id}', ['middleware' => ['oauth', 'role:feedback.delete'], 'uses' => 'FeedbackController@deleteFeedback']);

    Route::delete('notification/{id}', ['middleware' => ['oauth', 'role:notification.delete'], 'uses' => 'NotificationController@deleteNotification']);
});