<?php

namespace StudentInfo\Http\Controllers;

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
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
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

        if (!$user->getPassword()->checkAgainst($request->get('currentPassword'))) {
            return $this->returnForbidden(UserErrorCodes::WRONG_CURRENT_PASSWORD);
        }

        $password = $request->get('password');

        $user->setPassword(new Password($password));

        $this->userRepository->update($user);

        return $this->returnSuccess([
            'user' => $user,
        ]);
    }

}