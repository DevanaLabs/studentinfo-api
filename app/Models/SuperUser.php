<?php

namespace StudentInfo\Models;


use Doctrine\Common\Collections\ArrayCollection;
use LaravelDoctrine\ACL\Contracts\Role;
use StudentInfo\Roles\SuperUserRole;

class SuperUser extends User
{
    /**
     * @return ArrayCollection|Role[]
     */
    public function getRoles()
    {
        return [
            new SuperUserRole,
        ];
    }
}