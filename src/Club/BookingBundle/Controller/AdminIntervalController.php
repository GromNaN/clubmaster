<?php

namespace Club\BookingBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminIntervalController extends Controller
{
  /**
   * @Route("/booking/interval")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $intervals = $em->getRepository('ClubBookingBundle:Interval')->findAll();

    return array(
      'intervals' => $intervals
    );
  }

  /**
   * @Route("/booking/interval/new")
   * @Template()
   */
  public function newAction()
  {
    $interval = new \Club\BookingBundle\Entity\Interval();
    $res = $this->process($interval);

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/booking/interval/edit/{id}")
   * @Template()
   */
  public function editAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $interval = $em->find('ClubBookingBundle:Interval',$id);

    $res = $this->process($interval);

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'interval' => $interval,
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/booking/interval/delete/{id}")
   */
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $interval = $em->find('ClubBookingBundle:Interval',$this->getRequest()->get('id'));

    $em->remove($interval);
    $em->flush();

    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('club_booking_admininterval_index'));
  }

  protected function process($interval)
  {
    $form = $this->createForm(new \Club\BookingBundle\Form\Interval(), $interval);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($interval);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('club_booking_admininterval_index'));
      }
    }

    return $form;
  }
}
