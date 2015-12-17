<?php

namespace StudentInfo\Repositories;


interface LectureRepositoryInterface extends RepositoryInterface
{
    public function persist($object);

    public function flush();
}