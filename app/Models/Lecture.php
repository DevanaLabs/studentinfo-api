<?php

namespace StudentInfo\Models;

use Doctrine\Common\Collections\ArrayCollection;
use StudentInfo\ValueObjects\Time;

class Lecture
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var int
     */
    protected $type;

    /**
     * @var Course
     */
    protected $course;

    /**
     * @var Teacher
     */
    protected $teacher;

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
     * @var Time
     */
    protected $time;

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
     * @param int $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return int
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
     * @return Teacher
     */
    public function getTeacher()
    {
        return $this->teacher;
    }

    /**
     * @param Teacher $teacher
     */
    public function setTeacher($teacher)
    {
        $this->teacher = $teacher;
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
     * @return Time
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param Time $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    public function getNotificationCount()
    {
        return $this->notifications->count();
    }
}