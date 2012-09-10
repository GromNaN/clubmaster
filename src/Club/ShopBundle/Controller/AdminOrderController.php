<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/admin")
 */
class AdminOrderController extends Controller
{
  /**
   * @Route("/shop/order/page/{page}", name="admin_shop_order_page")
   * @Route("/shop/order", name="admin_shop_order")
   * @Template()
   */
  public function indexAction($page = null)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $form = $this->createForm(new \Club\ShopBundle\Form\OrderQuery);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {
        $data = $form->getData();

        $order = $em->getRepository('ClubShopBundle:Order')->findOneBy(array(
          'id' => $data['query']
        ));

        if ($order)
          return $this->redirect($this->generateUrl('admin_shop_order_edit', array('id' => $order->getId())));

        $this->get('session')->setFlash('error', $this->get('translator')->trans('There is no order with this number'));
      }
    }

    $count = $em->getRepository('ClubShopBundle:Order')->getCount($this->getFilter());
    $nav = $this->get('club_paginator.paginator_ng')
        ->init(20, $count, $page, 'admin_shop_order_page');

    $orders = $em->getRepository('ClubShopBundle:Order')->getWithPagination($this->getFilter(), null, $nav->getOffset(), $nav->getLimit());

    return array(
      'orders' => $orders,
      'nav' => $nav,
      'form' => $form->createView()
    );
  }

  /**
   * @Route("/shop/order/edit/{id}", name="admin_shop_order_edit")
   * @Template()
   */
  public function editAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $order = $em->find('ClubShopBundle:Order',$id);

    /**
    $form = $this->createForm(new \Club\ShopBundle\Form\Order(), $order);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {
        $data = $form->getData();

        $this->get('order')->setOrder($order);
        $this->get('order')->changeStatus($data->getOrderStatus());

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('admin_shop_order'));
      }
    }
     */

    return array(
      'order' => $order
      //,'form' => $form->createView()
    );
  }

  /**
   * @Route("/shop/order/delete/{id}", name="admin_shop_order_delete")
   */
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $order = $em->find('ClubShopBundle:Order',$id);

    $this->container->get('order')->setOrder($order);
    $status = $em->getRepository('ClubShopBundle:OrderStatus')->getCancelled();
    $this->container->get('order')->changeStatus($status);

    $this->get('session')->setFlash('notice', $this->get('translator')->trans('Your order has been cancelled'));

    return $this->redirect($this->generateUrl('admin_shop_order'));
  }

  private function getFilter()
  {
    return unserialize($this->get('session')->get('order_filter'));
  }

  /**
   * @Route("/shop/order/deliver/{id}")
   */
  public function deliverAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $order = $em->find('ClubShopBundle:Order',$id);

    $status = $em->getRepository('ClubShopBundle:OrderStatus')->getDelivered();

    $this->get('order')->setOrder($order);
    $this->get('order')->changeStatus($status);

    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('admin_shop_order_edit', array(
        'id' => $order->getId()
    )));
  }

  /**
   * @Route("/shop/order/product/edit/{id}")
   * @Template()
   */
  public function productEditAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $order = $em->find('ClubShopBundle:Order',$id);
    if ($order->getPaid() || $order->getCancelled() || $order->getDelivered()) {
      $this->get('session')->setFlash('error', $this->get('translator')->trans('You cannot chance a order which has been processed'));
      return $this->redirect($this->generateUrl('admin_shop_order_edit', array('id' => $order->getId())));
    }

    $form = $this->createForm(new \Club\ShopBundle\Form\OrderType, $order);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {

        $this->get('order')->setOrder($order);
        $this->get('order')->recalcPrice();

        $em->persist($order);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('admin_shop_order_edit', array('id' => $order->getId())));
      }
    }

    return array(
      'order' => $order,
      'form' => $form->createView()
    );
  }

}
