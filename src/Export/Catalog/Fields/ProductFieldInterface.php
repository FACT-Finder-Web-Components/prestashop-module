<?php

namespace Omikron\Factfinder\Prestashop\Export\Catalog\Fields;

interface ProductFieldInterface
{
    /**
     * Returns column specific formatted value
     *
     * @param $productId
     * @return string
     */
    public function getValue($productId);
}
