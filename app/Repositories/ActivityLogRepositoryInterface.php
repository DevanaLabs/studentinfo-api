<?php

namespace StudentInfo\Repositories;


interface ActivityLogRepositoryInterface extends RepositoryInterface
{
    public function getInactiveFor($minutes);

    public function findBySender($sender);
}