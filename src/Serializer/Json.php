<?php

namespace Omikron\Factfinder\Prestashop\Serializer;

class Json implements SerializerInterface
{
    /**
     * @param mixed $data
     *
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    public function serialize($data)
    {
        $result = json_encode($data);
        if (false === $result) {
            throw new \InvalidArgumentException('Unable to serialize value.');
        }

        return $result;
    }

    /**
     * @param string $string
     *
     * @return array
     *
     * @throws \InvalidArgumentException
     */
    public function unserialize($string)
    {
        $result = json_decode((string) $string, JSON_OBJECT_AS_ARRAY);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \InvalidArgumentException('Unable to unserialize value.');
        }

        return $result;
    }
}
