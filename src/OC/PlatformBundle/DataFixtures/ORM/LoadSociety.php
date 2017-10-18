<?php
// src/OC/PlatformBundle/DataFixtures/ORM/LoadSalary.php

namespace OC\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use OC\PlatformBundle\Entity\Society;
use OC\PlatformBundle\Entity\Image;
use OC\PlatformBundle\Entity\Address;

class LoadSociety 
      extends AbstractFixture 
      implements FixtureInterface, OrderedFixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    // use the factory to create a Faker\Generator instance
    $faker = \Faker\Factory::create('fr_FR'); // create a French faker

    for ($i=0; $i < 10 ; $i++) { 

      $image = new Image();
      $image->setUrl('https://picsum.photos/1920/1080?image='.rand(0,1084));
      $image->setAlt($faker->catchPhrase);

      $address = new Address();
      $address->setAddress($faker->streetAddress);
      $address->setPostCode($faker->postcode);
      $address->setCity($faker->city);
      $address->setCountry('France');

      $society = new Society();
      $society->setImage($image);
      $society->setName($faker->company);
      $society->setEmail($faker->companyEmail);
      $society->setWebsite('//www.'.$faker->domainName);
      $society->setPassword(md5('admin-'.$i.'29'));
      $society->setDescription($faker->text($maxNbChars = 255));
      $society->setAddress($address);
      
      // On ajoute l'objet en référence pour y accéder dans une autre fixtures
      // premier paramètre le nom de la référence pour y accéder par la suite
      // deuxième paramètre l'objet
      $this->addReference('user-'.$i, $society);
      // On la persiste
      $manager->persist($society);
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
    return 2; // LoadCategory doit avoir lieu avant LoadAdvert
  }
}