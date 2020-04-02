<?php

namespace Omikron\Factfinder\Prestashop\Model\Export\Catalog\Fields;

class CategoryPath implements ProductFieldInterface
{
    /** @var int */
    private $languageId;

    public function __construct()
    {
        $this->languageId = \Context::getContext()->language->id;
    }

    public function getValue($productId)
    {
        $categories = $this->filterCategories(array_column(\Product::getProductCategoriesFull($productId, $this->languageId), 'name'));
        return implode('/', array_map('urlencode', $categories));
    }

    private function filterCategories($categories)
    {
        return array_filter($categories, function ($category) {
            return $category != 'Home' ? true : false;
        });
    }
}
