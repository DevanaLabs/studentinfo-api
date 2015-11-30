<?php

namespace StudentInfo\Http\Controllers;


use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;
use StudentInfo\ErrorCodes\UserErrorCodes;
use StudentInfo\Http\Requests\AddEventRequest;
use StudentInfo\Http\Requests\StandardRequest;
use StudentInfo\Models\Course;
use StudentInfo\Models\CourseEvent;
use StudentInfo\Repositories\EventRepositoryInterface;
use StudentInfo\Repositories\CourseRepositoryInterface;

class CourseEventController extends ApiController
{
            /**
         * @var EventRepositoryInterface
         */
        protected $eventRepository;
        /**
         * @var CourseRepositoryInterface
         */
        protected $courseRepository;

        /**
         * @var Guard
         */
        protected $guard;

        /**
         * CourseController constructor.
         * @param EventRepositoryInterface   $eventRepository
         * @param CourseRepositoryInterface $courseRepository
         * @param Guard                      $guard
         */
        public function __construct(EventRepositoryInterface $eventRepository, CourseRepositoryInterface $courseRepository, Guard $guard)
    {
        $this->eventRepository   = $eventRepository;
        $this->courseRepository  = $courseRepository;
        $this->guard             = $guard;
    }

        public function addEvent(AddEventRequest $request)
    {
        $event    = new CourseEvent();
        $startsAt = Carbon::createFromFormat('Y-m-d H:i', $request->get('startsAt'));
        $endsAt   = Carbon::createFromFormat('Y-m-d H:i', $request->get('endsAt'));
        if ($endsAt->lte($startsAt)) {
            return $this->returnError(500, UserErrorCodes::INCORRECT_TIME);
        }

        $course = $this->courseRepository->find($request['courseId']);
        if ($course === null) {
            return $this->returnError(500, UserErrorCodes::COURSE_NOT_IN_DB);
        }

        $event->setType($request->get('type'));
        $event->setDescription($request->get('description'));
        $event->setCourse($course);
        $event->setStartsAt($startsAt);
        $event->setEndsAt($endsAt);

        $this->eventRepository->create($event);
        return $this->returnSuccess([
            'successful'   => $event,
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

        /** @var  CourseEvent $event */
        $event = $this->eventRepository->find($id);

        $startsAt = Carbon::createFromFormat('Y-m-d H:i', $request['startsAt']);
        $endsAt   = Carbon::createFromFormat('Y-m-d H:i', $request['endsAt']);
        if ($endsAt->lte($startsAt)) {
            return $this->returnError(500, UserErrorCodes::INCORRECT_TIME);
        }
        /** @var Course $course */
        $course = $this->courseRepository->find($request['courseId']);

        if ($course === null) {
            return $this->returnError(500, UserErrorCodes::COURSE_NOT_IN_DB);
        }

        $event->setType($request['type']);
        $event->setDescription($request['description']);
        $event->setCourse($course);
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