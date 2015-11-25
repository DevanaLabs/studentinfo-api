<?php


namespace StudentInfo\Http\Controllers;


use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;
use StudentInfo\ErrorCodes\UserErrorCodes;
use StudentInfo\Http\Requests\AddEventRequest;
use StudentInfo\Http\Requests\StandardRequest;
use StudentInfo\Models\Event;
use StudentInfo\Models\Lecture;
use StudentInfo\Repositories\EventRepositoryInterface;
use StudentInfo\Repositories\LectureRepositoryInterface;

class EventController extends ApiController
{
    /**
     * @var EventRepositoryInterface
     */
    protected $eventRepository;
    /**
     * @var LectureRepositoryInterface
     */
    protected $lectureRepository;

    /**
     * @var Guard
     */
    protected $guard;

    /**
     * CourseController constructor.
     * @param EventRepositoryInterface   $eventRepository
     * @param LectureRepositoryInterface $lectureRepository
     * @param Guard                      $guard
     */
    public function __construct(EventRepositoryInterface $eventRepository, LectureRepositoryInterface $lectureRepository, Guard $guard)
    {
        $this->eventRepository   = $eventRepository;
        $this->lectureRepository = $lectureRepository;
        $this->guard             = $guard;
    }

    public function addEvents(AddEventRequest $request)
    {
        $addedEvents       = [];
        $failedToAddEvents = [];

        $events = $request->get('events');

        foreach ($events as $eventEntry) {
            $event    = new Event();
            $startsAt = Carbon::createFromFormat('Y-m-d H:i', $eventEntry['startsAt']);
            $endsAt   = Carbon::createFromFormat('Y-m-d H:i', $eventEntry['endsAt']);
            if ($endsAt->lte($startsAt)) {
                $failedToAddEvents[] = $event;
                continue;
            }
            /** @var Lecture $lecture */
            $lecture = $this->lectureRepository->find($eventEntry['lectureId']);
            if ($lecture === null) {
                $failedToAddEvents[] = $event;
                continue;
            }
            $event->setType($eventEntry['type']);
            $event->setDescription($eventEntry['description']);
            $event->setLecture($lecture);
            $event->setStartsAt($startsAt);
            $event->setEndsAt($endsAt);
            $this->eventRepository->create($event);

            $addedEvents[] = $event;
        }

        return $this->returnSuccess([
            'successful'   => $addedEvents,
            'unsuccessful' => $failedToAddEvents,
        ]);
    }

    public function getEvent($id)
    {
        $event = $this->eventRepository->find($id);

        if($event === null){
            return $this->returnError(500, UserErrorCodes::EVENT_NOT_IN_DB);
        }

        return $this->returnSuccess([
            'event' => $event
        ]);
    }

    public function getEvents($start = 0, $count = 20)
    {
        $events = $this->eventRepository->all($start, $count);

        return $this->returnSuccess($events);
    }

    public function putEditEvent(StandardRequest $request, $id)
    {
        if($this->eventRepository->find($id) === null){
            return $this->returnError(500, UserErrorCodes::EVENT_NOT_IN_DB);
        }

        /** @var  Event $event */
        $event = $this->eventRepository->find($id);

        $startsAt = Carbon::createFromFormat('Y-m-d H:i', $request['startsAt']);
        $endsAt   = Carbon::createFromFormat('Y-m-d H:i', $request['endsAt']);
        if ($endsAt->lte($startsAt)) {
            return $this->returnError(500, UserErrorCodes::INCORRECT_TIME);
        }
        /** @var Lecture $lecture */
        $lecture = $this->lectureRepository->find($request['lectureId']);
        if ($lecture === null) {
            return $this->returnError(500, UserErrorCodes::EVENT_NOT_IN_DB);
        }
        $event->setType($request['type']);
        $event->setDescription($request['description']);
        $event->setLecture($lecture);
        $event->setStartsAt($startsAt);
        $event->setEndsAt($endsAt);

        $this->eventRepository->update($event);


        return $this->returnSuccess([
            'event' => $event
        ]);
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