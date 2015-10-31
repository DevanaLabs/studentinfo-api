<?php

namespace StudentInfo\Repositories;

use StudentInfo\ValueObjects\Email;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function findByEmail(Email $email);
}