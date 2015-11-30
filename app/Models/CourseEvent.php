<?php

namespace StudentInfo\Models;

class CourseEvent extends Event
{
    /**
     * @var Course
     */
    protected $course;

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
}