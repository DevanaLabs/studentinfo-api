<?php

namespace StudentInfo\Http\Controllers;


use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use StudentInfo\ErrorCodes\UserErrorCodes;
use StudentInfo\Http\Requests\Create\CreateGlobalEventRequest;
use StudentInfo\Http\Requests\Update\UpdateGlobalEventRequest;
use StudentInfo\Models\GlobalEvent;

class GlobalEventController extends EventController
{
    public function createEvent(CreateGlobalEventRequest $request)
    {
        $event    = new GlobalEvent(new ArrayCollection());
        $startsAt = Carbon::createFromFormat('Y-m-d H:i', $request->get('startsAt'));
        $endsAt   = Carbon::createFromFormat('Y-m-d H:i', $request->get('endsAt'));
        if ($endsAt->lte($startsAt)) {
            return $this->returnError(500, UserErrorCodes::INCORRECT_TIME);
        }

        $event->setType($request->get('type'));
        $event->setDescription($request->get('description'));
        $event->setStartsAt($startsAt);
        $event->setEndsAt($endsAt);

        $this->eventRepository->create($event);
        return $this->returnSuccess([
            'successful' => $event,
        ]);
    }

    public function retrieveEvent($id)
    {
        $event = $this->globalEventRepository->find($id);

        if ($event === null) {
            return $this->returnError(500, UserErrorCodes::EVENT_NOT_IN_DB);
        }

        return $this->returnSuccess([
            'event' => $event,
        ]);
    }

    public function retrieveEvents($start = 0, $count = 20)
    {
        $events = $this->globalEventRepository->all($start, $count);

        return $this->returnSuccess($events);
    }

    public function updateEvent(UpdateGlobalEventRequest $request, $id)
    {
        if ($this->eventRepository->find($id) === null) {
            return $this->returnError(500, UserErrorCodes::EVENT_NOT_IN_DB);
        }

        /** @var  GlobalEvent $event */
        $event = $this->eventRepository->find($id);

        $startsAt = Carbon::createFromFormat('Y-m-d H:i', $request['startsAt']);
        $endsAt   = Carbon::createFromFormat('Y-m-d H:i', $request['endsAt']);
        if ($endsAt->lte($startsAt)) {
            return $this->returnError(500, UserErrorCodes::INCORRECT_TIME);
        }

        $event->setType($request->get('type'));
        $event->setDescription($request->get('description'));
        $event->setStartsAt($startsAt);
        $event->setEndsAt($endsAt);

        $this->eventRepository->update($event);


        return $this->returnSuccess([
            'event' => $event,
        ]);
    }
}