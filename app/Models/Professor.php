<?php

namespace StudentInfo\Models;


use Doctrine\Common\Collections\ArrayCollection;
use LaravelDoctrine\ACL\Contracts\Role;
use StudentInfo\Roles\ProfessorRole;

class Professor extends Teacher
{
    /**
     * @return ArrayCollection|Role[]
     */
    public function getRoles()
    {
        return [
            new ProfessorRole,
        ];
    }
}
