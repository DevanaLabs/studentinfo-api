<?php

namespace StudentInfo\Http\Controllers;

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
     * CourseController constructor.
     * @param LectureRepositoryInterface     $lectureRepository
     * @param ClassroomRepositoryInterface   $classroomRepository
     * @param TeacherRepositoryInterface     $teacherRepository
     * @param GroupRepositoryInterface       $groupRepository
     * @param GlobalEventRepositoryInterface $globalEventRepository
     * @param CourseEventRepositoryInterface $courseEventRepository
     * @param GroupEventRepositoryInterface  $groupEventRepository
     */
    public function __construct(LectureRepositoryInterface $lectureRepository, ClassroomRepositoryInterface $classroomRepository, TeacherRepositoryInterface $teacherRepository, GroupRepositoryInterface $groupRepository, GlobalEventRepositoryInterface $globalEventRepository, CourseEventRepositoryInterface $courseEventRepository, GroupEventRepositoryInterface $groupEventRepository)
    {
        $this->lectureRepository     = $lectureRepository;
        $this->classroomRepository   = $classroomRepository;
        $this->teacherRepository     = $teacherRepository;
        $this->groupRepository       = $groupRepository;
        $this->globalEventRepository = $globalEventRepository;
        $this->courseEventRepository = $courseEventRepository;
        $this->groupEventRepository  = $groupEventRepository;
    }

    public function getData($faculty)
    {
        $teachers     = $this->teacherRepository->all($faculty, 0, 2000);
        $groups       = $this->groupRepository->all($faculty, 0, 2000);
        $classrooms   = $this->classroomRepository->all($faculty, 0, 2000);
        $globalEvents = $this->globalEventRepository->all($faculty, 0, 2000);
        $courseEvents = $this->courseEventRepository->all($faculty, 0, 2000);
        $groupEvents  = $this->groupEventRepository->all($faculty, 0, 2000);

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