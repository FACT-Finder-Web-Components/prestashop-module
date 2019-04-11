<?php

namespace Omikron\Factfinder\Prestashop\Export\Formatter;

class FormatNumber
{
    /**
     * @param float $number
     * @param int   $precision
     * @return string
     */
    public function format($number, $precision = 2)
    {
        return sprintf("%.{$precision}F", round($number, $precision));
    }
}
