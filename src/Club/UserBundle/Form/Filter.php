<?php

namespace Club\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class Filter extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $age = range(0,120);
    $boolean = array(
      '1' => 'Yes',
      '0' => 'No'
    );

    $builder->add('name');
    $builder->add('member_number');
    $builder->add('min_age', 'choice', array(
      'choices' => $age,
      'required' => false
    ));
    $builder->add('max_age', 'choice', array(
      'choices' => $age,
      'required' => false
    ));
    $builder->add('gender', 'choice', array(
      'choices' => array(
        'male' => 'Male',
        'female' => 'Female'
      ),
      'required' => false
    ));
    $builder->add('postal_code', 'text', array(
      'required' => false
    ));
    $builder->add('city', 'text', array(
      'required' => false
    ));
    $builder->add('country', 'entity', array(
      'class' => 'Club\UserBundle\Entity\Country',
      'required' => false
    ));
    $builder->add('is_active', 'choice', array(
      'choices' => $boolean,
      'required' => false
    ));
    $builder->add('has_ticket', 'choice', array(
      'choices' => $boolean,
      'required' => false
    ));
    $builder->add('has_subscription', 'choice', array(
      'choices' => $boolean,
      'required' => false
    ));
    $builder->add('location', 'entity', array(
      'class' => 'Club\UserBundle\Entity\Location',
      'required' => false,
      'multiple' => true
    ));
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\UserBundle\Filter\UserFilter'
    );
  }
}
