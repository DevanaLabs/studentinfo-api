<?php

namespace StudentInfo\Http\Controllers;


use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use StudentInfo\ErrorCodes\UserErrorCodes;
use StudentInfo\Http\Requests\AddEventRequest;
use StudentInfo\Http\Requests\StandardRequest;
use StudentInfo\Models\Course;
use StudentInfo\Models\CourseEvent;

class CourseEventController extends EventController
{
    public function addEvent(AddEventRequest $request)
    {
        $event = new CourseEvent(new ArrayCollection());
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
            'successful' => $event,
        ]);
    }

    public function putEditEvent(StandardRequest $request, $id)
    {
        if ($this->eventRepository->find($id) === null) {
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
            'event' => $event,
        ]);
    }
}