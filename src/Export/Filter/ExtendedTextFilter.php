<?php

namespace Omikron\Factfinder\Prestashop\Export\Filter;

class ExtendedTextFilter extends TextFilter
{
    private $forbiddenChars = '/[|#=]/';

    /**
     * @param string $value
     *
     * @return string
     */
    public function filterValue($value)
    {
        return trim(preg_replace($this->forbiddenChars, ' ', parent::filterValue($value)));
    }
}
