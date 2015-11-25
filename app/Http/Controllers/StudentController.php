<?php

namespace StudentInfo\Http\Controllers;


use Illuminate\Contracts\Auth\Guard;
use StudentInfo\ErrorCodes\UserErrorCodes;
use StudentInfo\Http\Requests\AddStudentsRequest;
use StudentInfo\Http\Requests\Request;
use StudentInfo\Http\Requests\SetGetLecturesRequest;
use StudentInfo\Http\Requests\GetStudentRequest;
use StudentInfo\Models\Student;
use StudentInfo\Repositories\FacultyRepositoryInterface;
use StudentInfo\Repositories\LectureRepositoryInterface;
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
     * @var LectureRepositoryInterface
     */
    protected $lectureRepository;

    /**
     * @var Guard
     */
    protected $guard;

    /**
     * StudentController constructor.
     * @param UserRepositoryInterface    $userRepository
     * @param StudentRepositoryInterface $studentRepository
     * @param FacultyRepositoryInterface $facultyRepository
     * @param LectureRepositoryInterface $lectureRepository
     * @param Guard                      $guard
     */
    public function __construct(UserRepositoryInterface $userRepository, StudentRepositoryInterface $studentRepository, FacultyRepositoryInterface $facultyRepository, LectureRepositoryInterface $lectureRepository, Guard $guard)
    {
        $this->userRepository = $userRepository;
        $this->studentRepository = $studentRepository;
        $this->facultyRepository = $facultyRepository;
        $this->lectureRepository = $lectureRepository;
        $this->guard          = $guard;
    }

    public function addStudent(AddStudentsRequest $request)
    {
        /** @var Email $email */
        $email = new Email($request->get('email'));
        if ($this->userRepository->findByEmail($email))
        {
            return $this->returnError(500, UserErrorCodes::STUDENT_NOT_UNIQUE_EMAIL);
        }
        $indexNumber = $request->get('indexNumber');
        if ($this->studentRepository->findByIndexNumber($indexNumber))
        {
            return $this->returnError(500, UserErrorCodes::STUDENT_NOT_UNIQUE_INDEX);
        }
        $student = new Student();
        $student->setFirstName($request->get('firstName'));
        $student->setLastName($request->get('lastName'));
        $student->setEmail($email);
        $student->setIndexNumber($indexNumber);
        $student->setYear($request->get('year'));
        $student->setPassword(new Password('password'));
        $student->generateRegisterToken();
        $student->setOrganisation($this->facultyRepository->findFacultyByName('Racunarski fakultet'));
        $this->userRepository->create($student);

        return $this->returnSuccess([
            'student' => $student
        ]);
    }

    public function getStudent($id)
    {
        $student = $this->studentRepository->find($id);

        if($student === null){
            return $this->returnError(500, UserErrorCodes::STUDENT_NOT_IN_DB);
        }

        return $this->returnSuccess([
            'student' => $student
        ]);

    }

    public function getStudents($start = 0, $count = 20)
    {
        $students = $this->studentRepository->getAllStudentsForFaculty($this->facultyRepository->findFacultyByName($this->guard->user()->getOrganisation()->getName()), $start, $count);

        return $this->returnSuccess($students);

    }

    public function deleteStudent($id)
    {

        $student = $this->studentRepository->find($id);
        if ($student=== null) {
            return $this->returnError(500, UserErrorCodes::STUDENT_NOT_IN_DB);
        }
        $this->studentRepository->destroy($student);

        return $this->returnSuccess();
    }

    public function chooseLectures(SetGetLecturesRequest $request)
    {
        $ids = $request->get('ids');

        $addedLectures = [];

        $failedToAddLectures = [];

        foreach ($ids as $id) {
            $lecture = $this->lectureRepository->find($id);
            if ($lecture === null) {
                $failedToAddLectures[] = $id;
                continue;
            }
            $addedLectures[] = $lecture;
        }
        /** @var Student $student */
        $student = $this->studentRepository->find($this->guard->user()->getId());

        $student->setLectures($addedLectures);

        $this->studentRepository->update($student);

        return $this->returnSuccess([
            'successful'   => $addedLectures,
            'unsuccessful' => $failedToAddLectures,
        ]);
    }

    public function showMyLectures(SetGetLecturesRequest $request)
    {
        $lecture = [];

        /** @var Student $student */
        $student = $this->studentRepository->find($this->guard->user()->getId());

        for($i = 0; $i < count($student->getLectures()); $i++){
            $lecture[] = $student->getLectures()[$i];
        }

        return $this->returnSuccess($lecture);
    }
}