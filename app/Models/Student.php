<?php

namespace StudentInfo\Models;

use Doctrine\Common\Collections\ArrayCollection;
use LaravelDoctrine\ACL\Contracts\Role;
use StudentInfo\Roles\StudentRole;

class Student extends User
{
    /**
     * @var string
     */
    protected $indexNumber;

    /**
     * @return string
     */
    public function getIndexNumber()
    {
        return $this->indexNumber;
    }

    /**
     * @param string $indexNumber
     */
    public function setIndexNumber($indexNumber)
    {
        $this->indexNumber = $indexNumber;
    }

    /**
     * @return ArrayCollection|Role[]
     */
    public function getRoles()
    {
        return [
            new StudentRole,
        ];
    }

}
