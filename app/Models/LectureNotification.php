<?php

namespace StudentInfo\Models;


class LectureNotification extends Notification
{
    /**
     * @var Lecture
     */
    protected $lecture;

    /**
     * @return Lecture
     */
    public function getLecture()
    {
        return $this->lecture;
    }

    /**
     * @param Lecture $lecture
     */
    public function setLecture($lecture)
    {
        $this->lecture = $lecture;
    }
}