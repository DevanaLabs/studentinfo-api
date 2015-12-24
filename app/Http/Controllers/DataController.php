<?php

namespace StudentInfo\Http\Controllers;


use Illuminate\Contracts\Auth\Guard;
use StudentInfo\Repositories\ClassroomRepositoryInterface;
use StudentInfo\Repositories\CourseEventRepositoryInterface;
use StudentInfo\Repositories\GlobalEventRepositoryInterface;
use StudentInfo\Repositories\GroupEventRepositoryInterface;
use StudentInfo\Repositories\GroupRepositoryInterface;
use StudentInfo\Repositories\LectureRepositoryInterface;
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
     * @var LectureRepositoryInterface
     */
    protected $lectureRepository;

    /**
     * @var GlobalEventRepositoryInterface
     */
    protected $globalEventRepository;

    /**
     * @var CourseEventRepositoryInterface
     */
    protected $courseEventRepository;

    /**
     * @var GroupEventRepositoryInterface
     */
    protected $groupEventRepository;

    /**
     * @var Guard
     */
    protected $guard;

    /**
     * CourseController constructor.
     * @param LectureRepositoryInterface     $lectureRepository
     * @param ClassroomRepositoryInterface   $classroomRepository
     * @param TeacherRepositoryInterface     $teacherRepository
     * @param GroupRepositoryInterface       $groupRepository
     * @param GlobalEventRepositoryInterface $globalEventRepository
     * @param CourseEventRepositoryInterface $courseEventRepository
     * @param GroupEventRepositoryInterface  $groupEventRepository
     * @param Guard                          $guard
     */
    public function __construct(LectureRepositoryInterface $lectureRepository, ClassroomRepositoryInterface $classroomRepository, TeacherRepositoryInterface $teacherRepository, GroupRepositoryInterface $groupRepository, GlobalEventRepositoryInterface $globalEventRepository, CourseEventRepositoryInterface $courseEventRepository, GroupEventRepositoryInterface $groupEventRepository, Guard $guard)
    {
        $this->lectureRepository     = $lectureRepository;
        $this->classroomRepository   = $classroomRepository;
        $this->teacherRepository     = $teacherRepository;
        $this->groupRepository       = $groupRepository;
        $this->globalEventRepository = $globalEventRepository;
        $this->courseEventRepository = $courseEventRepository;
        $this->groupEventRepository  = $groupEventRepository;
        $this->guard                 = $guard;
    }

    public function getData()
    {
        $teachers     = $this->teacherRepository->all(0, 2000);
        $groups       = $this->groupRepository->all(0, 2000);
        $classrooms   = $this->classroomRepository->all(0, 2000);
        $globalEvents = $this->globalEventRepository->all(0, 2000);
        $courseEvents = $this->courseEventRepository->all(0, 2000);
        $groupEvents  = $this->groupEventRepository->all(0, 2000);

        return $this->returnSuccess([
            'groups'       => $groups,
            'teachers'     => $teachers,
            'classrooms'   => $classrooms,
            'globalEvents' => $globalEvents,
            'courseEvents' => $courseEvents,
            'groupEvents'  => $groupEvents,
        ], [
            'display' => 'all',
        ]);
    }


}