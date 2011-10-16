<?php

namespace Club\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

class Product extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('product_name');
    $builder->add('description');
    $builder->add('price');
    $builder->add('categories');
    $builder->add('account', 'entity', array(
      'class' => 'ClubAccountBundle:Account',
      'query_builder' => function(EntityRepository $er) {
        return $er->createQueryBuilder('a')
          ->where('a.account_type = :type')
          ->setParameter('type', 'income');
      }
    ));
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\ShopBundle\Entity\Product'
    );
  }

  public function getName()
  {
    return 'product';
  }
}
