<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;
use AppBundle\Entity\Member;

/**
 * Description of UsersMembers
 *
 * @author George
 */
class UsersMembers implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $userAdmin = new User();
        $userAdmin->setUsername('admin');
        $userAdmin->setEmail('admin@bogus.info');
        $userAdmin->setEnabled(true);
        $userAdmin->addRole('ROLE_ADMIN');
        $userAdmin->setPassword('$2y$13$X04gnptMF5BAOQ1XWKOEWuTj.s7vqHgU.4HiQK4hvFLcMFM5Nh/r2');
        $userAdmin->setApikey('3e2ec79352d2e9cbd76ad409d968ee435af6695c');

        $manager->persist($userAdmin);
        
        $member1 = new Member();
        $member1->setEmail('bborko@bogus.info');
        $member1->setPassword('$2y$10$IbzoLl5zDGS/lRWk7wxe/Odxt4nMoT04T');
        $member1->setEnabled(true);
        $manager->persist($member1);
        
        $member2 = new Member();
        $member2->setEmail('developer@bogus.info');
        $member2->setEnabled(true);
        $manager->persist($member2);
        
        $member3 = new Member();
        $member3->setEmail('jglenshire@bogus.info');
        $member3->setPassword('$2y$10$AyrP6xfaHKbt8pOBYAc8lusg3.QJCMByXH/8mU9Xzwj33evkvg872');
        $member3->setEnabled(false);
        $manager->persist($member3);
        
        $manager->flush();
    }}
