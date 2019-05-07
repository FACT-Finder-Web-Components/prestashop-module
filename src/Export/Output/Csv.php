<?php

namespace Omikron\Factfinder\Prestashop\Export\Output;

use Omikron\Factfinder\Prestashop\Model\Export\DataProviderInterface;
use Omikron\Factfinder\Prestashop\Model\Export\ExportEntityInterface;
use PrestaShop\PrestaShop\Core\Export\ExportDirectory;
use SplFileObject;

class Csv extends AbstractOutput implements OutputInterface
{
    /** @var DataProviderInterface */
    private $dataProvider;

    /** @var ExportDirectory */
    private $exportDirectory;

    /** @var SplFileObject */
    private $handle;

    /**
     * Csv constructor.
     *
     * @param ExportDirectory       $exportDirectory
     * @param DataProviderInterface $dataProvider
     * @param array                 $headersData
     */
    public function __construct(
        ExportDirectory $exportDirectory,
        DataProviderInterface $dataProvider,
        array $headersData
    ) {
        parent::__construct();
        $this->exportDirectory = $exportDirectory;
        $this->dataProvider    = $dataProvider;
        $this->headersData     = $headersData;
    }

    public function __invoke()
    {
        $this->write();
        while (!$this->handle->eof()) {
            $buffer = $this->handle->fread($this->handle->getSize());
            echo $buffer;
            flush();
        }
    }

    public function __destruct()
    {
        unlink($this->handle->getPathname());
    }

    /**
     * @return SplFileObject
     */
    public function write()
    {
        $this->handle = new SplFileObject($this->exportDirectory . 'feed.tmp', 'w+');
        $this->handle->fputcsv($this->headersData, ';');
        /** @var ExportEntityInterface $line */
        foreach ($this->dataProvider->getEntities() as $line) {
            $this->handle->fputcsv($this->prepareRow($line->toArray()), ';');
        }
        $this->handle->rewind();

        return $this->handle;
    }
}
