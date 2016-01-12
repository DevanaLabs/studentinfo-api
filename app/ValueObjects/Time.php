<?php

namespace StudentInfo\ValueObjects;


class Time
{
    /**
     * @var Int
     */
    protected $startsAt;

    /**
     * @var Int
     */
    protected $endsAt;

    /**
     * @return Int
     */
    public function getStartsAt()
    {
        return $this->startsAt;
    }

    /**
     * @param Int $startsAt
     */
    public function setStartsAt($startsAt)
    {
        $this->startsAt = $startsAt;
    }

    /**
     * @return Int
     */
    public function getEndsAt()
    {
        return $this->endsAt;
    }

    /**
     * @param Int $endsAt
     */
    public function setEndsAt($endsAt)
    {
        $this->endsAt = $endsAt;
    }
}