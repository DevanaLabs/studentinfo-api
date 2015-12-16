<?php

namespace StudentInfo\Http\Controllers;


use Illuminate\Contracts\Auth\Guard;
use StudentInfo\Repositories\ClassroomRepositoryInterface;
use StudentInfo\Repositories\GroupRepositoryInterface;
use StudentInfo\Repositories\TeacherRepositoryInterface;

class DataController extends ApiController
{
    /**
     * @var ClassroomRepositoryInterface
     */
    protected $classroomRepository;

    /**
     * @var TeacherRepositoryInterface
     */
    protected $teacherRepository;

    /**
     * @var GroupRepositoryInterface
     */
    protected $groupRepository;

    /**
     * @var Guard
     */
    protected $guard;

    /**
     * CourseController constructor.
     * @param ClassroomRepositoryInterface $classroomRepository
     * @param TeacherRepositoryInterface   $teacherRepository
     * @param GroupRepositoryInterface     $groupRepository
     * @param Guard                        $guard
     */
    public function __construct(ClassroomRepositoryInterface $classroomRepository, TeacherRepositoryInterface $teacherRepository, GroupRepositoryInterface $groupRepository, Guard $guard)
    {
        $this->classroomRepository = $classroomRepository;
        $this->teacherRepository = $teacherRepository;
        $this->groupRepository     = $groupRepository;
        $this->guard               = $guard;
    }

    public function getData()
    {
        $teachers   = $this->teacherRepository->all(0, 2000);
        $groups     = $this->groupRepository->all(0, 2000);
        $classrooms = $this->classroomRepository->all(0, 2000);

        return $this->returnSuccess([
            'groups'     => $groups,
            'teachers' => $teachers,
            'classrooms' => $classrooms,
        ], [
            'display' => 'limited',
        ]);
    }


}