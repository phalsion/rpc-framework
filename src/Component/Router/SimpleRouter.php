<?php

namespace Phalsion\RpcFramework\Component\Router;


use Phalsion\RpcFramework\Bundle\FrameworkBundle\ErrorCode;
use Phalsion\RpcFramework\Component\Exception\NotFoundException;
use Phalsion\RpcFramework\Component\Exception\RuntimeException;

/**
 * Class SimpleRouter
 *
 * @author  liqi created_at 2017/10/20下午3:18
 * @package \Phalsion\RpcFramework\Component\Router
 */
class SimpleRouter extends AbstractRouter
{

    public function match( $request )
    {
        if ( !isset($request['method']) ) {
            throw new RuntimeException('invalid request', ErrorCode::FAIL);
        }

        if ( !array_key_exists($request['method'], $this->routerMap) ) {
            throw new NotFoundException('not fond', ErrorCode::FAIL);
        }

        return $this->routerMap[ $request['method'] ];
    }
}
