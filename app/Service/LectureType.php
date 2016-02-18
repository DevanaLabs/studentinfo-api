<?php

namespace StudentInfo\Service;


class LectureType
{
    protected $lecture = [
        '0' => 'Предавање',
        '1' => 'Vežbe',
    ];

    public function LectureTypeFromId($id)
    {
        return $this->lecture[$id];
    }
}