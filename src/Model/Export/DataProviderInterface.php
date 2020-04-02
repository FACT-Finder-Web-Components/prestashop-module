<?php

namespace Omikron\Factfinder\Prestashop\Model\Export;

interface DataProviderInterface
{
    /**
     * @return ExportEntityInterface[]
     */
    public function getEntities();
}
