<?php

namespace StudentInfo\Http\Controllers;

use Illuminate\Auth\Guard;
use StudentInfo\Http\Requests\AddClassroomRequest;
use StudentInfo\Http\Requests\DeleteClassroomRequest;
use StudentInfo\Http\Requests\EditClassroomRequest;
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

    public function addClassrooms(AddClassroomRequest $request)
    {
        $addedClassrooms = Classroom::addClassrooms($this->classroomRepository, $request->get('classrooms'));

        return $this->returnSuccess([
            'classrooms' => $addedClassrooms
        ]);
    }

    public function getClassrooms()
    {
        $classrooms = $this->classroomRepository->all();

        return $this->returnSuccess($classrooms);
//        foreach ($classrooms as $classroom) {
//            print_r($classroom);
//        }
    }

    public function getEditClassroom($id)
    {
        return $this->returnSuccess([
            'classroom' => $classroom = $this->classroomRepository->find($id)
        ]);
    }

    public function putEditClassroom(EditClassroomRequest $request, $id)
    {
        $classroom = Classroom::editClassrooms($request, $this->classroomRepository, $id);

        return $this->returnSuccess([
            'classroom' => $classroom
        ]);
    }

    public function deleteClassrooms(DeleteClassroomRequest $request)
    {
        $ids = $request->get('ids');
        $deletedClassrooms = [];

        foreach($ids as $id)
        {
            $classroom = $this->classroomRepository->find($id);
            if ($classroom === null)
            {
                continue;
            }
            $this->classroomRepository->destroy($classroom);
            $deletedClassrooms[] = $id;
        }
        return $this->returnSuccess([
                'deletedClassrooms' => $deletedClassrooms
            ]
        );
    }
}