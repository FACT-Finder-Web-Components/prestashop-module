<?php

namespace Omikron\Factfinder\Prestashop\Config;

abstract class AbstractParams implements \ArrayAccess
{
    /** @var array */
    protected $params;

    public function offsetExists($offset)
    {
        return isset($this->params[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->params[$offset]) ? $this->params[$offset] : '';
    }

    public function offsetSet($offset, $value)
    {
        throw new \BadMethodCallException('read only access');
    }

    public function offsetUnset($offset)
    {
        throw new \BadMethodCallException('read only access');
    }
}
