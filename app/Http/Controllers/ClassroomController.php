<?php

namespace StudentInfo\Http\Controllers;

use LucaDegasperi\OAuth2Server\Authorizer;
use StudentInfo\ErrorCodes\ClassroomErrorCodes;
use StudentInfo\Http\Requests\AddFromCSVRequest;
use StudentInfo\Http\Requests\Create\CreateClassroomRequest;
use StudentInfo\Http\Requests\StandardRequest;
use StudentInfo\Http\Requests\Update\UpdateClassroomRequest;
use StudentInfo\Models\Classroom;
use StudentInfo\Models\User;
use StudentInfo\Repositories\ClassroomRepositoryInterface;
use StudentInfo\Repositories\FacultyRepositoryInterface;
use StudentInfo\Repositories\UserRepositoryInterface;

class ClassroomController extends ApiController
{
    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * @var ClassroomRepositoryInterface $classroomRepository
     */
    protected $classroomRepository;

    /**
     * @var FacultyRepositoryInterface $facultyRepository
     */
    protected $facultyRepository;

    /**
     * @var UserRepositoryInterface
     */
    protected $userRepositoryInterface;

    /**
     * @var Authorizer
     */
    protected $authorizer;

    /**
     * StudentController constructor.
     * @param UserRepositoryInterface             $userRepository
     * @param ClassroomRepositoryInterface $classroomRepository
     * @param FacultyRepositoryInterface   $facultyRepository
     * @param UserRepositoryInterface             $userRepositoryInterface
     * @param Authorizer                          $authorizer
     */
    public function __construct(UserRepositoryInterface $userRepository, ClassroomRepositoryInterface $classroomRepository, FacultyRepositoryInterface $facultyRepository, UserRepositoryInterface $userRepositoryInterface, Authorizer $authorizer)
    {
        $this->userRepository = $userRepository;
        $this->classroomRepository = $classroomRepository;
        $this->facultyRepository   = $facultyRepository;
        $this->userRepositoryInterface = $userRepositoryInterface;
        $this->authorizer     = $authorizer;
    }

    public function createClassroom(CreateClassroomRequest $request, $faculty)
    {
        $name = $request->get('name');
        if ($this->classroomRepository->findByName($name)) {
            return $this->returnError(500, ClassroomErrorCodes::CLASSROOM_ALREADY_EXISTS);
        }
        $classroom = new Classroom();
        $classroom->setName($request->get('name'));
        $classroom->setDirections($request->get('directions'));
        $classroom->setFloor($request->get('floor'));
        $classroom->setOrganisation($this->userRepository->find($this->authorizer->getResourceOwnerId())->getOrganisation());

        $this->classroomRepository->create($classroom);

        return $this->returnSuccess([
            'classroom' => $classroom,
        ]);
    }

    public function retrieveClassroom(StandardRequest $request, $faculty, $id)
    {
        /** @var Classroom $classroom */
        $classroom = $this->classroomRepository->find($id);

        if ($classroom === null) {
            return $this->returnError(500, ClassroomErrorCodes::CLASSROOM_NOT_IN_DB);
        }

        if ($classroom->getOrganisation()->getSlug() != $faculty) {
            return $this->returnError(500, ClassroomErrorCodes::CLASSROOM_DOES_NOT_BELONG_TO_THIS_FACULTY);
        }

        $semester = $request->get('semester', 'current');
        $year     = $request->get('year', 'current');

        if (($semester == 'current') || ($year == 'current')) {
            $userId = $this->authorizer->getResourceOwnerId();
            /** @var User $user */
            $user = $this->userRepositoryInterface->find($userId);
            if ($semester == 'current') {
                $semester = $user->getOrganisation()->getSettings()->getSemester();
            }
            if ($year == 'current') {
                $year = $user->getOrganisation()->getSettings()->getYear();
            }
        } else {
            $semester = (int)$request->get('semester');
            $year     = (int)$request->get('year');
        }

        $lectures = [];
        foreach ($classroom->getLectures() as $lecture) {
            if (($lecture->getCourse()->getSemester() % 2 === $semester % 2) && ($lecture->getYear() === $year)) {
                $lectures[] = $lecture;
            }
        }
        $classroom->setLectures($lectures);

        return $this->returnSuccess([
            'classroom' => $classroom,
        ]);
    }

    public function retrieveClassrooms(StandardRequest $request, $faculty, $start = 0, $count = 2000)
    {
        /** @var Classroom[] $classrooms */
        $classrooms = $this->classroomRepository->all($faculty, $start, $count);

        $semester = $request->get('semester', 'current');
        $year     = $request->get('year', 'current');

        if (($semester == 'current') || ($year == 'current')) {
            $userId = $this->authorizer->getResourceOwnerId();
            /** @var User $user */
            $user = $this->userRepositoryInterface->find($userId);
            if ($semester == 'current') {
                $semester = $user->getOrganisation()->getSettings()->getSemester();
            }
            if ($year == 'current') {
                $year = $user->getOrganisation()->getSettings()->getYear();
            }
        } else {
            $semester = (int)$request->get('semester');
            $year     = (int)$request->get('year');
        }

        foreach ($classrooms as $classroom) {
            $lectures = [];
            foreach ($classroom->getLectures() as $lecture) {
                if (($lecture->getCourse()->getSemester() % 2 === $semester % 2) && ($lecture->getYear() === $year)) {
                    $lectures[] = $lecture;
                }
            }
            $classroom->setLectures($lectures);
        }

        return $this->returnSuccess($classrooms);
    }

    public function updateClassroom(UpdateClassroomRequest $request, $faculty, $id)
    {
        if ($this->classroomRepository->find($id) === null) {
            return $this->returnError(500, ClassroomErrorCodes::CLASSROOM_NOT_IN_DB);
        }

        /** @var  Classroom $classroom */
        $classroom = $this->classroomRepository->find($id);

        $classroom->setName($request->get('name'));
        $classroom->setDirections($request->get('directions'));
        $classroom->setFloor($request->get('floor'));

        $this->classroomRepository->update($classroom);

        return $this->returnSuccess([
            'classroom' => $classroom,
        ]);
    }

    public function deleteClassroom($faculty, $id)
    {
        $classroom = $this->classroomRepository->find($id);
        if ($classroom === null) {
            return $this->returnError(500, ClassroomErrorCodes::CLASSROOM_NOT_IN_DB);
        }
        $this->classroomRepository->destroy($classroom);

        return $this->returnSuccess();
    }

    public function addClassroomsFromCSV(AddFromCSVRequest $request, $faculty)
    {
        $handle = $request->file('import');

        $file_path = $handle->getPathname();
        $resource  = fopen($file_path, "r");

        $organisation = $this->userRepository->find($this->authorizer->getResourceOwnerId())->getOrganisation();

        while (($data = fgetcsv($resource, 1000, ",")) !== FALSE) {
            $name       = $data[0];
            $directions = $data[1];
            $floor      = $data[2];

            $classroom = new Classroom();
            $classroom->setName($name);
            $classroom->setDirections($directions);
            $classroom->setFloor($floor);
            $classroom->setOrganisation($organisation);

            $this->classroomRepository->create($classroom);
        }

        return $this->returnSuccess();
    }
}