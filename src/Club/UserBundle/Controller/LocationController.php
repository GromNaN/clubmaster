<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LocationController extends Controller
{
  /**
   * @Template()
   * @Route("/location")
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $locations = $em->getRepository('ClubUserBundle:Location')->findAllVisible();

    return array(
      'locations' => $locations
    );
  }

  /**
   * @Route("/location/{id}")
   */
  public function switchAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $user = $this->get('security.context')->getToken()->getUser();
    $location = $em->find('ClubUserBundle:Location',$id);

    $user->setLocation($location);
    $this->get('session')->set('location_id', $location->getId());
    $this->get('session')->set('location_name', $location->getLocationName());

    $em->persist($user);
    $em->flush();

    $url = ($this->get('session')->get('switch_location'))
      ? $this->get('session')->get('switch_location')
      : $this->generateUrl('homepage');

    $this->get('session')->set('switch_location', null);
    return $this->redirect($url);
  }
}
