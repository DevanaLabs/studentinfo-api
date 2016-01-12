<?php

namespace StudentInfo\Http\Controllers;


use Illuminate\Contracts\Auth\Guard;
use StudentInfo\ErrorCodes\UserErrorCodes;
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
     * @api {post} /auth Authenticate the User
     *
     * @apiName Login
     * @apiGroup User
     *
     * @apiParam {String} email Email of the User.
     * @apiParam {String} password  Password of the User.
     *
     * @apiSuccess {String} User The logged in User.
     *
     * @apiSuccessLogin Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       {"success":{"data":["user":{"user"}]}}
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
            'password'    => $input['password']
        ])) {
            return $this->returnForbidden(UserErrorCodes::ACCESS_DENIED);
        }
        return $this->returnSuccess([
            'user' => $guard->user()
        ]);
    }

    /**
     * @param Guard $guard
     *
     * @api {delete}
     *
     * @apiName Logout
     * @apiGroup User
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Guard $guard)
    {
        $guard->logout();

        return $this->returnSuccess();
    }
}
