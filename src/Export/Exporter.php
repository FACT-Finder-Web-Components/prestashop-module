<?php

namespace Omikron\Factfinder\Prestashop\Export;

use Omikron\Factfinder\Prestashop\Export\Filter\TextFilter;

class Exporter
{
    /** @var DataProviderInterface */
    private $dataProvider;

    /** @var array */
    private $headersData;

    /** @var TextFilter */
    private $filter;

    public function __construct(DataProviderInterface $dataProvider, array $headersData)
    {
        $this->dataProvider = $dataProvider;
        $this->headersData  = $headersData;
        $this->filter       = new TextFilter();
    }

    public function __invoke()
    {
        $handle = tmpfile();
        $emptyRecord = array_combine($this->headersData, array_fill(0, count($this->headersData), ''));
        fputcsv($handle, $this->headersData, ';');

        foreach ($this->dataProvider->getEntities() as $line) {
            $entityData = array_merge($emptyRecord, array_intersect_key($this->prepare($line->toArray()), $emptyRecord));
            fputcsv($handle, $entityData, ';');
        }
        fseek($handle, 0);

        while (!feof($handle)) {
            $buffer = fread($handle, 1024);
            echo $buffer;
            flush();
        }
        fclose($handle);

        return;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    private function prepare(array $data)
    {
        return array_map([$this->filter, 'filterValue'], $data);
    }
}
