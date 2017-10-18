<?php

namespace OC\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BaseController extends Controller
{
  public function indexAction()
  {
    // Pour l'instant, on ne fait qu'appeler le template
    return $this->render('OCCoreBundle:Base:index.html.twig');
  }

  public function contactAction(Request $request)
  {
    // On récupère la session
    $session = $request->getSession();

    // On enregistrer un message flash
    $session->getFlashBag()->add(
      'info',
      'La page de contact n’est pas encore disponible, merci de revenir plus tard.'
    );
    
    // On redirige vers l'accueil
    return $this->redirectToRoute('oc_core_home');
  }
}
