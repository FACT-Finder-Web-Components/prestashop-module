<?php

namespace Omikron\Factfinder\Prestashop\Export;

interface DataProviderInterface
{
    /**
     * @return ExportEntityInterface[]
     */
    public function getEntities();
}
