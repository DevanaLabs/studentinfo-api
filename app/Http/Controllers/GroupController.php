<?php

namespace StudentInfo\Http\Controllers;


use Illuminate\Contracts\Auth\Guard;
use StudentInfo\ErrorCodes\GroupErrorCodes;
use StudentInfo\Http\Requests\Create\CreateGroupRequest;
use StudentInfo\Http\Requests\Update\UpdateGroupRequest;
use StudentInfo\Models\Group;
use StudentInfo\Repositories\EventRepositoryInterface;
use StudentInfo\Repositories\FacultyRepositoryInterface;
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
     * @var FacultyRepositoryInterface $facultyRepository
     */
    protected $facultyRepository;

    /**
     * @var Guard guard
     */
    protected $guard;

    /**
     * GroupController constructor.
     * @param GroupRepositoryInterface   $groupRepository
     * @param LectureRepositoryInterface $lectureRepository
     * @param EventRepositoryInterface   $eventRepository
     * @param FacultyRepositoryInterface $facultyRepository
     * @param Guard                      $guard
     */
    public function __construct(GroupRepositoryInterface $groupRepository, LectureRepositoryInterface $lectureRepository,
                                EventRepositoryInterface $eventRepository, FacultyRepositoryInterface $facultyRepository, Guard $guard)
    {
        $this->groupRepository   = $groupRepository;
        $this->lectureRepository = $lectureRepository;
        $this->eventRepository = $eventRepository;
        $this->facultyRepository = $facultyRepository;
        $this->guard = $guard;
    }

    public function createGroup(CreateGroupRequest $request, $faculty)
    {
        $group         = new Group();
        $name          = $request->get('name');
        $group->setName($name);
        $group->setYear($request->get('year'));
        $group->setOrganisation($this->guard->user()->getOrganisation());

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
            return $this->returnError(500, GroupErrorCodes::GROUP_ALREADY_EXISTS);
        }
        $this->groupRepository->create($group);

        return $this->returnSuccess([
            'successful' => $group,
        ]);
    }

    public function retrieveGroup($faculty, $id)
    {
        $group = $this->groupRepository->find($id);

        if ($group === null) {
            return $this->returnError(500, GroupErrorCodes::GROUP_NOT_IN_DB);
        }

        if ($group->getOrganisation()->getSlug() != $faculty) {
            return $this->returnError(500, GroupErrorCodes::GROUP_DOES_NOT_BELONG_TO_THIS_FACULTY);
        }

        return $this->returnSuccess([
            'group' => $group,
        ]);
    }

    public function retrieveGroups($faculty, $start = 0, $count = 2000)
    {
        $groups = $this->groupRepository->all($faculty, $start, $count);

        return $this->returnSuccess([
            'groups' => $groups,
        ]);
    }

    public function updateGroup(UpdateGroupRequest $request, $faculty, $id)
    {
        /** @var Group $group */
        $group = $this->groupRepository->find($id);

        if ($group === null) {
            return $this->returnError(500, GroupErrorCodes::GROUP_NOT_IN_DB);
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
        $group->setOrganisation($this->guard->user()->getOrganisation());

        $this->groupRepository->update($group);

        return $this->returnSuccess([
            'group' => $group,
        ]);
    }

    public function deleteGroup($faculty, $id)
    {
        $group = $this->groupRepository->find($id);
        if ($group === null) {
            return $this->returnError(500, GroupErrorCodes::GROUP_NOT_IN_DB);
        }
        $this->groupRepository->destroy($group);

        return $this->returnSuccess();
    }
}