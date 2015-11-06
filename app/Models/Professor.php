<?php

namespace StudentInfo\Models;


use Doctrine\Common\Collections\ArrayCollection;

abstract class Professor
{
    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $firstName;
    /**
     * @var string
     */
    protected $lastName;

    /**
     * @var ArrayCollection
     */
    protected $lectures;

    /**
     * @return ArrayCollection
     */
    public function getLectures()
    {
        return $this->lectures;
    }

    /**
     * @param ArrayCollection $lectures
     */
    public function setLectures($lectures)
    {
        $this->lectures = $lectures;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

}
