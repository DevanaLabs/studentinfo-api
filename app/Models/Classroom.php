<?php

namespace StudentInfo\Models;

use Doctrine\Common\Collections\ArrayCollection;

class Classroom
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $directions;

    /**
     * @var ArrayCollection|Lecture[]
     */
    protected $lectures;

    /**
     * @var ArrayCollection|Event[]
     */
    protected $events;

    /**
     * Classroom constructor.
     */
    public function __construct()
    {
        $this->lectures = new ArrayCollection();
        $this->events = new ArrayCollection();
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDirections()
    {
        return $this->directions;
    }

    /**
     * @param string $directions
     */
    public function setDirections($directions)
    {
        $this->directions = $directions;
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
     * @return ArrayCollection|Event[]
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @param ArrayCollection|Event[] $events
     */
    public function setEvents($events)
    {
        $this->events = $events;
    }
}