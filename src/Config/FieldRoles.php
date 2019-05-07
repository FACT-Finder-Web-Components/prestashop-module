<?php

namespace Omikron\Factfinder\Prestashop\Config;

class FieldRoles implements \JsonSerializable
{
    public function jsonSerialize()
    {
        return [
            'brand'                 => 'Brand',
            'campaignProductNumber' => 'ProductNumber',
            'deeplink'              => 'ProductURL',
            'description'           => 'Description',
            'displayProductNumber'  => 'ProductNumber',
            'ean'                   => 'ProductNumber',
            'imageUrl'              => 'ImageUrl',
            'masterArticleNumber'   => 'Master',
            'price'                 => 'Price',
            'productName'           => 'Name',
            'trackingProductNumber' => 'ProductNumber',
        ];
    }
}
