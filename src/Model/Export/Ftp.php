<?php

namespace Omikron\Factfinder\Prestashop\Model\Export;

use Exception;
use Omikron\Factfinder\Prestashop\Config\FtpParams;
use SplFileObject;

class Ftp
{
    /** @var resource */
    private $connection;

    /** @var string */
    private $fileName;

    public function __construct($fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * @param FtpParams $params
     *
     * @return $this
     * @throws Exception
     */
    public function open(FtpParams $params)
    {
        if ($params['use-ssl']) {
            $this->connection = @ftp_ssl_connect($params['host'], $params['port'], 30);
        } else {
            $this->connection = @ftp_connect($params['host'], $params['port'], 30);
        }
        if (!$this->connection) {
            throw new Exception('FTP connection failed to open');
        }
        if (!@ftp_login($this->connection, $params['user'], $params['password'])) {
            $this->close();
            throw new Exception('The FTP username or password is invalid. Verify both and try again.');
        }
        if (!@ftp_pasv($this->connection, true)) {
            $this->close();
            throw new Exception('The file transfer mode is invalid. Verify and try again.');
        }

        return $this;
    }

    /**
     * @param SplFileObject $handle
     *
     * @return $this
     * @throws Exception
     */
    public function upload(SplFileObject $handle)
    {
        if ($handle->getSize() == 0) {
            throw new Exception('Feed file is 0kb size. The upload is stopped');
        }
        ftp_fput($this->connection, $this->fileName, fopen($handle->getPathName(), 'r+'), FTP_ASCII);

        return $this;
    }

    /**
     * Close a connection
     *
     * @return bool
     */
    public function close()
    {
        return @ftp_close($this->connection);
    }
}
