<?php

namespace StudentInfo\Models;


use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @var Carbon
     */
    protected $startsAt;

    /**
     * @var Carbon
     */
    protected $endsAt;

    /**
     * @var ArrayCollection|Notification[]
     */
    protected $notifications;

    /**
     * @var ArrayCollection|Classroom[]
     */
    protected $classrooms;

    /**
     * Event constructor.
     * @param ArrayCollection|Classroom[] $classrooms
     */
    public function __construct(ArrayCollection $classrooms)
    {
        $this->classrooms = $classrooms;
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
     * @return Carbon
     */
    public function getStartsAt()
    {
        return $this->startsAt;
    }

    /**
     * @param Carbon $startsAt
     */
    public function setStartsAt($startsAt)
    {
        $this->startsAt = $startsAt;
    }

    /**
     * @return Carbon
     */
    public function getEndsAt()
    {
        return $this->endsAt;
    }

    /**
     * @param Carbon $endsAt
     */
    public function setEndsAt($endsAt)
    {
        $this->endsAt = $endsAt;
    }

    /**
     * @return ArrayCollection|Notification[]
     */
    public function getNotifications()
    {
        return $this->notifications;
    }

    /**
     * @param ArrayCollection|Notification[] $notifications
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