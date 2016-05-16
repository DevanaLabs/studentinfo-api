<?php

namespace StudentInfo\Repositories;


interface CourseRepositoryInterface extends RepositoryInterface
{
    public function getAllStudentsListening($courseId);

    public function getAllProfessorsTeaching($courseId);

    public function findByCode($code);

    public function findByName($name, $faculty);

    public function persist($object);

    public function flush();
}