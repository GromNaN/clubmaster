<?php

namespace Club\APIBundle\Controller;

use Club\APIBundle\Controller\DefaultController as Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;


class TeamController extends Controller
{
  /**
   * @Route("/")
   * @Method("GET")
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $res = array();

    $start = new \DateTime(date('Y-m-d 00:00:00'));
    $end = new \DateTime(date('Y-m-d 23:59:59', strtotime('+7 day')));

    foreach ($em->getRepository('ClubTeamBundle:Schedule')->getAllBetween($start, $end) as $schedule) {
      $res[] = $schedule->toArray();
    }

    $response = new Response($this->get('club_api.encode')->encode($res));
    $response->headers->set('Access-Control-Allow-Origin', '*');

    return $response;
  }

  /**
   * @Route("/{id}/attend")
   * @Method("POST")
   * @Secure(roles="ROLE_USER")
   */
  public function attendAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $schedule = $em->find('ClubTeamBundle:Schedule', $id);

    $schedule->addUser($this->get('security.context')->getToken()->getUser());

    $em->persist($schedule);
    $em->flush();

    $response = new Response();
    $response->headers->set('Access-Control-Allow-Origin', '*');
    return $response;
  }

  /**
   * @Route("/{id}/unattend")
   * @Method("POST")
   * @Secure(roles="ROLE_USER")
   */
  public function unattendAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $schedule = $em->find('ClubTeamBundle:Schedule', $id);
    $user = $this->get('security.context')->getToken()->getUser();

    $schedule->getUsers()->removeElement($user);
    $em->flush();

    $response = new Response();
    $response->headers->set('Access-Control-Allow-Origin', '*');
    return $response;
  }
}
