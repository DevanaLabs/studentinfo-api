<?php

namespace StudentInfo\Repositories;

use StudentInfo\Models\Faculty;

interface StudentRepositoryInterface extends RepositoryInterface
{
    /**
     * @param $faculty Faculty
     */
    public function getAllStudentsForFaculty($faculty);
}