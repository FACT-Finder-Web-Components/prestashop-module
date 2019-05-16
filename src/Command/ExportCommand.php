<?php

namespace Omikron\Factfinder\Prestashop\Command;

use Omikron\Factfinder\Prestashop\Api\PushImport;
use Omikron\Factfinder\Prestashop\Config\CommunicationParams;
use Omikron\Factfinder\Prestashop\Config\FtpParams;
use Omikron\Factfinder\Prestashop\Export\Output\Csv;
use Omikron\Factfinder\Prestashop\Model\Cron\EmulateEnvironment;
use Omikron\Factfinder\Prestashop\Model\Export\FileWriter;
use Omikron\Factfinder\Prestashop\Model\Export\Ftp;
use Omikron\Factfinder\Prestashop\Model\Export\NameProvider;
use PrestaShop\PrestaShop\Core\Export\ExportDirectory;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ExportCommand extends ContainerAwareCommand
{
    const PUSH_IMPORT_STEP       = 'import-file';
    const SAVE_FILE_LOCALLY_STEP = 'save-file';
    const SHOP_ID_OPTION         = 'shop-id';
    const LANGUAGE_ID_OPTION     = 'language-id';
    const ADMIN_DIR_OPTION       = 'admin-dir';

    /** @var Csv */
    private $exportCsv;

    /** @var ExportDirectory */
    private $exportDirectory;

    /** @var EmulateEnvironment */
    private $emulateEnv;

    /** @var PushImport */
    private $pushImport;

    /** @var FileWriter */
    private $fileWriter;

    /** @var ProgressBar */
    private $progressBar;

    /** @var OutputInterface */
    private $output;

    /** @var InputInterface */
    private $input;

    /** @var array */
    private $params;

    /** @var array */
    private $steps;

    public function __construct(
        Csv $exportCsv,
        ExportDirectory $exportDirectory,
        EmulateEnvironment $emulateEnvironment,
        FileWriter $fileWriter
    ) {
        parent::__construct('fact-finder:feed');
        $this->exportCsv       = $exportCsv;
        $this->exportDirectory = $exportDirectory;
        $this->emulateEnv      = $emulateEnvironment;
        $this->fileWriter      = $fileWriter;
    }

    public function configure()
    {
        $this->setName('fact-finder:feed')
            ->setDescription('Export feed file to selected directory')
            ->addOption(self::SHOP_ID_OPTION, 'shop' ,InputOption::VALUE_REQUIRED,'Sets the shop identifier used in environment emulation', 1)
            ->addOption(self::LANGUAGE_ID_OPTION, 'lang', InputOption::VALUE_REQUIRED, 'Sets the language identifier used in environment emulation,', 1)
            ->addOption(self::PUSH_IMPORT_STEP, 'import', InputOption::VALUE_REQUIRED, 'Determines if feed file should be uploaded to configured FACT-Finder and then, imported', true)
            ->addOption(self::SAVE_FILE_LOCALLY_STEP, 'save', InputOption::VALUE_REQUIRED, 'Determines if feed file should be saved locally', false)
            ->addOption(self::ADMIN_DIR_OPTION , 'admin', InputOption::VALUE_REQUIRED, 'Admin directory, required to correctly store feed file', 'admin');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->init($input, $output);
        $this->params = array_merge((new CommunicationParams())->getParameters(), (new FtpParams())->getParameters());
        $fileName     =  (new NameProvider())->getName() ;
        $filePath     = $this->exportDirectory . $fileName;
        $handle       = $this->exportCsv->write();
        $this->advance('Feed file has been generated');

        if ($this->steps[self::PUSH_IMPORT_STEP]) {
            $ftp = new Ftp($fileName);
            $ftp->open(new FtpParams())->upload($handle)->close();
            $this->pushImport->execute();
            $this->advance(sprintf('Feed file uploaded to %s successfully and import has been started on %s', $this->params['host'], $this->params['url']));
        }

        if ($this->steps[self::SAVE_FILE_LOCALLY_STEP]) {
            $this->fileWriter->save($handle, $filePath);
            $this->advance(sprintf('Feed file saved in %s successfully', $filePath));
        }
        return true;
    }

    private function init(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
        $this->emulateEnv->emulate(
            $input->getOption(self::SHOP_ID_OPTION),
            $input->getOption(self::LANGUAGE_ID_OPTION),
            $input->getOption(self::ADMIN_DIR_OPTION)
        );
        $this->pushImport  = $this->getContainer()->get('factfinder.api_push_import');

        $this->progressBar = new ProgressBar($output, $this->countSteps());
        $this->progressBar->setFormat(sprintf('%s <info>%%message%%</info>', $this->progressBar->getFormatDefinition('normal')));
        $this->progressBar->setBarCharacter('<fg=green>⚬</>');
        $this->progressBar->setEmptyBarCharacter("<fg=red>⚬</>");
        $this->progressBar->setProgressCharacter("<fg=green>➤</>");
    }

    private function countSteps()
    {
        return array_reduce([self::PUSH_IMPORT_STEP, self::SAVE_FILE_LOCALLY_STEP], function ($counter, $step) {
                $this->steps[$step] = $this->checkOptionIsTrue($step);
                return $this->steps[$step] ? ++$counter : $counter;
            }) + 1;
    }

    /**
     * @param string $optionName
     *
     * @return bool
     */
    private function checkOptionIsTrue($optionName)
    {
        return filter_var($this->input->getOption($optionName), FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * @param string   $message
     *
     */
    private function advance($message)
    {
        if ($this->output->getVerbosity() >= OutputInterface::VERBOSITY_VERBOSE) {
            $this->progressBar->setMessage($message, 'message');
            $this->progressBar->advance();
            $this->output->writeln('');
        }
    }
}
