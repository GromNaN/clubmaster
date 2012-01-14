<?php

namespace Club\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class User extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('language');
    $builder->add('password', 'repeated', array(
      'type' => 'password',
      'first_name' => 'Password',
      'second_name' => 'Password again',
    ));
    $builder->add('profile', new \Club\UserBundle\Form\AdminProfile());
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Club\UserBundle\Entity\User',
      'validation_groups' => 'user'
    );
  }

  public function getName()
  {
    return 'user';
  }
}
