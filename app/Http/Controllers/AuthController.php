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
     */
    public function login(UserLoginPostRequest $request, Guard $guard)
    {
        $input = $request->only(['email', 'password']);

        if (!$guard->attempt([
            'email.email' => $input['email'],
            'password'    => $input['password'],
        ])
        ) {
            return $this->returnError(403,'Wrong');
        }
        return 'You\'re logged in as '.$input['email'];
    }

    /**
     * @param Guard $guard
     */
    public  function logout(Guard $guard)
    {
        $guard->logout();
    }
}
