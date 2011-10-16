<?php

namespace Club\AccountBundle\Listener;

class NewTransactionListener
{
  protected $em;

  public function __construct($em)
  {
    $this->em = $em;
  }

  public function onShopOrder(\Club\ShopBundle\Event\FilterOrderEvent $event)
  {
    $order = $event->getOrder();

    foreach ($order->getProducts() as $product) {
      switch ($product->getType()) {
      case 'product':
        $account = $this->em->getRepository('ClubShopBundle:Product')->getAccount($product->getProduct(), $order->getLocation());
        break;
      case 'coupon':
        $account = $this->em->getRepository('ClubUserBundle:LocationConfig')->getObjectByKey('account_default_discount',$order->getLocation());
        break;
      }

      $ledger = new \Club\AccountBundle\Entity\Ledger();
      $ledger->setValue($product->getPrice());
      $ledger->setNote($product->getQuantity().'x '.$product->getProductName());
      $ledger->setAccount($account);
      $ledger->setUser($order->getUser());
      $ledger->setOrder($order);

      $this->em->persist($ledger);
    }

    $this->em->flush();
  }
}
