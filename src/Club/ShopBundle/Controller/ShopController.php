<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ShopController extends Controller
{
  /**
   * @Route("/shop", name="shop")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $categories = $em->getRepository('Club\ShopBundle\Entity\Category')->findBy(array(
      'location' => $this->get('security.context')->getToken()->getUser()->getLocation()->getId()
    ));

    return array(
      'location' => $this->get('security.context')->getToken()->getUser()->getLocation(),
      'categories' => $categories
    );
  }

  /**
   * @Route("/shop/category/{id}",name="shop_prod_view")
   * @Template()
   */
  public function categoryAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $categories = $em->getRepository('Club\ShopBundle\Entity\Category')->findBy(array(
      'category' => $id
    ));
    $category = $em->find('Club\ShopBundle\Entity\Category',$id);

    return array(
      'location' => $this->get('security.context')->getToken()->getUser()->getLocation(),
      'categories' => $categories,
      'category' => $category
    );
  }

  /**
   * @Route("/shop/category/delete/{id}", name="shop_category_delete")
   */
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $category = $em->find('Club\ShopBundle\Entity\Category',$id);

    $em->remove($category);
    $em->flush();

    return new RedirectResponse($this->generateUrl('shop_category'));
  }

  /**
   * @Route("/shop/category/edit/{id}", name="shop_category_edit")
   */
  public function editAction($id)
  {
    return array();
  }
}
