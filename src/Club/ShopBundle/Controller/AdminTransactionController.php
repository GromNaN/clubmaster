<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminTransactionController extends Controller
{
  /**
   * @Route("/shop/transaction", name="admin_shop_transaction")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $transactions = $em->getRepository('\Club\ShopBundle\Entity\Transaction')->findAll();

    return array(
      'transactions' => $transactions
    );
  }
}
