<?php

namespace Club\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class Currency extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('currency_name');
    $builder->add('code');
  }

  public function getDefaultOptions()
  {
    return array(
      'data_class' => 'Club\UserBundle\Entity\Currency'
    );
  }

  public function getName()
  {
    return 'currency';
  }
}
