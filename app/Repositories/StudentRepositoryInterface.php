<?php

namespace StudentInfo\Repositories;

use StudentInfo\Models\Faculty;

interface StudentRepositoryInterface extends RepositoryInterface
{
    public function getAllStudentsForFaculty(Faculty $faculty, $start = 0, $count = 20);

    public function findByIndexNumber($indexNumber);
}