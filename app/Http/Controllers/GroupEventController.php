<?php

namespace StudentInfo\Http\Controllers;

use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use StudentInfo\ErrorCodes\UserErrorCodes;
use StudentInfo\Http\Requests\AddEventRequest;
use StudentInfo\Http\Requests\StandardRequest;
use StudentInfo\Models\Group;
use StudentInfo\Models\GroupEvent;

class GroupEventController extends EventController
{
    public function addEvent(AddEventRequest $request)
    {
        $event = new GroupEvent(new ArrayCollection());
        $startsAt = Carbon::createFromFormat('Y-m-d H:i', $request->get('startsAt'));
        $endsAt   = Carbon::createFromFormat('Y-m-d H:i', $request->get('endsAt'));
        if ($endsAt->lte($startsAt)) {
            return $this->returnError(500, UserErrorCodes::INCORRECT_TIME);
        }

        /** @var Group $group */
        $group = $this->groupRepository->find($request['groupId']);
        if ($group === null) {
            return $this->returnError(500, UserErrorCodes::GROUP_NOT_IN_DB);
        }

        $event->setType($request->get('type'));
        $event->setDescription($request->get('description'));
        $event->setGroup($group);
        $event->setStartsAt($startsAt);
        $event->setEndsAt($endsAt);

        $this->eventRepository->create($event);
        return $this->returnSuccess([
            'successful' => $event,
        ]);
    }

    public function getGroupEvents($groupId)
    {
        /** @var Group $group */
        $group = $this->groupRepository->find($groupId);

        return $this->returnSuccess([
            'events' => $group->getEvents(),
        ]);
    }

    public function putEditEvent(StandardRequest $request, $id)
    {
        if ($this->eventRepository->find($id) === null) {
            return $this->returnError(500, UserErrorCodes::EVENT_NOT_IN_DB);
        }

        /** @var  GroupEvent $event */
        $event = $this->eventRepository->find($id);

        $startsAt = Carbon::createFromFormat('Y-m-d H:i', $request['startsAt']);
        $endsAt   = Carbon::createFromFormat('Y-m-d H:i', $request['endsAt']);
        if ($endsAt->lte($startsAt)) {
            return $this->returnError(500, UserErrorCodes::INCORRECT_TIME);
        }

        /** @var Group $group */
        $group = $this->groupRepository->find($request['groupId']);
        if ($group === null) {
            return $this->returnError(500, UserErrorCodes::GROUP_NOT_IN_DB);
        }

        $event->setType($request['type']);
        $event->setDescription($request['description']);
        $event->setGroup($group);
        $event->setStartsAt($startsAt);
        $event->setEndsAt($endsAt);

        $this->eventRepository->update($event);


        return $this->returnSuccess([
            'event' => $event
        ]);
    }
}