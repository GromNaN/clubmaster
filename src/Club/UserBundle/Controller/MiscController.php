<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MiscController extends Controller
{
  public function locationBarAction()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $location = $em->find('ClubUserBundle:Location', $this->get('session')->get('location_id'));
    $locations = $em->getRepository('ClubUserBundle:Location')->findAllVisible();

    return $this->render('ClubUserBundle:Misc:locationBar.html.twig', array(
      'location' => $location,
      'locations' => $locations
    ));
  }

  public function versionBarAction()
  {
    return $this->render('ClubUserBundle:Misc:versionBar.html.twig', array(
      'version' => $this->get('clubmaster.version')->getVersion()
    ));
  }
}
