<?php

namespace StudentInfo\Models;


use StudentInfo\Models\Event;

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