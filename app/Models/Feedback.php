<?php

namespace StudentInfo\Models;


class Feedback
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var Faculty
     */
    protected $organisation;

    /**
     * @var String
     */
    protected $text;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     * @return String
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param String $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }
}