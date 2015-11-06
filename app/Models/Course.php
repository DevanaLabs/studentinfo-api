<?php

namespace StudentInfo\Models;

use Doctrine\Common\Collections\ArrayCollection;

class Course
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $code;

    /**
     * @var int
     */
    protected $semester;

    /**
     * @var int
     */
    protected $esp;

    /**
     * @var ArrayCollection
     */
    protected $lectures;
    /**
     * @var ArrayCollection
     */
    protected $students;

    /**
     * @return ArrayCollection
     */
    public function getLectures()
    {
        return $this->lectures;
    }

    /**
     * @param ArrayCollection $lectures
     */
    public function setLectures($lectures)
    {
        $this->lectures = $lectures;
    }

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
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return int
     */
    public function getSemester()
    {
        return $this->semester;
    }

    /**
     * @param int $semester
     */
    public function setSemester($semester)
    {
        $this->semester = $semester;
    }

    /**
     * @return int
     */
    public function getEsp()
    {
        return $this->esp;
    }

    /**
     * @param int $esp
     */
    public function setEsp($esp)
    {
        $this->esp = $esp;
    }

    /**
     * @return ArrayCollection
     */
    public function getStudents()
    {
        return $this->students;
    }

    /**
     * @param ArrayCollection $students
     */
    public function setStudents($students)
    {
        $this->students = $students;
    }

}