<?php

namespace Omikron\Factfinder\Prestashop\Model\Cron;

class EmulateEnvironment
{
    /**
     * This method is used for initialize partially mocked PrestaShop environment
     * causing its services will be able to use from CLI script
     *
     * @param \Context $context
     * @param string   $idShop
     * @param string   $idLang
     *
     * @throws \Exception
     */
    public function emulate(\Context $context, $idShop, $idLang)
    {
        $context->language   = new \Language($idLang);
        $context->shop       = new \Shop($idShop, $idLang);
        $context->employee   = new \Employee(null, $idLang, $idShop);
        $context->controller = new \AdminControllerCore('Admin');
    }
}
