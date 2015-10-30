<?php

namespace StudentInfo\Http\Controllers;

use Illuminate\Http\Request;

use StudentInfo\Http\Requests;
use StudentInfo\Http\Controllers\Controller;
use StudentInfo\Repositories\DoctrineUserRepository;
use StudentInfo\Repositories\UserRepositoryInterface;
use StudentInfo\ValueObjects\Email;

class AuthController extends ApiController
{
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email.required' => 'email required',
            'password.required'  => 'password required',
        ];
    }

    /**
     * @param UserRepositoryInterface $repository
     */
    public function authorize (UserRepositoryInterface $repository)
    {
        $repository->findByEmail(new Email('nebojsa@gmail.com'));
    }
}
