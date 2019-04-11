<?php

namespace Omikron\Factfinder\Prestashop\Export\Catalog;

use Omikron\Factfinder\Prestashop\Export\Catalog\ProductType\ConfigurableDataProvider;
use Omikron\Factfinder\Prestashop\Export\Catalog\ProductType\ProductDataProvider;
use Omikron\Factfinder\Prestashop\Export\DataProviderInterface;
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
        yield from [];
        foreach ($this->products as $product) {
            yield from $this->entitiesFrom($product)->getEntities();
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
