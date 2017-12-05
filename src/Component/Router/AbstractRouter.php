<?php

namespace Phalsion\RpcFramework\Component\Router;


use Phalsion\RpcFramework\Component\Exception\RuntimeException;

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
        foreach ( $map as $method => $item ) {
            if ( !array_key_exists('task', $item) or !array_key_exists('action', $item) or !$method ) {
                throw new RuntimeException(sprintf('router item is invalid:%s', json_encode($item)), 9996);
            }
        }
        $this->routerMap = $map;
    }

    public function attach( $method, $payload )
    {
        if ( array_key_exists($method, $this->routerMap) ) {
            throw new \LogicException(sprintf('method already exist in router:%s', $method), -1);
        }

        $this->routerMap[ $method ] = $payload;
    }

}
