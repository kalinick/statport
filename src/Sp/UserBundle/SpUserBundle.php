<?php

namespace Sp\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SpUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
