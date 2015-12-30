<?php

namespace StudentInfo\Models;


use Doctrine\Common\Collections\ArrayCollection;
use StudentInfo\ValueObjects\Datetime;

abstract class Event
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var String
     */
    protected $type;

    /**
     * #var String
     */
    protected $description;

    /**
     * @var Datetime
     */
    protected $datetime;

    /**
     * @var ArrayCollection|EventNotification[]
     */
    protected $notifications;

    /**
     * @var ArrayCollection|Classroom[]
     */
    protected $classrooms;

    /**
     * Event constructor.
     */
    public function __construct()
    {
        $this->classrooms    = new ArrayCollection();
        $this->notifications = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return String
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param String $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return Datetime
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * @param Datetime $datetime
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;
    }

    /**
     * @return ArrayCollection|EventNotification[]
     */
    public function getNotifications()
    {
        return $this->notifications;
    }

    /**
     * @param ArrayCollection|EventNotification[] $notifications
     */
    public function setNotifications($notifications)
    {
        $this->notifications = $notifications;
    }

    /**
     * @return ArrayCollection|Classroom[]
     */
    public function getClassrooms()
    {
        return $this->classrooms;
    }

    /**
     * @param ArrayCollection|Classroom[] $classrooms
     */
    public function setClassrooms($classrooms)
    {
        $this->classrooms = $classrooms;
    }
}