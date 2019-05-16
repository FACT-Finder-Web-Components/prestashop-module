<?php

namespace Omikron\Factfinder\Prestashop\Model\Export;

use PrestaShop\PrestaShop\Core\Export\Exception\FileWritingException;
use SplFileObject;

class FileWriter
{
    /**
     * @param SplFileObject $handle
     * @param string        $filePath
     *
     * @return SplFileObject
     * @throws FileWritingException
     */
    public function save(SplFileObject $handle, $filePath)
    {
        try {
            $exportFile = new SplFileObject($filePath, 'w');
        } catch (\Exception $e) {
            throw new FileWritingException(
                sprintf('Cannot open export file for writing'),
                FileWritingException::CANNOT_OPEN_FILE_FOR_WRITING
            );
        }

        while (($data = $handle->fgetcsv(';')) != false) {
            $exportFile->fputcsv($data, ';');
        }

        return $exportFile;
    }
}
