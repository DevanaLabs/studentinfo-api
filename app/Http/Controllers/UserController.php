<?php
/**
 * Created by PhpStorm.
 * User: Nebojsa
 * Date: 11/6/2015
 * Time: 10:52 AM
 */

namespace StudentInfo\Http\Controllers;


use Illuminate\Contracts\Auth\Guard;
use StudentInfo\ErrorCodes\UserErrorCodes;
use StudentInfo\Http\Requests\editUserPutRequest;
use StudentInfo\Repositories\UserRepositoryInterface;
use StudentInfo\ValueObjects\Password;
use StudentInfo\Models\User;

class UserController extends  ApiController
{
    /**
     * @var UserRepositoryInterface
     */
    protected $repository;

    /**
    * @var Guard
    */
    protected $guard;

    /**
     * StudentController constructor.
     * @param UserRepositoryInterface $repository
     */
    public function __construct(UserRepositoryInterface $repository, Guard $guard)
    {
        $this->repository = $repository;
        $this->guard = $guard;
    }

    public function editProfile($id)
    {
        /** @var User $user */
        $user = $this->repository->find($id);

        if ($user === null) {
            return $this->returnForbidden(UserErrorCodes::USER_DOES_NOT_EXIST);
        }

        if ($this->guard->user()->getId() != $id) {
            return $this->returnForbidden(UserErrorCodes::WRONG_ID);
        }
        echo var_dump($user);
    }

    public function updateProfile(editUserPutRequest $request, $id)
    {
        /** @var User $user */
        $user = $this->repository->find($id);

        if ($user === null) {
            return $this->returnForbidden(UserErrorCodes::USER_DOES_NOT_EXIST);
        }

        if ($this->guard->user()->getId() != $id) {
            return $this->returnForbidden(UserErrorCodes::WRONG_ID);
        }

        $password = $request->get('password');
        if ($password != null);
            $user->setPassword(new Password($password));
        $this->repository->update($user);
    }

}