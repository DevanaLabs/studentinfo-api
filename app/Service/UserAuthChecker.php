<?php

namespace StudentInfo\Service;

use Illuminate\Auth\Guard;
use StudentInfo\Models\User;
use StudentInfo\Repositories\UserRepositoryInterface;
use StudentInfo\ValueObjects\Email;

class UserAuthChecker
{
    /**
     * @var Guard
     */
    protected $guard;

    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepositoryInterface, Guard $guard)
    {
        $this->userRepository = $userRepositoryInterface;
        $this->guard          = $guard;
    }

    public function verify($email, $password)
    {
        /** @var User $user */
        $user = $this->userRepository->findByEmail(new Email($email));

        if ($user === null) {
            return false;
        }
        if (($user->getRegisterToken() !== "") && ($user->getRegisterToken() !== "0")) {
            return false;
        }

        $credentials = [
            'id'       => $user->getId(),
            'password' => $password,
        ];

        if ($this->guard->validate($credentials)) {
            return $user->getId();
        }
        return false;
    }
}