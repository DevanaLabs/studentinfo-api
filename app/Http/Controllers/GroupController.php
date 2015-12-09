<?php
/**
 * Created by PhpStorm.
 * User: Nebojsa
 * Date: 11/23/2015
 * Time: 3:47 PM
 */

namespace StudentInfo\Http\Controllers;


use StudentInfo\ErrorCodes\UserErrorCodes;
use StudentInfo\Http\Requests\AddGroupRequest;
use StudentInfo\Http\Requests\StandardRequest;
use StudentInfo\Models\Group;
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
     * GroupController constructor.
     * @param GroupRepositoryInterface   $groupRepository
     * @param LectureRepositoryInterface $lectureRepository
     */
    public function __construct(GroupRepositoryInterface $groupRepository, LectureRepositoryInterface $lectureRepository)
    {
        $this->groupRepository = $groupRepository;
        $this->lectureRepository = $lectureRepository;
    }

    public function addGroup(AddGroupRequest $request)
    {
        $lecturesEntry = $request->get('lectures');
        $lectures = [];
        $group = new Group();
        $name = $request->get('name');
        $group->setName($name);
        $group->setYear($request->get('year'));

        for ($i = 0; $i < count($lecturesEntry); $i++) {
            $lectures[] = $this->lectureRepository->find($lecturesEntry[$i]);
        }
        $group->setLectures($lectures);
        if ($this->groupRepository->findByName($name)) {
            return $this->returnError(500, UserErrorCodes::GROUP_ALREADY_EXISTS);
        }
        $this->groupRepository->create($group);

        return $this->returnSuccess([
            'successful'   => $group
        ]);
    }

    public function getGroup($id)
    {
        $group = $this->groupRepository->find($id);

        if($group  === null){
            return $this->returnError(500, UserErrorCodes::GROUP_NOT_IN_DB);
        }

        return $this->returnSuccess([
            'group' => $group
        ]);
    }

    public function getGroups($start = 0, $count = 20)
    {
        $groupsAll = $this->groupRepository->all($start, $count);
        $groups    = [];

        foreach ($groupsAll as $group) {
            $groups[] = $this->groupRepository->find($group['id']);
        }

//        return $this->returnSuccess([
//            'group' => $this->groupRepository->find(2)
//        ]);

        return $this->returnSuccess([
            'groups' => $groupsAll,
        ]);
    }

    public function putEditGroup(StandardRequest $request, $id)
    {
        /** @var Group $group */
        $group = $this->groupRepository->find($id);

        if($group === null){
            return $this->returnError(500, UserErrorCodes::GROUP_NOT_IN_DB);
        }

        $lecturesEntry = $request->get('lectures');
        $lectures      = [];

        for ($i = 0; $i < count($lecturesEntry); $i++) {
            $lectures[] = $this->lectureRepository->find($lecturesEntry[$i]);
        }
        $group->setLectures($lectures);
        $group->setName($request->get('name'));
        $group->setYear($request->get('year'));

        $this->groupRepository->update($group);

        return $this->returnSuccess([
            'group' => $group
        ]);
    }

    public function deleteGroup($id)
    {
        $group = $this->groupRepository->find($id);
        if ($group=== null) {
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