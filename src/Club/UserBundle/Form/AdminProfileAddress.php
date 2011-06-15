<?php

namespace Club\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AdminProfileAddress extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('street');
    $builder->add('suburl');
    $builder->add('postal_code');
    $builder->add('city');
    $builder->add('state');
    $builder->add('country');
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\UserBundle\Entity\ProfileAddress'
    );
  }
}
