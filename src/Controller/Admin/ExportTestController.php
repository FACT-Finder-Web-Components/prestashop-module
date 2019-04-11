<?php

namespace Omikron\Factfinder\Prestashop\Controller\Admin;

use Omikron\Factfinder\Prestashop\Export\Catalog\DataProvider;
use Omikron\Factfinder\Prestashop\Export\Exporter;
use PrestaShopBundle\Component\CsvResponse;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Response;

class ExportTestController extends FrameworkBundleAdminController
{
    public function exportAction()
    {
        $dataProvider = new DataProvider($this->get('prestashop.core.admin.data_provider.product_interface'));
        $headersData  = [
            'ProductNumber' => 'ProductNumber',
            'Master'        => 'Master',
            'Name'          => 'Name',
            'Description'   => 'Description',
            'ImageURL'      => 'ImageURL',
            'Price'         => 'Price',
            'Brand'         => 'Brand',
            'Availability'  => 'Availability',
            'ProductURL'    => 'ProductURL',
            'PrestaID'      => 'PrestaID',
            'CategoryPath'  => 'CategoryPath',
            'Attributes'    => 'Attributes',
        ];

        if (\Tools::getValue('dump')) {
            foreach ($dataProvider->getEntities() as $product) {
                dump($product->toArray());
            }

            return new Response();
        }

        return (new CsvResponse(new Exporter($dataProvider, $headersData)))
            ->setFileName(\Configuration::get('FF_CHANNEL') . '_' . date('Y-m-d_His') . '.csv');
    }
}
