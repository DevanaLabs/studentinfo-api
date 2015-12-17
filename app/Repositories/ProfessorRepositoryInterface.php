<?php

namespace StudentInfo\Repositories;


use StudentInfo\Models\Faculty;

interface ProfessorRepositoryInterface extends RepositoryInterface
{
    public function findByName($firstName, $lastName);

    public function getAllProfessorForFaculty(Faculty $faculty, $start = 0, $count = 20);

    public function persist($object);

    public function flush();
}