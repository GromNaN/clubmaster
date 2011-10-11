<?php

namespace Club\ShopBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;

class LoadAttributeData implements FixtureInterface
{
  public function load($manager)
  {
    $attributes = array();
    $attributes[] = 'time_interval';
    $attributes[] = 'ticket';
    $attributes[] = 'auto_renewal';
    $attributes[] = 'lifetime';
    $attributes[] = 'start_date';
    $attributes[] = 'expire_date';
    $attributes[] = 'allowed_pauses';
    $attributes[] = 'location';

    foreach ($attributes as $attr) {
      $a = new \Club\ShopBundle\Entity\Attribute();
      $a->setAttributeName($attr);

      $manager->persist($a);
    }

    $manager->flush();
  }
}
