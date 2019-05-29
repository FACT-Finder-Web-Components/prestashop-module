<?php

namespace Omikron\Factfinder\Prestashop\Export\Output;

use Omikron\Factfinder\Prestashop\Model\Export\DataProviderInterface;

class Csv extends AbstractOutput implements OutputInterface
{
    /** @var DataProviderInterface */
    private $dataProvider;

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
        $export = $this->write();
        fpassthru($export);
        fclose($export);
    }

    /**
     * @return resource
     */
    public function write()
    {
        $handle = tmpfile();
        fputcsv($handle, $this->headersData, ';');

        foreach ($this->dataProvider->getEntities() as $line) {
            fputcsv($handle, $this->prepareRow($line->toArray()), ';');
        }

        rewind($handle);
        return $handle;
    }
}
