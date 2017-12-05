<?php

namespace Phalsion\RpcFramework\Component\RpcKernel\Tests;


use Phalcon\Cli\Console;
use Phalcon\Di;
use Phalsion\RpcFramework\Component\Config\ConfigLoader;
use Phalsion\RpcFramework\Component\Router\SimpleRouter;
use Phalsion\RpcFramework\Component\RpcKernel\Kernel;

class KernelTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @group kernelTest
     */
    public function testKernel()
    {
        $kernel = $this->defaultKernel();

        $response   = $kernel->handle([ 'method' => 'test', 'params' => [] ]);
        $resp_array = json_decode(json_encode($response), true);
        $this->assertEquals(0, $resp_array[0]);
        $this->assertEquals('hello world', $resp_array[1]);
        $this->assertEquals('', $resp_array[2]);
        $this->assertEquals(0, $resp_array[3]);
    }


    public function defaultKernel()
    {

        $config_loader = new ConfigLoader();
        $router        = new SimpleRouter();

        $router->setRouterMap([
                                  'test' => [
                                      'task'   => 'Phalsion\RpcFramework\Component\RpcKernel\Tests\Test',
                                      'action' => 'index'
                                  ]
                              ]);
        $di  = new Di\FactoryDefault\Cli();
        $app = new Console();
        $app->setDI($di);
        $di->setShared('console', $app);

        return new class( 'test', true, $config_loader, $router, $di ) extends Kernel
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
                return __DIR__;
            }

            public function getLogDir()
            {
                return __DIR__ . '/log';
            }
        };
    }
}
