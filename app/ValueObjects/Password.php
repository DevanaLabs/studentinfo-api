<?php

namespace StudentInfo\ValueObjects;

use Illuminate\Support\Facades\Hash;

class Password
{
    /**
     * @var string
     */
    private $password;

    /**
     * Password constructor.
     * @param $password
     */
    public function __construct($password)
    {
        $this->password = $this->hashPassword($password);
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
     * @param $anotherPassword
     * @return boolean
     */
    public function checkAgainst($anotherPassword)
    {
        return Hash::check($anotherPassword, $this->getPassword());
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

}