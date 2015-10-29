<?php

namespace StudentInfo\ValueObjects;

use Illuminate\Support\Facades\Hash;

class Password
{
    /**
     * @var string
     */
    private $hashedPassword;

    /**
     * Password constructor.
     * @param $password
     */
    public function __construct($password)
    {
        $this->hashedPassword = $this->hashPassword($password);
    }

    /**
     * @param $password password to hash
     * @return string
     */
    protected function hashPassword($password)
    {
        return Hash::make($password);
    }

    /**
     * @return string
     */
    public function getHashedPassword()
    {
        return $this->hashedPassword;
    }
}