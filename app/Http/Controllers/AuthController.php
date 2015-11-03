<?php

namespace StudentInfo\Http\Controllers;


use Illuminate\Contracts\Auth\Guard;
use StudentInfo\Http\Controllers\Controller;
use StudentInfo\Http\Requests\UserLoginPostRequest;
use StudentInfo\Repositories\UserRepositoryInterface;

class AuthController extends ApiController
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param UserLoginPostRequest $request
     * @param Guard                $guard
     * @return \Illuminate\Http\Response
     *
     * @api {get} /user/:email, password Request User information
     *
     * @apiName Login
     * @apiGroup User
     *
     * @apiParam {String} email Email of the User.
     * @apiParam {String} password  Password of the User.
     *
     * @apiSuccess {String} email Email of the User.
     *
     * @apiSuccessLogin Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       {"success":{"data":["You're logger in as 'Email'"]}}
     *     }
     *
     * @apiError EmailOrPasswordIncorrect The email or password is incorrect.
     *
     * @apiErrorLogin Error-Response:
     *     HTTP/1.1 403 Forbidden
     *     {
     *       {"error":{"errorCode":"Access denied","message":"The email or password is incorrect"}}
     *     }
     */
    public function login(UserLoginPostRequest $request, Guard $guard)
    {
        $input = $request->only(['email', 'password']);

        if (!$guard->attempt([
            'email.email' => $input['email'],
            'password'    => $input['password'],
        ])
        ) {
            return $this->returnError(403,'Access denied');
        }
        return $this->returnSuccess(["You're logger in as ".$input['email']]);
    }

    /**
     * @param Guard $guard
     */
    public  function logout(Guard $guard)
    {
        $guard->logout();
    }
}
