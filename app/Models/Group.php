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
     * @var String
     */
    protected $name;

    /**
     * @var ArrayCollection|Lecture[]
     */
    protected $lectures;

    /**
     * @var ArrayCollection|GroupEvent[]
     */
    private $events;

    /**
     * Group constructor.
     */
    public function __construct()
    {
        $this->lectures = new ArrayCollection();
        $this->events = new ArrayCollection();
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

    /**
     * @return ArrayCollection|GroupEvent[]
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @param ArrayCollection|GroupEvent[] $events
     */
    public function setEvents($events)
    {
        $this->events = $events;
    }
}