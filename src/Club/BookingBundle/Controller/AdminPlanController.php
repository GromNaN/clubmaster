<?php

namespace Club\BookingBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/admin/booking/plan")
 */
class AdminPlanController extends Controller
{
  /**
   * @Route("")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $plans = $em->getRepository('ClubBookingBundle:Plan')->findBy(
      array(),
      array('updated_at' => 'DESC')
    );

    return array(
      'plans' => $plans
    );
  }

  /**
   * @Route("/new", defaults={"date" = null, "interval_id" = null})
   * @Route("/new/{date}/{interval_id}", name="club_booking_plan_pre")
   * @Template()
   */
  public function newAction($date, $interval_id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $plan = new \Club\BookingBundle\Entity\Plan();
    $repeat = new \Club\BookingBundle\Entity\PlanRepeat();
    $plan->addPlanRepeat($repeat);

    if ($date != '') {
      $interval = $em->find('ClubBookingBundle:Interval', $interval_id);

      $start = new \DateTime($date.' 00:00:00');
      $end = new \DateTime($date.' 23:59:59');

      $t_start = new \DateTime(date('Y-m-d '.$interval->getStartTime()->format('H:i:s')));
      $t_end = new \DateTime(date('Y-m-d '.$interval->getStopTime()->format('H:i:s')));
      $plan->setFirstTime($t_start);
      $plan->setEndTime($t_end);
      $plan->addField($interval->getField());

    } else {
      $start = new \DateTime(date('Y-m-d 00:00:00'));
      $end = new \DateTime(date('Y-m-d 23:59:59'));
    }

    $plan->setUser($this->getUser());
    $plan->setPeriodStart($start);
    $plan->setPeriodEnd($end);

    $plan->setDay($start->format('N'));

    $form = $this->createForm(new \Club\BookingBundle\Form\Plan, $plan);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bind($this->getRequest());
      if ($form->isValid()) {
        $em->persist($plan);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('club_booking_adminplan_index'));
      }
    }

    return array(
      'form' => $form->createView()
    );
  }

  /**
   * @Route("/edit/{id}")
   * @Template()
   */
  public function editAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $plan = $em->find('ClubBookingBundle:Plan',$id);
    $form = $this->createForm(new \Club\BookingBundle\Form\Plan, $plan);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bind($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($plan);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('club_booking_adminplan_index'));
      }
    }

    return array(
      'plan' => $plan,
      'form' => $form->createView()
    );
  }

  /**
   * @Route("/delete/{id}")
   */
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $plan = $em->find('ClubBookingBundle:Plan',$this->getRequest()->get('id'));

    $em->remove($plan);
    $em->flush();

    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('club_booking_adminplan_index'));
  }
}
