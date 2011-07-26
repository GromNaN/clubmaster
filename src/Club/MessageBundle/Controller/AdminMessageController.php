<?php

namespace Club\MessageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AdminMessageController extends Controller
{
  /**
   * @Route("/message")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $messages = $em->getRepository('ClubMessageBundle:Message')->findAll();

    return array(
      'messages' => $messages
    );
  }

  /**
   * @Route("/message/new")
   * @Template()
   */
  public function newAction()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $message = new \Club\MessageBundle\Entity\Message();
    $message->setSenderName($em->getRepository('ClubUserBundle:LocationConfig')->getObjectByKey('email_sender_name'));
    $message->setSenderAddress($em->getRepository('ClubUserBundle:LocationConfig')->getObjectByKey('email_sender_address'));
    $message->setType('mail');

    $form = $this->createForm(new \Club\MessageBundle\Form\Message(), $message);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());

      if ($form->isValid()) {
        $em->persist($message);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your message was queue for delivery.'));
        return $this->redirect($this->generateUrl('club_message_adminmessage_index'));
      }
    }
    return array(
      'form' => $form->createView()
    );
  }

  /**
   * @Route("/message/process/{id}/")
   */
  public function processAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $message = $em->find('ClubMessageBundle:Message',$id);

    $message->setProcessed(1);
    $message->setSentAt(new \DateTime());

    $em->persist($message);
    $em->flush();

    foreach ($message->getFilters() as $filter) {
      $this->processUsers($message, $em->getRepository('ClubUserBundle:User')->getUsers($filter));
    }

    $this->processUsers($message, $message->getUsers());

    foreach ($message->getGroups() as $group) {
      $this->processUsers($message, $group->getUsers());
    }

    foreach ($message->getEvents() as $event) {
      $this->processAttends($message, $event->getAttends());
    }

    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your message will now be processed from queue.'));
    return $this->redirect($this->generateUrl('club_message_adminmessage_index'));
  }

  private function processAttends(\Club\MessageBundle\Entity\Message $message, $attends)
  {
    foreach ($attends as $attend) {
      if ($message->getType() == 'mail') {
        $this->sendMail($message,$attend->getUser());
      }
    }
  }

  private function processUsers(\Club\MessageBundle\Entity\Message $message, $users)
  {
    foreach ($users as $user) {
      if ($message->getType() == 'mail') {
        $this->sendMail($message,$user);
      }
    }
  }

  private function sendMail(\Club\MessageBundle\Entity\Message $message, \Club\UserBundle\Entity\User $user)
  {
    try {
      $this->get('clubmaster_mailer')
        ->setSubject($message->getSubject())
        ->setFrom($message->getSenderAddress(),$message->getSenderName())
        ->setTo($user->getProfile()->getProfileEmail()->getEmailAddress())
        ->setBody($message->getMessage())
        ->send();
    } catch (\Exception $e) {
      $error = $e->getMessage();
    }
  }
}
