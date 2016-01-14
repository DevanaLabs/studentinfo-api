<?php

namespace StudentInfo\Models;

use Carbon\Carbon;
use Doctrine\ORM\Mapping as ORM;
use LaravelDoctrine\ACL\Contracts\BelongsToOrganisation as BelongsToOrganisationContract;
use LaravelDoctrine\ACL\Contracts\HasRoles as HasRolesContract;
use LaravelDoctrine\ACL\Mappings as ACL;
use LaravelDoctrine\ACL\Organisations\BelongsToOrganisation;
use LaravelDoctrine\ACL\Permissions\HasPermissions;
use LaravelDoctrine\ORM\Contracts\Auth\Authenticatable;
use StudentInfo\ValueObjects\Email;
use StudentInfo\ValueObjects\Password;


abstract class User implements HasRolesContract, Authenticatable, BelongsToOrganisationContract
{
    use HasPermissions;
    use BelongsToOrganisation;

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
     * @var \DateTime
     */
    protected $registerTokenCreatedAt;

    /**
     * @var Faculty
     */
    protected $organisation;

    /**
     * @return bool
     */
    public function isRegisterTokenExpired()
    {
        return Carbon::instance($this->getRegisterTokenCreatedAt())->diffInHours(Carbon::now()) > 48;
    }

    /**
     * @return Faculty
     */
    public function getOrganisation()
    {
        return $this->organisation;
    }

    /**
     * @param Faculty
     */
    public function setOrganisation(Faculty $organisation)
    {
        $this->organisation = $organisation;
    }

    /**
     * @return \DateTime
     */
    public function getRegisterTokenCreatedAt()
    {
        return $this->registerTokenCreatedAt;
    }

    /**
     * @return string
     */
    public function getRegisterToken()
    {
        return $this->registerToken;
    }

    /**
     * @return string
     */
    public function generateRegisterToken()
    {
        $this->registerTokenCreatedAt = Carbon::now();
        return $this->registerToken = md5($this->email->getEmail() . time());
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

    /**
     * @param string $registerToken
     */
    public function setRegisterToken($registerToken)
    {
        $this->registerToken = $registerToken;
    }

    /**
     * @return int
     */
    public function getAuthIdentifier()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password->getPassword();
    }

    /**
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'id';
    }

    /**
     * @return string
     */
    public function getRememberToken()
    {
        return $this->rememberToken;
    }

    /**
     * @param string $value
     */
    public function setRememberToken($value)
    {
        $this->rememberToken = $value;
    }

    /**
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }

}
