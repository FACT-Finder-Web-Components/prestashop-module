<?php

namespace Omikron\Factfinder\Prestashop\Command\Feed;

use Omikron\Factfinder\Prestashop\Export\Output\Csv as CsvExport;
use Omikron\Factfinder\Prestashop\Model\Cron\EmulateEnvironment;
use Omikron\Factfinder\Prestashop\Model\Export\Catalog\NameProvider;
use Omikron\Factfinder\Prestashop\Model\Export\FileWriter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class SaveCommand extends Command
{
    const SHOP_ID     = 'shop';
    const LANGUAGE_ID = 'language';
    const ADMIN_DIR   = 'admin-dir';

    /** @var KernelInterface */
    private $kernel;

    /** @var CsvExport */
    private $exportCsv;

    /** @var EmulateEnvironment */
    private $emulateEnv;

    /** @var FileWriter */
    private $fileWriter;

    public function __construct(
        KernelInterface $kernel,
        CsvExport $exportCsv,
        EmulateEnvironment $emulateEnvironment,
        FileWriter $fileWriter
    ) {
        parent::__construct('factfinder:feed:save');
        $this->kernel     = $kernel;
        $this->exportCsv  = $exportCsv;
        $this->emulateEnv = $emulateEnvironment;
        $this->fileWriter = $fileWriter;
    }

    public function configure()
    {
        $this->setDescription('Export feed file to selected directory');
        $this->addOption(self::SHOP_ID, 's', InputOption::VALUE_OPTIONAL, 'Shop ID of the shop to be exported', 1);
        $this->addOption(self::LANGUAGE_ID, 'l', InputOption::VALUE_OPTIONAL, 'Requested language ID', 1);
        $this->addOption(self::ADMIN_DIR, 'a', InputOption::VALUE_OPTIONAL, 'Admin directory location', 'admin');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filePath = sprintf('%s/%s', $this->getExportDir($input->getOption(self::ADMIN_DIR)), new NameProvider());

        $export = $this->exportCsv->write();
        $this->fileWriter->save($export, $filePath);
        fclose($export);

        $output->writeln('Feed file successfully saved in ' . $filePath);
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        require dirname($this->kernel->getRootDir()) . '/config/config.inc.php';

        $this->emulateEnv->emulate(
            \Context::getContext(),
            $input->getOption(self::SHOP_ID),
            $input->getOption(self::LANGUAGE_ID)
        );
    }

    private function getExportDir($adminDir)
    {
        $dir = realpath(sprintf('%s/../%s/export', $this->kernel->getRootDir(), $adminDir));
        if (!$dir) throw new \RuntimeException('Invalid admin directory: ' . $adminDir);
        return $dir;
    }
}
