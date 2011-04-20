<?php

namespace Club\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ProductController extends Controller
{
  /**
   * @extra:Route("/shop/product/{category}", name="shop_product")
   * @extra:Template()
   */
  public function indexAction($category)
  {
    $em = $this->get('doctrine.orm.entity_manager');

    $products = $em->getRepository('Club\ShopBundle\Entity\Product')->findByCategories(array($category));

    return array(
      'products' => $products
    );
  }

  /**
   * @extra:Route("/shop/product/delete/{id}", name="shop_product_delete")
   */
  public function deleteAction($id)
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $category = $em->find('Club\ShopBundle\Entity\Category',$id);

    $em->remove($category);
    $em->flush();

    return new RedirectResponse($this->generateUrl('shop_category'));
  }

  /**
   * @extra:Route("/shop/product/edit/{id}", name="shop_product_edit")
   */
  public function editAction($id)
  {
    return array();
  }
}
