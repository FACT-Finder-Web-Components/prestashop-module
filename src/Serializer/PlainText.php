<?php

namespace Omikron\Factfinder\Prestashop\Serializer;

class PlainText implements SerializerInterface
{
    public function serialize($data)
    {
        throw new \BadMethodCallException('Not implemented');
    }

    public function unserialize($string)
    {
        return ['success' => stripos((string) $string, 'success') !== false];
    }
}
