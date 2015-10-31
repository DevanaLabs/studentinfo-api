<?php

namespace StudentInfo\ValueObjects;

use Illuminate\Support\Facades\Validator;
use StudentInfo\ValueObjects\Exceptions\InvalidEmailException;

class Email
{
    /**
     * @var string
     */
    private $email;

    /**
     * @param string $email
     *
     * @throws InvalidEmailException
     */
    public function __construct($email)
    {
        $validator = Validator::make(['email' => $email], [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            throw new InvalidEmailException("The email: {$email} is not a valid email address.");
        }

        $this->email = $email;

    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Parses the input string to Email.
     *
     * @param string $email
     *
     * @return Email
     */
    public static function parse($email)
    {
        return new self($email);
    }
}