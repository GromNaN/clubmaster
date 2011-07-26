<?php

namespace Club\MailBundle\Helper;

class Mailer
{
  protected $em;
  protected $mailer;
  protected $message;

  public function __construct($em,$mailer)
  {
    $this->em = $em;
    $this->mailer = $mailer;

    $this->message = \Swift_Message::newInstance();
  }

  public function setFrom($sender_addr = null, $sender_name = null)
  {
    if ($sender_addr == null)
      $sender_addr = $this->em->getRepository('ClubUserBundle:LocationConfig')->getObjectByKey('email_sender_address');

    if ($sender_name == null)
      $sender_name = $this->em->getRepository('ClubUserBundle:LocationConfig')->getObjectByKey('email_sender_name');

    $this->message->setFrom(array(
       $sender_addr => $sender_name
    ));

    return $this;
  }

  public function setSubject($subject)
  {
    $this->message->setSubject($subject);

    return $this;
  }

  public function setTo($to)
  {
    $this->message->setTo($to);

    return $this;
  }

  public function setBody($body)
  {
    $this->message->setBody($body);

    return $this;
  }

  public function send()
  {
    $this->mailer->send($this->message);
  }
}
