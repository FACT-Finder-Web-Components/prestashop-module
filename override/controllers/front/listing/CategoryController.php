<?php

use Omikron\Factfinder\Prestashop\FeaturesConfig;

class CategoryController extends CategoryControllerCore
{
    public function initContent()
    {
        parent::initContent();
        if ((bool) \Configuration::get('FF_USE_FOR_CATEGORIES')) {
            $this->context->smarty->assign(
                'ff', [
                    'features'         => new FeaturesConfig(),
                    'search_immediate' => 'true',
                    'add_params'       => $this->getAddParams()
                ]
            );
            $this->template = 'module:factfinder/views/templates/front/search.tpl';

            $theme = $this->context->shop->theme;
            if (!$theme->get("theme_settings.layouts.{$this->getPageName()}")) {
                $layouts = $theme->getPageLayouts();
                $theme->setPageLayouts($layouts + [$this->getPageName() => $layouts['category']]);
            }
        }
    }

    /**
     * @return array
     */
    private function getAddParams()
    {
        $value        = ['navigation=true'];
        $path         = 'ROOT';
        foreach ($this->category->getAllParents() as $category) {
            if (!$category->isRootCategoryForAShop() && $category->getTopCategory()->id != $category->id) {
                $value[] = $this->prepareFilterExpression($category, $path);
                $path    .= urlencode('/' . $category->name);
            }
        }
        $value[] = $this->prepareFilterExpression($this->category, $path);

        return implode(',', $value);
    }

    /**
     * @param CategoryCore $category
     * @param string $path
     *
     * @return string
     */
    private function prepareFilterExpression(CategoryCore $category, $path)
    {
        $param        = 'CategoryPath';
        return sprintf("filter{$param}%s=%s", $path, urlencode($category->name));
    }
}
