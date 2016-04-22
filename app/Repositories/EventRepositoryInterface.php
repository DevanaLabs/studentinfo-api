<?php


namespace StudentInfo\Repositories;


interface EventRepositoryInterface extends RepositoryInterface
{
    public function persist($object);

    public function flush();
}