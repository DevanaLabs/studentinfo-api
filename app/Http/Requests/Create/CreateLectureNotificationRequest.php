<?php

namespace StudentInfo\Http\Requests\Create;

use StudentInfo\Http\Requests\Request;

class CreateLectureNotificationRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return parent::checkIfHasPermission('notification.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'description' => 'required',
            'expiresAt'   => 'required',
            'lectureId'   => 'required',
        ];
    }
}