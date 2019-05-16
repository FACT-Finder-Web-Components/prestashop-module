<?php

namespace Omikron\Factfinder\Prestashop\Model\Cron;

use Symfony\Component\HttpKernel\Kernel;

class EmulateEnvironment
{
    /** @var Kernel */
    private $kernel;

    public function __construct(Kernel $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * This method is used for initialize partially mocked PrestaShop environment
     * causing its services will be able to use from CLI script
     *
     * @param string $idShop
     * @param string $idLang
     * @param string $adminPath
     *
     * @throws \Exception
     */
    public function emulate($idShop, $idLang, $adminPath)
    {
        require $this->kernel->getRootDir() . '/../config/config.inc.php';
        \Context::getContext()->language   = new \Language($idLang);
        \Context::getContext()->shop       = new \Shop($idShop, $idLang);
        \Context::getContext()->employee   = new \Employee(null, $idLang, $idShop);
        \Context::getContext()->controller = new \AdminControllerCore('Admin');
        $adminPath                         = _PS_ROOT_DIR_ . DIRECTORY_SEPARATOR . $adminPath;
        if (is_dir($adminPath)) {
            define('_PS_ADMIN_DIR_', $adminPath);
        } else {
            throw new \Exception(sprintf('Specified path for admin directory %s is not exists', $adminPath));
        }
    }
}
