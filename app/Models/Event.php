<?php

namespace StudentInfo\Models;


use Carbon\Carbon;

class Event
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var Lecture
     */
    protected $lecture;

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
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Lecture
     */
    public function getLecture()
    {
        return $this->lecture;
    }

    /**
     * @param Lecture $lecture
     */
    public function setLecture(Lecture $lecture)
    {
        $this->lecture = $lecture;
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

}