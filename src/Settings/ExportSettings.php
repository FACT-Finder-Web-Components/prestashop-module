<?php

namespace Omikron\Factfinder\Prestashop\Settings;

class ExportSettings extends AbstractSection implements SectionInterface
{
    public function getTitle()
    {
        return $this->l('Export settings');
    }

    public function getFormFields()
    {
        return [
            'FF_UPLOAD_HOST' => [
                'type'     => 'text',
                'label'    => $this->l('FTP host'),
                'name'     => 'FF_UPLOAD_HOST',
                'desc'     => $this->l(
                    'Please specify the FTP server address, where the export file(s) should be uploaded. For example shopname.fact-finder.de.
                     This parameter shouldn\'t have any trailing slashes and shouldn\'t be prefixed with ftp://.'
                ),
                'required' => true,
            ],

            'FF_UPLOAD_PORT' => [
                'type'     => 'text',
                'label'    => $this->l('FTP port'),
                'name'     => 'FF_UPLOAD_PORT',
                'required' => true,
            ],

            'FF_UPLOAD_USER' => [
                'type'     => 'text',
                'label'    => $this->l('FTP user'),
                'name'     => 'FF_UPLOAD_USER',
                'required' => true,
            ],

            'FF_UPLOAD_PASSWORD' => [
                'type'     => 'password',
                'label'    => $this->l('FTP password'),
                'name'     => 'FF_UPLOAD_PASSWORD',
                'required' => true,
            ],

            'FF_UPLOAD_SSL' => [
                'type'   => 'switch',
                'label'  => $this->l('SSL enabled'),
                'name'   => 'FF_UPLOAD_SSL',
                'values' => [['value' => '1'], ['value' => '0']],
            ],

            'FF_AUTOMATIC_IMPORT' => [
                'type'   => 'switch',
                'label'  => $this->l('Automatic Import of product'),
                'name'   => 'FF_AUTOMATIC_IMPORT',
                'desc'   => $this->l('Runs an automatic import of the product data to the FACT-Finder servers, after the FTP upload is finished.'),
                'values' => [['value' => 1], ['value' => 0]],
            ],

            'FF_PUSHED_IMPORT_TYPES' => [
                'type'     => 'select',
                'multiple' => true,
                'label'    => $this->l('Pushed import types'),
                'name'     => 'FF_PUSHED_IMPORT_TYPES',
                'desc'     => $this->l('Runs an automatic import of the product data to the FACT-Finder servers, after the FTP upload is finished.'),
                'options'  => [
                    'id'    => 0,
                    'name'  => 0,
                    'query' => [['Data'], ['Suggest'], ['Recommendation']],
                ],
            ],

            'FF_ADDITIONAL_ATTRIBUTES' => [
                'type'     => 'select',
                'multiple' => true,
                'label'    => $this->l('Additional attributes to export'),
                'name'     => 'FF_ADDITIONAL_ATTRIBUTES',
                'desc'     => $this->l('Chosen features that will be exported as with product'),
                'options'  => [
                    'query' => \Feature::getFeatures(\Context::getContext()->language->id),
                    'id'    => 'id_feature',
                    'name'  => 'name',
                ],
            ],
        ];
    }

    public function getButtons()
    {
        return [
            'save-feed' => [
                'title' => $this->l('Save Feed'),
                'class' => 'btn btn-default pull-right',
                'id'    => 'ffSaveFeed',
                'icon'  => 'process-icon-download-alt',
                'href'  => \Context::getContext()->link->getAdminLink('', true, ['route' => 'factfinder.feed.save']),
            ],

            'upload-feed' => [
                'title' => $this->l('Upload Feed'),
                'class' => 'btn btn-default pull-right',
                'id'    => 'ffUploadFeed',
                'icon'  => 'process-icon-upload',
            ],
        ];
    }
}
