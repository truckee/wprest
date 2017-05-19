<?php

namespace AppBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Description of RestData
 *
 * @author George
 */
class RestData
{

    private $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function setMemberPassword($member, $email) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $password = substr(str_shuffle($chars), 0, 8);
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $member->setPassword($hash);
        $this->em->persist($member);
        $this->em->flush();
        
        $data = [
            'email' => $email,
            'password' => $password,
            'enabled' => $member->getEnabled()
        ];

        return $data;
    }

    public function resetMemberPassword($member, $hash) {
        $email = $member->getEmail();
        $member->setPassword($hash);
        $this->em->persist($member);
        $this->em->flush();
        $data = [
            'email' => $email,
            'enabled' => $member->getEnabled()
        ];

        return $data;
    }

}
