<?php

namespace StudentInfo\Http\Requests\Update;

use Illuminate\Contracts\Auth\Guard;
use StudentInfo\Http\Requests\Request;
use StudentInfo\Models\User;

class UpdateClassroomRequest extends Request
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
        return ($user->hasPermissionTo('classroom.update'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $rules = [
            'name'       => 'required',
            'directions' => 'required',
            'floor'      => 'required',
        ];
    }
}