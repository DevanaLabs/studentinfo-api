<?php

namespace StudentInfo\Http\Controllers;

use LucaDegasperi\OAuth2Server\Authorizer;
use StudentInfo\ErrorCodes\GroupErrorCodes;
use StudentInfo\Http\Requests\Create\CreateGroupRequest;
use StudentInfo\Http\Requests\StandardRequest;
use StudentInfo\Http\Requests\Update\UpdateGroupRequest;
use StudentInfo\Models\Group;
use StudentInfo\Models\User;
use StudentInfo\Repositories\EventRepositoryInterface;
use StudentInfo\Repositories\FacultyRepositoryInterface;
use StudentInfo\Repositories\GroupRepositoryInterface;
use StudentInfo\Repositories\LectureRepositoryInterface;
use StudentInfo\Repositories\UserRepositoryInterface;

class GroupController extends ApiController
{
    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;
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
     * @var UserRepositoryInterface
     */
    protected $userRepositoryInterface;

    /**
     * @var Authorizer
     */
    protected $authorizer;

    /**
     * GroupController constructor.
     * @param UserRepositoryInterface                         $userRepository
     * @param GroupRepositoryInterface   $groupRepository
     * @param LectureRepositoryInterface $lectureRepository
     * @param EventRepositoryInterface   $eventRepository
     * @param FacultyRepositoryInterface $facultyRepository
     * @param UserRepositoryInterface                         $userRepositoryInterface
     * @param Authorizer                                      $authorizer
     */
    public function __construct(UserRepositoryInterface $userRepository, GroupRepositoryInterface $groupRepository, LectureRepositoryInterface $lectureRepository,
                                EventRepositoryInterface $eventRepository, FacultyRepositoryInterface $facultyRepository, UserRepositoryInterface $userRepositoryInterface, Authorizer $authorizer)
    {
        $this->userRepository = $userRepository;
        $this->groupRepository   = $groupRepository;
        $this->lectureRepository = $lectureRepository;
        $this->eventRepository = $eventRepository;
        $this->facultyRepository = $facultyRepository;
        $this->userRepositoryInterface = $userRepositoryInterface;
        $this->authorizer     = $authorizer;
    }

    public function createGroup(CreateGroupRequest $request, $faculty)
    {
        $group         = new Group();
        $name          = $request->get('name');
        $group->setName($name);
        $group->setYear($request->get('year'));
        $group->setOrganisation($this->userRepository->find($this->authorizer->getResourceOwnerId())->getOrganisation());

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

        if ($this->groupRepository->findByName($name, $faculty)) {
            return $this->returnError(500, GroupErrorCodes::GROUP_ALREADY_EXISTS);
        }
        $this->groupRepository->create($group);

        return $this->returnSuccess([
            'successful' => $group,
        ]);
    }

    public function retrieveGroup(StandardRequest $request, $faculty, $id)
    {
        /** @var Group $group */
        $group = $this->groupRepository->find($id);

        if ($group === null) {
            return $this->returnError(500, GroupErrorCodes::GROUP_NOT_IN_DB);
        }

        if ($group->getOrganisation()->getSlug() != $faculty) {
            return $this->returnError(500, GroupErrorCodes::GROUP_DOES_NOT_BELONG_TO_THIS_FACULTY);
        }

        $semester = $request->get('semester', 'current');
        $year     = $request->get('year', 'current');

        if (($semester == 'current') || ($year == 'current')) {
            $userId = $this->authorizer->getResourceOwnerId();
            /** @var User $user */
            $user = $this->userRepositoryInterface->find($userId);
            if ($semester == 'current') {
                $semester = $user->getOrganisation()->getSettings()->getSemester();
            }
            if ($year == 'current') {
                $year = $user->getOrganisation()->getSettings()->getYear();
            }
        } else {
            $semester = (int)$request->get('semester');
            $year     = (int)$request->get('year');
        }

        $lectures = [];
        foreach ($group->getLectures() as $lecture) {
            if (($lecture->getCourse()->getSemester() % 2 === $semester % 2) && ($lecture->getYear() === $year)) {
                $lectures[] = $lecture;
            }
        }
        $group->setLectures($lectures);

        return $this->returnSuccess([
            'group' => $group,
        ]);
    }

    public function retrieveGroups(StandardRequest $request, $faculty, $start = 0, $count = 2000)
    {
        /** @var Group[] $groups */
        $groups = $this->groupRepository->all($faculty, $start, $count);

        $semester = $request->get('semester', 'current');
        $year     = $request->get('year', 'current');

        if (($semester == 'current') || ($year == 'current')) {
            $userId = $this->authorizer->getResourceOwnerId();
            /** @var User $user */
            $user = $this->userRepositoryInterface->find($userId);
            if ($semester == 'current') {
                $semester = $user->getOrganisation()->getSettings()->getSemester();
            }
            if ($year == 'current') {
                $year = $user->getOrganisation()->getSettings()->getYear();
            }
        } else {
            $semester = (int)$request->get('semester');
            $year     = (int)$request->get('year');
        }

        foreach ($groups as $group) {
            $lectures = [];
            foreach ($group->getLectures() as $lecture) {
                if (($lecture->getCourse()->getSemester() % 2 === $semester % 2) && ($lecture->getYear() === $year)) {
                    $lectures[] = $lecture;
                }
            }
            $group->setLectures($lectures);
        }
        return $this->returnSuccess($groups);
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
        $group->setOrganisation($this->userRepository->find($this->authorizer->getResourceOwnerId())->getOrganisation());

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