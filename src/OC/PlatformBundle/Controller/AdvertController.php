<?php

namespace OC\PlatformBundle\Controller;

use OC\PlatformBundle\Entity\Advert;
use OC\PlatformBundle\Entity\AdvertSkill;
use OC\PlatformBundle\Entity\Application;
use OC\PlatformBundle\Entity\Image;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdvertController extends Controller
{

  public function indexAction($page)
  {

    // Si $page supérieur à 1
    // On déclenche une exception NotFoundHttpException
    if ($page < 1) {
      throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
    }

    // Ici je fixe le nombre d'annonces par page à 3
    // Mais bien sûr il faudrait utiliser un paramètre, et y accéder via $this->container->getParameter('nb_per_page')
    $nbPerPage = 6;

    // On récupère l'entité manager
    $em = $this->getDoctrine()->getManager();

    // On récupère la liste des annonces
    $listAdverts = $em
      ->getRepository('OCPlatformBundle:Advert')
      ->FindAllForIndex($page, $nbPerPage)
    ;

    // On calcule le nombre total de pages grâce au count($listAdverts) qui retourne le nombre total d'annonces
    $nbPages = ceil(count($listAdverts) / $nbPerPage);
    
    // Si la page n'existe pas, on retourne une 404
    if ($page > $nbPages) {
      throw $this->createNotFoundException("La page ".$page." n'existe pas.");
    }

    // On récupère toutes les skills liées à l'annonce
    $categories = $em
      ->getRepository('OCPlatformBundle:Category')
      ->findBy(['parent' => 0])
    ;

    $listCategories['Tous'] = null;
    foreach ($categories as $key => $value) {

      if (in_array($value->getName(),['Marketing','Business','Social Média'])) {
        $listCategories['Biz/Market/Com'][]= $value;
      } elseif (in_array($value->getName(),['Administration Système'])) {
        $listCategories['Sys/Réseau']= $value;
      } elseif (in_array($value->getName(),['Design'])) {
        $listCategories['Graphisme']= $value;
      } else {
        $listCategories[$value->getName()]= $value;
      }

    }

    // On appele le template
    return $this->render('OCPlatformBundle:Advert:index.html.twig', compact(
      'listAdverts',
      'listCategories',
      'nbPages',
      'page'
    ));
  }

  public function viewAction($id)
  {
    // On récupère l'entité manager
    $em = $this->getDoctrine()->getManager();
    
    // On récupère une annonce
    $advert = $em
      ->getRepository('OCPlatformBundle:Advert')
      ->Find($id);
      // ->FindForView($id); // pour passer le nb de requêtes de 5 à 2
    ;

    // $advert est donc une instance de OC\PlatformBundle\Entity\Advert
    // ou null si l'id $id  n'existe pas, d'où ce if :
    if (null === $advert) {
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
    }

    // On récupère le type de contrat lié à l'annonce
    $advertContract = $em
      ->getRepository('OCPlatformBundle:AdvertContract')
      ->findByWithContract($advert)
    ;

    // On récupère toutes les descriptions liées à l'annonce
    $listDescriptions = $em
      ->getRepository('OCPlatformBundle:AdvertDescription')
      ->findBy(['advert' => $advert])
    ;

    // On récupère toutes les skills liées à l'annonce
    $listAdvertSkills = $em
      ->getRepository('OCPlatformBundle:AdvertSkill')
      ->findByWithSkills($advert)
    ;
 
    return $this->render('OCPlatformBundle:Advert:view.html.twig', compact(
      'advert',
      'listDescriptions',
      'listAdvertSkills',
      'advertContract'
    ));
  }

  public function addAction(Request $request)
  {

    // Si la requête est en POST, c'est que le visiteur a soumis le formulaire
    if ($request->isMethod('POST')) {
      // Ici, on s'occupera de la création et de la gestion du formulaire
      $request
        ->getSession()
        ->getFlashBag()
        ->add('notice', 'Annonce bien enregistrée.');
      // Puis on redirige vers la page de visualisation de cettte annonce
      return $this->redirectToRoute('oc_platform_view', ['id' => 5]);
    }

    // Si on n'est pas en POST, alors on affiche le formulaire
    return $this->render('OCPlatformBundle:Advert:add.html.twig');
  }

  public function editAction($id, Request $request)
  {
    // On récupère l'entité manager
    $em = $this->getDoctrine()->getManager();

    // On récupère l'annonce $id
    $advert = $em
      ->getRepository('OCPlatformBundle:Advert')
      ->find($id)
    ;

    if (null === $advert) {
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
    }

    // Même mécanisme que pour l'ajout
    if ($request->isMethod('POST')) {
      $request
        ->getSession()
        ->getFlashBag()
        ->add('notice', 'Annonce bien modifiée.');
      return $this->redirectToRoute('oc_platform_view', ['id' => $id]);
    }

    return $this->render('OCPlatformBundle:Advert:edit.html.twig', compact(
      'advert'
    ));
  }

  public function deleteAction($id, Request $request)
  {
    // On récupère l'entité manager
    $em = $this->getDoctrine()->getManager();

    // On récupère l'annonce $id
    $advert = $em
      ->getRepository('OCPlatformBundle:Advert')
      ->find($id);

    if (null === $advert) {
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
    }

    // On boucle sur les catégories de l'annonce pour les supprimer
    foreach ($advert->getCategories() as $category) {
      $advert->removeCategory($category);
    }

    // On déclenche la modification
    $em->flush();

    // Pour l'instant, on ne fait qu'enrigistrer un message flash et rediriger vers l'accueil
      $request
        ->getSession()
        ->getFlashBag()
        ->add('info','La fonctionnalité de suppression n’est pas encore disponible, merci de retenter plus tard.');
      
      return $this->redirectToRoute('oc_platform_view',compact(
        'id'
      ));
  }

  public function menuAction($limit)
  {
    // On récupère les X dernières annonces
    $listAdverts = $this->lastAdverts($limit);

    // Tout l'intérêt est ici : le contrôleur passe
    // les variables nécessaires au template !
    return $this->render('OCPlatformBundle:Components:menu.html.twig', compact(
      'listAdverts'
    ));
  }

  public function featureAction($limit)
  {
    // On récupère les X dernières annonces
    $listAdverts = $this->lastAdverts($limit);

    return $this->render('OCPlatformBundle:Advert:feature.html.twig', compact(
      'listAdverts'
    ));
  }

  private function lastAdverts($limit)
  {
    // On récupère l'entité manager
    $em = $this->getDoctrine()->getManager();

    // On récupère les 3 dernières annonces
    return $em
      ->getRepository('OCPlatformBundle:Advert')
      ->findBy(
        [],                  // Pas de critère
        ['date'=> 'desc'],   // On trie par date décroissante
        $limit,              // On sélectionne $limit annonces
        0                    // A partir du premier
      )
    ;
  }

}
