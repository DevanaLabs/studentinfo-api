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
            'admin.edit',
            'admin.create',
            'admin.delete',
            'admin.retrieve',
            'faculty.edit',
            'faculty.create',
            'faculty.delete',
            'faculty.retrieve',
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