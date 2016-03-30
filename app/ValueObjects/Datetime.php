<?php

namespace StudentInfo\ValueObjects;

use DateTime as DateTimeDateTime;

class Datetime
{
    /**
     * @var DateTimeDateTime
     */
    protected $startsAt;

    /**
     * @var DateTimeDateTime
     */
    protected $endsAt;

    /**
     * @return DateTimeDateTime
     */
    public function getStartsAt()
    {
        return $this->startsAt;
    }

    /**
     * @param DateTimeDateTime $startsAt
     */
    public function setStartsAt($startsAt)
    {
        $this->startsAt = $startsAt;
    }

    /**
     * @return DateTimeDateTime
     */
    public function getEndsAt()
    {
        return $this->endsAt;
    }

    /**
     * @param DateTimeDateTime $endsAt
     */
    public function setEndsAt($endsAt)
    {
        $this->endsAt = $endsAt;
    }
}