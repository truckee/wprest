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

    public function setMemberPassword($member, $hash) {
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

}
