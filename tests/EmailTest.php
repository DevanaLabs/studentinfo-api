<?php

use StudentInfo\ValueObjects\Exceptions\InvalidEmailException;

class EmailTest extends TestCase
{
    /**
     * Tests parsing valid email
     *
     * @return void
     */
    public function testParseWithValidData()
    {
        $emailString = "some_email@some_domain.com";
        try {
            $email = \StudentInfo\ValueObjects\Email::parse($emailString);
            $this->assertEquals($email->getEmail(), $emailString);
        } catch (InvalidEmailException $e) {
            $this->fail("Email parse throws " . typeOf($e) . ", failed");
        }
    }

    /**
     * Tests parsing couple of invalid emails
     *
     * @return void
     */
    public function testParseWithInvalidData()
    {
        $emailsArray = array(
            "email@domain",
            "email_domain.com",
            "@domain.com",
            "wrong",
        );
        foreach ($emailsArray as $emailString) {
            $this->setExpectedException("StudentInfo\\ValueObjects\\Exceptions\\InvalidEmailException");
            $email = \StudentInfo\ValueObjects\Email::parse($emailString);
        }
    }
}
