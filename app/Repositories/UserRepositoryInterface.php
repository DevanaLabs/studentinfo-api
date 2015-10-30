<?php

namespace StudentInfo\Repositories;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function findByEmail($email);
}