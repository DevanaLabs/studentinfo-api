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
     * @var int
     */
    protected $year;

    /**
     * @var ArrayCollection
     */
    protected $courses;

    /**
     * @var ArrayCollection
     */
    protected $lectures;

    /**
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param int $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

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
     * @return ArrayCollection
     */
    public function getCourses()
    {
        return $this->courses;
    }

    /**
     * @param ArrayCollection $courses
     */
    public function setCourses($courses)
    {
        $this->courses = $courses;
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
