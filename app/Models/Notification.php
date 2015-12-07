<?php


namespace StudentInfo\Models;


use Carbon\Carbon;

abstract class Notification
{
    /**
     * @var
     */
    protected $id;
    
    /**
     * @var
     */
    protected $description;
    
    /**
     * @var Carbon
     */
    protected $expiresAt;

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
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * @param Carbon $expiresAt
     */
    public function setExpiresAt($expiresAt)
    {
        $this->expiresAt = $expiresAt;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isExpired()
    {
        return $this->getExpiresAt()->lt(Carbon::now());
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return !$this->isExpired();
    }

    
    
    

}