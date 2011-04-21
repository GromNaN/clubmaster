<?php

namespace Club\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ShopController extends Controller
{
  /**
   * @extra:Routes({
   *   @extra:Route("/shop", name="shop"),
   *   @extra:Route("/shop/{id}",name="shop_prod_view")
   * })
   * @extra:Template()
   */
  public function indexAction($id=null)
  {
    $em = $this->get('doctrine.orm.entity_manager');

    $categories = $em->getRepository('Club\ShopBundle\Entity\Category')->findAll();
    $category = $em->find('Club\ShopBundle\Entity\Category',$id);

    return array(
      'categories' => $categories,
      'category' => $category
    );
  }

  /**
   * @extra:Route("/shop/category/delete/{id}", name="shop_category_delete")
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
   * @extra:Route("/shop/category/edit/{id}", name="shop_category_edit")
   */
  public function editAction($id)
  {
    return array();
  }
}
