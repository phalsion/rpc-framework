<?php

namespace Tests;


use Phalsion\RpcFramework\Component\RpcKernel\Kernel;

/**
 * Class TestKernel
 *
 * @author  liqi created_at 2017/10/18下午5:04
 * @package \Tests
 */
class TestKernel extends Kernel
{

    /**
     * @return \Phalsion\RpcFramework\Component\RpcKernel\Bundle\BundleInterface[]
     */
    public function registerBundles()
    {
        return [];
    }



    public function getRootDir()
    {
        return __DIR__ . '/../';
    }

    public function getLogDir()
    {
        return "logs";
    }
}
