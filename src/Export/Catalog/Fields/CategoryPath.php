<?php

namespace Omikron\Factfinder\Prestashop\Export\Catalog\Fields;

class CategoryPath implements ProductFieldInterface
{
    /** @var int */
    private $languageId;

    public function __construct()
    {
        $this->languageId = \ContextCore::getContext()->language->id;
    }

    public function getValue($productId)
    {
        $categories = array_column(\ProductCore::getProductCategoriesFull($productId, $this->languageId), 'name');
        return implode('|', array_map('urlencode', $categories));
    }
}
