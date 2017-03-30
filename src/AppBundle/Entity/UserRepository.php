<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Description of UserRepository
 *
 * @author George
 */
class UserRepository extends EntityRepository
{
    public function getApiUserHash($username) {
        return $this->createQueryBuilder('u')
                ->select('u.password')
                ->where('u.username = :username')
                ->setParameter('username', $username)
                ->getQuery()->getResult();
    }
}
