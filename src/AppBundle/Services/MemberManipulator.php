<?php

namespace AppBundle\Services;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Member;

/**
 * Description of MemberManipulator
 *
 * @author George
 */
class MemberManipulator
{
    private $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    
    public function create($email, $password, $active) {
        $member = new Member();
        $member->setEmail($email);
        $crypted = password_hash($password, PASSWORD_BCRYPT);
        $member->setPassword($crypted);
        $member->setEnabled((bool) $active);
        $this->em->persist($member);
        $this->em->flush();
    }
    
    public function activateMember($email) {
        $member = $this->em->getRepository('AppBundle:Member')->findOneBy(['email' => $email]);
        if (!$member) {
            throw $this->createNotFoundException('Unable to find member');
        }
        $member->setEnabled(true);
        $this->em->persist($member);
        $this->em->flush();
    }
    
    public function deactivateMember($email) {
        $member = $this->em->getRepository('AppBundle:Member')->findOneBy(['email' => $email]);
        if (!$member) {
            throw $this->createNotFoundException('Unable to find member');
        }
        $member->setEnabled(false);
        $this->em->persist($member);
        $this->em->flush();
    }
}
