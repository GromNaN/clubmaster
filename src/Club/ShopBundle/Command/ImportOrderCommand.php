<?php

namespace Club\ShopBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class ImportOrderCommand extends ContainerAwareCommand
{
  protected function configure()
  {
    $this
      ->setName('club:import:order')
      ->setDescription('Import orders')
      ->addArgument('file', InputArgument::REQUIRED, 'What filename to import')
      ->addArgument('location', InputArgument::REQUIRED, 'What location to shop from?')
      ->addArgument('product', InputArgument::REQUIRED, 'What product id to let the users buy?')
      ->setHelp(<<<EOF
The required filename just has to have a list of member numbers.
EOF
      )
      ;
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $em = $this->getContainer()->get('doctrine.orm.entity_manager');
    $product = $em->find('ClubShopBundle:Product', $input->getArgument('product'));
    $location = $em->find('ClubUserBundle:Location', $input->getArgument('location'));

    $fh = fopen($input->getArgument('file'), 'r');
    while (!feof($fh)) {
      $member_number = trim(fgets($fh, 1024));
      if (strlen($member_number) > 0) {

        $user = $em->getRepository('ClubUserBundle:User')->findOneBy(array( 'member_number' => $member_number ));
        if (!$user) throw new \Exception('No such user: '.$member_number);

        $order = $this->getContainer()->get('order');
        $order->createSimpleOrder($user, $location);
        $cart_prod = new \Club\ShopBundle\Entity\CartProduct();
        $cart_prod->setType('product');
        $cart_prod->setQuantity(1);
        $cart_prod->setPrice($product->getPrice());
        $cart_prod->setProductName($product->getProductName());
        $cart_prod->setProduct($product);

        foreach ($product->getProductAttributes() as $attr) {
          $product_attr = new \Club\ShopBundle\Entity\CartProductAttribute();
          $product_attr->setCartProduct($cart_prod);
          $product_attr->setValue($attr->getValue());
          $product_attr->setAttributeName($attr->getAttribute());
          $cart_prod->addCartProductAttribute($product_attr);
        }

        $order->addCartProduct($cart_prod);
        $order->save();

        $status = $em->getRepository('ClubShopBundle:OrderStatus')->getAcceptedStatus();
        $order->changeStatus($status);
      }
    }
    $em->flush();
  }
}
