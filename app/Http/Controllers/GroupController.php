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
        $groups = $this->groupRepository->all($start, $count);

        return $this->returnSuccess($groups);

    }

    public function putEditGroup(StandardRequest $request, $id)
    {
        /** @var Group $group */
        $group = $this->groupRepository->find($id);

        if($group === null){
            return $this->returnError(500, UserErrorCodes::GROUP_NOT_IN_DB);
        }

        $group->setName($request->get('name'));
        $group->setLectures($request->get('lectures'));

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
}