<?php

namespace Phalsion\RpcFramework\Component\DependencyInjectionRegister;

/**
 * Class DiRegisterInterface
 *
 * @author  liqi created_at 2017/10/20上午11:44
 * @package \Phalsion\RpcFramework\Component\DependencyInjectionRegister
 */
interface DiRegisterInterface
{
    public function register( $reload );
}
