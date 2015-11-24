<?php

namespace StudentInfo\Repositories;


interface ProfessorRepositoryInterface extends RepositoryInterface
{
    public function findByName($firstName, $lastName);
}