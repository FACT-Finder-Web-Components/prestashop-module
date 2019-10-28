<?php

namespace Omikron\Factfinder\Prestashop\Model\Export\Catalog\ProductType;

use Omikron\Factfinder\Prestashop\Export\Filter\TextFilter;
use Omikron\Factfinder\Prestashop\Export\Formatter\FormatNumber;
use Omikron\Factfinder\Prestashop\Model\Export\Catalog\Fields\Attributes;
use Omikron\Factfinder\Prestashop\Model\Export\Catalog\Fields\CategoryPath;
use Omikron\Factfinder\Prestashop\Model\Export\Catalog\Fields\ProductFieldInterface;
use Omikron\Factfinder\Prestashop\Model\Export\DataProviderInterface;
use Omikron\Factfinder\Prestashop\Model\Export\ExportEntityInterface;

class ProductDataProvider implements DataProviderInterface, ExportEntityInterface
{
    /** @var array */
    protected $productData;

    /** @var int */
    protected $languageId;

    /** @var TextFilter */
    protected $filter;

    /** @var FormatNumber */
    private $numberFormatter;

    /** @var \Link */
    private $link;

    /** @var array */
    private $productFields = [];

    /** @var array */
    protected $features = [];

    public function __construct($productData)
    {
        $this->productData     = $productData;
        $this->languageId      = \Context::getContext()->language->id;
        $this->filter          = new TextFilter();
        $this->numberFormatter = new FormatNumber();
        $this->link            = \Context::getContext()->link;
        $this->productFields   = [
            'CategoryPath' => new CategoryPath(),
            'Attributes'   => new Attributes(),
        ];
    }

    public function getId()
    {
        return $this->productData['id_product'];
    }

    /**
     * @return array
     */
    public function getEntities()
    {
        return [$this];
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $data = [
            'ProductNumber' => $this->productData['reference'] ?: $this->productData['id_product'],
            'Master'        => $this->productData['reference'] ?: $this->productData['id_product'],
            'Name'          => $this->productData['name'],
            'Description'   => strip_tags($this->productData['description']),
            'ImageUrl'      => $this->productData['image_link'],
            'Price'         => $this->numberFormatter->format($this->productData['price_final']),
            'Brand'         => \Manufacturer::getNameById($this->productData['id_manufacturer']) ?: '',
            'Availability'  => (int) (bool) $this->productData['sav_quantity'],
            'ProductUrl'    => $this->link->getProductLink($this->productData['id_product']),
            'PrestaID'      => $this->productData['id_product'],
        ];

        return array_merge($data, array_map(function (ProductFieldInterface $field) {
            return $field->getValue($this->productData['id_product']);
        }, $this->productFields));
    }

    public function __invoke()
    {
        return $this->toArray();
    }
}
