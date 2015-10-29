<?php

namespace StudentInfo\Models;

class Student extends User
{
    /**
     * @var string
     */
    private $indexNumber;

    /**
     * @return string
     */
    public function getIndexNumber()
    {
        return $this->indexNumber;
    }

    /**
     * @param string $indexNumber
     */
    public function setIndexNumber($indexNumber)
    {
        $this->indexNumber = $indexNumber;
    }
}
