<?php

namespace StudentInfo\Http\Requests;

use Illuminate\Contracts\Auth\Guard;

class UserLoginPostRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(Guard $guard)
    {
        return !$guard->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'    => 'required|email',
            'password' => 'required',
        ];
    }

}
