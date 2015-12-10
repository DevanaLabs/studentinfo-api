<?php


namespace StudentInfo\Http\Requests;



use Illuminate\Contracts\Auth\Guard;
use StudentInfo\Models\User;

class AddFromCSVRequest extends Request
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
        return ($user->hasPermissionTo('student.create')
            or $user->hasPermissionTo('professor.create')
            or $user->hasPermissionTo('classroom.create')
            or $user->hasPermissionTo('course.create'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $rules = [
            'import' => 'required|', //mimes:csv',
        ];
    }

    public function messages()
    {
        return [
            'import.required' => 'You must pick a file to upload.',
            'import.mimes'    => 'The file type must be .csv.'
        ];
    }

}