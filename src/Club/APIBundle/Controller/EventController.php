<?php

namespace Club\APIBundle\Controller;

use Club\APIBundle\Controller\DefaultController as Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * @Route("/events")
 */
class EventController extends Controller
{
  /**
   * @Route("/{id}/attend")
   * @Method("POST")
   * @Secure(roles="ROLE_USER")
   */
  public function attendAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $event = $em->find('ClubEventBundle:Event', $id);
    $user = $this->get('security.context')->getToken()->getUser();

    $attend = new \Club\EventBundle\Entity\Attend();
    $attend->setUser($user);
    $attend->setEvent($event);

    $event->addAttends($attend);

    $em->persist($event);
    $em->flush();

    $response = new Response();

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

    $user = $this->get('security.context')->getToken()->getUser();

    $attend = $em->getRepository('ClubEventBundle:Attend')->findOneBy(array(
      'event' => $id,
      'user' => $this->get('security.context')->getToken()->getUser()->getId()
    ));

    $em->remove($attend);
    $em->flush();

    $response = new Response();

    return $response;
  }

  /**
   * @Route("/", defaults={"start" = null, "end" = null})
   * @Route("/{start}", defaults={"end" = null})
   * @Route("/{start}/{end}")
   * @Method("GET")
   */
  public function indexAction($start, $end)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $res = array();

    $start = ($start == null) ? new \DateTime(date('Y-m-d 00:00:00')) : new \DateTime($start.' 00:00:00');
    $end = ($end == null) ? null : new \DateTime($end.' 23:59:59');

    foreach ($em->getRepository('ClubEventBundle:Event')->getAllBetween($start, $end) as $event) {
      $res[] = $event->toArray();
    }

    $response = new Response($this->get('club_api.encode')->encode($res));

    return $response;
  }
}
