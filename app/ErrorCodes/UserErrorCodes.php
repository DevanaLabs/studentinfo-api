<?php

namespace StudentInfo\ErrorCodes;

class UserErrorCodes
{
    const ACCESS_DENIED = 100;

    const INVALID_REGISTER_TOKEN = 101;

    const EXPIRED_REGISTER_TOKEN = 102;

    const USER_DOES_NOT_EXIST = 103;

    const PROFESSOR_NOT_IN_DB = 104;

    const COURSE_NOT_IN_DB = 105;

    const CLASSROOM_NOT_IN_DB = 106;

    const LECTURE_NOT_IN_DB = 107;

    const GROUP_NOT_IN_DB = 108;

    const YOU_ARE_NOT_A_STUDENT = 109;

    const INCORRECT_TIME = 110;

    const EVENT_NOT_IN_DB = 111;

    const NOT_UNIQUE_EMAIL = 112;

    const STUDENT_NOT_UNIQUE_INDEX = 113;

    const CLASSROOM_ALREADY_EXISTS = 114;

    const COURSE_ALREADY_EXISTS = 115;

    const GROUP_ALREADY_EXISTS = 116;

    const STUDENT_NOT_IN_DB = 117;

    const CSV_FILE_NOT_FOUND = 118;

    const ADMIN_NOT_IN_DB = 119;

    const FACULTY_NOT_IN_DB = 120;

    const FACULTY_ALREADY_EXISTS = 121;

    const USER_BELONGS_TO_THIS_FACULTY = 122;
}