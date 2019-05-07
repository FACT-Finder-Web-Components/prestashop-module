<?php

namespace Omikron\Factfinder\Prestashop\Config;

class FtpParams extends AbstractParams
{
    public function __construct()
    {
        $this->params = [
            'host'     => \Configuration::get('FF_UPLOAD_HOST'),
            'port'     => \Configuration::get('FF_UPLOAD_PORT'),
            'user'     => \Configuration::get('FF_UPLOAD_USER'),
            'password' => \Configuration::get('FF_UPLOAD_PASSWORD'),
            'use-ssl'  => \Configuration::get('FF_UPLOAD_SSL')
        ];
    }
}
