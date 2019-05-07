<?php

namespace Omikron\Factfinder\Prestashop\Config;

class AuthorizationParams extends AbstractParams
{
    public function __construct()
    {
        $this->params = [
            'username'              => \Configuration::get('FF_USERNAME'),
            'password'              => \Configuration::get('FF_PASSWORD'),
            'authenticationPrefix'  => \Configuration::get('FF_AUTHENTICATION_PREFIX'),
            'authenticationPostfix' => \Configuration::get('FF_AUTHENTICATION_POSTFIX'),
        ];
    }
}
