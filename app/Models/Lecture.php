<?php

namespace StudentInfo\Models;

use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;

class Lecture
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var Course
     */
    protected $course;

    /**
     * @var Professor
     */
    protected $professor;

    /**
     * @var Classroom
     */
    protected $classroom;

    /**
     * @var ArrayCollection|Student[]
     */
    protected $students;

    /**
     * @var ArrayCollection|Group[]
     */
    protected $groups;

    /**
     * @var ArrayCollection|LectureNotification[]
     */
    protected $notifications;

    /**
     * @var Carbon
     */
    protected $startsAt;

    /**
     * @var Carbon
     */
    protected $endsAt;

    /**
     * Lecture constructor.
     */
    public function __construct()
    {
        $this->students = new ArrayCollection();
        $this->groups = new ArrayCollection();
        $this->notifications = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return Course
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * @param Course $course
     */
    public function setCourse($course)
    {
        $this->course = $course;
    }

    /**
     * @return Professor
     */
    public function getProfessor()
    {
        return $this->professor;
    }

    /**
     * @param Professor $professor
     */
    public function setProfessor($professor)
    {
        $this->professor = $professor;
    }

    /**
     * @return Classroom
     */
    public function getClassroom()
    {
        return $this->classroom;
    }

    /**
     * @param Classroom $classroom
     */
    public function setClassroom($classroom)
    {
        $this->classroom = $classroom;
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
     * @return ArrayCollection|Group[]
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * @param ArrayCollection|Group[] $groups
     */
    public function setGroups($groups)
    {
        $this->groups = $groups;
    }

    /**
     * @return ArrayCollection|LectureNotification
     */
    public function getNotification()
    {
        return $this->notifications;
    }

    /**
     * @param ArrayCollection|LectureNotification $notifications
     */
    public function setNotification($notifications)
    {
        $this->notifications = $notifications;
    }

    /**
     * @return Carbon
     */
    public function getStartsAt()
    {
        return $this->startsAt;
    }

    /**
     * @param Carbon $startsAt
     */
    public function setStartsAt($startsAt)
    {
        $this->startsAt = $startsAt;
    }

    /**
     * @return Carbon
     */
    public function getEndsAt()
    {
        return $this->endsAt;
    }

    /**
     * @param Carbon $endsAt
     */
    public function setEndsAt($endsAt)
    {
        $this->endsAt = $endsAt;
    }
}