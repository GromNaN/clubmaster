<?php

namespace Club\RestBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
  /**
   * @Route("/add/user")
   * @Method("POST")
   */
  public function addUserAction()
  {
    $em = $this->get('doctrine.orm.entity_manager');

    $user = new \Club\UserBundle\Entity\User();
    $user->setMemberNumber($em->getRepository('Club\UserBundle\Entity\User')->findNextMemberNumber());

    $em->persist($user);

    $user->setPassword(1234);
    $em->persist($user);
    $em->flush();

    $profile = new \Club\UserBundle\Entity\Profile();
    $profile->setUser($user);
    $profile->setFirstName($this->get('request')->get('first_name'));
    $profile->setLastName($this->get('request')->get('last_name'));
    $profile->setGender($this->get('request')->get('gender'));
    $profile->setDayOfBirth(new \DateTime($this->get('request')->get('day_of_birth')));

    $em->persist($profile);
    $em->flush();

    $user->setProfile($profile);
    $em->persist($user);
    $em->flush();

    return ($r = $this->hasErrors($user)) ? $r : $this->renderJSon($user->toArray());
  }

  /**
   * @Route("/get/user/{id}")
   */
  public function getUserAction($id)
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $user = $em->find('Club\UserBundle\Entity\User',$id);

    return $this->renderJSon($user->toArray());
  }

  /**
   * @Route("/delete/user/{id}")
   * @Method("DELETE")
   */
  public function deleteUserAction($id)
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $user = $em->find('Club\UserBundle\Entity\User',$id);

    $em->remove($user);
    $em->flush();

    return $this->renderJSon();
  }

  /**
   * @Route("/get/users")
   */
  public function getUsersAction()
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $users = $em->getRepository('Club\UserBundle\Entity\User')->findAll();

    $res = array();
    foreach ($users as $user) {
      $res[] = $user->toArray();
    }

    return $this->renderJSon($res);
  }

  /**
   * @Route("/get/users/active")
   */
  public function getUsersActiveAction()
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $users = $em->getRepository('Club\UserBundle\Entity\User')->findAllActive();

    $res = array();
    foreach ($users as $user) {
      $res[] = $user->toArray();
    }

    return $this->renderJSon($res);
  }

  /**
   * @Route("/ban/user/{id}")
   */
  public function banUserAction($id)
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $user = $em->find('Club\UserBundle\Entity\User',$id);

    $ban = new \Club\UserBundle\Entity\Ban();
    $ban->setUser($user);
    $ban->setType('user');
    $ban->setValue($user->getId());

    $em->persist($ban);
    $em->flush();

    return $this->renderJSon($user->toArray());
  }

  /**
   * @Route("/add/user_role")
   */
  public function addUserRole()
  {
    $em = $this->get('doctrine.orm.entity_manager');

    $user = $em->find('Club\UserBundle\Entity\User',$this->get('request')->get('user'));
    $role = $em->find('Club\UserBundle\Entity\Role',$this->get('request')->get('role'));

    $role->addUser($user);

    $em->persist($role);
    $em->flush();

    return $this->renderJSon($user->toArray());
  }

  /**
   * @Route("/add/order")
   * @Method("POST")
   */
  public function addOrder()
  {
    $em = $this->get('doctrine.orm.entity_manager');

    $user = $em->find('Club\UserBundle\Entity\User',$this->get('request')->get('user'));
    $payment = $em->find('Club\ShopBundle\Entity\PaymentMethod',$this->get('request')->get('payment_method'));
    $shipping = $em->find('Club\ShopBundle\Entity\Shipping',$this->get('request')->get('shipping'));
    $currency = $em->find('Club\UserBundle\Entity\Currency',$this->get('request')->get('currency'));
    $status = $em->find('Club\ShopBundle\Entity\OrderStatus',1);

    $order = new \Club\ShopBundle\Entity\Order();
    $order->setUser($user);
    $order->setPaymentMethod($payment);
    $order->setShipping($shipping);
    $order->setCurrency($currency->getCode());
    $order->setCurrencyValue($currency->getValue());
    $order->setOrderMemo($this->get('request')->get('order_memo'));
    $order->setOrderStatus($status);

    if ($r = $this->hasErrors($order)) return $r;

    $em->persist($order);

    $products = json_decode($this->get('request')->get('products'));
    $price = 0;
    foreach ($products as $product) {
      $prod = $em->find('Club\ShopBundle\Entity\Product',$product->product);

      $price += $prod->getPrice();

      $op = new \Club\ShopBundle\Entity\OrderProduct;
      $op->setProductName($prod->getProductName());
      $op->setPrice($prod->getPrice());
      $op->setTax($prod->getTax()->getRate());
      $op->setQuantity($product->quantity);
      $op->setOrder($order);

      if ($r = $this->hasErrors($op)) return $r;

      $em->persist($op);

      foreach ($prod->getProductAttributes() as $attr) {
        $opa = new \Club\ShopBundle\Entity\OrderProductAttribute();
        $opa->setOrderProduct($op);
        $opa->setAttributeName($attr->getAttribute()->getAttributeName());
        $opa->setValue($attr->getValue());

        if ($r = $this->hasErrors($op)) return $r;
        $em->persist($opa);
      }

    }
    $order->setPrice($price);
    $em->flush();

    return $this->renderJSon($order->toArray());
  }

  /**
   * @Route("/update/order")
   */
  public function updateOrderAction()
  {
    $em = $this->get('doctrine.orm.entity_manager');

    $order = $em->find('Club\ShopBundle\Entity\Order',$this->get('request')->get('order'));
    $status = $em->find('Club\ShopBundle\Entity\OrderStatus',$this->get('request')->get('status'));

    $order->setOrderStatus($status);

    if ($r = $this->hasErrors($status)) return $r;

    $em->persist($order);
    $em->flush();

    $event = new \Club\ShopBundle\Event\FilterOrderEvent($order);
    $this->get('event_dispatcher')->dispatch(\Club\ShopBundle\Event\Events::onOrderChange, $event);

    return $this->renderJSon($order->toArray());
  }

  protected function hasErrors($object)
  {
    $errors = $this->get('validator')->validate($object);

    if (count($errors) > 0) {
      return $this->renderError($errors);
    }

    return false;
  }

  protected function renderError($errors,$status_code="403")
  {
    $res = array();
    foreach ($errors as $error) {
      $res[] = array(
        'field' => $error->getPropertyPath(),
        'message' => $error->getMessage()
      );
    }

    return $this->renderJSon($res,$status_code);
  }

  protected function renderJSon($array=array(),$status_code="200")
  {
    $response = new Response(json_encode($array));
    $response->setStatusCode($status_code);
    $response->headers->set('Content-Type','application/json');

    return $response;
  }
}
