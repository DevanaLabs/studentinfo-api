<?php

namespace StudentInfo\Roles;


class AdminRole extends Role
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
            'user.create',
            'user.delete',
            'classroom.create',
            'professor.create',
            'course.create',
            'course.delete',
            'lecture.create',
            'lecture.delete',
            'classroom.edit',
            'professor.edit',
            'course.edit',
            'lecture.edit',
        ];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_role';
    }
}