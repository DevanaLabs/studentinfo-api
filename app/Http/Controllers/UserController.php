<?php

namespace StudentInfo\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use StudentInfo\ErrorCodes\UserErrorCodes;
use StudentInfo\Http\Requests\EditUserGetRequest;
use StudentInfo\Http\Requests\EditUserPutRequest;
use StudentInfo\Models\User;
use StudentInfo\Repositories\UserRepositoryInterface;
use StudentInfo\ValueObjects\Password;

class UserController extends ApiController
{
    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * @var Guard
     */
    protected $guard;

    public function __construct(UserRepositoryInterface $userRepository, Guard $guard)
    {
        $this->userRepository = $userRepository;
        $this->guard    = $guard;
    }

    public function getProfile(EditUserGetRequest $request, $userId)
    {

        /** @var User $user */
        $user = $this->userRepository->find($userId);

        if ($user === null) {
            return $this->returnForbidden(UserErrorCodes::USER_DOES_NOT_EXIST);
        }

        return $this->returnSuccess([
            'user' => $user,
        ]);
    }

    public function updateProfile(EditUserPutRequest $request, $userId)
    {
        /** @var User $user */
        $user = $this->userRepository->find($userId);

        if ($user === null) {
            return $this->returnForbidden(UserErrorCodes::USER_DOES_NOT_EXIST);
        }

        $password = $request->get('password');

        $user->setPassword(new Password($password));

        $this->userRepository->update($user);

        return $this->returnSuccess([
            'user' => $user,
        ]);
    }

}