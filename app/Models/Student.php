<?php

namespace StudentInfo\Models;

class Student extends User
{

    /**
     * @var string
     */
    private $indexNumber;
    /**
     * @var User
     */
    private $user;

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

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

}
