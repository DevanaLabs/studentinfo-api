<?php

namespace StudentInfo\Models;

use Doctrine\ORM\Mapping as ORM;
use LaravelDoctrine\ACL\Contracts\Organisation;
use LaravelDoctrine\ACL\Mappings as ACL;

class Faculty implements Organisation
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $university;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getUniversity()
    {
        return $this->university;
    }

    /**
     * @param string $university
     */
    public function setUniversity($university)
    {
        $this->university = $university;
    }
}