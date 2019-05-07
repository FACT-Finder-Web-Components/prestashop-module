<?php

namespace Omikron\Factfinder\Prestashop\Controller\Admin;

use Omikron\Factfinder\Prestashop\Api\PushImport;
use Omikron\Factfinder\Prestashop\Config\FtpParams;
use Omikron\Factfinder\Prestashop\DataTransferObject\AjaxResponse;
use Omikron\Factfinder\Prestashop\Export\Output\Csv;
use Omikron\Factfinder\Prestashop\Export\Output\Dump;
use Omikron\Factfinder\Prestashop\Model\Export\Ftp;
use PrestaShopBundle\Component\CsvResponse;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Response;
use Tools;

class ExportController extends FrameworkBundleAdminController
{
    public function exportAction()
    {
        /** @var Csv $csv */
        $csv = $this->get('factfinder.export.output.csv');

        switch (Tools::getValue('mode')) {
            case 'dump':
                /** @var Dump $dumper */
                $dumper = $this->get('factfinder.export.output.dump');
                $dumper->write();
                $response = new Response();
                break;
            case 'download':
                /** @var CsvResponse $response */
                $response = $this->get('factfinder.export.catalog.csv_download');
                break;
            default:
                try {
                    /** @var Ftp $ftp */
                    $ftp = $this->get('factfinder.export_ftp');
                    $ftpParams = new FtpParams();
                    $ftp->open($ftpParams)->upload($csv->write())->close();

                    /** @var PushImport $pushImport */
                    $pushImport = $this->get('factfinder.api_push_import');
                    $pushImport->execute();

                    $response = $this->json(new AjaxResponse(
                        sprintf('Feed was successfully generated and uploaded to %s', $ftpParams['host'])));
                } catch (\Exception $e) {
                    $response = $this->json(new AjaxResponse('Feed Export failed. Reason:', $e->getMessage()), 400);
                }
        }

        return $response;
    }
}
