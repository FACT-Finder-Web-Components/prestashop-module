<?php

namespace Omikron\Factfinder\Prestashop\Export\Output;

use Omikron\Factfinder\Prestashop\Model\Export\DataProviderInterface;
use Omikron\Factfinder\Prestashop\Model\Export\ExportEntityInterface;

class Dump extends AbstractOutput implements OutputInterface
{
    /** @var DataProviderInterface */
    private $dataProvider;

    public function __construct(
        DataProviderInterface $dataProvider,
        array $headersData
    ) {
        parent::__construct();
        $this->dataProvider = $dataProvider;
        $this->headersData  = $headersData;
    }

    public function write()
    {
        dump($this->headersData);
        /** @var ExportEntityInterface $line */
        foreach ($this->dataProvider->getEntities() as $line) {
            dump($this->prepareRow($line->toArray()));
        }
    }
}
