<?php

namespace Omikron\Factfinder\Prestashop\Settings;

class GeneralSettings extends AbstractSection implements SectionInterface
{
    public function getTitle()
    {
        return $this->l('General settings');
    }

    public function getFormFields()
    {
        return [
            'FF_ENABLED' => [
                'type'   => 'switch',
                'label'  => $this->l('Enabled FACT-Finder® Web Components?'),
                'name'   => 'FF_ENABLED',
                'values' => [['value' => '1'], ['value' => '0']],
            ],

            'FF_SERVER_URL' => [
                'type'     => 'text',
                'label'    => $this->l('Server URL'),
                'name'     => 'FF_SERVER_URL',
                'required' => true,
            ],

            'FF_USERNAME' => [
                'type'         => 'text',
                'label'        => $this->l('User'),
                'name'         => 'FF_USERNAME',
                'autocomplete' => false,
            ],

            'FF_PASSWORD' => [
                'type'         => 'password',
                'label'        => $this->l('Password'),
                'name'         => 'FF_PASSWORD',
                'autocomplete' => false,
            ],

            'FF_CHANNEL' => [
                'type'  => 'text',
                'label' => $this->l('Channel'),
                'name'  => 'FF_CHANNEL',
                'lang'  => true,
            ],

            'FF_AUTHENTICATION_PREFIX' => [
                'type'  => 'text',
                'label' => $this->l('Authentication Prefix'),
                'name'  => 'FF_AUTHENTICATION_PREFIX',
            ],

            'FF_AUTHENTICATION_POSTFIX' => [
                'type'  => 'text',
                'label' => $this->l('Authentication Postfix'),
                'name'  => 'FF_AUTHENTICATION_POSTFIX',
            ],

            'FF_USE_FOR_CATEGORIES' => [
                'type'   => 'switch',
                'label'  => $this->l('Use FACT-Finder® for category pages?'),
                'name'   => 'FF_USE_FOR_CATEGORIES',
                'values' => [['value' => '1'], ['value' => '0']],
            ],
        ];
    }

    public function getButtons()
    {
        return [
            'testConnection' => [
                'title' => 'Test connection',
                'class' => 'btn btn-default pull-right',
                'id'    => 'ffTestConnection',
                'icon'  => 'process-icon-ok',
            ],
        ];
    }
}
