<?php

namespace Omikron\Factfinder\Prestashop\Export\Output;

use Omikron\Factfinder\Prestashop\Export\Filter\TextFilter;

class AbstractOutput
{
    /** @var array */
    protected $headersData;

    /** @var TextFilter */
    private $filter;

    public function __construct()
    {
        $this->filter = new TextFilter();
    }

    /**
     * @param array $data
     *
     * @return array
     */
    protected function prepareRow(array $data)
    {
        return array_merge($this->getEmptyRow(), array_intersect_key(array_map([$this->filter, 'filterValue'], $data), $this->getEmptyRow()));
    }

    /**
     * @return array
     */
    private function getEmptyRow()
    {
        return array_combine($this->headersData, array_fill(0, count($this->headersData), ''));
    }
}
