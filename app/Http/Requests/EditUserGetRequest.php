<?php

namespace StudentInfo\Http\Requests;

use LucaDegasperi\OAuth2Server\Authorizer;
use StudentInfo\Models\User;
use StudentInfo\Repositories\UserRepositoryInterface;

class EditUserGetRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @param Authorizer              $authorizer
     * @param UserRepositoryInterface $userRepository
     * @return bool
     */
    public function authorize(Authorizer $authorizer, UserRepositoryInterface $userRepository)
    {
        $userId = $authorizer->getResourceOwnerId();
        /** @var User $user */
        $user = $userRepository->find($userId);

        $userId = $this->route('user_id');

        if ($user === null) {
            return false;
        }

        if ($user->getId() == $userId) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }
}