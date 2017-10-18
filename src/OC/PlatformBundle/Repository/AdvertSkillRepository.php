<?php

namespace OC\PlatformBundle\Repository;

use Doctrine\ORM\QueryBuilder;

/**
 * AdvertSkillRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AdvertSkillRepository extends \Doctrine\ORM\EntityRepository
{

  public function findByWithSkills($advert)
  {
    $qb = $this
      ->createQueryBuilder('a_s')
      ->where('a_s.advert = :a_s')
        ->setParameter('a_s', $advert)
      ->innerJoin('a_s.skill', 's')
        ->addSelect('s')
    ;

    return $qb
      ->getQuery()
      ->getResult();
    ;
  }


}