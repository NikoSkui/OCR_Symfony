<?php

namespace OC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdvertController extends Controller
{

  public function indexAction($page)
  {
    // On ne sait pas combien de pages il y a
    // Mais on sait qu'une page doit être supérieure ou égale à 1
    if ($page < 1) {
      // On déclenche une exception NotFoundHttpException, cela va afficher
      // une page d'erreur 404 (qu'on pourra personnaliser plus tard d'ailleurs)
      throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
    }

    // Ici, on récupérera la liste des annonces, puis on la passera au template
    $listAdverts = [
      [
        'title'   => 'Recherche développpeur Symfony',
        'id'      => 1,
        'icon'    =>'globe',
        'author'  => 'Alexandre',
        'content' => '<p>Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…</p><p>
                      Commodo ullamcorper a lacus vestibulum sed arcu. Fermentum leo vel orci porta non. Proin fermentum leo vel orci porta non pulvinar. Imperdiet proin fermentum leo vel. Tortor posuere ac ut consequat semper viverra. Vestibulum lectus mauris ultrices eros. </p>
                      <h3 class="has-text-centered">Lectus vestibulum mattis ullamcorper velit sed ullamcorper morbi. Cras tincidunt lobortis feugiat vivamus.</h3> 
                      <p>
                        In eu mi bibendum neque egestas congue quisque egestas diam. Enim nec dui nunc mattis enim ut tellus. Ut morbi tincidunt augue interdum velit euismod in. At in tellus integer feugiat scelerisque varius morbi enim nunc. Vitae suscipit tellus mauris a diam. Arcu non sodales neque sodales ut etiam sit amet.
                      </p>',
        'date'    => new \Datetime()],
      [
        'title'   => 'Mission de webmaster',
        'id'      => 2,
        'icon'    =>'rocket',
        'author'  => 'Hugo',
        'content' => 'Nous recherchons un webmaster capable de maintenir notre site internet. Blabla…',
        'date'    => new \Datetime()],
      [
        'title'   => 'Offre de stage webdesigner',
        'id'      => 3,
        'icon'    =>'briefcase',
        'author'  => 'Mathieu',
        'content' => 'Nous proposons un poste pour webdesigner. Blabla…',
        'date'    => new \Datetime()]
    ];

    // Mais pour l'instant, on ne fait qu'appeler le template
    return $this->render('OCPlatformBundle:Advert:index.html.twig',compact('listAdverts'));
  }

  public function viewAction($id)
  {
    // Ici, on récupérera l'annonce correspondante à l'id $id
    $advert = [
      'title'   => 'Recherche développpeur Symfony2',
      'id'      => $id,
      'author'  => 'Alexandre',
      'content' => '<p>Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…</p><p>
                    Commodo ullamcorper a lacus vestibulum sed arcu. Fermentum leo vel orci porta non. Proin fermentum leo vel orci porta non pulvinar. Imperdiet proin fermentum leo vel. Tortor posuere ac ut consequat semper viverra. Vestibulum lectus mauris ultrices eros. </p>
                    <h3 class="has-text-centered">Lectus vestibulum mattis ullamcorper velit sed ullamcorper morbi. Cras tincidunt lobortis feugiat vivamus.</h3> 
                    <p>
                      In eu mi bibendum neque egestas congue quisque egestas diam. Enim nec dui nunc mattis enim ut tellus. Ut morbi tincidunt augue interdum velit euismod in. At in tellus integer feugiat scelerisque varius morbi enim nunc. Vitae suscipit tellus mauris a diam. Arcu non sodales neque sodales ut etiam sit amet.
                    </p>',
      'date'    => new \Datetime()
    ];

    return $this->render('OCPlatformBundle:Advert:view.html.twig', compact('advert'));
  }

  public function addAction(Request $request)
  {
    // La gestion d'un formulaire est particulière, mais l'idée est la suivante :

    // Si la requête est en POST, c'est que le visiteur a soumis le formulaire
    if ($request->isMethod('POST')) {
      // Ici, on s'occupera de la création et de la gestion du formulaire

      $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
      // Puis on redirige vers la page de visualisation de cettte annonce
      return $this->redirectToRoute('oc_platform_view', ['id' => 5]);
    }

    // // On récupère le service
    // $antispam = $this->container->get('oc_platform.antispam');

    // // Je pars du principe que $text contient le texte d'un message quelconque
    // $text = '...';
    // if ($antispam->isSpam($text)) {
    //   throw new \Exception('Votre message a été détecté comme spam !');
    // }

    // Si on n'est pas en POST, alors on affiche le formulaire
    return $this->render('OCPlatformBundle:Advert:add.html.twig');
  }

  public function editAction($id, Request $request)
  {
    // Ici, on récupérera l'annonce correspondante à $id
    $advert = [
      'title'   => 'Recherche développpeur Symfony2',
      'id'      => $id,
      'author'  => 'Alexandre',
      'content' => 'Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…',
      'date'    => new \Datetime()
    ];

    // Même mécanisme que pour l'ajout
    if ($request->isMethod('POST')) {
      $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');

      return $this->redirectToRoute('oc_platform_view', ['id' => $id]);
    }

    return $this->render('OCPlatformBundle:Advert:edit.html.twig', compact('advert'));
  }

  public function deleteAction($id, Request $request)
  {
    // Ici, on récupérera l'annonce correspondant à $id

    // Ici, on gérera la suppression de l'annonce en question

    // Pour l'instant, on ne fait qu'enrigistrer un message flash et rediriger vers l'accueil
      $request->getSession()->getFlashBag()->add('info', 'La fonctionnalité de suppression n’est pas encore disponible, merci de retenter plus tard.');
      return $this->redirectToRoute('oc_platform_view',['id' => $id]);
  }

  public function menuAction($limit)
  {
    // On fixe en dur une liste ici, bien entendu par la suite
    // on la récupérera depuis la BDD !
    $listAdverts = [
      [
        'id'    => 2,
        'title' => 'Recherche développeur Symfony',
        'slug'  => 'recherche-developpeur-symfony'],
      [
        'id'    => 5,
        'title' => 'Mission de webmaster',
        'slug'  => 'mission-de-webmaster'],
      [
        'id'    => 9,
        'title' => 'Offre de stage webdesigner',
        'slug'  => 'offre-de-stage-webdesigner']
    ];

    // Tout l'intérêt est ici : le contrôleur passe
    // les variables nécessaires au template !
    return $this->render('OCPlatformBundle:Components:menu.html.twig', compact('listAdverts'));
  }
  public function featureAction($limit)
  {
    // On fixe en dur une liste ici, bien entendu par la suite
    // on la récupérera depuis la BDD !
    $listAdverts = [
      [
        'id'      => 2,
        'icon'    => 'globe',
        'title'   => 'Recherche développeur Symfony', 
        'slug'    => 'recherche-developpeur-symfony', 
        'content' => 'Purus semper eget duis at tellus at urna condimentum mattis. Non blandit massa enim nec. Integer enim neque volutpat ac tincidunt vitae semper quis. Accumsan tortor posuere ac ut consequat semper viverra nam.'],
      [
        'id'      => 5,
        'icon'    => 'rocket',
        'title'   => 'Mission de webmaster', 
        'slug'    => 'mission-de-webmaster', 
        'content' => 'Ut venenatis tellus in metus vulputate. Amet consectetur adipiscing elit pellentesque. Sed arcu non odio euismod lacinia at quis risus. Faucibus turpis in eu mi bibendum neque egestas cmonsu songue. Phasellus vestibulum lorem sed risus.'],
      [
        'id'      => 9,
        'icon'    => 'briefcase',
        'title'   => 'Offre de stage webdesigner', 
        'slug'    => 'offre-de-stage-webdesigner', 
        'content' => 'Imperdiet dui accumsan sit amet nulla facilisi morbi. Fusce ut placerat orci nulla pellentesque dignissim enim. Commodo viverra maecenas accumsan lacus vel facilisis.']
    ];

    // Tout l'intérêt est ici : le contrôleur passe
    // les variables nécessaires au template !
    return $this->render('OCPlatformBundle:Advert:feature.html.twig', compact('listAdverts'));
  }
}