<?php

namespace StudentInfo\Models;

use Carbon\Carbon;
use LaravelDoctrine\ACL\Contracts\HasRoles as HasRolesContract;
use LaravelDoctrine\ACL\Permissions\HasPermissions;
use LaravelDoctrine\ORM\Contracts\Auth\Authenticatable;
use StudentInfo\ValueObjects\Email;
use StudentInfo\ValueObjects\Password;


abstract class User implements HasRolesContract, Authenticatable
{
    use HasPermissions;

    /**
     * @var Password
     */
    protected $password;
    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $firstName;
    /**
     * @var string
     */
    protected $lastName;

    /**
     * @var Email
     */
    protected $email;

    /**
     * @var string
     */
    protected $rememberToken;

    /**
     * @var string
     */
    protected $registerToken;

    /**
     * @var datetime
     */
    protected $registerTokenCreatedAt;

    /**
     * @return string
     */
    public function getRegisterTokenCreatedAt()
    {
        return $this->registerTokenCreatedAt;
    }

    /**
     */
    public function setRegisterTokenCreatedAt()
    {
        $this->registerTokenCreatedAt = Carbon::now();
    }

    /**
     * @return string
     */
    public function getRegisterToken()
    {
        return $this->registerToken;
    }

    /**
     */
    public function setRegisterToken()
    {
        $this->registerToken = md5($this->email->getEmail() . time());
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @param Password $password
     */
    public function setPassword(Password $password)
    {
        $this->password = $password;
    }

    /**
     * @return Email
     */

    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param Email $email
     */
    public function setEmail(Email $email)
    {
        $this->email = $email;
    }

    public function getAuthIdentifier()
    {
        return $this->id;
    }

    public function getAuthPassword()
    {
        return $this->password->getPassword();
    }

    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function getRememberToken()
    {
        return $this->rememberToken;
    }

    public function setRememberToken($value)
    {
        $this->rememberToken = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    /**
     * @param $time
     * @return \DateTime
     */
    public function isExpired($time)
    {
        // TODO : Shitty code, repair it
        $format         = 'Y-m-d H:i:s';
        $token_datetime = \DateTime::createFromFormat($format, $time);
        $now            = new \DateTime();
        if ($now->diff($token_datetime)->d > 1) {
            return true;
        }
        return false;
    }

}
