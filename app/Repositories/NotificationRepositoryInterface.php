<?php


namespace StudentInfo\Repositories;


use Carbon\Carbon;

interface NotificationRepositoryInterface extends RepositoryInterface
{
    public function getForInterval(Carbon $start, Carbon $end);
}