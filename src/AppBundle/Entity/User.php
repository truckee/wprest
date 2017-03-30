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
     * @ORM\Column(name="fname", type="string", length=25, nullable=false)
     */
    protected $fname;

    /**
     * @var string
     *
     * @ORM\Column(name="sname", type="string", length=45, nullable=false)
     */
    protected $sname;

    /**
     * Set fname.
     *
     * @param string $fname
     *
     * @return Usertable
     */
    public function setFname($fname)
    {
        $this->fname = $fname;

        return $this;
    }

    /**
     * Get fname.
     *
     * @return string
     */
    public function getFname()
    {
        return $this->fname;
    }

    /**
     * Set sname.
     *
     * @param string $sname
     *
     * @return Usertable
     */
    public function setSname($sname)
    {
        $this->sname = $sname;

        return $this;
    }

    /**
     * Get sname.
     *
     * @return string
     */
    public function getSname()
    {
        return $this->sname;
    }
}