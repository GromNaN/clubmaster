<?php

namespace Club\BookingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ManageDays extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('start_date', 'date');

    $date = new \DateTime('next monday');
    $int = new \DateInterval('P1D');
    $period = new \DatePeriod($date, $int, 7);

    foreach ($period as $dt) {
      $builder->add($dt->format('N'), new ManageInterval());
    }
  }

  public function getName()
  {
    return 'manage_day';
  }
}
