<?php

namespace StudentInfo\Repositories;


interface DeviceTokenRepositoryInterface extends RepositoryInterface
{
    public function findByDeviceToken($deviceToken);
}