<?php

namespace Club\APIBundle\Controller;

use Club\APIBundle\Controller\DefaultController as Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;


class AuthController extends Controller
{
  /**
   * @Route("/auth")
   * @Secure(roles="ROLE_USER")
   */
  public function authAction()
  {
    $user = $this->get('security.context')->getToken()->getUser();

    $response = new Response($this->get('club_api.encode')->encode($user->toArray()));
    $response->headers->set('Access-Control-Allow-Origin', '*');
    return $response;
  }
}
