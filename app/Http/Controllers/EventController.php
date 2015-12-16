<?php

namespace StudentInfo\Http\Controllers;


use Illuminate\Contracts\Auth\Guard;
use StudentInfo\ErrorCodes\UserErrorCodes;
use StudentInfo\Repositories\ClassroomRepositoryInterface;
use StudentInfo\Repositories\CourseRepositoryInterface;
use StudentInfo\Repositories\EventRepositoryInterface;
use StudentInfo\Repositories\GlobalEventRepositoryInterface;
use StudentInfo\Repositories\GroupRepositoryInterface;

class EventController extends ApiController
{
    /**
     * @var EventRepositoryInterface
     */
    protected $eventRepository;

    /**
     * @var GlobalEventRepositoryInterface
     */
    protected $globalEventRepository;

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
     * @param GlobalEventRepositoryInterface $globalEventRepository
     * @param Guard                          $guard
     */
    public function __construct(EventRepositoryInterface $eventRepository, ClassroomRepositoryInterface $classroomRepository, CourseRepositoryInterface $courseRepository, GroupRepositoryInterface $groupRepository, GlobalEventRepositoryInterface $globalEventRepository, Guard $guard)
    {
        $this->eventRepository       = $eventRepository;
        $this->globalEventRepository = $globalEventRepository;
        $this->classroomRepository   = $classroomRepository;
        $this->courseRepository      = $courseRepository;
        $this->groupRepository       = $groupRepository;
        $this->guard                 = $guard;
    }

    public function retrieveEvent($id)
    {
        $event = $this->eventRepository->find($id);

        if ($event === null) {
            return $this->returnError(500, UserErrorCodes::EVENT_NOT_IN_DB);
        }

        return $this->returnSuccess([
            'event' => $event,
        ]);
    }

    public function retrieveEvents($start = 0, $count = 20)
    {
        $events = $this->eventRepository->all($start, $count);

        return $this->returnSuccess($events);
    }

    public function deleteEvent($id)
    {

        $event = $this->eventRepository->find($id);
        if ($event === null) {
            return $this->returnError(500, UserErrorCodes::EVENT_NOT_IN_DB);
        }
        $this->eventRepository->destroy($event);

        return $this->returnSuccess();
    }
}