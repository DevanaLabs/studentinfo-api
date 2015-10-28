<?php
namespace StudentInfo\ValueObjects;

use Illuminate\Support\Facades\Hash;

/**
 * Created by PhpStorm.
 * User: Nebojsa
 * Date: 10/28/2015
 * Time: 4:59 PM
 */
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
        $this->hashedPassword = $this->HashPassword($password);
    }

    /**
     * @param $password
     * @return string
     */
    public function HashPassword($password)
    {
        return Hash::make($password);
    }
}