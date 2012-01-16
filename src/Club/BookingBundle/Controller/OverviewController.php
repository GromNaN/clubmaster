<?php

namespace Club\BookingBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class OverviewController extends Controller
{
   /**
    * @Template()
    * @Route("/booking/{date}/{interval_id}")
    */
   public function viewAction($date, $interval_id)
   {
     $em = $this->getDoctrine()->getEntityManager();

     $form = $this->createForm(new \Club\BookingBundle\Form\User());

     $date = new \DateTime($date);
     $interval = $em->find('ClubBookingBundle:Interval', $interval_id);

     $ret = array(
       'interval' => $interval,
       'date' => $date,
       'form' => $form->createVieW()
     );

     $booking = $em->getRepository('ClubBookingBundle:Booking')->findOneBy(array(
       'interval' => $interval_id,
       'date' => $date
     ));

     if ($booking)
       $ret['booking'] = $booking;

     return $ret;
   }

  /**
   * @Template()
   * @Route("/booking/{date}", defaults={"date" = null})
   */
   public function indexAction($date)
   {
     $date = ($date == null) ? new \DateTime() : new \DateTime($date);
     $em = $this->getDoctrine()->getEntityManager();

     $nav = $this->getNav();
     $location = $em->find('ClubUserBundle:Location', $this->get('session')->get('location_id'));
     $fields = $em->getRepository('ClubBookingBundle:Field')->getFieldsBooking($location, $date);
     $data = $em->getRepository('ClubBookingBundle:Field')->getDayData($location, $date);
     $period = $this->get('club_booking.interval')->getTimePeriod($data['start_time'], $data['end_time'], new \DateInterval('PT60M'));

     return array(
       'period' => $period,
       'fields' => $fields,
       'date' => $date,
       'nav' => $nav,
       'location' => $location
    );
   }

   protected function getNav()
   {
     $nav = array();
     $d = new \DateTime();
     $i = new \DateInterval('P1D');
     $p = new \DatePeriod($d, $i, 6);
     foreach ($p as $dt) {
       $nav[] = $dt;
     }

     return $nav;
   }
}
