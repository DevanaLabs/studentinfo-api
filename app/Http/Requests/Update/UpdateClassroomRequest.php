<?php

namespace StudentInfo\Http\Requests\Update;

use StudentInfo\Http\Requests\Request;

class UpdateClassroomRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return parent::checkIfHasPermission('classroom.update');
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
            'floor'      => 'required',
        ];
    }
}