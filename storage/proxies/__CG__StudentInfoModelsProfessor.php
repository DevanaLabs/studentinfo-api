<?php

namespace DoctrineProxies\__CG__\StudentInfo\Models;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Professor extends \StudentInfo\Models\Professor implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = array();



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return array('__isInitialized__', 'title', 'lectures', 'password', 'id', 'firstName', 'lastName', 'email', 'rememberToken', 'registerToken', 'registerTokenCreatedAt', 'organisation');
        }

        return array('__isInitialized__', 'title', 'lectures', 'password', 'id', 'firstName', 'lastName', 'email', 'rememberToken', 'registerToken', 'registerTokenCreatedAt', 'organisation');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Professor $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', array());
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', array());
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getRoles()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRoles', array());

        return parent::getRoles();
    }

    /**
     * {@inheritDoc}
     */
    public function getLectures()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLectures', array());

        return parent::getLectures();
    }

    /**
     * {@inheritDoc}
     */
    public function setLectures($lectures)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLectures', array($lectures));

        return parent::setLectures($lectures);
    }

    /**
     * {@inheritDoc}
     */
    public function getTitle()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTitle', array());

        return parent::getTitle();
    }

    /**
     * {@inheritDoc}
     */
    public function setTitle($title)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTitle', array($title));

        return parent::setTitle($title);
    }

    /**
     * {@inheritDoc}
     */
    public function addLecture($lecture)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addLecture', array($lecture));

        return parent::addLecture($lecture);
    }

    /**
     * {@inheritDoc}
     */
    public function isRegisterTokenExpired()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isRegisterTokenExpired', array());

        return parent::isRegisterTokenExpired();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrganisation()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getOrganisation', array());

        return parent::getOrganisation();
    }

    /**
     * {@inheritDoc}
     */
    public function setOrganisation(\StudentInfo\Models\Faculty $organisation)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setOrganisation', array($organisation));

        return parent::setOrganisation($organisation);
    }

    /**
     * {@inheritDoc}
     */
    public function getRegisterTokenCreatedAt()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRegisterTokenCreatedAt', array());

        return parent::getRegisterTokenCreatedAt();
    }

    /**
     * {@inheritDoc}
     */
    public function getRegisterToken()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRegisterToken', array());

        return parent::getRegisterToken();
    }

    /**
     * {@inheritDoc}
     */
    public function generateRegisterToken()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'generateRegisterToken', array());

        return parent::generateRegisterToken();
    }

    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', array());

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function getFirstName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFirstName', array());

        return parent::getFirstName();
    }

    /**
     * {@inheritDoc}
     */
    public function setFirstName($firstName)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFirstName', array($firstName));

        return parent::setFirstName($firstName);
    }

    /**
     * {@inheritDoc}
     */
    public function getLastName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLastName', array());

        return parent::getLastName();
    }

    /**
     * {@inheritDoc}
     */
    public function setLastName($lastName)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLastName', array($lastName));

        return parent::setLastName($lastName);
    }

    /**
     * {@inheritDoc}
     */
    public function setPassword(\StudentInfo\ValueObjects\Password $password)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPassword', array($password));

        return parent::setPassword($password);
    }

    /**
     * {@inheritDoc}
     */
    public function getEmail()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEmail', array());

        return parent::getEmail();
    }

    /**
     * {@inheritDoc}
     */
    public function setEmail(\StudentInfo\ValueObjects\Email $email)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEmail', array($email));

        return parent::setEmail($email);
    }

    /**
     * {@inheritDoc}
     */
    public function getAuthIdentifier()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAuthIdentifier', array());

        return parent::getAuthIdentifier();
    }

    /**
     * {@inheritDoc}
     */
    public function getAuthPassword()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAuthPassword', array());

        return parent::getAuthPassword();
    }

    /**
     * {@inheritDoc}
     */
    public function getAuthIdentifierName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAuthIdentifierName', array());

        return parent::getAuthIdentifierName();
    }

    /**
     * {@inheritDoc}
     */
    public function getRememberToken()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRememberToken', array());

        return parent::getRememberToken();
    }

    /**
     * {@inheritDoc}
     */
    public function setRememberToken($value)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setRememberToken', array($value));

        return parent::setRememberToken($value);
    }

    /**
     * {@inheritDoc}
     */
    public function getRememberTokenName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRememberTokenName', array());

        return parent::getRememberTokenName();
    }

    /**
     * {@inheritDoc}
     */
    public function hasPermissionTo($name, $requireAll = false)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'hasPermissionTo', array($name, $requireAll));

        return parent::hasPermissionTo($name, $requireAll);
    }

    /**
     * {@inheritDoc}
     */
    public function belongsToOrganisation($org, $requireAll = false)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'belongsToOrganisation', array($org, $requireAll));

        return parent::belongsToOrganisation($org, $requireAll);
    }

}
