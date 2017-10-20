<?php

namespace Phalsion\RpcFramework\Component\Router;


use Phalsion\RpcFramework\Component\RpcKernel\KernelInterface;

/**
 * Class AbstractRouter
 *
 * @author  liqi created_at 2017/10/20下午3:29
 * @package \Phalsion\RpcFramework\Component\Router
 */
abstract class AbstractRouter implements RouterInterface
{
    protected $routerMap;

    public function __construct()
    {
        $this->routerMap = [];
    }

    public function setRouterMap( $map )
    {
        $this->routerMap = $map;
    }

}
