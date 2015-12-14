<?php

namespace StudentInfo\Http\Requests\Create;


use Illuminate\Contracts\Auth\Guard;
use StudentInfo\Http\Requests\Request;
use StudentInfo\Models\User;

class CreateLectureRequest extends Request
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
        return ($user->hasPermissionTo('lecture.create'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'teacherId' => 'required | integer',
            'courseId'    => 'required | integer',
            'classroomId' => 'required | integer',
            'type'        => 'required',
            'startsAt'    => 'required',
            'endsAt'      => 'required',
        ];
    }
}