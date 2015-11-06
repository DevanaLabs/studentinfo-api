<?php

namespace StudentInfo\Models;

use Doctrine\Common\Collections\ArrayCollection;

class Lecture
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var Course
     */
    private $course;

    /**
     * @var Professor
     */
    private $professor;

    /**
     * @var Classroom
     */
    private $classroom;

    /**
     * @var ArrayCollection
     */
    private $students;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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