<?php

namespace Omikron\Factfinder\Prestashop\Command;

use Omikron\Factfinder\Prestashop\Config\CommunicationParams;
use Omikron\Factfinder\Prestashop\Config\FtpParams;
use Omikron\Factfinder\Prestashop\Export\Output\Csv;
use Omikron\Factfinder\Prestashop\Model\Cron\EmulateEnvironment;
use Omikron\Factfinder\Prestashop\Model\Export\Catalog\NameProvider;
use Omikron\Factfinder\Prestashop\Model\Export\FileWriter;
use Omikron\Factfinder\Prestashop\Model\Export\Ftp;
use PrestaShop\PrestaShop\Core\Export\ExportDirectory;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ExportCommand extends ContainerAwareCommand
{
    const UPLOAD_FEED = 'upload';
    const SAVE_FEED   = 'save';
    const SHOP_ID     = 'shop';
    const LANGUAGE_ID = 'language';
    const ADMIN_DIR   = 'admin-dir';

    /** @var Csv */
    private $exportCsv;

    /** @var ExportDirectory */
    private $exportDirectory;

    /** @var EmulateEnvironment */
    private $emulateEnv;

    /** @var FileWriter */
    private $fileWriter;

    public function __construct(
        Csv $exportCsv,
        ExportDirectory $exportDirectory,
        EmulateEnvironment $emulateEnvironment,
        FileWriter $fileWriter
    ) {
        parent::__construct('factfinder:feed');
        $this->exportCsv       = $exportCsv;
        $this->exportDirectory = $exportDirectory;
        $this->emulateEnv      = $emulateEnvironment;
        $this->fileWriter      = $fileWriter;
    }

    public function configure()
    {
        $this->setDescription('Export feed file to selected directory');
        $this->addOption(self::SHOP_ID, 's', InputOption::VALUE_OPTIONAL, 'Shop ID of the shop to be exported', 1);
        $this->addOption(self::LANGUAGE_ID, 'l', InputOption::VALUE_OPTIONAL, 'Requested language ID', 1);
        $this->addOption(self::UPLOAD_FEED, 'u', InputOption::VALUE_NONE, 'Upload feed to the FACT-Finder server');
        $this->addOption(self::SAVE_FEED, 'f', InputOption::VALUE_NONE, 'Save feed locally');
        $this->addOption(self::ADMIN_DIR, null, InputOption::VALUE_OPTIONAL, 'Admin directory location', 'admin');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $progress = $this->progress($output, $input->getOption(self::UPLOAD_FEED) + $input->getOption(self::SAVE_FEED));

        $fileName = (new NameProvider())->getName();
        $handle   = $this->exportCsv->write();

        $progress('Feed file has been generated');

        if ($input->getOption(self::UPLOAD_FEED)) {
            $ftp = new Ftp($fileName);
            $ftp->open(new FtpParams());
            $ftp->upload($handle);
            $ftp->close();

            $this->getContainer()->get('factfinder.api_push_import')->execute();

            $serverUrl = (new CommunicationParams())->getServerUrl(false);
            $progress('Feed file uploaded successfully and import has been started on %s', $serverUrl);
        }

        if ($input->getOption(self::SAVE_FEED)) {
            $filePath = $this->exportDirectory . $fileName;
            $this->fileWriter->save($handle, $filePath);
            $progress('Feed file successfully saved in %s', $filePath);
        }
    }

    private function progress(OutputInterface $output, $max)
    {
        if ($output->getVerbosity() < OutputInterface::VERBOSITY_VERBOSE) {
            return function () {
            };
        }

        $progressBar = new ProgressBar($output);
        $progressBar->setFormat("<info>%message%</info>\n" . $progressBar->getFormatDefinition('normal'));
        $progressBar->setMessage('Generating export feed...');
        $progressBar->start($max + 1);

        return function ($message, ...$args) use ($progressBar, $output) {
            $progressBar->setMessage(vsprintf($message, $args));
            $progressBar->advance();
            if ($progressBar->getMaxSteps() === $progressBar->getProgress()) {
                $progressBar->finish();
                $output->writeln('');
            }
        };
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        require dirname($this->getContainer()->get('kernel')->getRootDir()) . '/config/config.inc.php';

        $adminDir = _PS_ROOT_DIR_ . DIRECTORY_SEPARATOR . $input->getOption(self::ADMIN_DIR);
        if (!is_dir($adminDir)) {
            throw new \Exception(sprintf('%s is not a valid directory', $adminDir));
        }
        define('_PS_ADMIN_DIR_', $adminDir);

        $this->emulateEnv->emulate(
            \Context::getContext(),
            $input->getOption(self::SHOP_ID),
            $input->getOption(self::LANGUAGE_ID)
        );
    }
}
