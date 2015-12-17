<?php

namespace StudentInfo\Http\Controllers;

use Illuminate\Auth\Guard;
use StudentInfo\ErrorCodes\UserErrorCodes;
use StudentInfo\Http\Requests\AddFromCSVRequest;
use StudentInfo\Http\Requests\Create\CreateClassroomRequest;
use StudentInfo\Http\Requests\Update\UpdateClassroomRequest;
use StudentInfo\Models\Classroom;
use StudentInfo\Repositories\ClassroomRepositoryInterface;

class ClassroomController extends ApiController
{
    /**
     * @var ClassroomRepositoryInterface $classroomRepository
     */
    protected $classroomRepository;

    /**
     * @var Guard
     */
    protected $guard;

    /**
     * StudentController constructor.
     * @param ClassroomRepositoryInterface $classroomRepository
     * @param Guard                        $guard
     */
    public function __construct(ClassroomRepositoryInterface $classroomRepository, Guard $guard)
    {
        $this->classroomRepository = $classroomRepository;
        $this->guard               = $guard;
    }

    public function createClassroom(CreateClassroomRequest $request)
    {
        $name = $request->get('name');
        if ($this->classroomRepository->findByName($name)) {
            return $this->returnError(500, UserErrorCodes::CLASSROOM_ALREADY_EXISTS);
        }
        $classroom = new Classroom();
        $classroom->setName($request->get('name'));
        $classroom->setDirections($request->get('directions'));
        $classroom->setFloor($request->get('floor'));

        $this->classroomRepository->create($classroom);

        return $this->returnSuccess([
            'classroom' => $classroom,
        ]);
    }

    public function retrieveClassroom($id)
    {
        $classroom = $this->classroomRepository->find($id);

        if ($classroom === null) {
            return $this->returnError(500, UserErrorCodes::CLASSROOM_NOT_IN_DB);
        }

        return $this->returnSuccess([
            'classroom' => $classroom,
        ]);
    }

    public function retrieveClassrooms($start = 0, $count = 2000)
    {
        $classrooms = $this->classroomRepository->all($start, $count);

        return $this->returnSuccess($classrooms);
    }

    public function updateClassroom(UpdateClassroomRequest $request, $id)
    {
        if ($this->classroomRepository->find($id) === null) {
            return $this->returnError(500, UserErrorCodes::CLASSROOM_NOT_IN_DB);
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

    public function deleteClassroom($id)
    {
        $classroom = $this->classroomRepository->find($id);
        if ($classroom === null) {
            return $this->returnError(500, UserErrorCodes::CLASSROOM_NOT_IN_DB);
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

            $this->classroomRepository->create($classroom);
        }

        return $this->returnSuccess();
    }
}