<?php

namespace OC\PlatformBundle\Repository;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * AdvertRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AdvertRepository extends \Doctrine\ORM\EntityRepository
{

  public function FindAllForIndex($page, $nbPerPage)
  {
    $qb = $this->createQueryBuilder('a')

      ->leftJoin('a.advertContract', 'a_c')
      ->addSelect('a_c')
      ->leftJoin('a_c.contract', 'a_c_c')
      ->addSelect('a_c_c')
      ->orderBy('a.date','asc')
      ->getQuery()
    ;

    $qb
      // On définit l'annonce à partir de laquelle commencer la liste
      ->setFirstResult(($page-1) * $nbPerPage)
      // Ainsi que le nombre d'annonce à afficher sur une page
      ->setMaxResults($nbPerPage)
    ;
    // Enfin, on retourne l'objet Paginator correspondant à la requête construite
    // (n'oubliez pas le use correspondant en début de fichier)
    return new Paginator($qb, true);
  }

  public function FindForView($id)
  {
    $qb = $this
      ->createQueryBuilder('a')

      ->where('a.id = :id')
        ->setParameter('id', $id)

      ->leftJoin('a.applications', 'app')
        ->addSelect('app')
        
      ->leftJoin('a.author', 'auth')
        ->addSelect('auth')

      ->leftJoin('auth.address', 'ad')
        ->addSelect('ad')

      ->leftJoin('auth.image', 'i')
        ->addSelect('i')

    ;

    return $qb
      ->getQuery()
      ->getSingleResult();
    ;
  }

  public function getAdvertWithCategories(array $categoryNames)
  {
    $qb = $this
      ->createQueryBuilder('a')

    // On fait une jointure avec l'entité Category avec pour alias « c »
      ->innerJoin('a.categories', 'c')
      ->addSelect('c')

    // Puis on filtre sur le nom des catégories à l'aide d'un IN
      ->where($qb->expr()->in('c.name', $categoryNames));
      
    // La syntaxe du IN et d'autres expressions se trouve dans la documentation Doctrine

    // Enfin, on retourne le résultat
    return $qb
      ->getQuery()
      ->getResult()
    ;
  }
  
}