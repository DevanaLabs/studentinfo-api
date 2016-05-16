<?php

namespace StudentInfo\Repositories;


interface TeacherRepositoryInterface extends RepositoryInterface
{
    public function findByName($firstName, $lastName, $faculty);
}