<?php

namespace StudentInfo\Http\Controllers;

use LucaDegasperi\OAuth2Server\Authorizer;
use StudentInfo\ErrorCodes\EventErrorCodes;
use StudentInfo\Repositories\ClassroomRepositoryInterface;
use StudentInfo\Repositories\CourseEventRepositoryInterface;
use StudentInfo\Repositories\CourseRepositoryInterface;
use StudentInfo\Repositories\EventRepositoryInterface;
use StudentInfo\Repositories\FacultyRepositoryInterface;
use StudentInfo\Repositories\GlobalEventRepositoryInterface;
use StudentInfo\Repositories\GroupEventRepositoryInterface;
use StudentInfo\Repositories\GroupRepositoryInterface;
use StudentInfo\Repositories\TeacherRepositoryInterface;
use StudentInfo\Repositories\UserRepositoryInterface;

class EventController extends ApiController
{
    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * @var EventRepositoryInterface
     */
    protected $eventRepository;

    /**
     * @var CourseEventRepositoryInterface
     */
    protected $courseEventRepository;

    /**
     * @var GlobalEventRepositoryInterface
     */
    protected $globalEventRepository;

    /**
     * @var GroupEventRepositoryInterface
     */
    protected $groupEventRepository;

    /**
     * @var ClassroomRepositoryInterface
     */
    protected $classroomRepository;

    /**
     * @var CourseRepositoryInterface
     */
    protected $courseRepository;

    /**
     * @var GroupRepositoryInterface
     */
    protected $groupRepository;

    /**
     * @var FacultyRepositoryInterface
     */
    protected $facultyRepository;

    /**
     * @var TeacherRepositoryInterface
     */
    protected $teacherRepository;

    /**
     * @var Authorizer
     */
    protected $authorizer;

    /**
     * CourseController constructor.
     * @param EventRepositoryInterface       $eventRepository
     * @param ClassroomRepositoryInterface   $classroomRepository
     * @param CourseRepositoryInterface      $courseRepository
     * @param GroupRepositoryInterface       $groupRepository
     * @param CourseEventRepositoryInterface $courseEventRepository
     * @param GroupEventRepositoryInterface  $groupEventRepository
     * @param GlobalEventRepositoryInterface $globalEventRepository
     * @param FacultyRepositoryInterface     $facultyRepository
     * @param UserRepositoryInterface        $userRepository
     * @param TeacherRepositoryInterface     $teacherRepository
     * @param Authorizer                     $authorizer
     */
    public function __construct(EventRepositoryInterface $eventRepository, ClassroomRepositoryInterface $classroomRepository,
                                CourseRepositoryInterface $courseRepository, GroupRepositoryInterface $groupRepository,
                                CourseEventRepositoryInterface $courseEventRepository, GroupEventRepositoryInterface $groupEventRepository,
                                GlobalEventRepositoryInterface $globalEventRepository, FacultyRepositoryInterface $facultyRepository,
                                UserRepositoryInterface $userRepository, TeacherRepositoryInterface $teacherRepository, Authorizer $authorizer)
    {
        $this->eventRepository       = $eventRepository;
        $this->classroomRepository   = $classroomRepository;
        $this->courseRepository      = $courseRepository;
        $this->courseEventRepository = $courseEventRepository;
        $this->globalEventRepository = $globalEventRepository;
        $this->groupEventRepository = $groupEventRepository;
        $this->groupRepository       = $groupRepository;
        $this->facultyRepository     = $facultyRepository;
        $this->userRepository = $userRepository;
        $this->teacherRepository = $teacherRepository;
        $this->authorizer = $authorizer;
    }

    public function retrieveEvent($faculty, $id)
    {
        $event = $this->eventRepository->find($id);

        if ($event === null) {
            return $this->returnError(500, EventErrorCodes::EVENT_NOT_IN_DB);
        }

        if ($event->getOrganisation()->getSlug() != $faculty) {
            return $this->returnError(500, EventErrorCodes::EVENT_DOES_NOT_BELONG_TO_THIS_FACULTY);
        }

        return $this->returnSuccess([
            'event' => $event,
        ]);
    }

    public function retrieveEvents($faculty, $start = 0, $count = 2000)
    {
        $events = $this->eventRepository->all($faculty, $start, $count);

        return $this->returnSuccess($events);
    }

    public function deleteEvent($faculty, $id)
    {

        $event = $this->eventRepository->find($id);
        if ($event === null) {
            return $this->returnError(500, EventErrorCodes::EVENT_NOT_IN_DB);
        }
        $this->eventRepository->destroy($event);

        return $this->returnSuccess();
    }
}