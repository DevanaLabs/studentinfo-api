<?php

namespace StudentInfo\Repositories;


interface LectureNotificationRepositoryInterface extends RepositoryInterface
{
    public function getForInterval($faculty, $startsAt, $endsAt);
}