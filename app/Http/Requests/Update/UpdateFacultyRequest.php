<?php

namespace StudentInfo\Http\Requests\Update;

use StudentInfo\Http\Requests\Request;

class UpdateFacultyRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return parent::checkIfHasPermission('faculty.update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'       => 'required',
            'university' => 'required',
            'slug'       => 'required',
            'language'   => 'required',
            'semester'   => 'required',
            'year'       => 'required',
        ];
    }
}