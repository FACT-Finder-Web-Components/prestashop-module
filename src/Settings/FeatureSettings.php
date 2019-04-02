<?php

namespace Omikron\Factfinder\Prestashop\Settings;

class FeatureSettings extends AbstractSection implements SectionInterface
{
    public function getTitle()
    {
        return $this->l('Feature settings');
    }

    public function getFormFields()
    {
        return [
            'FF_FEATURE_SUGGEST' => [
                'type'   => 'switch',
                'label'  => $this->l('Suggestions'),
                'name'   => 'FF_FEATURE_SUGGEST',
                'values' => [['value' => '1'], ['value' => '0']],
            ],

            'FF_FEATURE_ASN' => [
                'type'   => 'switch',
                'label'  => $this->l('Filter / ASN'),
                'name'   => 'FF_FEATURE_ASN',
                'values' => [['value' => '1'], ['value' => '0']],
            ],

            'FF_FEATURE_PAGING' => [
                'type'   => 'switch',
                'label'  => $this->l('Paging'),
                'name'   => 'FF_FEATURE_PAGING',
                'values' => [['value' => '1'], ['value' => '0']],
            ],

            'FF_FEATURE_SORTING' => [
                'type'   => 'switch',
                'label'  => $this->l('Sorting'),
                'name'   => 'FF_FEATURE_SORTING',
                'values' => [['value' => '1'], ['value' => '0']],
            ],

            'FF_FEATURE_BREADCRUMBS' => [
                'type'   => 'switch',
                'label'  => $this->l('Breadcrumbs'),
                'name'   => 'FF_FEATURE_BREADCRUMBS',
                'values' => [['value' => '1'], ['value' => '0']],
            ],

            'FF_FEATURE_PRODUCTS_PER_PAGE' => [
                'type'   => 'switch',
                'label'  => $this->l('Products per page'),
                'name'   => 'FF_FEATURE_PRODUCTS_PER_PAGE',
                'values' => [['value' => '1'], ['value' => '0']],
            ],

            'FF_FEATURE_CAMPAIGNS' => [
                'type'   => 'switch',
                'label'  => $this->l('Campaigns'),
                'name'   => 'FF_FEATURE_CAMPAIGNS',
                'values' => [['value' => '1'], ['value' => '0']],
            ],

            'FF_FEATURE_RECOMMENDATIONS' => [
                'type'   => 'switch',
                'label'  => $this->l('Recommendations'),
                'name'   => 'FF_FEATURE_RECOMMENDATIONS',
                'values' => [['value' => '1'], ['value' => '0']],
            ],

            'FF_FEATURE_SIMILAR' => [
                'type'   => 'switch',
                'label'  => $this->l('Similar products'),
                'name'   => 'FF_FEATURE_SIMILAR',
                'values' => [['value' => '1'], ['value' => '0']],
            ],

            'FF_FEATURE_PUSHED_PRODUCTS' => [
                'type'   => 'switch',
                'label'  => $this->l('Pushed products'),
                'name'   => 'FF_FEATURE_PUSHED_PRODUCTS',
                'values' => [['value' => '1'], ['value' => '0']],
            ],
        ];
    }
}
