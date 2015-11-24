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
            'student.edit',
            'student.create',
            'student.delete',
            'student.retrieve',
            'classroom.create',
            'classroom.delete',
            'classroom.edit',
            'classroom.retrieve',
            'professor.create',
            'professor.delete',
            'professor.edit',
            'professor.retrieve',
            'course.create',
            'course.delete',
            'course.edit',
            'course.retrieve',
            'lecture.create',
            'lecture.delete',
            'lecture.edit',
            'lecture.retrieve',
            'group.create',
            'group.edit',
            'group.retrieve',
            'group.delete'
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