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

    public function addGroups(AddGroupRequest $request)
    {
        $addedGroups = [];

        $failedToAddGroups= [];

        $groups = $request->get('groups');

        for ($count = 0; $count < count($groups); $count++){
            $lectures = [];
            $group = new Group();
            $group->setName($groups[$count]['name']);

            for ($i = 0; $i < count($groups[$count]['lectures']); $i++) {
                $lectures[] = $this->lectureRepository->find($groups[$count]['lectures'][$i]);
            }

            $group->setLectures($lectures);
            if ($this->groupRepository->findByName($groups[$count]['name'])) {
                $failedToAddGroups[] = $group;
                continue;
            }

            $this->groupRepository->create($group);

            $addedGroups[] = $group;
        }

        return $this->returnSuccess([
            'successful'   => $addedGroups,
            'unsuccessful' => $failedToAddGroups,
        ]);

    }

    public function getGroups()
    {
        $groups = $this->groupRepository->all();

        return $this->returnSuccess($groups);

    }

    public function getEditGroup($id)
    {
        $group = $this->groupRepository->find($id);

        if($group  === null){
            return $this->returnError(500, UserErrorCodes::GROUP_NOT_IN_DB);
        }

        return $this->returnSuccess([
            'group' => $group
        ]);
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

    public function deleteGroup(StandardRequest $request)
    {
        $ids = $request->get('ids');
        $deletedGroups = [];

        foreach($ids as $id)
        {
            $group = $this->groupRepository->find($id);
            if ($group=== null)
            {
                continue;
            }
            $this->groupRepository->destroy($group);
            $deletedGroups[] = $id;
        }
        return $this->returnSuccess([
                'deletedClassrooms' => $deletedGroups
            ]
        );
    }
}