<?php

namespace StudentInfo\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use StudentInfo\ErrorCodes\UserErrorCodes;
use StudentInfo\Http\Requests\EditUserPutRequest;
use StudentInfo\Models\User;
use StudentInfo\Repositories\UserRepositoryInterface;
use StudentInfo\ValueObjects\Password;

class UserController extends ApiController
{
    /**
     * @var UserRepositoryInterface
     */
    protected $userRepo;

    /**
     * @var Guard
     */
    protected $guard;

    public function __construct(UserRepositoryInterface $userRepo, Guard $guard)
    {
        $this->userRepo = $userRepo;
        $this->guard    = $guard;
    }

    public function updateProfile(EditUserPutRequest $request, $userId)
    {
        /** @var User $user */
        $user = $this->userRepo->findById($userId);

        if ($user === null) {
            return $this->returnForbidden(UserErrorCodes::USER_DOES_NOT_EXIST);
        }

        $password = $request->get('password');

        $user->setPassword(new Password($password));

        $this->userRepo->update($user);

        return $this->returnSuccess([
            'user' => $user,
        ]);
    }

}