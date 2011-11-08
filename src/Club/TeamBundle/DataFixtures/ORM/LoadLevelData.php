<?php

namespace Club\TeamBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;

class LoadLevelData implements FixtureInterface
{
  public function load($manager)
  {
    $payment = new \Club\TeamBundle\Entity\Level();
    $payment->setLevelName('Easy');
    $manager->persist($payment);

    $payment = new \Club\TeamBundle\Entity\Level();
    $payment->setLevelName('Medium');
    $manager->persist($payment);

    $payment = new \Club\TeamBundle\Entity\Level();
    $payment->setLevelName('Hard');
    $manager->persist($payment);

    $manager->flush();
  }
}
