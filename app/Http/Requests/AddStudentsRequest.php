<?php


namespace StudentInfo\Http\Requests;


use Illuminate\Contracts\Auth\Guard;
use StudentInfo\Models\User;

class AddStudentsRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @param Guard $guard
     * @return bool
     */
    public function authorize(Guard $guard)
    {
        /** @var User $user */
       $user = $guard->user();
       if ($user === null) {
            return false;
        }
        return ($user->hasPermissionTo('student.create'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'students' => 'array|required'
        ];

        for($i = 0; $i < count($this->get('students')); $i++){
            $rules['students.' . $i . '.email'] = 'required';
            $rules['students.' . $i . '.firstName'] = 'required';
            $rules['students.' . $i . '.lastName'] = 'required';
            $rules['students.' . $i . '.indexNumber'] = 'required';
            $rules['students.' . $i . '.year'] = 'required';
        }

        return $rules;
    }
}