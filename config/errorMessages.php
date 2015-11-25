<?php

return [

    \StudentInfo\ErrorCodes\UserErrorCodes::ACCESS_DENIED          => 'The email or password is incorrect',

    \StudentInfo\ErrorCodes\UserErrorCodes::INVALID_REGISTER_TOKEN => 'The provided token is invalid',

    \StudentInfo\ErrorCodes\UserErrorCodes::EXPIRED_REGISTER_TOKEN => 'Your register token has expired. Please contact your administrator',

    \StudentInfo\ErrorCodes\UserErrorCodes::USER_DOES_NOT_EXIST    => 'User does not exist in database',

    \StudentInfo\ErrorCodes\UserErrorCodes::YOU_ARE_NOT_A_STUDENT  => 'You are not a student',

    \StudentInfo\ErrorCodes\UserErrorCodes::CLASSROOM_NOT_IN_DB    => 'Classroom is not in database',

    \StudentInfo\ErrorCodes\UserErrorCodes::PROFESSOR_NOT_IN_DB    => 'Professor is not in database',

    \StudentInfo\ErrorCodes\UserErrorCodes::COURSE_NOT_IN_DB       => 'Course is not in database',

    \StudentInfo\ErrorCodes\UserErrorCodes::LECTURE_NOT_IN_DB      => 'Lecture is not in database',

    \StudentInfo\ErrorCodes\UserErrorCodes::GROUP_NOT_IN_DB        => 'Group is not in database',

    \StudentInfo\ErrorCodes\UserErrorCodes::INCORRECT_TIME         => 'Lecture start or end time is incorrect',

    \StudentInfo\ErrorCodes\UserErrorCodes::EVENT_NOT_IN_DB        => 'Event is not in database',

    \StudentInfo\ErrorCodes\UserErrorCodes::STUDENT_NOT_IN_DB      => 'Student is not in database',

    \StudentInfo\ErrorCodes\UserErrorCodes::STUDENT_NOT_UNIQUE_EMAIL        => 'Student with this email already exists in database',

    \StudentInfo\ErrorCodes\UserErrorCodes::STUDENT_NOT_UNIQUE_INDEX        => 'Student with this index number already exists in database',

    \StudentInfo\ErrorCodes\UserErrorCodes::CLASSROOM_ALREADY_EXISTS        => 'Classroom with this name already exists in database',

    \StudentInfo\ErrorCodes\UserErrorCodes::COURSE_ALREADY_EXISTS        => 'Course with this name already exists in database',

    \StudentInfo\ErrorCodes\UserErrorCodes::GROUP_ALREADY_EXISTS        => 'Group with this name already exists in database',

];