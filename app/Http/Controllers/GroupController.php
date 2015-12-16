<?php

namespace StudentInfo\Http\Controllers;


use StudentInfo\ErrorCodes\UserErrorCodes;
use StudentInfo\Http\Requests\Create\CreateGroupRequest;
use StudentInfo\Http\Requests\Update\UpdateGroupRequest;
use StudentInfo\Models\Group;
use StudentInfo\Repositories\EventRepositoryInterface;
use StudentInfo\Repositories\GroupRepositoryInterface;
use StudentInfo\Repositories\LectureRepositoryInterface;

class GroupController extends ApiController
{
    /**
     * @var GroupRepositoryInterface
     */
    protected $groupRepository;

    /**
     * @var LectureRepositoryInterface
     */
    protected $lectureRepository;

    /**
     * @var EventRepositoryInterface
     */
    protected $eventRepository;

    /**
     * GroupController constructor.
     * @param GroupRepositoryInterface   $groupRepository
     * @param LectureRepositoryInterface $lectureRepository
     * @param EventRepositoryInterface   $eventRepository
     */
    public function __construct(GroupRepositoryInterface $groupRepository, LectureRepositoryInterface $lectureRepository, EventRepositoryInterface $eventRepository)
    {
        $this->groupRepository   = $groupRepository;
        $this->lectureRepository = $lectureRepository;
        $this->eventRepository = $eventRepository;
    }

    public function createGroup(CreateGroupRequest $request)
    {
        $group         = new Group();
        $name          = $request->get('name');
        $group->setName($name);
        $group->setYear($request->get('year'));

        $lecturesEntry = $request->get('lectures');
        $lectures      = [];
        for ($i = 0; $i < count($lecturesEntry); $i++) {
            $lecture = $this->lectureRepository->find($lecturesEntry[$i]);
            if ($lecture === null) {
                continue;
            }
            $lectures[] = $lecture;
        }
        $group->setLectures($lectures);

        $eventEntry = $request->get('events');
        $events     = [];
        for ($i = 0; $i < count($eventEntry); $i++) {
            $event = $this->eventRepository->find($eventEntry[$i]);
            if ($event === null) {
                continue;
            }
            $events[] = $event;
        }
        $group->setEvents($events);

        if ($this->groupRepository->findByName($name)) {
            return $this->returnError(500, UserErrorCodes::GROUP_ALREADY_EXISTS);
        }
        $this->groupRepository->create($group);

        return $this->returnSuccess([
            'successful' => $group,
        ]);
    }

    public function retrieveGroup($id)
    {
        $group = $this->groupRepository->find($id);

        if ($group === null) {
            return $this->returnError(500, UserErrorCodes::GROUP_NOT_IN_DB);
        }

        return $this->returnSuccess([
            'group' => $group,
        ]);
    }

    public function retrieveGroups($start = 0, $count = 2000)
    {
        $groups = $this->groupRepository->all($start, $count);

        return $this->returnSuccess([
            'groups' => $groups,
        ]);
    }

    public function updateGroup(UpdateGroupRequest $request, $id)
    {
        /** @var Group $group */
        $group = $this->groupRepository->find($id);

        if ($group === null) {
            return $this->returnError(500, UserErrorCodes::GROUP_NOT_IN_DB);
        }

        $lecturesEntry = $request->get('lectures');
        $lectures      = [];

        for ($i = 0; $i < count($lecturesEntry); $i++) {
            $lecture = $this->lectureRepository->find($lecturesEntry[$i]);
            if ($lecture === null) {
                continue;
            }
            $lectures[] = $lecture;
        }
        $group->setLectures($lectures);

        $eventEntry = $request->get('events');
        $events     = [];

        for ($i = 0; $i < count($eventEntry); $i++) {
            $event = $this->eventRepository->find($eventEntry[$i]);
            if ($event === null) {
                continue;
            }
            $events[] = $event;
        }
        $group->setEvents($events);

        $group->setLectures($lectures);
        $group->setName($request->get('name'));
        $group->setYear($request->get('year'));

        $this->groupRepository->update($group);

        return $this->returnSuccess([
            'group' => $group,
        ]);
    }

    public function deleteGroup($id)
    {
        $group = $this->groupRepository->find($id);
        if ($group === null) {
            return $this->returnError(500, UserErrorCodes::GROUP_NOT_IN_DB);
        }
        $this->groupRepository->destroy($group);

        return $this->returnSuccess();
    }

    public function getAllYears()
    {
        return $this->returnSuccess($this->groupRepository->getAllYears());
    }

    public function getAllGroups($year)
    {
        return $this->returnSuccess($this->groupRepository->getAllGroups($year));
    }
}