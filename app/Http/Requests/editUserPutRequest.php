<?php

namespace StudentInfo\Http\Requests;

use Illuminate\Contracts\Auth\Guard;
use StudentInfo\Models\User;

class EditUserPutRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @param Guard $guard
     * @return bool
     */
    public function authorize(Guard $guard)
    {
        $userId = $this->route('user_id');

        /** @var User $user */
        $user = $guard->user();
        if ($user === null) {
            return false;
        }

        if ($user->getId() == $userId){
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
        return [
            'password' => 'required|confirmed',
        ];
    }
}