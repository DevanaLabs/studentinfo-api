<?php

namespace StudentInfo\Repositories;

use StudentInfo\ValueObjects\Email;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function findByEmail(Email $email);

    public function isAdmin($id);

    public function findByRegisterToken($registerToken);

    public function getAllStudents();

    // TODO refactor
    public function findFacultyByName($name);

    public function findById($id);


}