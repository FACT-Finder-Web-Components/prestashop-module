<?php

namespace Omikron\Factfinder\Prestashop\Controller\Admin;

use Omikron\Factfinder\Prestashop\Api\PushImport;
use Omikron\Factfinder\Prestashop\DataTransferObject\AjaxResponse;
use Omikron\Factfinder\Prestashop\Export\Output\Csv;
use Omikron\Factfinder\Prestashop\Model\Export\FtpClient;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends FrameworkBundleAdminController
{
    public function exportAction()
    {
        /** @var Csv $csv */
        $csv = $this->get('factfinder.export.output.csv');

        try {
            /** @var FtpClient $ftp */
            $ftp = $this->get('factfinder.export_ftp');
            $ftp->upload($csv->write(), (string) $this->get('factfinder.export.catalog.name_provider'));

            /** @var PushImport $pushImport */
            $pushImport = $this->get('factfinder.api_push_import');
            $pushImport->execute();

            $ftpHost = $this->get('factfinder.config.ftp_params')->getHost();
            return $this->json(new AjaxResponse('Feed was successfully generated and uploaded to ' . $ftpHost));
        } catch (\Exception $e) {
            return $this->json(new AjaxResponse('Feed Export failed. Reason:', $e->getMessage()), 400);
        }
    }

    public function dumpAction()
    {
        return StreamedResponse::create([$this->get('factfinder.export.output.dump'), 'write']);
    }

    public function saveAction()
    {
        return $this->get('factfinder.export.catalog.csv_download');
    }
}
