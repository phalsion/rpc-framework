<?php

namespace Phalsion\RpcFramework\Component\Router;

/**
 * Interface RouterAttacherInterface
 *
 * @author  liqi created_at 2017/12/5下午12:01
 * @package Phalsion\RpcFramework\Component\Router
 */
interface RouterAttacherInterface
{
    public function attach( $method, $payload );
}
