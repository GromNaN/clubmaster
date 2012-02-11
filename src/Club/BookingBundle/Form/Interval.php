<?php

namespace Club\BookingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

class Interval extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $days = array(
      1 => 'Monday',
      2 => 'Tuesday',
      3 => 'Wednesday',
      4 => 'Thursday',
      5 => 'Friday',
      6 => 'Saturday',
      7 => 'Sunday'
    );
    $builder->add('day', 'choice', array(
      'choices' => $days
    ));
    $builder->add('start_time');
    $builder->add('stop_time');
    $builder->add('field');
    $builder->add('valid_from');
    $builder->add('valid_to');
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\BookingBundle\Entity\Interval'
    );
  }

  public function getName()
  {
    return 'interval';
  }
}
