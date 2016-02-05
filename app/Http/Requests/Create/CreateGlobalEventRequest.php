<?php

namespace StudentInfo\Http\Requests\Create;

use StudentInfo\Http\Requests\Request;

class CreateGlobalEventRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return parent::checkIfHasPermission('event.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type'     => 'required',
            'description' => 'required',
            'startsAt' => 'required',
            'endsAt'   => 'required',
        ];
    }
}
