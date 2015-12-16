<?php

namespace StudentInfo\Http\Controllers;


use Illuminate\Contracts\Auth\Guard;
use StudentInfo\ErrorCodes\UserErrorCodes;
use StudentInfo\Http\Requests\AddFromCSVRequest;
use StudentInfo\Http\Requests\Create\CreateStudentRequest;
use StudentInfo\Http\Requests\Update\UpdateStudentRequest;
use StudentInfo\Models\Student;
use StudentInfo\Models\User;
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
        $this->userRepository    = $userRepository;
        $this->studentRepository = $studentRepository;
        $this->facultyRepository = $facultyRepository;
        $this->lectureRepository = $lectureRepository;
        $this->guard             = $guard;
    }

    public function createStudent(CreateStudentRequest $request)
    {
        /** @var Email $email */
        $email = new Email($request->get('email'));
        if ($this->userRepository->findByEmail($email)) {
            return $this->returnError(500, UserErrorCodes::NOT_UNIQUE_EMAIL);
        }

        $indexNumber = $request->get('indexNumber');
        if ($this->studentRepository->findByIndexNumber($indexNumber)) {
            return $this->returnError(500, UserErrorCodes::STUDENT_NOT_UNIQUE_INDEX);
        }

        $lecturesEntry = $request->get('lectures');
        $lectures      = [];

        for ($i = 0; $i < count($lecturesEntry); $i++) {
            $lecture = $this->lectureRepository->find($lecturesEntry[$i]);
            if ($lecture === null) {
                continue;
            }
            $lectures[] = $lecture;
        }

        $student = new Student();
        $student->setFirstName($request->get('firstName'));
        $student->setLastName($request->get('lastName'));
        $student->setEmail($email);
        $student->setIndexNumber($indexNumber);
        $student->setYear($request->get('year'));
        $student->setLectures($lectures);
        $student->setPassword(new Password('password'));
        $student->generateRegisterToken();
        $student->setOrganisation($this->facultyRepository->findFacultyByName($this->guard->user()->getOrganisation()->getName()));

        $this->studentRepository->create($student);

        return $this->returnSuccess([
            'student' => $student,
        ]);
    }

    public function retrieveStudent($id)
    {
        $student = $this->studentRepository->find($id);

        if ($student === null) {
            return $this->returnError(500, UserErrorCodes::STUDENT_NOT_IN_DB);
        }

        return $this->returnSuccess([
            'student' => $student,
        ], [
            'display' => 'limited',
        ]);

    }

    public function retrieveStudents($start = 0, $count = 20)
    {
        $students = $this->studentRepository->getAllStudentsForFaculty($this->facultyRepository->findFacultyByName($this->guard->user()->getOrganisation()->getName()), $start, $count);

        return $this->returnSuccess($students);
    }

    public function updateStudent(UpdateStudentRequest $request, $id)
    {
        if ($this->studentRepository->find($id) === null) {
            return $this->returnError(500, UserErrorCodes::STUDENT_NOT_IN_DB);
        }

        /** @var  Student $student */
        $student = $this->studentRepository->find($id);

        $email = new Email($request->get('email'));

        /** @var  User $user */
        $user = $this->userRepository->findByEmail($email);
        if ($user) {
            if ($user->getId() != $id) {
                return $this->returnError(500, UserErrorCodes::NOT_UNIQUE_EMAIL);
            }
        }

        $indexNumber = $request->get('indexNumber');

        if ($this->studentRepository->findByIndexNumber($indexNumber)) {
            if ($user->getId() != $id) {
                return $this->returnError(500, UserErrorCodes::STUDENT_NOT_UNIQUE_INDEX);
            }
        }

        $lecturesEntry = $request->get('lectures');
        $lectures      = [];

        for ($i = 0; $i < count($lecturesEntry); $i++) {
            $lecture = $this->lectureRepository->find($lecturesEntry[$i]);
            if ($lecture === null) {
                continue;
            }
            $lectures[] = $lecture;
        }

        $student->setFirstName($request->get('firstName'));
        $student->setLastName($request->get('lastName'));
        $student->setEmail($email);
        $student->setIndexNumber($indexNumber);
        $student->setLectures($lectures);
        $student->setYear($request->get('year'));

        $this->studentRepository->update($student);

        return $this->returnSuccess([
            'student' => $student,
        ]);
    }

    public function deleteStudent($id)
    {

        $student = $this->studentRepository->find($id);
        if ($student === null) {
            return $this->returnError(500, UserErrorCodes::STUDENT_NOT_IN_DB);
        }
        $this->studentRepository->destroy($student);

        return $this->returnSuccess();
    }

    /**
     * @param AddFromCSVRequest $request
     * @return \Illuminate\Http\Response
     */
    public function addStudentsFromCSV(AddFromCSVRequest $request)
    {
        $addedStudents       = [];
        $failedToAddStudents = [];
        $firstNameIndex      = $request->get('firstNameIndex');
        $lastNameIndex       = $request->get('lastNameIndex');
        $emailIndex          = $request->get('emailIndex');
        $indexNumberIndex    = $request->get('indexNumberIndex');
        $yearIndex           = $request->get('yearIndex');
        if (($firstNameIndex === null) or ($lastNameIndex === null) or ($emailIndex === null) or ($indexNumberIndex === null)
        or ($yearIndex === null)) {
            $firstNameIndex = 0;
            $lastNameIndex = 1;
            $emailIndex = 2;
            $indexNumberIndex = 3;
            $yearIndex = 4;
        }
        $handle = $request->file('import');

        $file_path = $handle->getPathname();
        $resource  = fopen($file_path, "r");
        while (($data = fgetcsv($resource, 1000, ",")) !== FALSE) {
            $firstName = $data[$firstNameIndex];
            $lastName  = $data[$lastNameIndex];

            /** @var Email $email */
            $email       = new Email($data[$emailIndex]);
            $indexNumber = $data[$indexNumberIndex];
            $year        = $data[$yearIndex];

            if ($this->userRepository->findByEmail($email)) {
                $failedToAddStudents[] = $email;
                continue;
            }
            if ($this->studentRepository->findByIndexNumber($indexNumber)) {
                $failedToAddStudents[] = $email;
                continue;
            }
            $student = new Student();
            $student->setFirstName($firstName);
            $student->setLastName($lastName);
            $student->setEmail($email);
            $student->setIndexNumber($indexNumber);
            $student->setYear($year);
            $student->setPassword(new Password('password'));
            $student->generateRegisterToken();
            $student->setOrganisation($this->facultyRepository->findFacultyByName('Racunarski fakultet'));
            $this->userRepository->create($student);

            $addedStudents[] = $student;
        }

        return $this->returnSuccess([
            "successful"   => $addedStudents,
            "unsuccessful" => $failedToAddStudents,
        ]);

    }
}