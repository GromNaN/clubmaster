<?php

namespace Club\TaskBundle\Listener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class TaskListener
{
  protected $em;
  protected $event_dispatcher;

  public function __construct($em, $event_dispatcher)
  {
    $this->em = $em;
    $this->event_dispatcher = $event_dispatcher;
  }

  public function onCoreRequest(GetResponseEvent $event)
  {
    try {
      $tasks = $this->em->getRepository('ClubTaskBundle:Task')->getTasksToExecute();

      foreach ($tasks as $task) {
        $this->startTask($task);

        $event = new \Club\TaskBundle\Event\FilterTaskEvent($task);
        $this->event_dispatcher->dispatch(constant('\Club\TaskBundle\Event\Events::'.$task->getEvent()), $event);

        $this->stopTask($task);
      }

    } catch (\Exception $e) {
    }
  }

  protected function startTask($task)
  {
    $task->setLocked(1);
    $task->setLastRunAt(new \DateTime());

    $this->em->persist($task);
    $this->em->flush();

    return $task;
  }

  protected function stopTask($task)
  {
    $task->setLocked(0);

    $date = new \DateTime();
    $date->modify($task->getTaskInterval());
    $task->setNextRunAt($date);
    $this->em->persist($task);
    $this->em->flush();

    return $task;
  }
}
