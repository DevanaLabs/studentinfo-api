<?php

namespace StudentInfo\ErrorCodes;

class UserErrorCodes
{
    const ACCESS_DENIED = 100;

    const INVALID_REGISTER_TOKEN = 101;

    const EXPIRED_REGISTER_TOKEN = 102;

    const USER_DOES_NOT_EXIST = 103;

    const INCORRECT_TIME = 110;

    const NOT_UNIQUE_EMAIL = 112;

    const CSV_FILE_NOT_FOUND = 118;

    const USER_BELONGS_TO_THIS_FACULTY = 122;

    const USER_DOES_NOT_BELONG_TO_THIS_FACULTY = 127;

    const YOU_DO_N0T_HAVE_PERMISSION_TO_SEE_THIS = 141;
}