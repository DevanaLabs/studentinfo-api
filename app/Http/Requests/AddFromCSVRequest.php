<?php


namespace StudentInfo\Http\Requests;

use LucaDegasperi\OAuth2Server\Authorizer;
use StudentInfo\Models\User;
use StudentInfo\Repositories\UserRepositoryInterface;

class AddFromCSVRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @param Authorizer              $authorizer
     * @param UserRepositoryInterface $userRepository
     * @return bool
     */
    public function authorize(Authorizer $authorizer, UserRepositoryInterface $userRepository)
    {
        $userId = $authorizer->getResourceOwnerId();
        /** @var User $user */
        $user = $userRepository->find($userId);
        if ($user === null) {
            return false;
        }
        return ($user->hasPermissionTo('student.create')
            or $user->hasPermissionTo('teacher.create')
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