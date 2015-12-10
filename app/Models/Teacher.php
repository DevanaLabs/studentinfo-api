<?php

namespace StudentInfo\Models;

use Doctrine\Common\Collections\ArrayCollection;

abstract class Teacher extends User
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var ArrayCollection|Lecture[]
     */
    protected $lectures;

    /**
     * Professor constructor.
     */
    public function __construct()
    {
        $this->lectures = new ArrayCollection();
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
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param Lecture $lecture
     */
    public function addLecture($lecture)
    {
        $this->lectures[] = $lecture;
    }
}