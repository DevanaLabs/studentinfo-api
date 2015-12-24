<?php

namespace StudentInfo\Models;


class Feedback
{
    /**
     * @var int
     */
    protected $id;

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