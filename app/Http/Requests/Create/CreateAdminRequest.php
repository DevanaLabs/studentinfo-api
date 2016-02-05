<?php

namespace StudentInfo\Http\Requests\Create;

use StudentInfo\Http\Requests\Request;

class CreateAdminRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return parent::checkIfHasPermission('admin.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $rules = [
            'email'    => 'required',
            'firstName' => 'required',
            'lastName' => 'required',
        ];

    }
}