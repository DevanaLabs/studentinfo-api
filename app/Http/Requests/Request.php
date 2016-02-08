<?php

namespace StudentInfo\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use LucaDegasperi\OAuth2Server\Authorizer;
use StudentInfo\Models\User;
use StudentInfo\Repositories\UserRepositoryInterface;

abstract class Request extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @param $permission
     * @return bool
     */
    protected function checkIfHasPermission($permission)
    {
        $userRepository = $this->container->make(UserRepositoryInterface::class);
        $authorizer     = $this->container->make(Authorizer::class);

        $userId = $authorizer->getResourceOwnerId();
        /** @var User $user */
        $user = $userRepository->find($userId);

        if ($user === null) {
            return false;
        }

        if ($permission === '') {
            return true;
        }

        return ($user->hasPermissionTo($permission));
    }
}
