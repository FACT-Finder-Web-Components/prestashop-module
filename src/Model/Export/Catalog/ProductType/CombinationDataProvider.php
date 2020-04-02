<?php

namespace Omikron\Factfinder\Prestashop\Model\Export\Catalog\ProductType;

use Omikron\Factfinder\Prestashop\Model\Export\ExportEntityInterface;

class CombinationDataProvider implements ExportEntityInterface
{
    /** @var array */
    private $combinationData;

    /** @var array */
    private $data;

    public function __construct(array $combination, array $data)
    {
        $this->combinationData = $combination;
        $this->data            = $data;
    }

    public function getId()
    {
        return $this->getCombinationPrestaId();
    }

    public function toArray()
    {
        return array_merge($this->data, [
            'ProductNumber' => $this->getCombinationNumber(),
            'PrestaID'      => $this->getCombinationPrestaId(),
        ]);
    }

    private function getCombinationNumber()
    {
        return implode('-', [$this->data['ProductNumber'], $this->combinationData['id_product_attribute']]);
    }

    private function getCombinationPrestaId()
    {
        return implode('-', [$this->data['PrestaID'], $this->combinationData['id_product_attribute']]);
    }
}
