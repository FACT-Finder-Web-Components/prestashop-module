<?php

namespace Omikron\Factfinder\Prestashop\Config;

class FtpParams extends AbstractParams
{
    public function __construct()
    {
        $this->params = [
            'host'     => 'FF_UPLOAD_HOST',
            'port'     => 'FF_UPLOAD_PORT',
            'user'     => 'FF_UPLOAD_USER',
            'password' => 'FF_UPLOAD_PASSWORD',
            'use-ssl'  => 'FF_UPLOAD_SSL',
        ];
    }
}
