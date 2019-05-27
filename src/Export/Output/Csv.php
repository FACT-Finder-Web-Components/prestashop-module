<?php

namespace Omikron\Factfinder\Prestashop\Export\Output;

use Omikron\Factfinder\Prestashop\Model\Export\DataProviderInterface;
use Omikron\Factfinder\Prestashop\Model\Export\ExportEntityInterface;
use SplFileObject;

class Csv extends AbstractOutput implements OutputInterface
{
    /** @var DataProviderInterface */
    private $dataProvider;

    /** @var SplFileObject */
    private $handle;

    /**
     * Csv constructor.
     *
     * @param DataProviderInterface $dataProvider
     * @param array                 $headersData
     */
    public function __construct(
        DataProviderInterface $dataProvider,
        array $headersData
    ) {
        parent::__construct();
        $this->dataProvider = $dataProvider;
        $this->headersData  = $headersData;
    }

    public function __invoke()
    {
        $this->write();
        $this->handle->fpassthru();
        $this->handle->rewind();
    }

    /**
     * @return SplFileObject
     */
    public function write()
    {
        $this->handle = new SplFileObject('php://temp', 'w+');
        $this->handle->fputcsv($this->headersData, ';');

        /** @var ExportEntityInterface $line */
        foreach ($this->dataProvider->getEntities() as $line) {
            $this->handle->fputcsv($this->prepareRow($line->toArray()), ';');
        }
        $this->handle->rewind();
        return $this->handle;
    }
}
