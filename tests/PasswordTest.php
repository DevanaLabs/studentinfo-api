<?php

use \StudentInfo\ValueObjects\Password;

class PasswordTest extends TestCase
{
    /**
     * Tests creating a new Password object
     *
     * @return void
     */
    public function testNewPassword()
    {
        $passwordString = "test_password";
        $password       = new Password($passwordString);

        $this->assertTrue($password->checkAgainst($passwordString));
        $this->assertFalse($password->checkAgainst("this_is_wrong"));
    }
}
