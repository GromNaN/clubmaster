<?php

namespace Club\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class LocationConfig extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('config');
    $builder->add('value');
  }

  public function getDefaultOptions()
  {
    return array(
      'data_class' => 'Club\UserBundle\Entity\LocationConfig'
    );
  }

  public function getName()
  {
    return 'location_config';
  }
}
