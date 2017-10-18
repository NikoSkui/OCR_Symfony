<?php
// src/OC/PlatformBundle/DataFixtures/ORM/LoadSalary.php

namespace OC\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use OC\PlatformBundle\Entity\Salary;

class LoadSalary 
      extends AbstractFixture 
      implements FixtureInterface, OrderedFixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    // Liste des noms de catégorie à ajouter
    $datas = [
      'Entre 25K et 34K',
      'Entre 35K et 44K',
      'Entre 45K et 54K',
      'Entre 55K et 59K',
      'Entre 60K et 69K',
      'Moins de 24K',
      'NC',
      'Plus de 70K',
    ];

    foreach ($datas as $i => $data) {
      // On crée la catégorie
      $salary = new Salary();
      $salary->setName($data);

      // On ajoute l'objet en référence pour y accéder dans une autre fixtures
      // premier paramètre le nom de la référence pour y accéder par la suite
      // deuxième paramètre l'objet
      $this->addReference($data, $salary);

      // On ajoute l'objet en référence pour y accéder dans une autre fixtures
      // premier paramètre le nom de la référence pour y accéder par la suite
      // deuxième paramètre l'objet
      $this->addReference('salary-'.$i, $salary);

      // On la persiste
      $manager->persist($salary);
    }

    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }
  /**
  * Get the order of this fixture
  * @return integer
  */
  public function getOrder()
  {
    return 1; // LoadCategory doit avoir lieu avant LoadAdvert
  }
}