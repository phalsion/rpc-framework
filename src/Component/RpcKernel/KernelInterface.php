<?php

namespace Phalsion\RpcFramework\Component\RpcKernel;


use Phalcon\Di\InjectionAwareInterface;


/**
 * Interface KernelInterface
 *
 * @author  liqi created_at 2017/10/18下午4:54
 * @package Phalsion\RpcFramework\Component\RpcKernel
 */
interface KernelInterface extends InjectionAwareInterface, ReloadKernelInterface
{
    /**
     * @return \Phalsion\RpcFramework\Component\RpcKernel\Bundle\BundleInterface[]
     */
    public function registerBundles();

    public function getBundles();

    public function getEnvironment();

    public function isDebug();

    public function getRootDir();

    public function getLogDir();

    public function handle( $data );
}
