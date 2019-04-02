<?php

namespace Omikron\Factfinder\Prestashop\Settings;

class CommunicationSettings extends AbstractSection implements SectionInterface
{
    public function getTitle()
    {
        return $this->l('Communication settings');
    }

    public function getFormFields()
    {
        return [
            'FF_API_VERSION' => [
                'type'    => 'select',
                'label'   => $this->l('API Version'),
                'desc'    => $this->l('FACT-Finder® version'),
                'name'    => 'FF_API_VERSION',
                'options' => [
                    'id'    => 0,
                    'name'  => 0,
                    'query' => [['7.2'], ['7.3']],
                ],
            ],

            'FF_USE_URL_PARAMS' => [
                'type'   => 'switch',
                'label'  => $this->l('Use URL params?'),
                'desc'   => $this->l('If active, HTTP parameters of the current search are pushed to the browser URL'),
                'name'   => 'FF_USE_URL_PARAMS',
                'values' => [['value' => 1], ['value' => 0]],
            ],

            'FF_USE_BROWSER_CACHE' => [
                'type'   => 'switch',
                'label'  => $this->l('Use browser cache?'),
                'desc'   => $this->l('Modern browsers support this feature and therefore speed up search for repeated requests.'),
                'name'   => 'FF_USE_BROWSER_CACHE',
                'values' => [['value' => 1], ['value' => 0]],
            ],

            'FF_DEFAULT_QUERY' => [
                'type'  => 'text',
                'label' => $this->l('Default query'),
                'desc'  => $this->l("Determines which search term should be used by default. Default is '*'"),
                'name'  => 'FF_DEFAULT_QUERY',
            ],

            'FF_ADD_PARAMS' => [
                'type'  => 'text',
                'label' => $this->l('Add search params'),
                'desc'  => $this->l('Attach these params to every search request. Example: param1=abcd,param2=xyz'),
                'name'  => 'FF_ONLY_SEARCH_PARAMS',
            ],

            'FF_DISABLE_SINGLE_HIT_REDIRECTS' => [
                'type'   => 'switch',
                'label'  => $this->l('Disable single hit redirects?'),
                'desc'   => $this->l('If active, prevents redirects to the product page when only one result is found'),
                'name'   => 'FF_DISABLE_SINGLE_HIT_REDIRECTS',
                'values' => [['value' => 1], ['value' => 0]],
            ],
        ];
    }
}
