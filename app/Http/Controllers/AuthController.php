<?php

namespace StudentInfo\Http\Controllers;


use Illuminate\Contracts\Auth\Guard;
use LucaDegasperi\OAuth2Server\Authorizer;
use StudentInfo\Http\Requests\UserLoginPostRequest;
use StudentInfo\Repositories\UserRepositoryInterface;

class AuthController extends ApiController
{
    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * @var Guard
     */
    protected $guard;

    /**
     * @var Authorizer
     */
    protected $authorizer;

    public function __construct(UserRepositoryInterface $userRepository, Guard $guard, Authorizer $authorizer)
    {
        $this->userRepository = $userRepository;
        $this->guard = $guard;
        $this->authorizer = $authorizer;

    }

    /**
     * @param UserLoginPostRequest $request
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
    public function login()
    {
        return $this->returnSuccess([
            'oauth' => $this->authorizer->issueAccessToken(),
            'user'  => $this->guard->user(),
        ]);

//        $input = $request->only(['email', 'password']);
//
//        $user = $this->userRepository->findByEmail(new Email($input['email']));
//
//        if (($user->getRegisterToken() != "") && ($user->getRegisterToken() != "0")) {
//            return $this->returnForbidden(UserErrorCodes::YOU_NEED_TO_REGISTER_FIRST);
//        }
//
//        if (!$this->guard->attempt([
//            'email.email' => $input['email'],
//            'password'    => $input['password']
//        ])) {
//            return $this->returnForbidden(UserErrorCodes::ACCESS_DENIED);
//        }
//
//        return $this->returnSuccess([
//            'user' => $user,
//        ]);
    }

    /**
     * @return \Illuminate\Http\Response
     * @internal param Guard $guard
     *
     * @api {delete}
     *
     * @apiName Logout
     * @apiGroup User
     *
     */
    public function logout()
    {
        $this->guard->logout();

        return $this->returnSuccess();
    }
}
