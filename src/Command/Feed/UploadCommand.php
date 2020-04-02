<?php

namespace Omikron\Factfinder\Prestashop\Command\Feed;

use Omikron\Factfinder\Prestashop\Api\PushImport;
use Omikron\Factfinder\Prestashop\Export\Output\Csv as CsvExport;
use Omikron\Factfinder\Prestashop\Model\Cron\EmulateEnvironment;
use Omikron\Factfinder\Prestashop\Model\Export\Catalog\NameProvider;
use Omikron\Factfinder\Prestashop\Model\Export\FtpClient;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class UploadCommand extends ContainerAwareCommand
{
    const SHOP_ID     = 'shop';
    const LANGUAGE_ID = 'language';
    const ADMIN_DIR   = 'admin-dir';

    /** @var CsvExport */
    private $exportCsv;

    /** @var EmulateEnvironment */
    private $emulateEnv;

    /** @var FtpClient */
    private $ftpClient;

    /** @var PushImport */
    private $pushImport;

    public function __construct(
        CsvExport $exportCsv,
        EmulateEnvironment $emulateEnvironment,
        FtpClient $ftpClient,
        PushImport $pushImport
    ) {
        parent::__construct('factfinder:feed:upload');
        $this->exportCsv  = $exportCsv;
        $this->emulateEnv = $emulateEnvironment;
        $this->ftpClient  = $ftpClient;
        $this->pushImport = $pushImport;
    }

    public function configure()
    {
        $this->setDescription('Export feed file to selected directory');
        $this->addOption(self::SHOP_ID, 's', InputOption::VALUE_OPTIONAL, 'Shop ID of the shop to be exported', 1);
        $this->addOption(self::LANGUAGE_ID, 'l', InputOption::VALUE_OPTIONAL, 'Requested language ID', 1);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $handle = $this->exportCsv->write();
        $output->writeln('Feed file has been generated');

        $this->ftpClient->upload($handle, (string) new NameProvider());
        $this->pushImport->execute();

        $host = $this->getContainer()->get('factfinder.config.ftp_params')->getHost();
        $output->writeln('Feed file uploaded successfully and import has been started on ' . $host);
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        require dirname($this->getContainer()->get('kernel')->getRootDir()) . '/config/config.inc.php';

        $this->emulateEnv->emulate(
            \Context::getContext(),
            $input->getOption(self::SHOP_ID),
            $input->getOption(self::LANGUAGE_ID)
        );
    }
}
