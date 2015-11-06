<?php

return [

    \StudentInfo\ErrorCodes\UserErrorCodes::ACCESS_DENIED          => 'The email or password is incorrect',

    \StudentInfo\ErrorCodes\UserErrorCodes::INVALID_REGISTER_TOKEN => 'The provided token is invalid',

    \StudentInfo\ErrorCodes\UserErrorCodes::EXPIRED_REGISTER_TOKEN => 'Your register token has expired. Please contact your administrator',

    \StudentInfo\ErrorCodes\UserErrorCodes::WRONG_ID               => 'You don\'t have permission to edit this user',

    \StudentInfo\ErrorCodes\UserErrorCodes::USER_DOES_NOT_EXIST    => 'User does not exist in database'
];