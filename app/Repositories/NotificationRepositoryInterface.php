<?php


namespace StudentInfo\Repositories;


use DateTime;

interface NotificationRepositoryInterface extends RepositoryInterface
{
    public function getForInterval(DateTime $start, DateTime $end);
}