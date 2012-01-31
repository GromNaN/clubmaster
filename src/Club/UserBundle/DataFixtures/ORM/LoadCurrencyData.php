<?php

namespace Club\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadCurrencyData implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $currency = new \Club\UserBundle\Entity\Currency();
    $currency->setCurrencyName('US Dollar');
    $currency->setCode('USD');
    $currency->setSymbolLeft('$');
    $currency->setDecimalPlaces(2);
    $currency->setValue(1);
    $currency->setActive(0);
    $manager->persist($currency);

    $currency = new \Club\UserBundle\Entity\Currency();
    $currency->setCurrencyName('Euro');
    $currency->setCode('EUR');
    $currency->setSymbolLeft('€');
    $currency->setDecimalPlaces(2);
    $currency->setValue(1);
    $currency->setActive(0);
    $manager->persist($currency);

    $currency = new \Club\UserBundle\Entity\Currency();
    $currency->setCurrencyName('Danish Krone');
    $currency->setCode('DKK');
    $currency->setSymbolRight('DK');
    $currency->setDecimalPlaces(2);
    $currency->setValue(1);
    $currency->setActive(0);
    $manager->persist($currency);

    $manager->flush();
  }
}
