<?php

namespace Omikron\Factfinder\Prestashop\Config;

class AuthorizationParams extends AbstractParams
{
    public function __construct()
    {
        $this->params = [
            'username'              => 'FF_USERNAME',
            'password'              => 'FF_PASSWORD',
            'authenticationPrefix'  => 'FF_AUTHENTICATION_PREFIX',
            'authenticationPostfix' => 'FF_AUTHENTICATION_POSTFIX',
        ];
    }
}
