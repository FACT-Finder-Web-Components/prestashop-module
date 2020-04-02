<?php

use Omikron\Factfinder\Prestashop\FeaturesConfig;

class FactfinderSearchModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        parent::initContent();
        $this->context->smarty->assign('ff', [
            'features'         => new FeaturesConfig(),
            'search_immediate' => 'true',
        ]);
        $this->setTemplate('module:factfinder/views/templates/front/search.tpl');

        $theme = $this->context->shop->theme;
        if (!$theme->get("theme_settings.layouts.{$this->getPageName()}")) {
            $layouts = $theme->getPageLayouts();
            $theme->setPageLayouts($layouts + [$this->getPageName() => $layouts['category']]);
        }
    }

    public function getTemplateVarPage()
    {
        $page                  = parent::getTemplateVarPage();
        $page['meta']['title'] = $this->module->l('Search');
        return $page;
    }
}
