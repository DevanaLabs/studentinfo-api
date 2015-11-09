<?php

namespace StudentInfo\Repositories;


interface LectureRepositoryInterface extends RepositoryInterface
{
    public function getProfessor();

    public function getStudents();

    public function getTime();
}