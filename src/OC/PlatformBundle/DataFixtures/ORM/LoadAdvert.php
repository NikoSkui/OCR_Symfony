<?php
// src/OC/PlatformBundle/DataFixtures/ORM/LoadAdvert.php

namespace OC\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use OC\PlatformBundle\Entity\Advert;
use OC\PlatformBundle\Entity\AdvertSkill;
use OC\PlatformBundle\Entity\AdvertContract;
use OC\PlatformBundle\Entity\AdvertDescription;
use OC\PlatformBundle\Entity\Application;

class LoadAdvert 
      extends AbstractFixture 
      implements FixtureInterface, OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {
    // use the factory to create a Faker\Generator instance
    $faker = \Faker\Factory::create('fr_FR'); // create a French faker

    for ($i=0; $i < 100 ; $i++) { 

      // Date pour le create
      $date = $faker->dateTimeBetween(
        $startDate = '-30 days',
        $endDate = 'now',
        $timezone = date_default_timezone_get()
      );
      // Modification de la date pour l'update
      $limitUp = $faker->numberBetween($min = 0, $max = 29);
      $update = new \DateTime($date->format('Y-m-d H:i:s'));
      $update->modify("+".$limitUp." day");

      $advert = new Advert();
      $advert->setDate($date);
      $advert->setTitle($faker->catchPhrase);
      $advert->setExcerpt($faker->text($maxNbChars = 255));
      $advert->setPublished(rand(0,1));
      $advert->setUpdatedAt($update);
      $advert->setSlug($faker->slug);

      $limitApp = $faker->numberBetween($min = 0, $max = 6);
      $advert->setNbApplications($limitApp);
      for ($app=0; $app < $limitApp ; $app++) { 
        $application = new Application();
        $application->setAuthor($faker->name);
        $application->setContent($faker->realText($maxNbChars = 200, $indexSize = 1));
        $application->setAdvert($advert);
        $advert->addApplication($application);
      }

      // On ajoute les catégories liées à l'annonce 
      $categories = $faker->randomElements(
        $array = [
          'Lead Developer',
          'Front-end Web Developer',
          'Back-end Web Developer',
          'Full-stack Web Developer',
          'Développeur Mobile',
          'Développeur Logiciel',
          'Data Scientist',
          'Admin Réseaux',
          'Admin Systèmes',
          'Admin BDD',
          'WebDesigner',
          'Ergonome (UX)',
          'Illustrateur',
          'Monteur/Vidéo',
          'Intégrateur',
          'Chef de projet',
          'Commercial/Business Developer',
          'Webmarketeur (Growth Hacker)',
          'Médias Sociaux',
          'Relations Clients/Support',
          'Commercial/Business Dev',
          'Rédacteur Web',
          'Marketing ',
          'Communication',
          'Journaliste RP',
          'Evenementiel',
          'SEO Référencement',
          'SEM Acquisition',
          'Talent Acquisition',
          'Office Manager',
          'Chief Happiness Officer'
        ],
        $count = $faker->numberBetween($min = 1, $max = 6)
      );
      foreach ($categories as $category) {
        $category = $this->getReference($category);
        $advert->addCategory($category);
      }

      // On ajoute l'auteur lié à l'annonce 
      for ($ia=0; $ia < 10 ; $ia++) { $users[] = 'user-'.$ia; }
      $author = $faker->randomElement($array = $users);
      $author = $this->getReference($author);
      $advert->setAuthor($author);

      // On ajoute le salaire lié à l'annonce 
      for ($is=0; $is < 7 ; $is++) { $salaries[] = 'salary-'.$is; }
      $salary = $faker->randomElement($array = $salaries);
      $salary = $this->getReference($salary);
      $advert->setSalary($salary);

      // On ajoute les description lié à l'annonce 
      $iSection = $faker->numberBetween($min = 0, $max = 1);
      if ($iSection === 0){
        $sections = ['La société', 'Description du poste','Profil recherché', 'Autres informations'];
      } else{
        $sections = ['La société', 'Description du poste','Profil recherché'];
      }
      foreach ($sections as $section) {
        $advertDescription = new AdvertDescription();
        $advertDescription->setName($section);
        $advertDescription->setContent($faker->realText($maxNbChars = 500, $indexSize = 2));
        $advertDescription->setAdvert($advert);
        // On persiste
        $manager->persist($advertDescription);
      }

      // On persiste
      $manager->persist($advert);

      // On ajoute les compétences liées à l'annonce 
      $skills = $faker->randomElements(
        $array = [
            'PHP', 
            'Symfony', 
            'C++', 
            'Java', 
            'Photoshop', 
            'Blender', 
            'Bloc-note'
        ],
        $count = $faker->numberBetween($min = 1, $max = 6)
      );
      foreach ($skills as $skill) {

        $skill = $this->getReference($skill);

        $advertSkill = new AdvertSkill();
        $advertSkill->setAdvert($advert);
        $advertSkill->setSkill($skill);
        $advertSkill->setLevel($faker->randomElement($array = array ('Expert','Débutant','Intermédiaire'))); 
        // On persiste
        $manager->persist($advertSkill);
      }

      // On ajoute le contrat lié à l'annonce 
      $contract = $faker->randomElement(
        $array = [
            'CDI', 
            'CDD', 
            'Freelance', 
            'Stage/Alternance'
        ]
      );

      $contract = $this->getReference($contract);

      $advertContract = new AdvertContract();
      $advertContract->setAdvert($advert);
      $advertContract->setContract($contract);
      $advertContract->setTeleworking($faker->numberBetween($min = 0, $max = 1));
      // On persiste
      $manager->persist($advertContract);
      
    }

    // On déclenche l'enregistrement de toutes les compétences
    $manager->flush();
  }
  /**
  * Get the order of this fixture
  * @return integer
  */
  public function getOrder()
  {
    return 2; // LoadAdvert doit avoir lieu après LoadSkill
  }
}