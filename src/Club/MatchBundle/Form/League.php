<?php

namespace Club\MatchBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class League extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('name');
    $builder->add('rule');
    $builder->add('gender', 'choice', array(
      'choices' => \Club\UserBundle\Helper\Util::getGenders(),
      'required' => false
    ));
    $builder->add('invite_only', 'checkbox', array(
      'required' => false
    ));
    $builder->add('game_set');
    $builder->add('start_date');
    $builder->add('end_date');
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\MatchBundle\Entity\League'
    );
  }

  public function getName()
  {
    return 'league';
  }
}
