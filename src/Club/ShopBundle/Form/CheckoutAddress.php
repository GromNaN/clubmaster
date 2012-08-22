<?php

namespace Club\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CheckoutAddress extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('company_name');
    $builder->add('cvr');
    $builder->add('first_name');
    $builder->add('last_name');
    $builder->add('street');
    $builder->add('postal_code');
    $builder->add('city');
    $builder->add('state');
    $builder->add('country');
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'Club\ShopBundle\Entity\CartAddress'
    ));
  }

  public function getName()
  {
    return 'checkout_address';
  }
}
