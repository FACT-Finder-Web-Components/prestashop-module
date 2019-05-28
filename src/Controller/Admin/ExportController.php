<?php

namespace Omikron\Factfinder\Prestashop\Controller\Admin;

use Omikron\Factfinder\Prestashop\Api\PushImport;
use Omikron\Factfinder\Prestashop\DataTransferObject\AjaxResponse;
use Omikron\Factfinder\Prestashop\Export\Output\Csv;
use Omikron\Factfinder\Prestashop\Export\Output\Dump;
use Omikron\Factfinder\Prestashop\Model\Export\FtpClient;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Response;

class ExportController extends FrameworkBundleAdminController
{
    public function exportAction()
    {
        /** @var Csv $csv */
        $csv = $this->get('factfinder.export.output.csv');

        switch (\Tools::getValue('mode')) {
            case 'dump':
                /** @var Dump $dumper */
                $dumper = $this->get('factfinder.export.output.dump');
                $dumper->write();
                $response = new Response();
                break;
            default:
                try {
                    /** @var FtpClient $ftp */
                    $ftp = $this->get('factfinder.export_ftp');
                    $ftp->upload($csv->write(), (string) $this->get('factfinder.export.catalog.name_provider'));

                    /** @var PushImport $pushImport */
                    $pushImport = $this->get('factfinder.api_push_import');
                    $pushImport->execute();

                    $response = $this->json(new AjaxResponse(
                        'Feed was successfully generated and uploaded to ' . $this->get('factfinder.config.ftp_params')->getHost()));
                } catch (\Exception $e) {
                    $response = $this->json(new AjaxResponse('Feed Export failed. Reason:', $e->getMessage()), 400);
                }
                break;
        }

        return $response;
    }

    public function saveAction()
    {
        return $this->get('factfinder.export.catalog.csv_download');
    }
}
