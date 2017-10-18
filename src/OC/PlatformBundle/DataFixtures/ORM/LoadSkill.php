<?php
// src/OC/PlatformBundle/DataFixtures/ORM/LoadSkill.php

namespace OC\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use OC\PlatformBundle\Entity\Skill;

class LoadSkill 
      extends AbstractFixture 
      implements FixtureInterface, OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {
    // Liste des noms de compétences à ajouter
    $datas = [
      'PHP',
      'Symfony',
      'C++',
      'Java',
      'Photoshop',
      'Blender',
      'Bloc-note'
    ];

    foreach ($datas as $data) {
      // On crée la compétence
      $skill = new Skill();
      $skill->setName($data);

      // On ajoute l'objet en référence pour y accéder dans une autre fixtures
      // premier paramètre le nom de la référence pour y accéder par la suite
      // deuxième paramètre l'objet
      $this->addReference($data, $skill);
      // On la persiste
      $manager->persist($skill);
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