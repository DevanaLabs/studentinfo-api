<?php

namespace StudentInfo\Repositories;


interface GroupRepositoryInterface extends RepositoryInterface
{
    public function findByName($name);

    public function getAllYears();

    public function getAllGroups($year);
}