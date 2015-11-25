<?php

namespace StudentInfo\Repositories;

use StudentInfo\Models\Faculty;

interface StudentRepositoryInterface extends RepositoryInterface
{
    /**
     * @param     $faculty Faculty
     * @param int $start
     * @param int $count
     * @return
     */
    public function getAllStudentsForFaculty(Faculty $faculty, $start = 0, $count = 20);

    /**
     * @param $indexNumber
     */
    public function findByIndexNumber($indexNumber);
}