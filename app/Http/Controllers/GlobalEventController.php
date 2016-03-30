<?php

namespace StudentInfo\Http\Controllers;

use DateTime as DateTimeDateTime;
use Doctrine\Common\Collections\ArrayCollection;
use StudentInfo\ErrorCodes\EventErrorCodes;
use StudentInfo\ErrorCodes\UserErrorCodes;
use StudentInfo\Http\Requests\Create\CreateGlobalEventRequest;
use StudentInfo\Http\Requests\Update\UpdateGlobalEventRequest;
use StudentInfo\Models\GlobalEvent;
use StudentInfo\ValueObjects\Datetime;

class GlobalEventController extends EventController
{
    public function createEvent(CreateGlobalEventRequest $request, $faculty)
    {
        $event    = new GlobalEvent(new ArrayCollection());
        $startsAt = DateTimeDateTime::createFromFormat('Y-m-d H:i', $request->get('startsAt'));
        $endsAt   = DateTimeDateTime::createFromFormat('Y-m-d H:i', $request->get('endsAt'));
        if ($endsAt < $startsAt) {
            return $this->returnError(500, UserErrorCodes::INCORRECT_TIME);
        }
        $datetime = new Datetime();
        $datetime->setStartsAt($startsAt);
        $datetime->setEndsAt($endsAt);

        $event->setType($request->get('type'));
        $event->setDescription($request->get('description'));
        $event->setDatetime($datetime);
        $event->setOrganisation($this->userRepository->find($this->authorizer->getResourceOwnerId())->getOrganisation());

        $this->eventRepository->create($event);
        return $this->returnSuccess([
            'event' => $event,
        ]);
    }

    public function retrieveEvent($faculty, $id)
    {
        $event = $this->globalEventRepository->find($id);

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
        $events = $this->globalEventRepository->all($faculty, $start, $count);

        return $this->returnSuccess($events);
    }

    public function updateEvent(UpdateGlobalEventRequest $request, $faculty, $id)
    {
        if ($this->eventRepository->find($id) === null) {
            return $this->returnError(500, EventErrorCodes::EVENT_NOT_IN_DB);
        }

        /** @var  GlobalEvent $event */
        $event = $this->eventRepository->find($id);

        $startsAt = DateTimeDateTime::createFromFormat('Y-m-d H:i', $request['startsAt']);
        $endsAt   = DateTimeDateTime::createFromFormat('Y-m-d H:i', $request['endsAt']);
        if ($endsAt < $startsAt) {
            return $this->returnError(500, UserErrorCodes::INCORRECT_TIME);
        }
        $datetime = new Datetime();
        $datetime->setStartsAt($startsAt);
        $datetime->setEndsAt($endsAt);

        $event->setType($request->get('type'));
        $event->setDescription($request->get('description'));
        $event->setDatetime($datetime);
        $event->setOrganisation($this->userRepository->find($this->authorizer->getResourceOwnerId())->getOrganisation());

        $this->eventRepository->update($event);


        return $this->returnSuccess([
            'event' => $event,
        ]);
    }
}