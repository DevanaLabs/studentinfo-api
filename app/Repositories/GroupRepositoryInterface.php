<?php

namespace StudentInfo\Repositories;


interface GroupRepositoryInterface extends RepositoryInterface
{
    public function findByName($name, $faculty);
}