<?php

namespace StudentInfo\Models;


use Doctrine\Common\Collections\ArrayCollection;
use LaravelDoctrine\ACL\Contracts\Role;
use StudentInfo\Roles\PanelRole;

class Panel extends User
{

    protected $live;

    /**
     * @return ArrayCollection|Role[]
     */
    public function getRoles()
    {
        return [
            new PanelRole,
        ];
    }

    /**
     * @return mixed
     */
    public function getLive()
    {
        return $this->live;
    }

    /**
     * @param mixed $live
     */
    public function setLive($live)
    {
        $this->live = $live;
    }
}