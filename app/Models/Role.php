<?php

namespace StudentInfo\Models;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use LaravelDoctrine\ACL\Contracts\Permission;
use LaravelDoctrine\ACL\Contracts\Role as RoleContract;


class Role implements RoleContract
{

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $roleName;
    /**
     * @var string[]
     */
    protected $permissions = [];

    /**
     * Role constructor.
     * @param int       $id
     * @param string    $roleName
     * @param \string[] $permissions
     */
    public function __construct($id, $roleName, array $permissions)
    {
        $this->id          = $id;
        $this->roleName    = $roleName;
        $this->permissions = $permissions;
    }

    /**
     * Adds permission.
     * @param string $permission
     * @return $this
     */
    public function addPermission($permission)
    {
        if (!in_array($permission, $this->getPermissions()))
            $this->permissions[] = $permission;
        return $this;
    }

    /**
     * @return ArrayCollection|Permission[]
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * @param string $permission
     *
     * @return bool
     */
    public function hasPermissionTo($permission)
    {
        return in_array($permission, $this->getPermissions());
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->roleName;
    }
}