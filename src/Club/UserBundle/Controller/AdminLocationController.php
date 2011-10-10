<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminLocationController extends Controller
{
  /**
   * @Template()
   * @Route("/location", name="admin_location")
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $location = $em->find('ClubUserBundle:Location',1);
    $location = $em->getRepository('ClubUserBundle:Location')->getAllChilds($location);

    return array(
      'location' => $location
    );
  }

  /**
   * @Template()
   * @Route("/location/new", name="admin_location_new")
   */
  public function newAction()
  {
    $location = new \Club\UserBundle\Entity\Location();
    $res = $this->process($location);

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'form' => $res->createView()
    );
  }

  /**
   * @Template()
   * @Route("/location/edit/{id}", name="admin_location_edit")
   */
  public function editAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $location = $em->find('ClubUserBundle:Location',$id);

    $res = $this->process($location);

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'location' => $location,
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/location/delete/{id}", name="admin_location_delete")
   */
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $location = $em->find('ClubUserBundle:Location',$this->getRequest()->get('id'));

    $em->remove($location);
    $em->flush();

    $this->get('session')->setFlash('notify',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('admin_location'));
  }

  protected function process($location)
  {
    $form = $this->createForm(new \Club\UserBundle\Form\Location(), $location);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($location);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('admin_location'));
      }
    }

    return $form;
  }
}
