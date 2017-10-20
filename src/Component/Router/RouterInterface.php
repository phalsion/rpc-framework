<?php

namespace Phalsion\RpcFramework\Component\Router;

/**
 * Class RouterInterface
 *
 * @author  liqi created_at 2017/10/20下午3:15
 * @package \Phalsion\RpcFramework\Component\Router
 */
Interface RouterInterface
{
    public function match( $request );

    public function setRouterMap( $map );
}
