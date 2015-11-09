<?php
/**
 * Created by PhpStorm.
 * User: Nebojsa
 * Date: 11/6/2015
 * Time: 10:28 AM
 */

namespace StudentInfo\Http\Controllers;


use Illuminate\Contracts\Auth\Guard;
use StudentInfo\Http\Requests\AddStudentsRequest;
use StudentInfo\Models\Student;
use StudentInfo\Repositories\FacultyRepositoryInterface;
use StudentInfo\Repositories\StudentRepositoryInterface;
use StudentInfo\Repositories\UserRepositoryInterface;
use StudentInfo\ValueObjects\Email;
use StudentInfo\ValueObjects\Password;

class StudentController extends ApiController
{
    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * @var StudentRepositoryInterface
     */
    protected $studentRepository;

    /**
     * @var FacultyRepositoryInterface
     */
    protected $facultyRepository;

    /**
     * @var Guard
     */
    protected $guard;

    /**
     * StudentController constructor.
     * @param UserRepositoryInterface    $userRepository
     * @param StudentRepositoryInterface $studentRepository
     * @param Guard                      $guard
     */
    public function __construct(UserRepositoryInterface $userRepository, StudentRepositoryInterface $studentRepository, Guard $guard, FacultyRepositoryInterface $facultyRepository)
    {
        $this->userRepository = $userRepository;
        $this->studentRepository = $studentRepository;
        $this->facultyRepository = $facultyRepository;
        $this->guard          = $guard;
    }

    public function addStudents(AddStudentsRequest $request)
    {
        $students = $request->get('students');
        for ($count = 0; $count < count($students); $count++) {
            $student = new Student();
            $student->setFirstName($students[$count]['firstName']);
            $student->setLastName($students[$count]['lastName']);
            $student->setEmail(new Email($students[$count]['email']));
            $student->setIndexNumber($students[$count]['indexNumber']);
            $student->setYear($students[$count]['year']);
            $student->setPassword(new Password('password'));
            $student->generateRegisterToken();
            $student->setOrganisation($this->facultyRepository->find(3));
            if (!$this->userRepository->findByEmail(new Email($students[$count]['email']))) {
                $this->userRepository->create($student);
            }
        }
    }

    public function getStudents()
    {

        $students = $this->studentRepository->getAllStudentsForFaculty($this->facultyRepository->find($this->guard->user()->getOrganisation()->getId()));
        foreach ($students as $student) {
            dd($student);
           print_r($student);
        }

    }
}