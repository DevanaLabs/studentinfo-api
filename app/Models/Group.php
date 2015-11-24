<?php
/**
 * Created by PhpStorm.
 * User: Nebojsa
 * Date: 11/23/2015
 * Time: 3:31 PM
 */

namespace StudentInfo\Models;


use Doctrine\Common\Collections\ArrayCollection;

class Group
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var String
     */
    protected $name;

    /**
     * @var ArrayCollection|Lecture[]
     */
    protected $lectures;

    /**
     * Group constructor.
     */
    public function __construct()
    {
        $this->lectures = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return String
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param String $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return ArrayCollection|Lecture[]
     */
    public function getLectures()
    {
        return $this->lectures;
    }

    /**
     * @param ArrayCollection|Lecture[] $lectures
     */
    public function setLectures($lectures)
    {
        $this->lectures = $lectures;
    }
}