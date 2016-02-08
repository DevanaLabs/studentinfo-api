<?php

namespace StudentInfo\Http\Requests\Update;

use StudentInfo\Http\Requests\Request;

class UpdateLectureNotificationRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return parent::checkIfHasPermission('notification.update');
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
        ];
    }
}