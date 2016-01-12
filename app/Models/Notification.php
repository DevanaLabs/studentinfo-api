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
     * @var Faculty
     */
    protected $organisation;
    
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
     * @return Faculty
     */
    public function getOrganisation()
    {
        return $this->organisation;
    }

    /**
     * @param Faculty $organisation
     */
    public function setOrganisation($organisation)
    {
        $this->organisation = $organisation;
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