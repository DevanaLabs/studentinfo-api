<?php

namespace StudentInfo\Repositories;


interface EventNotificationRepositoryInterface extends RepositoryInterface
{
    public function getForInterval($faculty, $startsAt, $endsAt);
}