<?php

namespace AppBundle\DataFixtures\Test;

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
        $userAdmin->setPassword('$2y$13$rxEZj2fW9U5BcZ8TGoTkTehKRRuVqnZorRmMm9uRm2CKDCdp/rtUO');
        $userAdmin->setApikey('3e2ec79352d2e9cbd76ad409d968ee435af6695c');

        $manager->persist($userAdmin);
        
        $member1 = new Member();
        $member1->setEmail('bborko@bogus.info');
        $member1->setPassword('$2y$10$IbzoLl5zDGS/lRWk7wxe/Odxt4nMoT04T');
        $member1->setEnabled(true);
        $manager->persist($member1);
        
        $member2 = new Member();
        $member2->setEmail('developer@bogus.info');
        $member2->setPassword(false);
        $member2->setEnabled(true);
        $manager->persist($member2);
        
        $manager->flush();
    }}
