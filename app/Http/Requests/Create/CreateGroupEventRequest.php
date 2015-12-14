<?php

namespace StudentInfo\Http\Requests\Create;


use Illuminate\Contracts\Auth\Guard;
use StudentInfo\Http\Requests\Request;
use StudentInfo\Models\User;

class CreateGroupEventRequest extends Request
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
        return ($user->hasPermissionTo('event.create'));

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type'        => 'required',
            'description' => 'required',
            'startsAt'    => 'required',
            'endsAt'      => 'required',
            'groupId'     => 'required',
            'classrooms'  => 'required|array',
        ];
    }
}
