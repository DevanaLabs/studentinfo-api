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
     * @var ArrayCollection|Lecture[]
     */
    protected $lectures;

    /**
     * @var ArrayCollection|Student[]
     */
    protected $students;

    /**
     * @var ArrayCollection|CourseEvent[]
     */
    protected $events;

    /**
     * Course constructor.
     */
    public function __construct()
    {
        $this->lectures = new ArrayCollection();
        $this->students = new ArrayCollection();
        $this->events = new ArrayCollection();
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
     * @return ArrayCollection|Student[]
     */
    public function getStudents()
    {
        return $this->students;
    }

    /**
     * @param ArrayCollection|Student[] $students
     */
    public function setStudents($students)
    {
        $this->students = $students;
    }

    /**
     * @param Lecture $lecture
     * @return Lecture
     */
    public function addLecture(Lecture $lecture)
    {
        return $this->lectures[]=$lecture;
    }

    /**
     * @return ArrayCollection|CourseEvent[]
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @param ArrayCollection|CourseEvent[] $events
     */
    public function setEvents($events)
    {
        $this->events = $events;
    }
}