<?php

namespace Omikron\Factfinder\Prestashop\Model\Export\Catalog;

class NameProvider
{
    public function getName()
    {
        return \Configuration::get('FF_CHANNEL', \Context::getContext()->language->id) . date('_Y-m-d_His') . '.csv';
    }
}
