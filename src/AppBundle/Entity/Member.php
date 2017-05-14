<?php
// src/AppBundle/Entity/Member.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Member table contains entities whose credentials are queried by RMA plugin
 * 
 * @ORM\Entity
 * @ORM\Table(name="member")
 */
class Member 
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     * @var string
     */
    private $email;

    /**
     * @ORM\Column(name="password", type="string", length=255)
     * @var string
     */
    private $password;

    /**
     * @ORM\Column(name="enabled", type="boolean")
     * @var string
     */
    private $enabled;

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return Member
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
 
    /**
     * Set password.
     *
     * @param string $password
     *
     * @return Member
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
 
    /**
     * Set enabled.
     *
     * @param string $enabled
     *
     * @return Member
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled.
     *
     * @return string
     */
    public function getEnabled()
    {
        return $this->enabled;
    }
   
}