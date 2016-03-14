<?php

namespace StudentInfo\Http\Requests\Create;

use StudentInfo\Http\Requests\Request;

class CreateLectureRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return parent::checkIfHasPermission('lecture.create');
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
            'year' => 'required',
            'startsAt'    => 'required',
            'endsAt'      => 'required',
        ];
    }
}