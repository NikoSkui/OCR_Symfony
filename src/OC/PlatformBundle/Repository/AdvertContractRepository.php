<?php

namespace OC\PlatformBundle\Repository;

/**
 * AdvertContractRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AdvertContractRepository extends \Doctrine\ORM\EntityRepository
{

  public function findByWithContract($advert)
  {
    $qb = $this
      ->createQueryBuilder('a_c')
      ->where('a_c.advert = :a_c')
        ->setParameter('a_c', $advert)
      ->innerJoin('a_c.contract', 'c')
        ->addSelect('c')
    ;

    return $qb
      ->getQuery()
      ->getSingleResult();
    ;
  }

}
