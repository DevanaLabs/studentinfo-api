<?php

namespace StudentInfo\Roles;


class StudentRole extends Role
{

    /**
     * Returns the permission of this role.
     *
     * @return array
     */
    public function getPermissions()
    {
        return [
            'user.update',
            'event.retrieve',
            'groups.retrieve',
            'notification.retrieve',
        ];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'student_role';
    }
}