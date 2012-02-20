<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminProductAttributeController extends Controller
{
  /**
   * @Route("/shop/product/attribute/{id}", name="admin_shop_product_attribute")
   * @Template()
   */
  public function indexAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $product = $em->find('ClubShopBundle:Product',$id);

    $form = $this->getForm($product);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());

      if ($form->isValid()) {
        $r = $form->getData();
        $this->setData($product,$form->getData());

        $this->get('session')->setFlash('notice', $this->get('translator')->trans('Your changes are saved.'));
        return $this->redirect($this->generateUrl('admin_shop_product_attribute',array(
          'id' => $id
        )));
      }
    }
    return array(
      'form' => $form->createView(),
      'product' => $product
    );
  }

  private function getForm($product)
  {
    $form = $this->createForm(new \Club\ShopBundle\Form\ProductAttribute(), $this->getData($product));

    return $form;
  }

  private function getData($product)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $attribute = $this->get('club_shop.product')->getAttribute($product);

    return $attribute;
  }

  private function setData(\Club\ShopBundle\Entity\Product $product, $data)
  {
    $em = $this->getDoctrine()->getEntityManager();

    foreach ($data as $attribute => $value) {
      if ($value == '') {
        $prod_attr = $em->getRepository('ClubShopBundle:ProductAttribute')->findOneBy(array(
          'product' => $product->getId(),
          'attribute' => $attribute
        ));

        $em->remove($prod_attr);
      }

      if (($attribute == 'start_date' || $attribute == 'expire_date') && $value != '') {
        $value = $value->format('Y-m-d');
      }

      if ($attribute == 'location') {
        $str = '';
        foreach ($value as $l) {
          $str .= $l->getId().',';
        }
        $str = preg_replace("/,$/","",$str);
        $str = ($str != '') ? $str : null;

        if ($str == '') {
          if ($prod_attr)
            $em->remove($prod_attr);
        } else {
          if (!$prod_attr)
            $prod_attr = $this->buildProductAttribute($product,$attribute);

          $prod_attr->setValue($str);
          $em->persist($prod_attr);
        }

      } else {

        if ($prod_attr && $value == '') {

        } elseif ($prod_attr && $value != '') {
          $prod_attr->setValue($value);
          $em->persist($prod_attr);

        } elseif (!$prod_attr && $value != '') {
          $prod_attr = $this->buildProductAttribute($product,$attribute);
          $prod_attr->setValue($value);
          $em->persist($prod_attr);
        }
      }
    }

    $em->flush();
  }

  private function buildProductAttribute(\Club\ShopBundle\Entity\Product $product, $attribute)
  {
    $prod_attr = new \Club\ShopBundle\Entity\ProductAttribute();
    $prod_attr->setProduct($product);
    $prod_attr->setAttribute($attribute);

    return $prod_attr;
  }
}
