<?php

namespace StudentInfo\Http\Controllers;


use Illuminate\Contracts\Auth\Guard;
use StudentInfo\ErrorCodes\UserErrorCodes;
use StudentInfo\Http\Requests\AddDeleteClassroomToEventRequest;
use StudentInfo\Models\Classroom;
use StudentInfo\Models\Event;
use StudentInfo\Repositories\ClassroomRepositoryInterface;
use StudentInfo\Repositories\CourseRepositoryInterface;
use StudentInfo\Repositories\EventRepositoryInterface;
use StudentInfo\Repositories\GroupRepositoryInterface;

class EventController extends ApiController
{
    /**
     * @var EventRepositoryInterface
     */
    protected $eventRepository;

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
     * @param EventRepositoryInterface     $eventRepository
     * @param ClassroomRepositoryInterface $classroomRepository
     * @param CourseRepositoryInterface    $courseRepository
     * @param GroupRepositoryInterface     $groupRepository
     * @param Guard                        $guard
     */
    public function __construct(EventRepositoryInterface $eventRepository, ClassroomRepositoryInterface $classroomRepository, CourseRepositoryInterface $courseRepository, GroupRepositoryInterface $groupRepository, Guard $guard)
    {
        $this->eventRepository     = $eventRepository;
        $this->classroomRepository = $classroomRepository;
        $this->courseRepository    = $courseRepository;
        $this->groupRepository     = $groupRepository;
        $this->guard               = $guard;
    }

    public function getEvent($id)
    {
        $event = $this->eventRepository->find($id);

        if ($event === null) {
            return $this->returnError(500, UserErrorCodes::EVENT_NOT_IN_DB);
        }

        return $this->returnSuccess([
            'event' => $event,
        ]);
    }

    public function getEvents($start = 0, $count = 20)
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

    public function addClassroom(AddDeleteClassroomToEventRequest $request, $eventId)
    {
        $name = $request->get('name');

        /** @var Event $event */
        $event = $this->eventRepository->find($eventId);
        if ($event === null) {
            return $this->returnError(500, UserErrorCodes::EVENT_NOT_IN_DB);
        }

        $classrooms = $event->getClassrooms();
        /** @var  Classroom $classroom */
        $classroom = $this->classroomRepository->findByName($name);

        if (($classroom === null)) {
            return $this->returnError(500, UserErrorCodes::CLASSROOM_NOT_IN_DB);
        }
        foreach ($classrooms as $class) {
            if ($class->getId() === $classroom->getId())
                return $this->returnError(500, UserErrorCodes::CLASSROOM_ALREADY_ADDED_TO_EVENT);
        }

        $classrooms->add($classroom);

        $event->setClassrooms($classrooms);

        $this->eventRepository->update($event);

        return $this->returnSuccess([
            'event' => $event,
        ]);
    }

    public function DeleteClassroom(AddDeleteClassroomToEventRequest $request, $eventId)
    {
        $name = $request->get('name');

        /** @var Event $event */
        $event = $this->eventRepository->find($eventId);
        if ($event === null) {
            return $this->returnError(500, UserErrorCodes::EVENT_NOT_IN_DB);
        }

        $classrooms = $event->getClassrooms();
        /** @var  Classroom $classroom */
        $classroom = $this->classroomRepository->findByName($name);
        if (($classroom === null)) {
            return $this->returnError(500, UserErrorCodes::CLASSROOM_NOT_IN_DB);
        }
        $classrooms->remove($classroom->getId() - 1);

        $event->setClassrooms($classrooms);

        $this->eventRepository->update($event);

        return $this->returnSuccess([
            'event' => $event,
        ]);
    }

    public function getClassrooms($eventId)
    {
        /** @var Event $event */
        $event = $this->eventRepository->find($eventId);
        if ($event === null) {
            return $this->returnError(500, UserErrorCodes::EVENT_NOT_IN_DB);
        }

        return $this->returnSuccess([
            'classrooms' => $event->getClassrooms(),
        ]);

    }
}