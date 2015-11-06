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
     * @var ArrayCollection|Course[]
     */
    protected $courses;

    /**
     * @var ArrayCollection|Lecture[]
     */
    protected $lectures;

    /**
     * Student constructor.
     */
    public function __construct()
    {
        $this->courses = new ArrayCollection();
        $this->lectures = new ArrayCollection();
    }

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
     * @return ArrayCollection|Lecture[]
     */
    public function getLectures()
    {
        return $this->lectures;
    }

    /**
     * @param ArrayCollection|Lecture[] $lectures
     */
    public function setLectures($lectures)
    {
        $this->lectures = $lectures;
    }

    /**
     * @return ArrayCollection|Course[]
     */
    public function getCourses()
    {
        return $this->courses;
    }

    /**
     * @param ArrayCollection|Course[] $courses
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
