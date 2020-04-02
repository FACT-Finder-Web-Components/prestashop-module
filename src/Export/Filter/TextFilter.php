<?php

namespace Omikron\Factfinder\Prestashop\Export\Filter;

class TextFilter
{
    /**
     * @param string $value
     *
     * @return string
     */
    public function filterValue($value)
    {
        // phpcs:ignore
        $tags  = '#<(address|article|aside|blockquote|br|canvas|dd|div|dl|dt|fieldset|figcaption|figure|footer|form|h[1-6]|header|hr|li|main|nav|noscript|ol|p|pre|section|table|tfoot|ul|video)#';
        $value = preg_replace($tags, ' <$1', $value); // Add one space in front of block elements before stripping tags
        $value = strip_tags($value);
        $value = mb_convert_encoding($value, 'HTML-ENTITIES', 'UTF-8');
        $value = mb_convert_encoding($value, 'UTF-8', 'HTML-ENTITIES');
        $value = preg_replace('#\s+#', ' ', $value);
        return trim($value);
    }
}
