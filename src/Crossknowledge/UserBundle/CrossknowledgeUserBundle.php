<?php

namespace Crossknowledge\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CrossknowledgeUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}