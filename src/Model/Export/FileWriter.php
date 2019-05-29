<?php

namespace Omikron\Factfinder\Prestashop\Model\Export;

use PrestaShop\PrestaShop\Core\Export\Exception\FileWritingException;
use SplFileObject;

class FileWriter
{
    /**
     * @param resource $handle
     * @param string   $filePath
     *
     * @throws FileWritingException
     */
    public function save($handle, $filePath)
    {
        try {
            $exportFile = new SplFileObject($filePath, 'w');
        } catch (\Exception $e) {
            throw new FileWritingException(
                sprintf('Cannot open export file %s for writing', $filePath),
                FileWritingException::CANNOT_OPEN_FILE_FOR_WRITING
            );
        }

        while (($data = fgetcsv($handle, ';')) != false) {
            $exportFile->fputcsv($data, ';');
        }
    }
}
