<?php

namespace Club\UserBundle\Helper;

class Version
{
  protected $version = '1.2-dev';

  public function getVersion()
  {
    return $this->version;
  }
}
