<?php

namespace OC\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use OC\PlatformBundle\Entity\Contract;

class LoadContract 
      extends AbstractFixture 
      implements FixtureInterface, OrderedFixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    // Liste des noms de catégorie à ajouter
    $datas = [
      [
        'name'        => 'CDI',
        'icon'        => 'handshake-o'],
      [
        'name'        => 'CDD',
        'icon'        => 'rocket'],
      [
        'name'        => 'Freelance',
        'icon'        => 'paper-plane-o '],
      [
        'name'        => 'Stage/Alternance',
        'icon'        => 'graduation-cap ']
    ];

    // 'icon'    =>'rocket','globe','briefcase'

    foreach ($datas as $data) {
      // On crée la catégorie
      $contract = new Contract();
      $contract->setName($data['name']);
      $contract->setIcon($data['icon']);

      // On ajoute l'objet en référence pour y accéder dans une autre fixtures
      // premier paramètre le nom de la référence pour y accéder par la suite
      // deuxième paramètre l'objet
      $this->addReference($data['name'], $contract);
      // On la persiste
      $manager->persist($contract);
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