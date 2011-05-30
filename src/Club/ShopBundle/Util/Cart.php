<?php

namespace Club\ShopBundle\Util;

use Symfony\Component\HttpFoundation\Session;
use Symfony\Component\HttpFoundation\SessionStorage\NativeSessionStorage;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Club\ShopBundle\Events;

class Cart
{
  protected $cart;
  protected $session;
  protected $em;
  protected $user;
  protected $dispatcher;

  public function __construct($em,$session,$security,$dispatcher)
  {
    $this->session = $session;
    $this->em = $em;
    $this->user = $security->getToken()->getUser();
    $this->dispatcher = $dispatcher;

    $this->cart = $this->session->get('cart');
    if (!$this->cart) {
      $this->cart = $em->getRepository('\Club\ShopBundle\Entity\Cart')->findOneBy(
        array('user' => $this->user->getId())
      );

      if (!$this->cart) {
        $this->cart = new \Club\ShopBundle\Entity\Cart();
        $this->cart->setUser($this->user);
        $location = $this->em->find('\Club\UserBundle\Entity\Location',$this->session->get('location_id'));
        $this->cart->setCurrency($location->getCurrency()->getCode());
        $this->cart->setCurrencyValue($location->getCurrency()->getValue());
      }
    }
  }

  public function addToCart($product)
  {
    $trigger = 0;
    // check if its already in the cart
    foreach ($this->cart->getCartProducts() as $prod) {
      if ($prod->getProduct()->getId() == $product->getId()) {
        $prod->setQuantity($prod->getQuantity()+1);
        $this->cart->setPrice($this->cart->getPrice()+$prod->getPrice());
        $trigger = 1;
      }
    }

    if (!$trigger) {
      $op = new \Club\ShopBundle\Entity\CartProduct();
      $op->setCart($this->cart);
      $op->setProduct($product);
      $op->setProductName($product->getProductName());
      $op->setPrice($product->getPrice());
      $op->setTax($product->getTax()->getRate());
      $op->setQuantity(1);

      foreach ($product->getProductAttributes() as $attr) {
        $opa = new \Club\ShopBundle\Entity\CartProductAttribute();
        $opa->setCartProduct($op);
        $opa->setValue($attr->getValue());
        $opa->setAttributeName($attr->getAttribute()->getAttributeName());

        $op->addCartProductAttribute($opa);
      }

      $this->cart->addCartProduct($op);
      $this->cart->setPrice($this->cart->getPrice()+$op->getPrice());
    }
    $this->save();
  }

  public function emptyCart()
  {
    $this->em->remove($this->cart);
    $this->em->flush();
  }

  public function setShipping($shipping)
  {
    $this->cart->setShipping($shipping);
    $this->save();
  }

  public function setPayment($payment)
  {
    $this->cart->setPayment($payment);
    $this->save();
  }

  public function setCart($cart)
  {
    $this->cart = $cart;
    $this->save();
  }

  public function getCart()
  {
    return $this->cart;
  }

  public function convertToOrder()
  {
    $order = new \Club\ShopBundle\Entity\Order();
    $order->setCurrency($this->cart->getCurrency());
    $order->setCurrencyValue($this->cart->getCurrencyValue());
    $order->setPrice($this->cart->getPrice());
    $order->setPaymentMethod($this->em->find('\Club\ShopBundle\Entity\PaymentMethod',$this->cart->getPaymentMethod()->getId()));
    $order->setShipping($this->em->find('\Club\ShopBundle\Entity\Shipping',$this->cart->getShipping()->getId()));
    $order->setOrderStatus($this->em->getRepository('\Club\ShopBundle\Entity\OrderStatus')->getDefaultStatus());
    $order->setUser($this->user);

    $this->em->persist($order);

    foreach ($this->cart->getCartProducts() as $product) {
      $op = new \Club\ShopBundle\Entity\OrderProduct();
      $op->setOrder($order);
      $op->setPrice($product->getPrice());
      $op->setProductName($product->getProductName());
      $op->setTax($product->getTax());
      $op->setQuantity($product->getQuantity());
      $op->setProduct($product);

      $this->em->persist($op);

      foreach ($product->getCartProductAttributes() as $attr) {
        $opa = new \Club\ShopBundle\Entity\OrderProductAttribute();
        $opa->setOrderProduct($op);
        $opa->setAttributeName($attr->getAttributeName());
        $opa->setValue($attr->getValue());

        $this->em->persist($opa);
      }
    }

    $event = new \Club\ShopBundle\Event\FilterOrderEvent($order);
    $this->dispatcher->dispatch(Events::onStoreOrder, $event);

    $this->em->remove($this->cart);
    $this->em->flush();
  }

  protected function save()
  {
    $this->em->persist($this->cart);
    $this->em->flush();
  }
}
