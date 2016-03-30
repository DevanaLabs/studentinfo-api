<?php


namespace StudentInfo\Models;


use Carbon\Carbon;
use DateTime;

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
     * @var DateTime
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
     * @return DateTime
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * @param DateTime $expiresAt
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
        return $this->getExpiresAt() < Carbon::now();
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return !$this->isExpired();
    }

    
    
    

}