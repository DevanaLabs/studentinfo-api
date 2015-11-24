<?php

namespace StudentInfo\Models;


use Doctrine\Common\Collections\ArrayCollection;

class Group
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var Stringl
     */
    protected $name;

    /**
     * @var ArrayCollection|Lecture[]
     */
    protected $lectures;

    /**
     * Group constructor.
     */
    public function __construct()
    {
        $this->lectures = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return String
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param String $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
}