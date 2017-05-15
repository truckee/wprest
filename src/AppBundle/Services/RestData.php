<?php

namespace AppBundle\Services;

use Doctrine\ORM\EntityManager;

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
    
    public function setUserPassword($email) {
        $data = $this->em->getRepository('AppBundle:Member')->findOneBy(['email' => $email]);
        if (!$data) {
            throw $this->createNotFoundException('Unable to find member entity');
        }
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $password = substr(str_shuffle($chars), 0, 8);
        $crypted = password_hash($password, PASSWORD_BCRYPT);
        $data->setPassword($crypted);
        $this->em->persist($data);
        $this->em->flush();
        $member = [
            'email' => $email,
            'password' => $password,
            'enabled' => $data->getEnabled()
        ];
        
        return $member;
    }
}
