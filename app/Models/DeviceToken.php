<?php

namespace StudentInfo\Models;


class DeviceToken
{
    /**
     * @var Int
     */
    protected $id;

    /**
     * @var String
     */
    protected $token;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var Int
     */
    protected $active;

    /**
     * @return Int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return String
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param String $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return Int
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param Int $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }
}