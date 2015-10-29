<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 10/29/2015
 * Time: 12:42 PM
 */

namespace StudentInfo\Models;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use LaravelDoctrine\ACL\Contracts\Permission;
use LaravelDoctrine\ACL\Contracts\Role as RoleContract;


class Role implements RoleContract
{

    /**
     * @param string $permission
     *
     * @return bool
     */
    public function hasPermissionTo($permission)
    {
        // TODO: Implement hasPermissionTo() method.
    }

    /**
     * @return ArrayCollection|Permission[]
     */
    public function getPermissions()
    {
        // TODO: Implement getPermissions() method.
    }

    /**
     * @return string
     */
    public function getName()
    {
        // TODO: Implement getName() method.
    }
}