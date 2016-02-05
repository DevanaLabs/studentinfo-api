<?php

namespace StudentInfo\Http\Requests\Update;

use StudentInfo\Http\Requests\Request;

class UpdateLectureRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return parent::checkIfHasPermission('lecture.update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'teacherId'   => 'required | integer',
            'courseId'    => 'required | integer',
            'classroomId' => 'required | integer',
            'type'        => 'required',
            'startsAt'    => 'required',
            'endsAt'      => 'required',
        ];
    }
}