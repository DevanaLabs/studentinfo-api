<?php

namespace StudentInfo\Models;


class GroupEvent extends Event
{
    /**
     * @var Group
     */
    protected $group;

    /**
     * @return Group
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param Group $group
     */
    public function setGroup($group)
    {
        $this->group = $group;
    }
}