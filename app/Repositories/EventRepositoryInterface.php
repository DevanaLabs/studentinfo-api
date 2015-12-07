<?php


namespace StudentInfo\Repositories;


interface EventRepositoryInterface extends RepositoryInterface
{
    public function findAllForGroup($id);
}