<?php

namespace StudentInfo\Repositories;


interface FacultyRepositoryInterface extends RepositoryInterface
{
    public function findFacultyByName($name);
}