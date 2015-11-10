<?php

namespace StudentInfo\Http\Controllers;

use Illuminate\Auth\Guard;
use StudentInfo\Http\Requests\AddClassroomRequest;
use StudentInfo\Models\Classroom;
use StudentInfo\Repositories\ClassroomRepositoryInterface;
use StudentInfo\Repositories\DoctrineClassroomRepository;

class ClassroomController extends ApiController
{
    /**
     * @var DoctrineClassroomRepository $classroomRepository
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
        $classrooms = $request->get('classrooms');
        $added_classrooms = [];
        for ($count = 0; $count < count($classrooms); $count++) {
            $classroom = new Classroom();
            $classroom->setName($classrooms[$count]['name']);
            $classroom->setDirections($classrooms[$count]['directions']);
            $this->classroomRepository->create($classroom);
            $added_classrooms[]=$classroom;
        }
        return $this->returnSuccess([
            'classrooms' => $added_classrooms
        ]);

    }

    public function getClassrooms()
    {
        $classrooms = $this->classroomRepository->all();
        foreach ($classrooms as $classroom) {
            print_r($classroom);
        }
    }
}