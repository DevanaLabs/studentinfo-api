<?php
namespace StudentInfo\Roles;


class SuperUserRole extends Role
{

    /**
     * Returns the permission of this role.
     *
     * @return array
     */
    public function getPermissions()
    {
        return [
            'admin.create',
            'admin.retrieve',
            'admin.update',
            'admin.delete',
            'faculty.create',
            'faculty.retrieve',
            'faculty.update',
            'faculty.delete',
        ];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'superUser_role';
    }
}