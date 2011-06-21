<?php

namespace Club\EventBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminEventController extends Controller
{
  /**
   * @Route("/event/event", name="admin_event_event")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $events = $em->getRepository('\Club\EventBundle\Entity\Event')->findAll();

    return array(
      'events' => $events
    );
  }

  /**
   * @Route("/event/event/new", name="admin_event_event_new")
   * @Template()
   */
  public function newAction()
  {
    $event = new \Club\EventBundle\Entity\Event();
    $res = $this->process($event);

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/event/event/edit/{id}", name="admin_event_event_edit")
   * @Template()
   */
  public function editAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $event = $em->find('Club\EventBundle\Entity\Event',$id);

    $res = $this->process($event);

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'event' => $event,
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/event/event/delete/{id}", name="admin_event_event_delete")
   */
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $event = $em->find('ClubEventBundle:Event',$this->getRequest()->get('id'));

    $em->remove($event);
    $em->flush();

    $this->get('session')->setFlash('notify',sprintf('Event %s deleted.',$event->getEventName()));

    return $this->redirect($this->generateUrl('admin_event_event'));
  }

  protected function process($event)
  {
    $form = $this->get('form.factory')->create(new \Club\EventBundle\Form\Event(), $event);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {
        if (!$event->getId()) {
          $e = new \Club\EventBundle\Event\FilterEventEvent($event);
          $this->get('event_dispatcher')->dispatch(\Club\EventBundle\Event\Events::onEventAdd, $e);
        }

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($event);
        $em->flush();

        $this->get('session')->setFlash('notice','Your changes were saved!');

        return $this->redirect($this->generateUrl('admin_event_event'));
      }
    }

    return $form;
  }
}
