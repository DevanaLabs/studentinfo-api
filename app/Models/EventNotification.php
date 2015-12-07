<?php

namespace StudentInfo\Models;


class EventNotification extends Notification
{
    /**
     * @var Event
     */
    protected $event;

    /**
     * @return Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param Event $event
     */
    public function setEvent($event)
    {
        $this->event = $event;
    }
}