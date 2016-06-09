<?php namespace StudentInfo\Models;

use Carbon\Carbon;

class ActivityLog
{
    /**
     * @var
     */
    private $id;

    /**
     * @var Carbon
     */
    private $created_at;

    /**
     * @var
     */
    private $sender;

    /**
     * ActivityLog constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Carbon
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param Carbon $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return mixed
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @param mixed $sender
     */
    public function setSender($sender)
    {
        $this->sender = $sender;
    }

}