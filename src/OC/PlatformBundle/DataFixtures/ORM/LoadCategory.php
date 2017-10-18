<?php
// src/OC/PlatformBundle/DataFixtures/ORM/LoadCategory.php

namespace OC\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use OC\PlatformBundle\Entity\Category;

class LoadCategory 
      extends AbstractFixture 
      implements FixtureInterface, OrderedFixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    // Liste des noms de catégorie à ajouter
    $datas = [
      [
        'name'        => 'Développement',
        'parent'      => 0],
      [
        'name'        => 'Lead Developer',
        'parent'      => 1],
      [
        'name'        => 'Front-end Web Developer',
        'parent'      => 1],
      [
        'name'        => 'Back-end Web Developer',
        'parent'      => 1],
      [
        'name'        => 'Full-stack Web Developer',
        'parent'      => 1],
      [
        'name'        => 'Développeur Mobile',
        'parent'      => 1],
      [
        'name'        => 'Développeur Logiciel',
        'parent'      => 1],
      [
        'name'        => 'Data Scientist',
        'parent'      => 1],
      [
        'name'        => 'Administration Systèmes',
        'parent'      => 0],
      [
        'name'        => 'Admin Réseaux',
        'parent'      => 9],
      [
        'name'        => 'Admin Systèmes',
        'parent'      => 9],
      [
        'name'        => 'Admin BDD',
        'parent'      => 9],
      [
        'name'        => 'Design',
        'parent'      => 0],
      [ 
        'name'        => 'WebDesigner',
        'parent'      => 13],
      [ 
        'name'        => 'Ergonome (UX)',
        'parent'      => 13],
      [ 
        'name'        => 'Illustrateur',
        'parent'      => 13],
      [ 
        'name'        => 'Monteur/Vidéo',
        'parent'      => 13],
      [ 
        'name'        => 'Intégrateur',
        'parent'      => 13],
      [
        'name'        => 'Gestion de projet',
        'parent'      => 0],
      [
        'name'        => 'Chef de projet',
        'parent'      => 19],
      [
        'name'        => 'Business',
        'parent'      => 0],
      [
        'name'        => 'Marketing',
        'parent'      => 0],
      [
        'name'        => 'Commercial/Business Developer',
        'parent'      => 22],
      [
        'name'        => 'Webmarketeur (Growth Hacker)',
        'parent'      => 22],
      [
        'name'        => 'Médias Sociaux',
        'parent'      => 22],
      [
        'name'        => 'Relations Clients/Support',
        'parent'      => 22],
      [
        'name'        => 'Commercial/Business Dev',
        'parent'      => 22],
      [
        'name'        => 'Rédacteur Web',
        'parent'      => 22],
      [
        'name'        => 'Marketing ',
        'parent'      => 22],
      [
        'name'        => 'Communication',
        'parent'      => 22],
      [
        'name'        => 'Journaliste RP',
        'parent'      => 22],
      [
        'name'        => 'Evenementiel',
        'parent'      => 22],
      [
        'name'        => 'Social Média',
        'parent'      => 0],
      [
        'name'        => 'SEO/SEM',
        'parent'      => 0],
      [
        'name'        => 'SEO Référencement',
        'parent'      => 34],
      [
        'name'        => 'SEM Acquisition',
        'parent'      => 34],
      [
        'name'        => 'RH',
        'parent'      => 0],
      [
        'name'        => 'Talent Acquisition',
        'parent'      => 37],
      [
        'name'        => 'Office Manager',
        'parent'      => 37],
      [
        'name'        => 'Chief Happiness Officer',
        'parent'      => 37],
    ];

    foreach ($datas as $data) {
      // On crée la catégorie
      $category = new Category();
      $category->setName($data['name']);
      $category->setParent($data['parent']);
      
      // On ajoute l'objet en référence pour y accéder dans une autre fixtures
      // premier paramètre le nom de la référence pour y accéder par la suite
      // deuxième paramètre l'objet
      $this->addReference($data['name'], $category);
      // On la persiste
      $manager->persist($category);
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