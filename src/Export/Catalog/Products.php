<?php

namespace Omikron\Factfinder\Prestashop\Export\Catalog;

use PrestaShopBundle\Service\DataProvider\Admin\ProductInterface;

class Products implements \IteratorAggregate
{
    /** @var ProductInterface */
    private $productProvider;

    /** @var int */
    private $batchSize = 300;

    public function __construct(ProductInterface $productProvider)
    {
        $this->productProvider = $productProvider;
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        for ($offset = 0; $list = $this->getProductList($offset, $this->batchSize); $offset += $this->batchSize) {
            foreach ($list as $product) yield $product;
        }
    }

    /**
     * @param int    $offset
     * @param int    $batchSize
     * @param string $orderBy
     * @param string $dir
     *
     * @return array
     */
    private function getProductList($offset, $batchSize, $orderBy = 'id_product', $dir = 'ASC')
    {
        return $this->productProvider->getCatalogProductList($offset, $batchSize, $orderBy, $dir, [], true, false);
    }
}
