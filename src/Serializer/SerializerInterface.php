<?php

namespace Omikron\Factfinder\Prestashop\Serializer;

interface SerializerInterface
{
    /**
     * @param array $data
     *
     * @return string
     */
    public function serialize($data);

    /**
     * @param string $string
     *
     * @return array
     */
    public function unserialize($string);
}
