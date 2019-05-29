<?php

namespace Omikron\Factfinder\Prestashop\Model\Export\Catalog;

use Omikron\Factfinder\Prestashop\Model\Export\Catalog\ProductType\ConfigurableDataProvider;
use Omikron\Factfinder\Prestashop\Model\Export\Catalog\ProductType\ProductDataProvider;
use Omikron\Factfinder\Prestashop\Model\Export\DataProviderInterface;
use PrestaShopBundle\Service\DataProvider\Admin\ProductInterface;

class DataProvider implements DataProviderInterface
{
    /** @var Products */
    private $products;

    public function __construct(ProductInterface $productProvider)
    {
        $this->products = new Products($productProvider);
    }

    /**
     * @return \Iterator
     */
    public function getEntities()
    {
        foreach ($this->products as $product) {
            foreach ($this->entitiesFrom($product)->getEntities() as $entity) {
                yield $entity;
            }
        }
    }

    /**
     * @param array $productData
     *
     * @return DataProviderInterface
     */
    private function entitiesFrom($productData)
    {
        if ((bool) $productData['has_attributes']) {
            return new ConfigurableDataProvider($productData);
        }
        return new ProductDataProvider($productData);
    }
}
