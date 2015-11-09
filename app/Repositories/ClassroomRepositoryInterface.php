<?php

namespace StudentInfo\Repositories;


interface ClassroomRepositoryInterface extends RepositoryInterface
{
    public function findClassroomByName($name);
}