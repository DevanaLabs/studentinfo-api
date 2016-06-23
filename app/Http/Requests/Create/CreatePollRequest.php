<?php namespace StudentInfo\Http\Requests\Create;

use StudentInfo\Http\Requests\Request;

class CreatePollRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->checkIfHasPermission('poll.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'question'       => 'required',
            'answers'       => 'required|array',
        ];
    }
}