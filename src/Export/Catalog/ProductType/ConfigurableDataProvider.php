<?php

namespace Omikron\Factfinder\Prestashop\Export\Catalog\ProductType;

use PrestaShop\PrestaShop\Adapter\Attribute\AttributeDataProvider;

class ConfigurableDataProvider extends ProductDataProvider
{
    /** @var AttributeDataProvider */
    private $combinationProvider;

    /** @var array */
    private $combinations = [];

    /** @var array */
    private $attributes = [];

    public function __construct($productData)
    {
        parent::__construct($productData);
        $this->combinationProvider = new AttributeDataProvider();
    }

    /**
     * @inheritdoc
     */
    public function getEntities()
    {
        foreach (parent::getEntities() as $entity) yield $entity;
        yield from array_map($this->combinationCallback($this->productData), $this->getCombinations($this->productData['id_product']));
    }

    /**
     * @inheritdoc
     */
    public function toArray()
    {
        $data    = parent::toArray();
        $options = array_merge([], ...array_values($this->getAttributes()));
        if ($options) {
            $data = ['Attributes' => $this->formatAttributes($data, $options)] + $data;
        }
        return $data;
    }

    /**
     * @param array $productData
     *
     * @return callable
     */
    private function combinationCallback(array $productData)
    {
        $dataToExport = parent::toArray();
        return function (array $combination) use ($productData, $dataToExport) {
            $dataToExport = ['Attributes' => $this->formatAttributes($dataToExport, $this->getCombinationAttributes($combination['id_product_attribute']))] + $dataToExport;
            return new CombinationDataProvider($combination, $dataToExport);
        };
    }

    /**
     * Get all attributes formatted for configuration
     *
     * @return array
     */
    private function getAttributes()
    {
        if (!$this->attributes) {
            $this->attributes = array_reduce($this->getCombinationsAttributes(), function (array $res, array $combination) {
                foreach ($combination as ['id_product_attribute' => $combinationId, 'group_name' => $label, 'attribute_name' => $value]) {
                    $res[$combinationId][] = "{$this->filter->filterValue($label)}={$this->filter->filterValue($value)}";
                }
                return $res;
            }, []);
        }
        return $this->attributes;
    }

    /**
     * Get raw attributes all combinations
     *
     * @return array
     */
    private function getCombinationsAttributes()
    {
        return array_reduce($this->getCombinations($this->productData['id_product']), function (array $attributes, array $combination) {
            $product = new \ProductCore($this->productData['id_product']);
            $attributes[$combination['id_product_attribute']] = $product->getAttributeCombinationsById($combination['id_product_attribute'], $this->languageId);
            return $attributes;
        }, []);
    }

    /**
     * Get all combinations
     *
     * @param $productId
     *
     * @return array
     */
    private function getCombinations($productId)
    {
        if (!$this->combinations) {
            $this->combinations = $this->combinationProvider->getProductCombinations($productId);;
        }
        return $this->combinations;
    }

    /**
     * Get formatted attributes for specific combination
     *
     * @param int $combinationId
     *
     * @return array
     */
    private function getCombinationAttributes($combinationId)
    {
        return isset($this->attributes[$combinationId]) ? $this->attributes[$combinationId] : [];
    }

    /**
     * @param array $parent
     * @param array $productAttributes
     *
     * @return string
     */
    private function formatAttributes(array $parent, array $productAttributes)
    {
        return ($parent['Attributes'] ?: '|') . implode('|', $productAttributes) . '|';
    }
}
