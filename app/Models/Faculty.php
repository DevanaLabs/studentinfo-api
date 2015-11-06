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
}