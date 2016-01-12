<?php

namespace StudentInfo\Http\Controllers;

use Illuminate\Auth\Guard;
use StudentInfo\ErrorCodes\ClassroomErrorCodes;
use StudentInfo\ErrorCodes\FacultyErrorCodes;
use StudentInfo\Http\Requests\AddFromCSVRequest;
use StudentInfo\Http\Requests\Create\CreateClassroomRequest;
use StudentInfo\Http\Requests\Update\UpdateClassroomRequest;
use StudentInfo\Models\Classroom;
use StudentInfo\Repositories\ClassroomRepositoryInterface;
use StudentInfo\Repositories\FacultyRepositoryInterface;

class ClassroomController extends ApiController
{
    /**
     * @var ClassroomRepositoryInterface $classroomRepository
     */
    protected $classroomRepository;

    /**
     * @var FacultyRepositoryInterface $facultyRepository
     */
    protected $facultyRepository;

    /**
     * @var Guard
     */
    protected $guard;

    /**
     * StudentController constructor.
     * @param ClassroomRepositoryInterface $classroomRepository
     * @param FacultyRepositoryInterface   $facultyRepository
     * @param Guard                        $guard
     */
    public function __construct(ClassroomRepositoryInterface $classroomRepository, FacultyRepositoryInterface $facultyRepository, Guard $guard)
    {
        $this->classroomRepository = $classroomRepository;
        $this->facultyRepository   = $facultyRepository;
        $this->guard               = $guard;
    }

    public function createClassroom(CreateClassroomRequest $request)
    {
        $name = $request->get('name');
        if ($this->classroomRepository->findByName($name)) {
            return $this->returnError(500, ClassroomErrorCodes::CLASSROOM_ALREADY_EXISTS);
        }
        $classroom = new Classroom();
        $classroom->setName($request->get('name'));
        $classroom->setDirections($request->get('directions'));
        $classroom->setFloor($request->get('floor'));
        $classroom->setOrganisation($this->guard->user()->getOrganisation());

        $this->classroomRepository->create($classroom);

        return $this->returnSuccess([
            'classroom' => $classroom,
        ]);
    }

    public function retrieveClassroom($faculty, $id)
    {
        $classroom = $this->classroomRepository->find($id);

        if ($classroom === null) {
            return $this->returnError(500, ClassroomErrorCodes::CLASSROOM_NOT_IN_DB);
        }

        if ($classroom->getOrganisation()->getSlug() != $faculty) {
            return $this->returnError(500, ClassroomErrorCodes::ClASSROOM_DOES_NOT_BELONG_TO_THIS_FACULTY);
        }

        return $this->returnSuccess([
            'classroom' => $classroom,
        ]);
    }

    public function retrieveClassrooms($faculty, $start = 0, $count = 2000)
    {
        $classrooms = $this->classroomRepository->all($faculty, $start, $count);

        return $this->returnSuccess($classrooms);
    }

    public function updateClassroom(UpdateClassroomRequest $request, $id)
    {
        if ($this->classroomRepository->find($id) === null) {
            return $this->returnError(500, ClassroomErrorCodes::CLASSROOM_NOT_IN_DB);
        }

        /** @var  Classroom $classroom */
        $classroom = $this->classroomRepository->find($id);

        $classroom->setName($request->get('name'));
        $classroom->setDirections($request->get('directions'));
        $classroom->setFloor($request->get('floor'));
        $classroom->setOrganisation($this->guard->user()->getOrganisation());

        $this->classroomRepository->update($classroom);

        return $this->returnSuccess([
            'classroom' => $classroom,
        ]);
    }

    public function deleteClassroom($id)
    {
        $classroom = $this->classroomRepository->find($id);
        if ($classroom === null) {
            return $this->returnError(500, ClassroomErrorCodes::CLASSROOM_NOT_IN_DB);
        }
        $this->classroomRepository->destroy($classroom);

        return $this->returnSuccess();
    }

    public function addClassroomsFromCSV(AddFromCSVRequest $request)
    {
        $handle = $request->file('import');

        $file_path = $handle->getPathname();
        $resource  = fopen($file_path, "r");
        while (($data = fgetcsv($resource, 1000, ",")) !== FALSE) {
            $name       = $data[0];
            $directions = $data[1];
            $floor      = $data[2];

            $classroom = new Classroom();
            $classroom->setName($name);
            $classroom->setDirections($directions);
            $classroom->setFloor($floor);
            $classroom->setOrganisation($this->guard->user()->getOrganisation());

            $this->classroomRepository->create($classroom);
        }

        return $this->returnSuccess();
    }
}