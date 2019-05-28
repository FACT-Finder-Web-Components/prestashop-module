<?php

namespace Omikron\Factfinder\Prestashop\Model\Export;

use Omikron\Factfinder\Prestashop\Config\FtpParams;
use SplFileObject as File;

class FtpClient
{
    /** @var FtpParams */
    private $config;

    public function __construct(FtpParams $config)
    {
        $this->config = $config;
    }

    /**
     * @param File   $handle
     * @param string $filename
     *
     * @throws \Exception
     */
    public function upload(File $handle, $filename = '')
    {
        $connection = $this->connect($this->config);

        try {
            ftp_fput($connection, $filename ?: $handle->getFilename(), fopen($handle->getFileInfo(), '+r'), FTP_ASCII);
        } finally {
            $this->close($connection);
        }
    }

    /**
     * @param FtpParams $config
     * @param int       $timeout
     *
     * @return resource
     * @throws \Exception
     */
    private function connect(FtpParams $config, $timeout = 30)
    {
        $connection = $config->useSsl() ?
            @ftp_ssl_connect($config->getHost(), $config->getPort(), $timeout) :
            @ftp_connect($config->getHost(), $config->getPort(), $timeout);

        if (!$connection) {
            throw new \Exception('FTP connection failed to open');
        }

        if (!@ftp_login($connection, $config->getUser(), $config->getPassword())) {
            $this->close($connection);
            throw new \Exception('The FTP username or password is invalid. Verify both and try again.');
        }
        if (!@ftp_pasv($connection, true)) {
            $this->close($connection);
            throw new \Exception('The file transfer mode is invalid. Verify and try again.');
        }

        return $connection;
    }

    private function close($connection)
    {
        @ftp_close($connection);
    }
}
