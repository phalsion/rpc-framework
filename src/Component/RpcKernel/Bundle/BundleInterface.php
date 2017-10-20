<?php

namespace Phalsion\RpcFramework\Component\RpcKernel\Bundle;


use Phalcon\Di\ServiceProviderInterface;

/**
 * Interface Bundle
 *
 * @author  liqi created_at 2017/10/18下午7:10
 * @package Phalsion\RpcFramework\Component\RpcKernel\Bundle
 */
interface BundleInterface extends ServiceProviderInterface
{
    public function boot();

    public function getName();
}
