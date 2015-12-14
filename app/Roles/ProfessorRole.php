<?php

namespace StudentInfo\Roles;


class ProfessorRole extends Role
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
            'event.create',
            'event.update',
        ];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'professor_role';
    }
}