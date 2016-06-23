<?php namespace StudentInfo\Models;

use Doctrine\Common\Collections\ArrayCollection;

class PollQuestion
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    private $text;

    /**
     * @var ArrayCollection|PollAnswer[]
     */
    protected $answers;

    /**
     * @var ArrayCollection|Faculty[]
     */
    private $faculties;

    /**
     * @var boolean
     */
    private $active;

    /**
     * PollQuestion constructor.
     *
     */
    public function __construct()
    {
        $this->faculties = new ArrayCollection();
        $this->answers   = new ArrayCollection();
    }

    /**
     * @return ArrayCollection|PollAnswer[]
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * @param ArrayCollection|PollAnswer[] $answers
     */
    public function setAnswers($answers)
    {
        $this->answers = $answers;
    }

    /**
     * @return ArrayCollection|Faculty[]
     */
    public function getFaculties()
    {
        return $this->faculties;
    }

    /**
     * @param ArrayCollection|Faculty[] $faculties
     */
    public function setFaculties($faculties)
    {
        $this->faculties = $faculties;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param boolean $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

}