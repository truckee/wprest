<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\UserRepository")
 * @ORM\Table(name="member")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * @var string
     *
     * @ORM\Column(name="apikey", type="string", length=40, nullable=false)
     */
    protected $apikey;

    /**
     * Set apikey.
     *
     * @param string $apikey
     *
     * @return Usertable
     */
    public function setApikey($apikey)
    {
        $this->apikey = $apikey;

        return $this;
    }

    /**
     * Get apikey.
     *
     * @return string
     */
    public function getApikey()
    {
        return $this->apikey;
    }

}