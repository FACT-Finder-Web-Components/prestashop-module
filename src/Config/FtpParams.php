<?php

namespace Omikron\Factfinder\Prestashop\Config;

class FtpParams
{
    public function getHost()
    {
        return \Configuration::get('FF_UPLOAD_HOST');
    }

    public function getPort()
    {
        return \Configuration::get('FF_UPLOAD_PORT');
    }

    public function getUser()
    {
        return \Configuration::get('FF_UPLOAD_USER');
    }

    public function getPassword()
    {
        return \Configuration::get('FF_UPLOAD_PASSWORD');
    }

    public function useSsl()
    {
        return (bool) \Configuration::get('FF_UPLOAD_SSL');
    }
}
