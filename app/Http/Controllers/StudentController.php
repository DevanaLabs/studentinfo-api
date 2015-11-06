<?php
/**
 * Created by PhpStorm.
 * User: Nebojsa
 * Date: 11/6/2015
 * Time: 10:28 AM
 */

namespace StudentInfo\Http\Controllers;


use StudentInfo\Http\Requests\AddStudentsRequest;
use StudentInfo\Models\Student;
use StudentInfo\Repositories\UserRepositoryInterface;
use StudentInfo\ValueObjects\Email;
use StudentInfo\ValueObjects\Password;

class StudentController extends ApiController
{
    /**
     * @var UserRepositoryInterface
     */
    protected $repository;


    /**
     * StudentController constructor.
     * @param UserRepositoryInterface $repository
     */
    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function addStudents(AddStudentsRequest $request)
    {
        $students = $request->get('students');
        for($count=0; $count < count($students); $count++)
        {
            $student = new Student();
            $student->setFirstName($students[$count]['firstName']);
            $student->setLastName($students[$count]['lastName']);
            $student->setEmail(new Email($students[$count]['email']));
            $student->setIndexNumber($students[$count]['indexNumber']);
            $student->setPassword(new Password('password'));
            $student->generateRegisterToken();
            if (!$this->repository->findByEmail(new Email($students[$count]['email'])))
            {
                $this->repository->create($student);
            }
        }
    }

    public function getStudents()
    {
        $students = $this->repository->getAllStudents();
        foreach($students as $student){
            print_r($student);
        }
    }
}