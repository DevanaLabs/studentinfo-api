<?php

namespace StudentInfo\Http\Requests;


use Illuminate\Contracts\Auth\Guard;
use StudentInfo\Models\User;

class AddFacultyRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @param Guard $guard
     * @return bool
     */
    public function authorize(Guard $guard)
    {
        /** @var User $user */
        $user = $guard->user();
        if ($user === null) {
            return false;
        }
        return ($user->hasPermissionTo('faculty.create'));

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'university' => 'required',
        ];
    }
}