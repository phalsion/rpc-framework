<?php

namespace Phalsion\RpcFramework\Component\RpcKernel\Foundation;


use Phalsion\RpcFramework\Component\Exception\RuntimeException;

/**
 * Class RequestResolver
 *
 * @author  liqi created_at 2017/10/19上午8:23
 * @package \Phalsion\RpcFramework\Component\RpcKernel\Foundation
 */
class RequestBuilder
{
    public static function createFromData( $data )
    {
        $router_name = $data['method'];
        $router      = $data['router'];

        if ( !array_key_exists('params', $data) || !is_array($data['params']) ) {
            throw new RuntimeException('数据中缺少params参数!');
        }

        $frontend = $data['params']['frontend'] ?? [];
        $session  = $data['params']['session'] ?? [];

        return new Request($router, $router_name, $frontend, $session);
    }
}
