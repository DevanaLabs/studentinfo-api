<?php

namespace StudentInfo\Http\Controllers;


use Illuminate\Contracts\Auth\Guard;
use StudentInfo\Repositories\ClassroomRepositoryInterface;
use StudentInfo\Repositories\GroupRepositoryInterface;
use StudentInfo\Repositories\ProfessorRepositoryInterface;

class DataController extends ApiController
{
    /**
     * @var ClassroomRepositoryInterface
     */
    protected $classroomRepository;

    /**
     * @var ProfessorRepositoryInterface
     */
    protected $professorRepository;

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
     * @param ProfessorRepositoryInterface $professorRepository
     * @param GroupRepositoryInterface     $groupRepository
     * @param Guard                        $guard
     */
    public function __construct(ClassroomRepositoryInterface $classroomRepository, ProfessorRepositoryInterface $professorRepository, GroupRepositoryInterface $groupRepository, Guard $guard)
    {
        $this->classroomRepository = $classroomRepository;
        $this->professorRepository = $professorRepository;
        $this->groupRepository     = $groupRepository;
        $this->guard               = $guard;
    }

    public function getData()
    {
        $professors = $this->professorRepository->all();
        $groups     = $this->groupRepository->all();
        $classrooms = $this->classroomRepository->all();

        return $this->returnSuccess([
            'groups'     => $groups,
            'professors' => $professors,
            'classrooms' => $classrooms,
        ]);
    }


}