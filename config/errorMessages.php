<?php

return [

    \StudentInfo\ErrorCodes\UserErrorCodes::ACCESS_DENIED                        => 'The email or password is incorrect',

    \StudentInfo\ErrorCodes\UserErrorCodes::INVALID_REGISTER_TOKEN               => 'The provided token is invalid',

    \StudentInfo\ErrorCodes\UserErrorCodes::EXPIRED_REGISTER_TOKEN               => 'Your register token has expired. Please contact your administrator',

    \StudentInfo\ErrorCodes\UserErrorCodes::USER_DOES_NOT_EXIST                  => 'User does not exist in database',

    \StudentInfo\ErrorCodes\StudentErrorCodes::YOU_ARE_NOT_A_STUDENT             => 'You are not a student',

    \StudentInfo\ErrorCodes\ClassroomErrorCodes::CLASSROOM_NOT_IN_DB             => 'Classroom is not in database',

    \StudentInfo\ErrorCodes\ProfessorErrorCodes::PROFESSOR_NOT_IN_DB             => 'Professor is not in database',

    \StudentInfo\ErrorCodes\CourseErrorCodes::COURSE_NOT_IN_DB                   => 'Course is not in database',

    \StudentInfo\ErrorCodes\LectureErrorCodes::LECTURE_NOT_IN_DB                 => 'Lecture is not in database',

    \StudentInfo\ErrorCodes\GroupErrorCodes::GROUP_NOT_IN_DB                     => 'Group is not in database',

    \StudentInfo\ErrorCodes\UserErrorCodes::INCORRECT_TIME                       => 'The time is incorrect',

    \StudentInfo\ErrorCodes\EventErrorCodes::EVENT_NOT_IN_DB                     => 'Event is not in database',

    \StudentInfo\ErrorCodes\StudentErrorCodes::STUDENT_NOT_IN_DB                 => 'Student is not in database',

    \StudentInfo\ErrorCodes\UserErrorCodes::NOT_UNIQUE_EMAIL                     => 'User with this email already exists in database',

    \StudentInfo\ErrorCodes\StudentErrorCodes::STUDENT_NOT_UNIQUE_INDEX          => 'Student with this index number already exists in database',

    \StudentInfo\ErrorCodes\ClassroomErrorCodes::CLASSROOM_ALREADY_EXISTS        => 'Classroom with this name already exists in database',

    \StudentInfo\ErrorCodes\CourseErrorCodes::COURSE_ALREADY_EXISTS              => 'Course with this name already exists in database',

    \StudentInfo\ErrorCodes\GroupErrorCodes::GROUP_ALREADY_EXISTS                => 'Group with this name already exists in database',

    \StudentInfo\ErrorCodes\UserErrorCodes::CSV_FILE_NOT_FOUND                   => 'Valid CSV file was not found',

    \StudentInfo\ErrorCodes\AdminErrorCodes::ADMIN_NOT_IN_DB                     => 'Admin is not in database',

    \StudentInfo\ErrorCodes\FacultyErrorCodes::FACULTY_NOT_IN_DB                 => 'Faculty is not in database',

    \StudentInfo\ErrorCodes\FacultyErrorCodes::FACULTY_ALREADY_EXISTS            => 'Faculty with same name already exist in database',

    \StudentInfo\ErrorCodes\UserErrorCodes::USER_BELONGS_TO_THIS_FACULTY         => 'You can\'t delete this faculty, there are users in it',

    \StudentInfo\ErrorCodes\NotificationErrorCodes::NOTIFICATION_NOT_IN_DB       => 'Notification is not in database',

    \StudentInfo\ErrorCodes\AssistantErrorCodes::ASSISTANT_NOT_IN_DB             => 'Assistant is not in database',

    \StudentInfo\ErrorCodes\UserErrorCodes::USER_DOES_NOT_BELONG_TO_THIS_FACULTY => 'User does not belong to this faculty',

    \StudentInfo\ErrorCodes\TeacherErrorCodes::TEACHER_NOT_IN_DB                 => 'Teacher is not in database',

    \StudentInfo\ErrorCodes\FeedbackErrorCodes::FEEDBACK_NOT_IN_DB => 'Feedback is not in database',
];