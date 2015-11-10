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
            'course.add',
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