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
            'user.edit',
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