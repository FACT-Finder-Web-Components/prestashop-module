<?php

namespace Omikron\Factfinder\Prestashop;

class FeaturesConfig implements \ArrayAccess
{
    public function offsetGet($offset)
    {
        return (bool) \Configuration::get('FF_FEATURE_' . strtoupper($offset));
    }

    public function offsetExists($offset)
    {
        throw new \BadMethodCallException('Not implemented');
    }

    public function offsetSet($offset, $value)
    {
        throw new \BadMethodCallException('Not implemented');
    }

    public function offsetUnset($offset)
    {
        throw new \BadMethodCallException('Not implemented');
    }
}
