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
    $locations = $em->getRepository('ClubUserBundle:Location')->findAll();

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

    $em->persist($user);
    $em->flush();

    return $this->redirect($this->generateUrl('homepage'));
  }
}
