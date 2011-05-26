<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class RoleController extends Controller
{
  /**
   * @Template()
   * @Route("/role", name="admin_role")
   */
  public function indexAction()
  {
    $dql = "SELECT r FROM Club\UserBundle\Entity\Role r ORDER BY r.role_name";
    $em = $this->get('doctrine.orm.entity_manager');

    $query = $em->createQuery($dql);
    $roles = $query->getResult();

    return $this->render('ClubUserBundle:Role:index.html.twig',array(
      'page' => array('header' => 'User'),
      'roles' => $roles
    ));
  }

  /**
   * @Route("/role/batch", name="admin_role_batch")
   */
  public function batchAction()
  {
  }
}
