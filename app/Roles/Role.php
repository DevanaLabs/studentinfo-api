<?php

namespace StudentInfo\Roles;

use Doctrine\ORM\Mapping as ORM;
use LaravelDoctrine\ACL\Contracts\Role as RoleContract;
use LaravelDoctrine\ACL\Permissions\HasPermissions;


abstract class Role implements RoleContract
{

    use HasPermissions;

    /**
     * Returns the permission of this role.
     *
     * @return array
     */
    public abstract function getPermissions();

    /**
     * @return string
     */
    public abstract function getName();
}