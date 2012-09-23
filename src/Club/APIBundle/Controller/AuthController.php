<?php

namespace Club\APIBundle\Controller;

use Club\APIBundle\Controller\DefaultController as Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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
    $user = $this->getUser();

    if ($this->validateKey())
      $this->get('club_checkin.checkin')->checkin();

    $response = new Response($this->get('club_api.encode')->encode($user->toArray()));

    return $response;
  }
}
