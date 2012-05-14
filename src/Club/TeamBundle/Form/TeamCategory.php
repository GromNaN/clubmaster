<?php

namespace Club\TeamBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class TeamCategory extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('team_name');
    $builder->add('description');
    $builder->add('penalty');
  }

  public function getDefaultOptions()
  {
    return array(
      'data_class' => 'Club\TeamBundle\Entity\TeamCategory'
    );
  }

  public function getName()
  {
    return 'team_category';
  }
}
