<?php

namespace Phalsion\Example;


use Phalsion\RpcFramework\Component\Router\HasRouteInterface;
use Phalsion\RpcFramework\Component\RpcKernel\Bundle\AbstractBundle;

/**
 * Class ExampleBundle
 *
 * @author  liqi created_at 2017/12/5下午3:07
 * @package \Phalsion\Example
 */
class ExampleBundle extends AbstractBundle implements HasRouteInterface
{

    public function boot()
    {
    }

    public function getRouteMap()
    {
        return [
            'test' => [
                'task'   => 'Phalsion\Example\Test',
                'action' => 'index'
            ]
        ];
    }
}
