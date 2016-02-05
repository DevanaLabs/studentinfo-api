<?php

namespace StudentInfo\Http\Requests\Update;

use StudentInfo\Http\Requests\Request;

class UpdateStudentRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return parent::checkIfHasPermission('student.update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $rules = [
            'email'       => 'required',
            'firstName'   => 'required',
            'lastName'    => 'required',
            'indexNumber' => 'required',
            'year'        => 'required',
            'lectures' => 'array',
        ];
    }
}