<?php

namespace Omikron\Factfinder\Prestashop\Model;

use Category;

class CategoryFilter
{
    /** @var Category */
    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function __toString()
    {
        return $this->getValue();
    }

    /**
     * @param string $param
     *
     * @return string
     */
    private function getValue($param = 'CategoryPath')
    {
        $value = ['navigation=true'];
        $path  = 'ROOT';
        foreach ($this->category->getAllParents() as $category) {
            if (!$category->isRootCategoryForAShop() && $category->getTopCategory()->id != $category->id) {
                $value[] = $this->prepareFilterExpression($category, $path, $param);
                $path    .= urlencode('/' . $category->name);
            }
        }
        $value[] = $this->prepareFilterExpression($this->category, $path, $param);
        return implode(',', $value);
    }

    /**
     * @param Category $category
     * @param string   $path
     * @param string   $param
     *
     * @return string
     */
    private function prepareFilterExpression(Category $category, $path, $param)
    {
        return sprintf("filter{$param}%s=%s", $path, urlencode($category->name));
    }
}
