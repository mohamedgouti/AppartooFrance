<?php

namespace EspritUserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class EspritUserBundle extends Bundle
{
      public function getParent()
  {
    return 'FOSUserBundle';
  }
}
