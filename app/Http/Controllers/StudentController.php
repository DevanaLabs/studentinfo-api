<?php

namespace StudentInfo\Http\Controllers;

use LucaDegasperi\OAuth2Server\Authorizer;
use StudentInfo\ErrorCodes\StudentErrorCodes;
use StudentInfo\ErrorCodes\UserErrorCodes;
use StudentInfo\Http\Requests\AddFromCSVRequest;
use StudentInfo\Http\Requests\Create\CreateStudentRequest;
use StudentInfo\Http\Requests\Update\UpdateStudentRequest;
use StudentInfo\Models\Course;
use StudentInfo\Models\Lecture;
use StudentInfo\Models\Student;
use StudentInfo\Models\User;
use StudentInfo\Repositories\FacultyRepositoryInterface;
use StudentInfo\Repositories\LectureRepositoryInterface;
use StudentInfo\Repositories\StudentRepositoryInterface;
use StudentInfo\Repositories\UserRepositoryInterface;
use StudentInfo\ValueObjects\Email;
use StudentInfo\ValueObjects\Password;

/**
 * Class StudentController
 * @package StudentInfo\Http\Controllers
 */
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
     * @var Authorizer
     */
    protected $authorizer;

    /**
     * StudentController constructor.
     * @param UserRepositoryInterface    $userRepository
     * @param StudentRepositoryInterface $studentRepository
     * @param FacultyRepositoryInterface $facultyRepository
     * @param LectureRepositoryInterface $lectureRepository
     * @param Authorizer                 $authorizer
     */
    public function __construct(UserRepositoryInterface $userRepository, StudentRepositoryInterface $studentRepository, FacultyRepositoryInterface $facultyRepository, LectureRepositoryInterface $lectureRepository, Authorizer $authorizer)
    {
        $this->userRepository    = $userRepository;
        $this->studentRepository = $studentRepository;
        $this->facultyRepository = $facultyRepository;
        $this->lectureRepository = $lectureRepository;
        $this->authorizer = $authorizer;
    }

    /**
     * @param CreateStudentRequest $request
     * @return \Illuminate\Http\Response
     */
    public function createStudent(CreateStudentRequest $request, $faculty)
    {
        /** @var Email $email */
        $email = new Email($request->get('email'));
        if ($this->userRepository->findByEmail($email)) {
            return $this->returnError(500, UserErrorCodes::NOT_UNIQUE_EMAIL);
        }

        $indexNumber = $request->get('indexNumber');
        if ($this->studentRepository->findByIndexNumber($indexNumber)) {
            return $this->returnError(500, StudentErrorCodes::STUDENT_NOT_UNIQUE_INDEX);
        }

        $lecturesEntry = $request->get('lectures');
        $lectures      = [];
        $courses = [];

        for ($i = 0; $i < count($lecturesEntry); $i++) {
            /** @var Lecture $lecture */
            $lecture = $this->lectureRepository->find($lecturesEntry[$i]);
            if ($lecture === null) {
                continue;
            }
            $lectures[] = $lecture;
            /** @var Course $course */
            $course = $lecture->getCourse();
            if (!in_array($course, $courses)) {
                $courses[] = $course;
            }
        }

        $student = new Student();
        $student->setFirstName($request->get('firstName'));
        $student->setLastName($request->get('lastName'));
        $student->setEmail($email);
        $student->setIndexNumber($indexNumber);
        $student->setYear($request->get('year'));
        $student->setLectures($lectures);
        $student->setCourses($courses);
        $student->setPassword(new Password('password'));
        $student->generateRegisterToken();
        $student->setOrganisation($this->userRepository->find($this->authorizer->getResourceOwnerId())->getOrganisation());

        $this->studentRepository->create($student);

        return $this->returnSuccess([
            'student' => $student,
        ]);
    }

    public function retrieveStudent($faculty, $id)
    {
        $student = $this->studentRepository->find($id);

        if ($student === null) {
            return $this->returnError(500, StudentErrorCodes::STUDENT_NOT_IN_DB);
        }

        if ($student->getOrganisation()->getSlug() != $faculty) {
            return $this->returnError(500, StudentErrorCodes::STUDENT_DOES_NOT_BELONG_TO_THIS_FACULTY);
        }

        return $this->returnSuccess([
            'student' => $student,
        ]);
    }

    public function retrieveStudents($faculty, $start = 0, $count = 2000)
    {
        $students = $this->studentRepository->all($faculty, $start, $count);

        return $this->returnSuccess($students);
    }

    public function updateStudent(UpdateStudentRequest $request, $faculty, $id)
    {
        if ($this->studentRepository->find($id) === null) {
            return $this->returnError(500, StudentErrorCodes::STUDENT_NOT_IN_DB);
        }

        $email = new Email($request->get('email'));

        /** @var  User $user */
        $user = $this->userRepository->findByEmail($email);
        if ($user) {
            if ($user->getId() != $id) {
                return $this->returnError(500, UserErrorCodes::NOT_UNIQUE_EMAIL);
            }
        }

        /** @var  Student $student */
        $student = $this->studentRepository->find($id);

        $indexNumber = $request->get('indexNumber');

        if ($this->studentRepository->findByIndexNumber($indexNumber)) {
            if ($user->getId() != $id) {
                return $this->returnError(500, StudentErrorCodes::STUDENT_NOT_UNIQUE_INDEX);
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
        $student->setOrganisation($this->userRepository->find($this->authorizer->getResourceOwnerId())->getOrganisation());

        $this->studentRepository->update($student);

        return $this->returnSuccess([
            'student' => $student,
        ]);
    }

    public function deleteStudent($faculty, $id)
    {
        $student = $this->studentRepository->find($id);

        if ($student === null) {
            return $this->returnError(500, StudentErrorCodes::STUDENT_NOT_IN_DB);
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
        $firstNameIndex   = $request->get('firstNameIndex');
        $lastNameIndex    = $request->get('lastNameIndex');
        $emailIndex       = $request->get('emailIndex');
        $indexNumberIndex = $request->get('indexNumberIndex');
        $yearIndex        = $request->get('yearIndex');
        if (($firstNameIndex === null) or ($lastNameIndex === null) or ($emailIndex === null) or ($indexNumberIndex === null)
            or ($yearIndex === null)
        ) {
            $firstNameIndex = 0;
            $lastNameIndex  = 1;
            $emailIndex = 2;
            $indexNumberIndex = 3;
            $yearIndex      = 4;
        }
        $handle = $request->file('import');

        $file_path = $handle->getPathname();
        $resource  = fopen($file_path, "r");

        $organisation = $this->userRepository->find($this->authorizer->getResourceOwnerId())->getOrganisation();

        while (($data = fgetcsv($resource, 1000, ",")) !== FALSE) {
            $firstName = $data[$firstNameIndex];
            $lastName  = $data[$lastNameIndex];

            /** @var Email $email */
            $email       = new Email($data[$emailIndex]);
            $indexNumber = $data[$indexNumberIndex];
            $year        = $data[$yearIndex];

            if ($this->userRepository->findByEmail($email)) {
                return $this->returnError(500, UserErrorCodes::NOT_UNIQUE_EMAIL, $email->getEmail());
            }

            if ($this->studentRepository->findByIndexNumber($indexNumber)) {
                return $this->returnError(500, StudentErrorCodes::STUDENT_NOT_UNIQUE_INDEX);
            }

            $student = new Student();
            $student->setFirstName($firstName);
            $student->setLastName($lastName);
            $student->setEmail($email);
            $student->setIndexNumber($indexNumber);
            $student->setYear($year);
            $student->setPassword(new Password('password'));
            $student->setOrganisation($organisation);

            $this->studentRepository->persist($student);
        }
        $this->studentRepository->flush();

        return $this->returnSuccess();
    }
}