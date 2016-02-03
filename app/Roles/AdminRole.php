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
            'student.create',
            'student.retrieve',
            'student.update',
            'student.delete',
            'classroom.create',
            'classroom.retrieve',
            'classroom.update',
            'classroom.delete',
            'teacher.create',
            'teacher.retrieve',
            'teacher.update',
            'teacher.delete',
            'course.create',
            'course.retrieve',
            'course.update',
            'course.delete',
            'lecture.create',
            'lecture.retrieve',
            'lecture.update',
            'lecture.delete',
            'group.create',
            'group.retrieve',
            'group.update',
            'group.delete',
            'event.create',
            'event.retrieve',
            'event.update',
            'event.delete',
            'notification.create',
            'notification.retrieve',
            'notification.update',
            'notification.delete',
            'feedback.create',
            'feedback.retrieve',
            'feedback.update',
            'feedback.delete',
            'token.create',
            'token.retrieve',
            'token.update',
            'token.delete',
            'image.create',
            'language.set',
            'token.update',
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