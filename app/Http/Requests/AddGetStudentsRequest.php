<?php


namespace StudentInfo\Http\Requests;


use Illuminate\Contracts\Auth\Guard;
use StudentInfo\Models\User;

class AddGetStudentsRequest extends Request
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
        return ($user->hasPermissionTo('user.create'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
//        return [
//            'students' => 'array|required'
//        ];

//        return [
//            'students.email.1' => 'required',
//            'students.firstName.1' => 'required',
//            'students.lastName.1' => 'required',
//            'students.indexNumber.1' => 'required',
//            'students.year.1' => 'required'
//        ];
        $rules = [
            'students' => 'array|required'
        ];

//        foreach($this->request->get('students') as $key => $val)
//        {
//            $rules['students.'.$key] = 'required';
//            var_dump($key);
//        }
        //dd($this->get('students')[0]['email']);
        //dd($rules['students[0][email]'] = 'required');
        //dd(count($this->get('students.email')));
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