<?php


namespace StudentInfo\Http\Requests;


use Illuminate\Contracts\Auth\Guard;
use StudentInfo\Models\User;

class AddImageRequest extends Request
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
        return ($user->hasPermissionTo('image.add'));

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'import' => 'required|mimes:jpeg,bmp,png'
        ];
    }

    public function messages()
    {
        return [
            'import.required' => 'You must pick a file to upload.',
            'import.mimes'    => 'Not a valid file type. Valid types include jpeg, bmp and png.'
        ];
    }
}