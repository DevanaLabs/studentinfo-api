<?php

namespace StudentInfo\Http\Controllers;


use Illuminate\Contracts\Auth\Guard;
use StudentInfo\ErrorCodes\EventErrorCodes;
use StudentInfo\Repositories\ClassroomRepositoryInterface;
use StudentInfo\Repositories\CourseEventRepositoryInterface;
use StudentInfo\Repositories\CourseRepositoryInterface;
use StudentInfo\Repositories\EventRepositoryInterface;
use StudentInfo\Repositories\GlobalEventRepositoryInterface;
use StudentInfo\Repositories\GroupEventRepositoryInterface;
use StudentInfo\Repositories\GroupRepositoryInterface;

class EventController extends ApiController
{
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
     * @var Guard
     */
    protected $guard;

    /**
     * CourseController constructor.
     * @param EventRepositoryInterface       $eventRepository
     * @param ClassroomRepositoryInterface   $classroomRepository
     * @param CourseRepositoryInterface      $courseRepository
     * @param GroupRepositoryInterface       $groupRepository
     * @param CourseEventRepositoryInterface $courseEventRepository
     * @param GroupEventRepositoryInterface  $groupEventRepository
     * @param GlobalEventRepositoryInterface $globalEventRepository
     * @param Guard                          $guard
     */
    public function __construct(EventRepositoryInterface $eventRepository, ClassroomRepositoryInterface $classroomRepository, CourseRepositoryInterface $courseRepository, GroupRepositoryInterface $groupRepository, CourseEventRepositoryInterface $courseEventRepository, GroupEventRepositoryInterface $groupEventRepository, GlobalEventRepositoryInterface $globalEventRepository, Guard $guard)
    {
        $this->eventRepository       = $eventRepository;
        $this->classroomRepository   = $classroomRepository;
        $this->courseRepository      = $courseRepository;
        $this->courseEventRepository = $courseEventRepository;
        $this->globalEventRepository = $globalEventRepository;
        $this->groupEventRepository = $groupEventRepository;
        $this->groupRepository       = $groupRepository;
        $this->guard                 = $guard;
    }

    public function retrieveEvent($id)
    {
        $event = $this->eventRepository->find($id);

        if ($event === null) {
            return $this->returnError(500, EventErrorCodes::EVENT_NOT_IN_DB);
        }

        return $this->returnSuccess([
            'event' => $event,
        ]);
    }

    public function retrieveEvents($start = 0, $count = 2000)
    {
        $events = $this->eventRepository->all($start, $count);

        return $this->returnSuccess($events);
    }

    public function deleteEvent($id)
    {

        $event = $this->eventRepository->find($id);
        if ($event === null) {
            return $this->returnError(500, EventErrorCodes::EVENT_NOT_IN_DB);
        }
        $this->eventRepository->destroy($event);

        return $this->returnSuccess();
    }
}