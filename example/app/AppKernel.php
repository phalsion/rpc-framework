<?php

namespace Phalsion\Example\App;


use Phalsion\Example\ExampleBundle;
use Phalsion\RpcFramework\Bundle\DataBaseBundle\DataBaseBundle;
use Phalsion\RpcFramework\Bundle\DebugBundle\DebugBundle;
use Phalsion\RpcFramework\Bundle\FrameworkBundle\FrameWorkBundle;
use Phalsion\RpcFramework\Bundle\RedisBundle\RedisBundle;
use Phalsion\RpcFramework\Component\RpcKernel\Kernel;

/**
 * Class appKernel
 *
 * @author  liqi created_at 2017/12/5下午1:45
 * @package \Phalsion\Example\app
 */
class AppKernel extends Kernel
{

    public function registerBundles()
    {
        $bundles = [
            new FrameWorkBundle(),
            new ExampleBundle(),
            new RedisBundle(),
            new DataBaseBundle()
        ];

        if ( $this->isDebug() ) {
            $bundles[] = new DebugBundle();
        }

        return $bundles;
    }

    public function getRootDir()
    {
        return __DIR__ . '/../';
    }

    public function getLogDir()
    {
        return __DIR__;
    }
}
